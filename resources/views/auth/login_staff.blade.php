<!-- resources/views/auth/login_staff.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Staff</title>
    <style>
        /* Fondo general */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-image: url('/assets/imagen/img2.webp');
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        body::before {
            content: "";                          /* contenido vacio */
            position: fixed;                      /* posicion fija */
            top: 0;                               /* posicion superior */
            left: 0;                              /* posicion izquierda */
            width: 100%;                          /* ancho completo */
            height: 100%;                         /* altura completa */
            background-color: rgba(0,0,0,0.4);  /* 40% de opacidad */
            z-index: 0;
        }

        /* Contenedor estilo vidrio */
        .login-container {
            background: rgba(255, 255, 255, 0.15); /* transparente para efecto vidrio */
            backdrop-filter: blur(10px); /* desenfoque de fondo */
            -webkit-backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 40px 50px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.2);
            color: #fff;
            width: 320px;
            text-align: center;
        }

        h2 {
            margin-bottom: 25px;
        }

        form div {
            margin-bottom: 20px;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: none;
            outline: none;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background-color: rgba(191, 160, 70, 0.85); /* dorado semitransparente */
            color: #fff;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: rgba(212, 175, 55, 0.85);
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Ingresa tus credenciales</h2>
        @if($errors->any())
    <div style="background: rgba(255,0,0,0.2); padding: 10px; margin-bottom: 15px; border-radius:5px;">
        {{ $errors->first() }}
    </div>
@endif
        <form action="{{ route('staff.login.submit') }}" method="POST">
            @csrf
            <div>
                <label>Correo Electronico:</label>
                <input type="email" name="email" required>
            </div>
            <div>
                <label>Contraseña:</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit">Ingresar</button>
        </form>
    </div>
</body>
</html>
