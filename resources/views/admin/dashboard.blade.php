<!-- resources/views/admin/dashboard.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif; }
        body { background:#f0f2f5; }

        .dashboard-container { display:flex; min-height:100vh; }

        /* Sidebar */
        .sidebar-admin {
            width:300px; 
            background:linear-gradient(180deg,#d3b657,#c7a021);
            color:#fff; 
            padding:40px 20px; 
            display:flex; 
            flex-direction:column;
            align-items:center; 
            gap:20px; 
            box-shadow:4px 0 20px rgba(0,0,0,0.3);
            position:fixed; 
            height:100vh; 
            border-top-right-radius:20px;
            border-bottom-right-radius:20px; 
            transition:all 0.3s ease;
        }
        .sidebar-admin h2 { font-size:22px; text-align:center; font-weight:700; }
        .sidebar-admin p { font-size:15px; text-align:center; font-weight:500; }
        .sidebar-admin img { 
            width:100px; height:100px; border-radius:50%; 
            object-fit:cover; border:3px solid #fff; 
            box-shadow:0 5px 15px rgba(0,0,0,0.2); margin-bottom:15px; 
        }

        .sidebar-admin .acciones { width:100%; }
        .sidebar-admin .acciones a {
            display:block; padding:12px; margin-bottom:10px; border-radius:10px;
            background:rgba(255,255,255,0.15); color:#fff; text-align:center; text-decoration:none;
            font-weight:600; cursor:pointer; transition:all 0.3s ease, color 0.3s ease;
            box-shadow:0 2px 5px rgba(0,0,0,0.15);
        }
        .sidebar-admin .acciones a:hover {
            background:rgba(255,255,255,0.35); font-weight:700; transform:translateX(5px);
            box-shadow:0 5px 15px rgba(0,0,0,0.3);
        }

        .sidebar-admin .cerrar-sesion {
            margin-top:auto; background:#fff; color:#c7a021; padding:10px 25px;
            border-radius:30px; font-weight:600; width:100%; text-align:center; text-decoration:none;
            transition:all 0.3s ease,color 0.3s ease;
        }
        .sidebar-admin .cerrar-sesion:hover { 
            background:#ffe08a; color:#9c7200; transform:translateY(-3px); 
            box-shadow:0 5px 15px rgba(0,0,0,0.2); 
        }

        /* Contenido principal */
        .contenido {
            flex: 1;
            margin-left: 300px; /* espacio para sidebar en desktop */
            padding: 50px;
            background: #f9fafb;
            transition: all 0.3s ease;
            min-width: 0; /* evita overflow en flexbox */
        }

        /* Secciones internas */
        .seccion {
            display: none;
            background: #fff;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            overflow-x: auto; /* scroll horizontal si algo se desborda */
        }

        /* Tablas adaptables */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            table-layout: fixed; /* evita que las columnas se desborden */
            word-wrap: break-word; /* fuerza que el texto largo se rompa */
        }
        table, th, td { border:1px solid #ccc; }
        th, td { padding:8px; text-align:left; }
        th { background:#e5e7eb; }

        /* Botones estado */
        .estado-btn { padding:6px 10px; border-radius:6px; border:none; color:#fff; cursor:pointer; font-size:13px; margin-right:4px; }
        .btn-verde { background:#28a745; } 
        .btn-rojo { background:#dc3545; } 
        .btn-gris { background:#6c757d; }
        .btn-verde:hover { background:#218838; } 
        .btn-rojo:hover { background:#c82333; } 
        .btn-gris:hover { background:#5a6268; }
        .tag-estado { padding:5px 10px; border-radius:8px; color:#fff; font-weight:600; font-size:13px; }

        /* Modal */
        #modal-editar, #modal-editar-servicio { 
            display:none; position:fixed; top:0; left:0; width:100%; height:100%; 
            background:rgba(0,0,0,0.6); align-items:center; justify-content:center; z-index:1000; 
        }
        .modal-contenido { background:#fff; padding:30px; border-radius:10px; width:400px; position:relative; }
        .modal-contenido h3 { margin-bottom:15px; font-weight:700; }
        .modal-contenido label { display:block; margin-bottom:5px; font-weight:600; }
        .modal-contenido input, .modal-contenido select { width:100%; padding:8px; margin-bottom:15px; border-radius:5px; border:1px solid #ccc; }
        .modal-contenido button { padding:8px 15px; border-radius:5px; border:none; cursor:pointer; }
        .btn-guardar { background:#28a745; color:#fff; margin-right:10px; }
        .btn-cancelar { background:#6c757d; color:#fff; }

        .btn-amarillo {
            background: #ffc107; color: #fff; border: none; padding: 6px 12px;
            border-radius: 6px; cursor: pointer; font-size: 13px; transition: all 0.3s ease;
        }
        .btn-amarillo:hover { background: #e0a800; }

        /* Media query para móviles */
        @media(max-width:768px) {
            .dashboard-container { flex-direction: column; }
            .sidebar-admin { 
                width: 100%; height: auto; border-radius: 0; position: relative; 
                padding: 20px; align-items: center; 
            }
            .contenido { margin-left: 0; padding: 20px; }
        }
        .btn-imprimir {
            background-color: #ffc107; /* amarillo */
            color: #fff; /* letras blancas */
            padding: 8px 15px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-imprimir:hover {
            background-color: #e0a800; /* amarillo más oscuro al pasar el mouse */
        }

    </style>

</head>
<body>

<div class="dashboard-container">
    <div class="sidebar-admin">
        <h2>{{ $admin->nombre }} {{ $admin->apellido }}</h2>
        <p><strong>Email:</strong> {{ $admin->email }}</p>
        @php $avatar = asset('assets/imagen/barberialogo.webp'); @endphp
        <img src="{{ $avatar }}" alt="Avatar">
        <div class="acciones">
            <a onclick="mostrarSeccion('agregar-barberos')">Barberos</a>
            <a onclick="mostrarSeccion('ver-barberos')">Ver Barberos</a>
            <a onclick="mostrarSeccion('servicios')">Servicios</a>
            <a onclick="mostrarSeccion('lista-servicio')">Ver Servicios</a>
            <a onclick="mostrarSeccion('reporte-reservas')">Reporte de Reservas</a>
        </div>
        <a href="{{ route('admin.logout') }}" class="cerrar-sesion"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar Sesión</a>
        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display:none;">@csrf</form>
    </div>

    <!-- Contenido principal -->
    <div class="contenido">
        <!-- Panel principal -->
        <div id="panel-principal" class="seccion" style="display:block;">
            <h1>Bienvenido, {{ $admin->nombre }}</h1>
            <p>Selecciona una opción del menú para ver detalles.</p>
        </div>

        <div id="agregar-barberos" class="seccion">
            <h1>Agregar Barberos</h1>
            @include('admin.tabla-barberos')
        </div>

        <div id="ver-barberos" class="seccion">
            <h1>Lista de Barberos</h1>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                        <th>Estado</th>
                        <th>Fecha Inicio Permiso</th>
                        <th>Fecha Fin Permiso</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($barberos as $barbero)
                        <tr>
                            <td>{{ $barbero->nombre }}</td>
                            <td>{{ $barbero->apellido }}</td>
                            <td>{{ $barbero->email }}</td>
                            <td>{{ $barbero->estado }}</td>
                            <td>{{ $barbero->fecha_inicio_permiso ?? '-' }}</td>
                            <td>{{ $barbero->fecha_fin_permiso ?? '-' }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm"
                                    onclick="abrirModal({{ $barbero->id }}, '{{ $barbero->estado }}', '{{ $barbero->fecha_inicio_permiso ?? '' }}', '{{ $barbero->fecha_fin_permiso ?? '' }}')">
                                    Editar
                                </button>
                                <form action="{{ route('admin.barbero.delete', $barbero->id) }}" method="POST" style="display:inline-block;"
                                    onsubmit="return confirm('¿Seguro que deseas eliminar este barbero?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div id="servicios" class="seccion">
            <h1>Servicios</h1>
            @include('admin.tabla-servicios')
        </div>

        <div id="lista-servicio" class="seccion">
            <h1>Lista de Servicios</h1>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Duración (min)</th>
                        <th>Precio (Bs)</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($servicios as $servicio)
                    <tr>
                        <td>{{ $servicio->nombre }}</td>
                        <td>{{ $servicio->descripcion ?? '-' }}</td>
                        <td>{{ $servicio->duracion }}</td>
                        <td>{{ $servicio->precio }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm"
                                onclick="abrirModalServicio(
                                    {{ $servicio->id }},
                                    '{{ addslashes($servicio->nombre) }}',
                                    '{{ addslashes($servicio->descripcion ?? '') }}',
                                    {{ $servicio->duracion }},
                                    {{ $servicio->precio }}
                                )">
                                Editar
                            </button>

                            <form action="{{ route('servicios.delete', $servicio->id) }}" method="POST" style="display:inline-block;"
                                  onsubmit="return confirm('¿Seguro que deseas eliminar este servicio?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="estado-btn btn-rojo">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Sección: Reporte de Reservas (pegar justo después de #lista-servicio) -->
<div id="reporte-reservas" class="seccion">
    <h1>Reporte de Reservas</h1>
    <p>Selecciona un rango de fechas para generar el reporte:</p>

    <form method="GET" action="{{ route('admin.reporte.reservas') }}">
        <input type="hidden" name="seccion" value="reporte-reservas">

        <label>Desde:</label>
        <input type="date" name="fecha_inicio" required value="{{ request('fecha_inicio') }}">

        <label>Hasta:</label>
        <input type="date" name="fecha_fin" required value="{{ request('fecha_fin') }}">

        <label>Barbero:</label>
        <select name="barbero_id">
            <option value="">Todos</option>
            @foreach($barberos as $barbero)
                <option value="{{ $barbero->id }}" 
                    {{ (string)request('barbero_id') === (string)$barbero->id ? 'selected' : '' }}>
                    {{ $barbero->nombre }} {{ $barbero->apellido }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="btn-amarillo">Generar Reporte</button>
    </form>


    @if(isset($reservas))
        <h3 style="margin-top:20px;">Resultados del Reporte ({{ $reservas->count() }})</h3>
        <table>
            <thead>
                <tr>
                    <th>cliente</th>
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

        <form action="{{ route('admin.reporte.reservas.pdf') }}" method="GET" target="_blank" style="margin-top:15px;">
            <input type="hidden" name="fecha_inicio" value="{{ request('fecha_inicio') }}">
            <input type="hidden" name="fecha_fin" value="{{ request('fecha_fin') }}">
            <input type="hidden" name="barbero_id" value="{{ request('barbero_id') }}">
            <button type="submit" class="btn-imprimir">🖨️ Imprimir PDF</button>
        </form>

    @endif
</div>
<!-- Fin sección reporte -->


    </div>
</div>

<!-- Modal barbero -->
<div id="modal-editar">
    <div class="modal-contenido">
        <h3>Editar Barbero</h3>
        <form id="form-editar" method="POST">
            @csrf
            @method('PUT')

            <label>Estado</label>
            <select name="estado" id="estado-edit">
                <option value="Activo">Activo</option>
                <option value="Permiso">Permiso</option>
            </select>

            <div id="fechas-permiso-container" style="display:none;">
                <label>Fecha inicio permiso</label>
                <input type="date" name="fecha_inicio_permiso" id="fecha_inicio_permiso-edit">
                <label>Fecha fin permiso</label>
                <input type="date" name="fecha_fin_permiso" id="fecha_fin_permiso-edit">
            </div>

            <button type="submit" class="btn-guardar">Guardar</button>
            <button type="button" class="btn-cancelar" onclick="cerrarModal()">Cancelar</button>
        </form>
    </div>
</div>
<!-- Fin modal barbero -->

<!-- Modal servicio -->
<div id="modal-editar-servicio">
    <div class="modal-contenido">
        <h3>Editar Servicio</h3>
        <form id="form-editar-servicio" method="POST">
            @csrf
            @method('PUT')

            <label>Nombre</label>
            <input type="text" name="nombre" id="nombre-servicio" required>

            <label>Descripción</label>
            <input type="text" name="descripcion" id="descripcion-servicio">

            <label>Duración (min)</label>
            <input type="number" name="duracion" id="duracion-servicio" required min="1">

            <label>Precio ($)</label>
            <input type="number" name="precio" id="precio-servicio" required min="0" step="0.01">

            <button type="submit" class="btn-guardar">Guardar</button>
            <button type="button" class="btn-cancelar" onclick="cerrarModalServicio()">Cancelar</button>
        </form>
    </div>
</div>
<!-- Fin modal servicio -->
<script>
function mostrarSeccion(seccionId) {
    document.querySelectorAll('.contenido .seccion').forEach(sec => sec.style.display='none');
    const target = document.getElementById(seccionId);
    if(target) target.style.display='block';
}

// Modal barbero
function abrirModal(id, estado, fechaInicio, fechaFin) {
    document.getElementById('modal-editar').style.display='flex';
    const form = document.getElementById('form-editar');
    form.action = '/admin/barbero/' + id;

    const estadoSelect = document.getElementById('estado-edit');
    const fechasContainer = document.getElementById('fechas-permiso-container');
    estadoSelect.value = estado;

    document.getElementById('fecha_inicio_permiso-edit').value = fechaInicio;
    document.getElementById('fecha_fin_permiso-edit').value = fechaFin;

    fechasContainer.style.display = estado==='Permiso'?'block':'none';

    estadoSelect.onchange = function(){
        fechasContainer.style.display = this.value==='Permiso'?'block':'none';
    };
}
function cerrarModal() { document.getElementById('modal-editar').style.display='none'; }

// Modal servicio
function abrirModalServicio(id, nombre, descripcion, duracion, precio){
    const modal = document.getElementById('modal-editar-servicio');
    modal.style.display = 'flex';

    const form = document.getElementById('form-editar-servicio');
    form.action = '/admin/servicios/' + id;

    document.getElementById('nombre-servicio').value = nombre;
    document.getElementById('descripcion-servicio').value = descripcion;
    document.getElementById('duracion-servicio').value = duracion;
    document.getElementById('precio-servicio').value = precio;
}
function cerrarModalServicio(){
    document.getElementById('modal-editar-servicio').style.display = 'none';
}
</script>
<script>
    window.addEventListener('DOMContentLoaded', () => {
        const seccion = "{{ request('seccion', '') }}";
        if(seccion){
            mostrarSeccion(seccion);
        }
    });
</script>

</body>
</html>
