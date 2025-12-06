<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acerca De</title>
    <link rel="stylesheet" href="assets/css/stylenoso.css">
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

    <!-- Sección Acerca De -->
    <section class="about">
        <div class="container">
            <div class="about-content">
                <div class="about-text">
                    <h2>Descubre nuestra historia</h2>
                    <p>Somos un equipo apasionado dedicado a proporcionar servicios de alta calidad para satisfacer todas tus necesidades de belleza y cuidado personal.</p>
                    <p>Nuestro compromiso con la excelencia y la satisfacción del cliente nos ha convertido en un referente en el sector. Ven y descubre lo que podemos hacer por ti.</p>
                    <p>En Estilo Urbano, creemos que cada cliente merece una experiencia única y personalizada. Nuestro equipo de profesionales está aquí para asesorarte y ofrecerte los mejores servicios adaptados a tus gustos y necesidades.</p>
                    <p>Contamos con un ambiente acogedor y un equipo altamente capacitado que se preocupa por cada detalle para que te sientas cómodo y relajado durante tu visita.</p>
                    <p>¡Te esperamos para que vivas una experiencia inolvidable!</p>
                    <p>Estamos ubicados San Martin entre honduras  y Ismael Montes</p>
                </div>
                <div class="about-image">
                    <img src="{{ asset('assets/imagen/img4.webp') }}" alt="Acerca De Nosotros">

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
            position: fixed;
            bottom: 0;
            width: 100;
            left: 0; /* Asegura que comience desde el borde izquierdo */
            right: 0;
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
