<?php
include_once "../auth/auth_helper.php";
requerir_login();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Nuevo Libro</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>
    <h1>Añadir Nuevo Libro</h1>
    <p>Formulario para agregar un nuevo libro al catálogo de la biblioteca.</p>

    <form action="procesar_libro.php" method="POST">
        <label for="isbn">ISBN:</label>
        <input type="text" id="isbn" name="isbn" required>

        <label for="titulo">Título del Libro:</label>
        <input type="text" id="titulo" name="titulo" required>

        <label for="autor">Autor:</label>
        <input type="text" id="autor" name="autor" required>

        <label for="genero">Género:</label>
        <input type="text" id="genero" name="genero" required>

        <label for="año_publicacion">Año de Publicación:</label>
        <input type="number" id="año_publicacion" name="año_publicacion" required>

        <label for="numero_paginas">Número de Páginas:</label>
        <input type="number" id="numero_paginas" name="numero_paginas" required>

        <button type="submit">Añadir Libro</button>
    </form>

    <a class="volver" href="../index.php">← Volver al inicio</a>

</body>

</html>
