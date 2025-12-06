<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="{{ asset('assets/css/perfil.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/editar_perfil.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/locales/es.global.min.js"></script>

    <style>
        /* Secciones ocultas por defecto */
        .seccion { display: none; }
        .perfil-img { width: 100px; height: 100px; border-radius: 50%; object-fit: cover; margin-top: 10px; }

        /* Tabla */
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: left; }
        th { background-color: #f4f4f4; }

        /* Botones unificados */
        button, a.btn-accion, .btn-cerrar {
            padding: 12px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(90deg, #f5d76e, #d4af37);
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            box-shadow: 0 4px 12px rgba(212,175,55,0.4);
        }

        button:hover, a.btn-accion:hover, .btn-cerrar:hover {
            background: linear-gradient(90deg, #d4af37, #f5d76e);
            transform: translateY(-1px);
        }

        /* Celda de botones en tabla */
        .celda-botones { display: flex; flex-wrap: wrap; gap: 10px; }

        /* Formulario reprogramar inline */
        .reprogramar-form { display: none; margin-top: 10px; }

        #calendar-wrapper {
    width: 100%;
    padding: 10px;
}
        #calendar {
            width: 100%;
            max-width: 1200px;
            margin: 20px auto;
            box-sizing: border-box;
        }
/* FullCalendar - colores para vista lista y díaGrid */
.fc .fc-col-header-cell-cushion,
.fc .fc-list-heading,
.fc .fc-list-day-cushion,
.fc .fc-list-day-header,
.fc .fc-event-title {
    color: #000 !important; /* negro siempre */
}


    </style>
</head>
<body>
    
    <!-- Sidebar -->
    <div class="sidebar-perfil">
        <h2>{{ $user->name }} {{ $user->apellido_paterno }} {{ $user->apellido_materno }}</h2>
        <p><strong>Email:</strong> {{ $user->email }}</p>

        @php
            $avatar = asset('assets/imagen/avatar.webp'); // avatar por defecto
            if(isset($user->imagen_perfil)) {
                $avatar = Str::startsWith($user->imagen_perfil, ['http://', 'https://'])
                            ? $user->imagen_perfil   // avatar de Google
                            : asset('uploads/'.$user->imagen_perfil); // avatar local
            }
        @endphp

        <img src="{{ $avatar }}" alt="Avatar" class="perfil-img">


        <!-- Menú lateral -->
        <ul class="menu-perfil">
            <li><a href="#" onclick="mostrarSeccion('panel')">Panel Principal</a></li>
            <li><a href="#" onclick="mostrarSeccion('reservar')">Reservar Cita</a></li>
            <li><a href="#" onclick="mostrarSeccion('mis-reservas')">Mis Reservas</a></li>
            <li><a href="#" onclick="mostrarSeccion('perfil')">Editar Perfil</a></li>
        </ul>

        <a href="#" 
        onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
        class="btn-cerrar">
        Cerrar sesión
        </a>


        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
            @csrf
        </form>
    </div>

    <!-- Contenido principal -->
    <div class="contenido-principal">
        <!-- Panel Principal -->
        <div id="panel" class="seccion" style="display:block;">
            <h1>Bienvenido, {{ $user->name }} {{ $user->apellido_paterno }} {{ $user->apellido_materno }}</h1>
            <div id="calendar-wrapper">
    <div id="calendar"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let calendarEl = document.getElementById('calendar');
    if (!calendarEl) return;

    let calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'es',
        initialView: window.innerWidth < 768 ? 'listWeek' : 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next',
            center: 'title',
            right: ''
        },
        events: @json($eventos),
        height: 'auto',
        contentHeight: 'auto',
        eventDisplay: 'block',
        displayEventTime: false,
        dayHeaderFormat: { weekday: 'long' }, // nombres completos
        datesDidMount: function(info) {
            // Encabezados de días y títulos de lista
            let els = info.el.querySelectorAll('.fc-col-header-cell-cushion, .fc-list-heading');
            els.forEach(e => e.style.color = "#000");
        },
        eventDidMount: function(info) {
            // Eventos en negro
            info.el.style.color = "#000";

            // Mantener saltos de línea si hay "|"
            let titleEl = info.el.querySelector('.fc-event-title');
            if (titleEl) {
                titleEl.innerHTML = info.event.title.replace(/\|/g, '<br>');
            }
        }
    });

    calendar.render();

    // Responsividad real
    window.addEventListener("resize", () => {
        if (window.innerWidth < 768) {
            calendar.changeView('listWeek');
        } else {
            calendar.changeView('dayGridMonth');
        }
    });
});


</script>

                
        </div>
        

        <!-- Reservar Cita -->
        <div id="reservar" class="seccion">
            @include('reservas.crear') 
        </div>

        <!-- Mis Reservas -->
        <div id="mis-reservas" class="seccion">
            <style>
    /* Responsive tabla */
                @media only screen and (max-width: 768px) {
                    table, thead, tbody, th, td, tr {
                        display: block;
                        width: 100% !important;
                    }

                    thead tr { display: none; }

                    tr {
                        margin-bottom: 15px;
                        border: 1px solid #ddd;
                        border-radius: 8px;
                        padding: 10px;
                    }

                    td {
                        display: flex;
                        justify-content: space-between;
                        padding: 6px 10px;
                        border-bottom: 1px solid #eee;
                        flex-wrap: wrap;
                    }

                    td:last-child { border-bottom: 0; }

                    td:before {
                        content: attr(data-label);
                        font-weight: bold;
                        flex: 1 0 100%;
                        margin-bottom: 4px;
                    }

                    .celda-botones {
                        flex-direction: column;
                        gap: 5px;
                    }

                    .reprogramar-form {
                        display: block !important;
                        width: 100%;
                        margin-top: 10px;
                    }

                    .form-reprogramar-inline > div {
                        flex: 1 1 100% !important; /* cada input ocupa todo el ancho */
                        margin-bottom: 8px;
                    }

                    .form-reprogramar-inline button {
                        width: 100%; /* botón ocupa todo el ancho */
                    }
                }
            </style>

            <h1>Mis Reservas</h1>
            <table>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Servicio</th>
                        <th>Precio</th>
                        <th>Duración</th>
                        <th>Estado</th>
                        <th>Barbero</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservas as $reserva)
                        <tr>
                            <td>{{ $reserva->fecha_reserva }}</td>
                            <td>{{ $reserva->hora_reserva }}</td>
                            <td>{{ $reserva->servicio->nombre ?? 'N/A' }}</td>
                            <td>Bs {{ $reserva->servicio->precio ?? '0' }}</td>
                            <td>{{ $reserva->duracion }} min</td>
                            <td>{{ $reserva->estado }}</td>
                            <td>{{ $reserva->barbero->nombre }} {{ $reserva->barbero->apellido }}</td>
                            <td class="celda-botones">
                                @if($reserva->estado == 'pendiente')
                                    <form action="{{ route('reservas.cancelar', $reserva->id) }}" method="POST" style="display:inline" class="form-cancelar" data-reserva-id="{{ $reserva->id }}">
                                        @csrf
                                        <button type="submit">Cancelar</button>
                                    </form>
                                    <a href="#" class="btn-accion" onclick="mostrarReprogramar({{ $reserva->id }})">Reprogramar</a>

                                    <!-- Formulario inline reprogramar -->
                                    <div class="reprogramar-form" id="reprogramar-{{ $reserva->id }}">
                                        @include('reservas.reprogramar', ['reserva' => $reserva])
                                    </div>
                                @else
                                    <span>No disponible</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No tienes reservas todavía.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


        <!-- Editar Perfil -->
        <div id="perfil" class="seccion">
            <h2>Editar Perfil</h2>

            <form action="{{ route('perfil.actualizar') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <label>Nombre:</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required>

                <label>Apellido Paterno:</label>
                <input type="text" name="apellido_paterno" value="{{ old('apellido_paterno', $user->apellido_paterno) }}">

                <label>Apellido Materno:</label>
                <input type="text" name="apellido_materno" value="{{ old('apellido_materno', $user->apellido_materno) }}">

                <label>Email:</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required>

                <label>Foto de Perfil:</label>
                {{-- Input para subir nueva imagen manualmente --}}
                <input type="file" name="imagen">
                {{-- Mostrar imagen --}}
                @if(isset($user->imagen_perfil))
                    @php
                        // Si la URL comienza con http, es un avatar de Google
                        $imgSrc = Str::startsWith($user->imagen_perfil, ['http://', 'https://']) 
                                ? $user->imagen_perfil 
                                : asset('uploads/'.$user->imagen_perfil);
                    @endphp
                    <img src="{{ $imgSrc }}" alt="Perfil" class="perfil-img">
                @endif

                <button type="submit">Guardar Cambios</button>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Mostrar secciones
        function mostrarSeccion(seccion) {
            document.querySelectorAll('.seccion').forEach(s => s.style.display = 'none');
            const target = document.getElementById(seccion);
            if(target) target.style.display = 'block';
        }

        // Mostrar formulario inline de reprogramar
        function mostrarReprogramar(reservaId){
            const form = document.getElementById('reprogramar-' + reservaId);
                if (!form) return;

                // Si está visible, lo ocultamos, si está oculto, lo mostramos
                if (form.style.display === 'block') {
                    form.style.display = 'none';
                } else {
                    document.querySelectorAll('.reprogramar-form').forEach(f => f.style.display = 'none'); // oculta otros
                    form.style.display = 'block';
                }
            }
        

        // Cancelar reserva con SweetAlert y preguntar si reprogramar
        document.querySelectorAll('.form-cancelar').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "Esta acción cancelará tu reserva.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d4af37', cancelButtonColor: '#d4af37',
                    confirmButtonText: 'Sí, cancelar',
                    cancelButtonText: 'No, mantener'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Envía el formulario
                        fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': form.querySelector('[name="_token"]').value
                            }
                        }).then(response => {
                            if(response.ok){
                                Swal.fire({
                                    title: 'Reserva cancelada',
                                    text: '¿Deseas reprogramarla?',
                                    icon: 'info',
                                    showCancelButton: true,
                                    confirmButtonColor: '#d4af37', cancelButtonColor: '#d4af37',
                                    confirmButtonText: 'Sí, reprogramar',
                                    cancelButtonText: 'No'
                                }).then(r => {
                                    if(r.isConfirmed){
                                        mostrarReprogramar(form.dataset.reservaId);
                                    } else {
                                        location.reload(); // recarga la página para actualizar tabla
                                    }
                                });
                            }
                        });
                    }
                });
            });
        });

        // Mensajes de sesión
        @if(session('success'))
            Swal.fire({ icon: 'success', title: '{{ session('success') }}', showConfirmButton: false, timer: 2000 });
        @endif

        @if(session('error'))
            Swal.fire({ icon: 'error', title: '{{ session('error') }}', showConfirmButton: true });
        @endif

        // Errores de validación
        @if($errors->any())
            let errorMsg = "";
            @foreach($errors->all() as $error)
                errorMsg += "{{ addslashes($error) }}\n";
            @endforeach
            Swal.fire({ icon: 'error', title: 'Errores en el formulario', text: errorMsg, confirmButtonText: 'Aceptar' });
        @endif
    </script>

</body>
</html>
