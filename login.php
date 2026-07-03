<?php
define('BASE_PATH', '');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['autenticado']) && $_SESSION['autenticado'] === true) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Biblioteca</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <h1>Iniciar Sesión</h1>
    <p>Accede al sistema con tu email y contraseña.</p>

    <form action="procesar_login.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Aceptar</button>
    </form>

    <p class="enlace-registro">¿No estás registrado? <a href="usuarios/añadir_usuario.php">Regístrate aquí</a></p>

    <a class="volver" href="index.php">← Volver al inicio</a>
</body>

</html>