<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
    <style>
        /* Fondo general con imagen */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-image: url('{{ asset("assets/imagen/img2.webp") }}'); /* Imagen de fondo */
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            background-attachment: fixed;
            margin: 0;
            padding: 0;
            color: #333;
            position: relative;
        }

        /* Overlay oscuro */
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.4); /* 40% de opacidad */
            z-index: 0;
        }

        /* Contenedor del formulario */
        .reset-container {
            width: 90%;
            max-width: 500px;
            margin: 50px auto;
            background-color: rgba(255, 255, 255, 0.95);
            padding: 30px 40px;
            border-radius: 15px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.15);
            position: relative;
            z-index: 1; /* sobre el overlay */
            overflow: hidden;
        }

        /* Marca de agua sutil dentro del contenedor (opcional) */
        .reset-container::before {
            content: "";
            background-size: cover;
            background-position: center;
            opacity: 0.05;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
        }

        h2 {
            text-align: center;
            color: #1a1a1a;
            margin-bottom: 25px;
            position: relative;
            z-index: 1;
        }

        input {
            display: block;
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
            position: relative;
            z-index: 1;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #bfa046;
            color: #fff;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            position: relative;
            z-index: 1;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #d4af37;
        }

        .info {
            background-color: #fdf6e3;
            border-left: 5px solid #bfa046;
            padding: 10px 15px;
            margin-bottom: 15px;
            border-radius: 8px;
            position: relative;
            z-index: 1;
        }

        .forgot-password {
            text-align: center;
            margin-top: 10px;
            position: relative;
            z-index: 1;
        }

        .forgot-password a {
            color: #bfa046;
            text-decoration: none;
            font-weight: bold;
        }

        .forgot-password a:hover {
            color: #d4af37;
        }
        @media screen and (max-width: 600px) {
        .reset-container {
            width: 95%;
            padding: 20px;
            margin: 20px auto;
        }

        h2 {
            font-size: 22px;
            margin-bottom: 20px;
        }

        input, button {
            font-size: 14px;
            padding: 10px;
        }

        .forgot-password {
            font-size: 13px;
        }
    }

    </style>
</head>
<body>
    <div class="reset-container">
        <h2>Restablecer Contraseña</h2>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <input type="email" name="email" value="{{ $email ?? old('email') }}" placeholder="Correo Electrónico" required autofocus>
            <input type="password" name="password" placeholder="Nueva Contraseña" required>
            <input type="password" name="password_confirmation" placeholder="Confirmar Contraseña" required>

            <button type="submit">Actualizar Contraseña</button>

            @if ($errors->any())
                <div class="info">
                    <ul style="margin:0; padding-left:20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('status'))
                <div class="info" style="color:green;">
                    {{ session('status') }}
                </div>
            @endif
        </form>

        <p class="forgot-password">
            <a href="{{ route('login.form') }}">Volver al inicio de sesión</a>
        </p>
    </div>
</body>
</html>
