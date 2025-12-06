<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\Barbero;
use App\Models\Servicio;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservaConfirmada;
use App\Jobs\EnviarRecordatorioReserva;
use Illuminate\Support\Facades\Log;

class ReservasController extends Controller
{
    public function perfil()
    {
        $user = Auth::user();

        $reservas = Reserva::where('usuario_id', $user->id)
            ->with('barbero')
            ->orderBy('fecha_reserva', 'desc')
            ->orderBy('hora_reserva', 'desc')
            ->get();

        $barberos = Barbero::all();
        $servicios = Servicio::all();

        $eventos = $reservas->map(function($reserva){
            return [
                'title' => $reserva->tipo_servicio
                           . ' | ' . $reserva->hora_reserva 
                           . ' - ' . $reserva->hora_fin
                           . ' | ' . $reserva->barbero->nombre . ' ' . $reserva->barbero->apellido
                           . ' | ' . $reserva->estado,
                'start' => $reserva->fecha_reserva . 'T' . $reserva->hora_reserva,
                'end'   => $reserva->fecha_reserva . 'T' . $reserva->hora_fin,
                'color' => $reserva->estado === 'Cancelada' ? '#ff4d4d' : '#3788d8',
            ];           
        });

        return view('auth.perfil', compact('user', 'reservas', 'barberos', 'servicios', 'eventos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha_reserva' => 'required|date|after_or_equal:today',
            'hora_reserva'  => 'required|date_format:H:i',
            'barbero_id'    => 'required|exists:barberos,id',
            'servicio_id'   => 'required|exists:servicios,id',
            'nombre_completo'=> 'required|string',
            'email'         => 'required|email',
            'celular'       => 'required|string',
        ], [
            'fecha_reserva.after_or_equal' => 'La fecha de la reserva debe ser hoy o posterior.',
        ]);

        // Bloquear domingos
        $fechaReserva = Carbon::parse($request->fecha_reserva);
        if ($fechaReserva->isSunday()) {
            return back()
                ->withErrors(['fecha_reserva' => 'No se permiten reservas los domingos.'])
                ->withInput();
        }

        $servicio = Servicio::findOrFail($request->servicio_id);
        $duracion = $servicio->duracion;
        $horaInicio = Carbon::createFromFormat('H:i', $request->hora_reserva);
        $horaFin = $horaInicio->copy()->addMinutes($duracion);

        // Verificación de permiso del barbero
        $barbero = Barbero::findOrFail($request->barbero_id);
        if ($barbero->estado == 'permiso') {
            $fechaReserva = Carbon::parse($request->fecha_reserva);
            $inicioPermiso = Carbon::parse($barbero->fecha_inicio_permiso);
            $finPermiso = Carbon::parse($barbero->fecha_fin_permiso);

            if ($fechaReserva->between($inicioPermiso, $finPermiso)) {
                return redirect()->back()
                    ->withErrors(['barbero_id'=>'El barbero seleccionado no se encuentra disponible por el momento.'])
                    ->withInput();
            }
        }

        // Validar conflictos de horario
        $conflicto = Reserva::where('barbero_id', $request->barbero_id)
            ->where('fecha_reserva', $request->fecha_reserva)
            ->where(function ($query) use ($horaInicio, $horaFin) {
                $query->where(function ($q) use ($horaInicio, $horaFin) {
                    $q->where('hora_reserva', '<', $horaFin->format('H:i'))
                      ->where('hora_fin', '>', $horaInicio->format('H:i'));
                });
            })
            ->exists();

        if ($conflicto) {
            return redirect()->route('perfil.editar')
                             ->withErrors(['hora_reserva' => 'La hora seleccionada ya está ocupada para este barbero.'])
                             ->withInput();
        }
        $reserva = Reserva::create([
            'usuario_id'      => Auth::id(),
            'nombre_completo' => $request->nombre_completo,
            'email'           => $request->email,
            'celular'         => $request->celular,
            'fecha_reserva'   => $request->fecha_reserva,
            'hora_reserva'    => $request->hora_reserva,
            'hora_fin'        => $horaFin->format('H:i'),
            'duracion'        => $duracion,
            'tipo_servicio'   => $servicio->nombre,
            'servicio_id'     => $servicio->id,
            'precio'          => $servicio->precio,
            'barbero_id'      => $request->barbero_id,
            'estado'          => 'pendiente',
            'codigo_reserva'  => strtoupper(Str::random(6)),
        ]);


        // Reemplaza esta línea:
// Mail::to($reserva->email)->send(new ReservaConfirmada($reserva));

// Por esto:


try {
    Mail::to($reserva->email)->send(new ReservaConfirmada($reserva));
} catch (\Exception $e) {
    // Si falla el envío, puedes registrar el error en los logs 
    // pero permitir que la reserva se complete.
    Log::error('Fallo al enviar correo de confirmación de reserva ' . $reserva->id . ': ' . $e->getMessage());
}


        // Programar recordatorio
        $reserva->load('servicio');
        EnviarRecordatorioReserva::dispatch($reserva)->delay($horaInicio->subHours(0));

        return redirect()->route('perfil.editar')->with('success', 'Reserva creada correctamente.');
    }

    public function cancelarReserva($id)
    {
        $reserva = Reserva::where('id', $id)
            ->where('usuario_id', Auth::id())
            ->firstOrFail();

        $reserva->estado = 'Cancelada';
        $reserva->save();

        return redirect()->route('perfil.editar')->with('success', 'Reserva cancelada correctamente.');
    }

    public function reprogramarReserva(Request $request, $id)
    {
        $request->validate([
            'fecha' => 'required|date|after_or_equal:today',
            'hora'  => 'required|date_format:H:i',
        ]);

        $fechaNueva = Carbon::parse($request->fecha);
        if ($fechaNueva->isSunday()) {
            return back()
                ->withErrors(['fecha' => 'No se permiten reprogramaciones para los domingos.'])
                ->withInput();
        }

        $reserva = Reserva::where('id', $id)
            ->where('usuario_id', Auth::id())
            ->firstOrFail();

        $servicio = Servicio::where('nombre', $reserva->tipo_servicio)->first();
        $duracion = $servicio ? $servicio->duracion : $reserva->duracion;

        $horaInicio = Carbon::createFromFormat('H:i', $request->hora);
        $horaFin = $horaInicio->copy()->addMinutes($duracion);

        // Validar conflicto de horario
        $conflicto = Reserva::where('barbero_id', $reserva->barbero_id)
            ->where('fecha_reserva', $request->fecha)
            ->where('id', '!=', $reserva->id)
            ->where(function ($query) use ($horaInicio, $horaFin) {
                $query->where('hora_reserva', '<', $horaFin->format('H:i'))
                      ->where('hora_fin', '>', $horaInicio->format('H:i'));
            })
            ->exists();

        if ($conflicto) {
            return redirect()->route('perfil.editar')
                             ->withErrors(['hora' => 'La hora seleccionada ya está ocupada para este barbero.'])
                             ->withInput();
        }

        $reserva->fecha_reserva = $request->fecha;
        $reserva->hora_reserva  = $request->hora;
        $reserva->hora_fin      = $horaFin->format('H:i');
        $reserva->save();

        return redirect()->route('perfil.editar')->with('success', 'Reserva reprogramada correctamente.');
    }

    public function horasOcupadas(Request $request)
    {
        $request->validate([
            'barbero_id' => 'required|exists:barberos,id',
            'fecha_reserva' => 'required|date',
        ]);

        $horarios = Reserva::where('barbero_id', $request->barbero_id)
            ->where('fecha_reserva', $request->fecha_reserva)
            ->select('hora_reserva', 'hora_fin')
            ->get();

        return response()->json($horarios);
    }
}
