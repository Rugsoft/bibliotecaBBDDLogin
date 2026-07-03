<?php
require_once "../config/conexion.php";
define('BASE_PATH', '../');
require_once "../includes/auth.php";
requerir_admin();

// 1. Obtener todos los usuarios
$sqlUsuarios = "SELECT id_usuario, nombre, apellidos FROM usuarios ORDER BY nombre, apellidos ASC";
$stmtUsuarios = mysqli_prepare($conexion, $sqlUsuarios);
mysqli_stmt_execute($stmtUsuarios);
$resUsuarios = mysqli_stmt_get_result($stmtUsuarios);

// 2. Obtener libros disponibles (aquellos que no tienen un préstamo activo con devuelto = 0)
$sqlLibros = "SELECT id_libro, titulo, autor FROM libros 
            WHERE id_libro NOT IN (
                SELECT id_libro FROM prestamos WHERE devuelto = 0) 
            ORDER BY titulo ASC";
$stmtLibros = mysqli_prepare($conexion, $sqlLibros);
mysqli_stmt_execute($stmtLibros);
$resLibros = mysqli_stmt_get_result($stmtLibros);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Nuevo Préstamo - Biblioteca</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>
    <h1>Añadir Nuevo Préstamo</h1>
    <p>Registrar el préstamo de un libro disponible a un usuario de la biblioteca.</p>

    <form action="procesar_prestamo.php" method="POST">
        <label for="id_usuario">Seleccionar Usuario:</label>
        <select id="id_usuario" name="id_usuario" required>
            <option value="" disabled selected>-- Elige un usuario --</option>
            <?php while ($usuario = mysqli_fetch_assoc($resUsuarios)) { ?>
                <option value="<?php echo $usuario['id_usuario']; ?>">
                    <?php echo htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellidos']); ?>
                </option>
            <?php } ?>
        </select>

        <label for="id_libro">Seleccionar Libro Disponible:</label>
        <select id="id_libro" name="id_libro" required>
            <option value="" disabled selected>-- Elige un libro --</option>
            <?php
            if (mysqli_num_rows($resLibros) > 0) {
                while ($libro = mysqli_fetch_assoc($resLibros)) {
            ?>
                    <option value="<?php echo $libro['id_libro']; ?>">
                        <?php echo htmlspecialchars($libro['titulo'] . ' (' . $libro['autor'] . ')'); ?>
                    </option>
                <?php
                }
            } else {
                ?>
                <option value="" disabled>No hay libros disponibles en este momento</option>
            <?php
            }
            ?>
        </select>

        <button type="submit" <?php echo (mysqli_num_rows($resLibros) == 0) ? 'disabled style="background-color: var(--text-muted); cursor: not-allowed;"' : ''; ?>>
            Registrar Préstamo
        </button>
    </form>

    <a class="volver" href="../index.php">← Volver al inicio</a>
</body>

</html>
<?php
mysqli_stmt_close($stmtUsuarios);
mysqli_stmt_close($stmtLibros);
mysqli_close($conexion);
?>
