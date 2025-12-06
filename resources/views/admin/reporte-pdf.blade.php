<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Reservas</title>
    <style>
        table { width:100%; border-collapse: collapse; margin-top:10px; }
        th, td { border:1px solid #000; padding:5px; text-align:left; }
        th { background:#eee; }
    </style>
</head>
<body>
    <img src="{{ public_path('assets/imagen/barberialogo.webp') }}" 
     style="position: absolute; top: 10px; right: 10px; width: 120px;">

    <h2>Reporte de Reservas</h2>
    <p>Generado por: {{ $admin->nombre }} {{ $admin->apellido }}</p>
    <p>Fecha de generación: {{ \Carbon\Carbon::now()->format('d/m/Y') }} — Hora: {{ \Carbon\Carbon::now()->format('H:i') }}</p>
    <p>Desde: {{ $fecha_inicio }} Hasta: {{ $fecha_fin }}</p>
    @if($barbero_id)
    @php $barbero = \App\Models\Barbero::find($barbero_id) @endphp
    <p>Barbero: {{ $barbero->nombre ?? 'N/A' }} {{ $barbero->apellido ?? '' }}</p>
    @else
        <p>Barbero: Todos</p>
    @endif


    <table>
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Email</th>
                <th>Barbero</th>
                <th>Servicio</th>
                <th>Fecha</th>
                <th>Hora inicio</th>
                <th>Hora fin</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservas as $reserva)
            <tr>
                <td>{{ $reserva->nombre_completo }}</td>
                <td>{{ $reserva->email }}</td>
                <td>{{ $reserva->barbero->nombre ?? 'N/A' }} {{ $reserva->barbero->apellido ?? '' }}</td>
                <td>{{ $reserva->servicio->nombre ?? 'N/A' }}</td>
                <td>{{ \Carbon\Carbon::parse($reserva->fecha_reserva)->format('d/m/Y') }}</td>
                <td>{{ $reserva->hora_reserva }}</td>
                <td>{{ $reserva->hora_fin }}</td>
                <td>{{ $reserva->estado }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
