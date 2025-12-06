<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Barbería</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body>
    <!-- menu de navegacion -->
    <header class="header">
        <div class="menu container">
            <a href="#" class="logo">Estilo Urbano</a>
            <input type="checkbox" id="menu"/>
            <label for="menu" class="menu-icon">
                <img src="{{ asset('assets/imagen/menu.webp') }}" class="menu-icono" alt="Menú">
            </label>
            <nav class="navbar">
                <ul>
                    <li><a href="{{ url('/nosotros') }}">Acerca de</a></li>
                    <li><a href="{{ url('/servicios') }}">Servicios</a></li>
                    <li><a href="{{ url('/login_cliente') }}">Reservas</a></li>
                    <li><a href="{{ url('/login_cliente') }}">Inicia Sesión</a></li>
                </ul>
            </nav>
        </div>
        <div class="header-content container">
            <h1>Barbería</h1>
            <p>Descubre nuestros servicios de alta calidad para tu cuidado personal.</p>
            <a href="{{ url('/login_cliente') }}" class="btn-1">Haz tu reserva</a>
        </div>
    </header>

    <!-- Sección del blog -->
    <section class="blog container">
        <h2>Blog</h2>
        
        <div class="blog-content">
            <div class="blog-1">
                <img src="{{ asset('assets/imagen/formas.webp') }}" alt="Blog 1">
                <h3>Encuentra el corte de cabello perfecto</h3>
                <p>¿Alguna vez te has preguntado por qué ciertos cortes de cabello le quedan genial a algunos hombres y a otros no tanto? La clave radica en entender la relación entre la forma de tu rostro y el corte de cabello que mejor se adapta a ti. No te preocupes, ¡estamos aquí para ayudarte a descubrirlo! </p>
            </div>
            <div class="blog-1">
                <img src="{{ asset('assets/imagen/caida_del_cabello.webp') }}" alt="Blog 2">
                <h3>¿Perdida de cabello en grandes cantidades?</h3>
                <p>La alopecia es un mal que afecta tanto a hombres como a mujeres, esta es la pérdida del cabello en grandes cantidades. Aquí te diremos como evitarla, las causas más comunes y si la padeces como darle una solución efectiva.</p>
            </div>
            <div class="blog-1">
                <img src="{{ asset('assets/imagen/aceite_barba.webp') }}" alt="Blog 3">
                <h3>¿Qué es un aceite para barba?</h3>
                <p>Son varias las personas que nos escriben preguntando cuáles son los beneficios del aceite para barba, para qué sirve y cómo se aplica.
                Aquí te contamos todos los beneficios de usar aceites para la barba y te recomendamos algunos para que no tengas que pasar horas buscando.</p>
            </div>
        </div>
        <a href="{{ url('/login_cliente') }}" class="btn-1">¡Reserve Ahora!</a>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <a href="https://www.facebook.com/100063620063677/about/?_rdr" target="_blank">
                <img src="{{ asset('assets/imagen/facebook.webp') }}" alt="facebook" width="40">
            </a>
            <a href="https://www.instagram.com/" target="_blank">
                <img src="{{ asset('assets/imagen/instagram.webp') }}" alt="instagram" width="40">
            </a> 
            <a href="https://wa.me/59171454425" target="_blank">
                <img src="{{ asset('assets/imagen/whatsapp.webp') }}" alt="whatsapp" width="40">
            </a>
        </div>
    </footer>

    <style>
        .footer {
            background-color: rgb(49, 49, 49);
            padding: 20px;
            text-align: center;
        }
        .footer-content {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }
        .footer-content a {
            width: 50px;
            height: 50px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 10px;
            transition: transform 0.3s ease;
            text-decoration: none;
        }
        .footer-content a img {
            width: 30px;
        }
        .footer-content a:hover {
            transform: scale(1.1);
        }
    </style>

    <script>
        document.getElementById('menu').addEventListener('change', function() {
            const navbar = document.querySelector('.navbar ul');
            if (this.checked) {
                navbar.classList.add('active');
            } else {
                navbar.classList.remove('active');
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 2000
        });
    </script>
    @endif
</body>
</html>
