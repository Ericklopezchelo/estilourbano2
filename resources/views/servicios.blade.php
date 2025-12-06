<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios</title>
    <link rel="stylesheet" href="{{ asset('assets/css/styleserv.css') }}">
</head>
<body>
    <!-- Navegación minimalista para ir atrás -->
    <nav class="nav-back">
        <a href="#" onclick="history.back(); return false;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            INICIO
        </a> 
    </nav>

    <!-- Sección de servicios -->
    <section class="services">
        <div class="container">
            <h2>Nuestros Servicios</h2>
            <div class="services-grid">
                <div class="service-item">
                    <img src="assets/imagen/cortecabello.webp" alt="Servicio 1">
                    <h3>Corte de Cabello</h3>
                    <p>Ofrecemos cortes de cabello profesionales para todos los estilos y edades.</p>
                </div>
                <div class="service-item">
                    <img src="assets/imagen/afeitadobarba.webp" alt="Servicio 2">
                    <h3>Afeitado Clásico</h3>
                    <p>Disfruta de un afeitado clásico con navaja y toallas calientes.</p>
                </div>
                <div class="service-item">
                    <img src="assets/imagen/tratamientocapilar.webp" alt="Servicio 3">
                    <h3>Tratamiento Capilar</h3>
                    <p>Mantén tu cabello saludable con nuestros tratamientos capilares personalizados.</p>
                </div>
                <div class="service-item">
                    <img src="assets/imagen/tinte.webp" alt="Servicio 4">
                    <h3>Coloración</h3>
                    <p>Actualiza tu look con nuestros servicios de coloración profesional.</p>
                </div>
                <div class="service-item">
                    <img src="assets/imagen/peinado.webp" alt="Servicio 4">
                    <h3>Peinados</h3>
                    <p>Ofrecemos una amplia variedad de servicios de peinados para adaptarnos a tus necesidades</p>
                </div>
            </div>
        </div>
    </section>
    
    <footer class="footer">
    <div class="footer-content">
        <a href="https://www.facebook.com/100063620063677/about/?_rdr" target="_blank">
            <img src="assets/imagen/facebook.webp" alt="facebook" width="40">
        </a>
        <a href="https://www.instagram.com/" target="_blank">
            <img src="assets/imagen/instagram.webp" alt="instagram" width="40">
        </a> 
        <a href="https://wa.me/59171454425" target="_blank">
            <img src="assets/imagen/whatsapp.webp" alt="whatsaap" width="40">
        </a>
    </div>
    </footer>
    <style>
        .footer {
            background-color:rgb(49, 49, 49);
            padding: 20px;
            text-align: center;
        }
        .footer-content{
            display: flex;
            flex-direction: row; /* Acomoda los elementos en columna */
            align-items: center; /* Centra los elementos en el eje horizontal */
            justify-content: center;
            gap: 15px; /* Espacio entre los íconos */
        }

        .footer-content a {
            width: 50px;
            height: 50px;
            background: white;
            border-radius: 50%;
            align-items: center; /* Centra los elementos en el eje horizontal */
            display: flex;
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
</body>
</html>
