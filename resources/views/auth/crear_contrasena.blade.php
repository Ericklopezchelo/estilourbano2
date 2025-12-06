<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Crear Contraseña</title>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">

<style>
/* Fuente general */
body {
    font-family: 'Roboto', sans-serif;
    background-image: url(../imagen/img2.webp);
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    background-attachment: fixed;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    position: relative;
}

body::before {
    content: "";
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.4); /* fondo opaco */
    z-index: 0;
}

/* Contenedor del formulario */
.form-container {
    background-color: #fffaf2; /* crema */
    padding: 40px 30px;
    border-radius: 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    width: 100%;
    max-width: 400px;
    box-sizing: border-box;
    position: relative;
    z-index: 1;
    border: 2px solid #d4af37; /* borde dorado */
}

/* Título */
.form-container h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #6b4f1d; /* dorado oscuro */
    font-weight: 500;
}

/* Descripción */
.form-container p {
    text-align: center;
    margin-bottom: 20px;
    font-size: 14px;
    color: #6b4f1d; /* dorado oscuro */
}

/* Input flotante */
.form-group {
    position: relative;
    margin-bottom: 25px;
}

.form-group input {
    width: 100%;
    padding: 12px 12px;
    font-size: 16px;
    border: 1px solid #d4af37; /* borde dorado */
    border-radius: 10px;
    background: #fffaf2;
    color: #6b4f1d;
    outline: none;
    transition: border-color 0.2s;
}

.form-group input:focus {
    border-color: #6b4f1d; /* dorado oscuro */
}

.form-group label {
    position: absolute;
    top: 50%;
    left: 12px;
    transform: translateY(-50%);
    color: #6b4f1d;
    font-size: 16px;
    pointer-events: none;
    transition: 0.2s all;
}

.form-group input:focus + label,
.form-group input:not(:placeholder-shown) + label {
    top: -8px;
    left: 8px;
    font-size: 12px;
    color: #d4af37; /* dorado claro */
    background-color: #fffaf2;
    padding: 0 4px;
}

/* Botón */
button {
    width: 100%;
    padding: 12px;
    background-color: #d4af37; /* dorado claro */
    color: #6b4f1d; /* dorado oscuro */
    font-size: 16px;
    font-weight: 500;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
}

button:hover {
    background-color: #6b4f1d; /* dorado oscuro */
    color: #fff;
    transform: translateY(-2px);
}

/* Mensajes de error y éxito */
.errors, .success {
    margin-top: 10px;
    font-size: 14px;
}

.errors li {
    color: #d93025; /* rojo para errores */
}

.success {
    color: #188038; /* verde para éxito */
    font-weight: 500;
}
</style>
</head>
<body>

<div class="form-container">
    <h2>Crear Contraseña</h2>
    <p>
        Crea una contraseña para que puedas iniciar sesión con Gmail y tu nueva contraseña.
    </p>

    <form action="{{ route('perfil.crearContrasena') }}" method="POST">
        @csrf
        <div class="form-group">
            <input type="password" name="password" required placeholder=" ">
            <label>Contraseña</label>
        </div>

        <div class="form-group">
            <input type="password" name="password_confirmation" required placeholder=" ">
            <label>Confirmar Contraseña</label>
        </div>

        <button type="submit">Guardar Contraseña</button>

        @if ($errors->any())
            <ul class="errors">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        @if(session('success'))
            <div class="success">
                {{ session('success') }}
            </div>
        @endif
    </form>
</div>

</body>
</html>
