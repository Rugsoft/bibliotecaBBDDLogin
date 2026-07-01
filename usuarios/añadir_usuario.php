<?php
include_once "../auth/auth_helper.php";
requerir_login();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Nuevo Usuario</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>
    <h1>Añadir Nuevo Usuario</h1>
    <p>Formulario para agregar un nuevo usuario al sistema de la biblioteca.</p>

    <form action="procesar_usuario.php" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" required>

        <button type="submit">Añadir Usuario</button>
    </form>

    <a class="volver" href="../index.php">← Volver al inicio</a>

</body>

</html>
