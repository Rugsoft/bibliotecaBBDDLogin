<?php
include_once "../auth/auth_helper.php";
requerir_login();
require_once "../config/conexion.php";

$id = trim($_GET["id"] ?? "");
$libro = null;

if ($id != "") {
    $sql = "SELECT * FROM libros WHERE id_libro = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $libro = mysqli_fetch_assoc($res);
    mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Libro - Biblioteca</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <h1>Modificar Libro</h1>
    <p>Actualizar los datos del ejemplar seleccionado.</p>

    <?php if (!$libro): ?>
        <div class="feedback-container">
            <div class="alerta">
                <p>El libro solicitado no existe o no se especificó un ID válido.</p>
            </div>
            <a class="boton" href="listar_libros.php">Volver al listado</a>
        </div>
    <?php else: ?>
        <form action="procesar_modificar_libro.php" method="POST">
            <input type="hidden" name="id_libro" value="<?php echo htmlspecialchars($libro['id_libro']); ?>">

            <label for="isbn">ISBN:</label>
            <input type="text" id="isbn" name="isbn" value="<?php echo htmlspecialchars($libro['isbn']); ?>" required>

            <label for="titulo">Título del Libro:</label>
            <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($libro['titulo']); ?>" required>

            <label for="autor">Autor:</label>
            <input type="text" id="autor" name="autor" value="<?php echo htmlspecialchars($libro['autor']); ?>" required>

            <label for="genero">Género:</label>
            <input type="text" id="genero" name="genero" value="<?php echo htmlspecialchars($libro['genero']); ?>" required>

            <label for="año_publicacion">Año de Publicación:</label>
            <input type="number" id="año_publicacion" name="año_publicacion" value="<?php echo htmlspecialchars($libro['año']); ?>" required>

            <label for="numero_paginas">Número de Páginas:</label>
            <input type="number" id="numero_paginas" name="numero_paginas" value="<?php echo htmlspecialchars($libro['paginas']); ?>" required>

            <button type="submit">Guardar Cambios</button>
        </form>
        <a class="volver" href="listar_libros.php">← Cancelar y Volver</a>
    <?php endif; ?>
</body>
</html>
<?php mysqli_close($conexion); ?>

