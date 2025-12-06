<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel de Barbero')</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background: #f0f2f5; }

        .dashboard-container { display: flex; min-height: 100vh; }

        .sidebar-barbero {
            width: 300px;
            background: linear-gradient(180deg, #d3b657, #c7a021);
            color: #fff;
            padding: 40px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
            box-shadow: 4px 0 20px rgba(0,0,0,0.3);
            position: fixed;
            height: 100vh;
            border-top-right-radius: 20px;
            border-bottom-right-radius: 20px;
            transition: all 0.3s ease;
        }

        .sidebar-barbero h2 { font-size: 22px; text-align: center; }
        .sidebar-barbero p { font-size: 15px; text-align: center; }

        .sidebar-barbero img {
            width: 100px; height: 100px; border-radius: 50%;
            object-fit: cover; border: 3px solid #fff;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2); margin-bottom: 15px;
        }

        .sidebar-barbero .acciones { width: 100%; }
        .sidebar-barbero .acciones a {
            display: block; padding: 12px; margin-bottom: 10px;
            border-radius: 10px; background: rgba(255,255,255,0.15);
            color: #fff; text-align: center; text-decoration: none;
            font-weight: 500; transition: all 0.3s ease; cursor: pointer;
        }

        .sidebar-barbero .acciones a:hover {
            background: #fff; color: #c7a021; transform: translateX(5px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        .sidebar-barbero .cerrar-sesion {
            margin-top: auto; background: #fff; color: #c7a021;
            padding: 10px 25px; border-radius: 30px; font-weight: 600;
            width: 100%; text-align: center; text-decoration: none;
            transition: all 0.3s ease;
        }

        .sidebar-barbero .cerrar-sesion:hover {
            background: #ffe08a; color: #9c7200; transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        /* 🔹 Apartado de reservas */
        .sidebar-barbero .reservas { width: 100%; margin-top: 10px; }
        .sidebar-barbero .reservas a {
            display: block; padding: 12px; margin-bottom: 10px;
            border-radius: 10px; background: rgba(255,255,255,0.15);
            color: #fff; text-align: center; text-decoration: none;
            font-weight: 500; transition: all 0.3s ease; cursor: pointer;
        }

        .sidebar-barbero .reservas a:hover {
            background: #fff; color: #c7a021; transform: translateX(5px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        .contenido {
            flex: 1; margin-left: 300px; padding: 50px;
            background: #f9fafb; transition: all 0.3s ease;
        }

        .seccion {
            display: none; background: #fff; padding: 25px; border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 20px;
        }

        form { display: flex; flex-direction: column; gap: 15px; }
        input, select, button {
            padding: 12px; border-radius: 8px; border: 1px solid #ccc;
            font-size: 15px; outline: none;
        }
        button {
            background: #c7a021; color: #fff; font-weight: 600;
            border: none; cursor: pointer; transition: all 0.3s ease;
        }
        button:hover { background: #9c7200; transform: scale(1.05); }

        /* ✅ TABLA RESPONSIVA Y MÁS MARCADA 🔥 */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            background: #fff;
            border: 2.5px solid #c7a021; /* borde más grueso */
            box-shadow: 0 5px 15px rgba(0,0,0,0.15); /* sombra para marcar */
            border-radius: 8px;
            overflow: hidden;
        }

        th {
            background: #c7a021;
            color: white;
            font-weight: 600;
            padding: 10px;
            border-bottom: 3.5px solid #9c7200; /* línea header más marcada */
        }

        td {
            padding: 10px;
            border: 2px solid #d6b53a; /* borde más visible */
            font-size: 15px;
            white-space: nowrap;
        }

        /* Tablets */
        @media (max-width: 1024px) {
            th, td { font-size: 14px; padding: 8px; }
        }

        /* 📱 MODO TARJETA REAL EN CELULAR ✅ */
        @media (max-width: 768px) {
            table thead { display: none; }

            table, tbody, tr, td {
                display: block;
                width: 100%;
            }

            tr {
                background: #fff;
                margin-bottom: 15px;
                border-radius: 12px;
                border: 2.5px solid #c7a021; /* tarjeta más marcada */
                box-shadow: 0 6px 14px rgba(0,0,0,0.2);
                padding: 15px;
            }

            td {
                padding: 8px 0;
                font-size: 14px;
                border: none;
                border-bottom: 1.8px solid #eee;
                text-align: right;
                position: relative;
                white-space: normal;
            }

            td::before {
                content: attr(data-label);
                position: absolute;
                left: 0;
                width: 50%;
                text-align: left;
                font-weight: 700;
                color: #9c7200;
                font-size: 14px;
            }

            td:last-child { border-bottom: none; }
        }

        /* 🔹 TAG ESTADO */
        .tag-estado {
            padding: 5px 10px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            float: left;
        }

        /* 🔹 Botones de estado */
        .estado-btn {
            padding: 6px 10px; border-radius: 6px; border: none; color: #fff;
            cursor: pointer; font-size: 13px; margin-right: 4px;
        }
        .btn-verde { background: #28a745; }
        .btn-rojo { background: #dc3545; }
        .btn-gris { background: #6c757d; }
        .btn-verde:hover { background: #218838; }
        .btn-rojo:hover { background: #c82333; }
        .btn-gris:hover { background: #5a6268; }

        /* ✅ SIDEBAR GENERAL RESPONSIVE */
        @media(max-width:768px) {
            .dashboard-container { flex-direction: column; }
            .sidebar-barbero { width: 100%; height: auto; border-radius: 0; position: relative; }
            .contenido { margin-left: 0; padding: 20px; }
        }

        /* Sidebar reservas ajustes */
        @media (max-width: 1024px) {
            .sidebar-barbero .reservas a { padding: 10px; font-size: 14px; }
        }
        @media (max-width: 480px) {
            .sidebar-barbero .reservas a { padding: 8px; font-size: 12px; }
        }
    </style>


</head>
<body>

<div class="dashboard-container">

    <!-- Sidebar -->
    <div class="sidebar-barbero">
        <h2>{{ $barbero->nombre }} {{ $barbero->apellido }}</h2>
        <p><strong>Email:</strong> {{ $barbero->email }}</p>

        <div style="position: relative; display: inline-block;">
            @php
                $avatarPath = $barbero->imagen_perfil && file_exists(public_path($barbero->imagen_perfil))
                            ? asset($barbero->imagen_perfil)
                            : asset('assets/imagen/avatar.webp');
            @endphp

            <img id="avatar-img" 
            src="{{ $barbero->imagen_perfil ? asset($barbero->imagen_perfil) . '?t=' . time() : asset('assets/imagen/avatar.png') }}" 
            alt="Avatar"
            style="width:100px; height:100px; border-radius:50%; object-fit:cover; border:3px solid #fff; box-shadow:0 5px 15px rgba(0,0,0,0.2);"

                style="width:100px; height:100px; border-radius:50%; object-fit:cover; border:3px solid #fff; box-shadow:0 5px 15px rgba(0,0,0,0.2);">

            <label for="avatar-input"
                style="position:absolute; bottom:0; right:0; background:#fff; color:#c7a021;
                        width:30px; height:30px; border-radius:50%; display:flex; justify-content:center;
                        align-items:center; cursor:pointer; font-weight:bold; font-size:20px;
                        border:2px solid #c7a021; box-shadow:0 2px 6px rgba(0,0,0,0.3); transition:all 0.3s ease;">
                +
            </label>

            <form id="avatar-form" action="{{ route('barbero.avatar.update') }}" method="POST" enctype="multipart/form-data" style="display:none;">
                @csrf
                <input type="file" name="imagen_perfil" id="avatar-input" accept="image/*">
            </form>
        </div>

        <script>
            const avatarInput = document.getElementById('avatar-input');
            const avatarForm = document.getElementById('avatar-form');
            const avatarImg = document.getElementById('avatar-img');

            avatarInput.addEventListener('change', function() {
                if(this.files && this.files[0]) {
                    // Vista previa inmediata
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        avatarImg.src = e.target.result;
                    }
                    reader.readAsDataURL(this.files[0]);

                    // Subir imagen automáticamente
                    avatarForm.submit();
                }
            });
        </script>
        
        <div class="acciones">
            <a onclick="mostrarSeccion('ver-citas')">Ver Citas</a>
        </div>

        <a href="{{ route('staff.logout') }}" class="cerrar-sesion"
        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        Cerrar Sesión
        </a>

        <form id="logout-form" action="{{ route('staff.logout') }}" method="POST" style="display:none;">
            @csrf
        </form>
    </div>
    <!-- Contenido principal -->
    <div class="contenido">
        <div id="panel-principal" class="seccion" style="display:block;">
            <h1>Bienvenido, {{ $barbero->nombre }}</h1>
            <p>Selecciona una opción del menú para ver detalles.</p>
        </div>
        <!-- Ver Citas -->
        <div id="ver-citas" class="seccion">
            <h1>Mis Reservas</h1>
            <table>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Hora Inicio</th>
                        <th>Hora Fin</th>
                        <th>Cliente</th>
                        <th>Email</th>
                        <th>Celular</th>
                        <th>Servicio</th>
                        <th>Duración (min)</th>
                        <th>Estado</th>
                        <th>Código</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservas as $reserva)
                    <tr>
                        <td>{{ $reserva->fecha_reserva }}</td>
                        <td>{{ $reserva->hora_reserva }}</td>
                        <td>{{ $reserva->hora_fin ?? '-' }}</td>
                        <td>{{ $reserva->nombre_completo }}</td>
                        <td>{{ $reserva->email }}</td>
                        <td>{{ $reserva->celular }}</td>
                        <td>{{ $reserva->servicio->nombre ?? 'N/A' }}</td>
                        <td>{{ $reserva->duracion }}</td>
                        <td>
                            <span class="tag-estado" style="
                                background:
                                    {{ $reserva->estado == 'Pendiente' ? '#f0ad4e' :
                                       ($reserva->estado == 'Atendido' ? '#28a745' :
                                       ($reserva->estado == 'Cancelado' ? '#dc3545' :
                                       ($reserva->estado == 'No vino' ? '#6c757d' : '#999'))) }};">
                                {{ ucfirst($reserva->estado) }}
                            </span>
                        </td>
                        <td>{{ $reserva->codigo_reserva }}</td>
                        <td>
                            @if(!in_array($reserva->estado, ['Atendido', 'Cancelado', 'No vino']))
                                <form action="{{ route('barbero.cambiar.estado', $reserva->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    <input type="hidden" name="estado" value="Atendido">
                                    <button type="submit" class="estado-btn btn-verde">Atendido</button>
                                </form>

                                <form action="{{ route('barbero.cambiar.estado', $reserva->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    <input type="hidden" name="estado" value="Cancelado">
                                    <button type="submit" class="estado-btn btn-rojo">Cancelado</button>
                                </form>

                                <form action="{{ route('barbero.cambiar.estado', $reserva->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    <input type="hidden" name="estado" value="No vino">
                                    <button type="submit" class="estado-btn btn-gris">No vino</button>
                                </form>
                            @else
                                <em>Estado finalizado</em>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

</div>

<script>
    function mostrarSeccion(seccionId) {
        document.querySelectorAll('.contenido .seccion').forEach(sec => sec.style.display = 'none');
        const target = document.getElementById(seccionId);
        if(target) target.style.display = 'block';
    }
</script>
</body>
</html>
