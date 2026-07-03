<?php
require_once "../config/conexion.php";
define('BASE_PATH', '../');
require_once "../includes/auth.php";
requerir_admin();

$id_usuario = trim($_POST["id_usuario"] ?? "");
$id_libro = trim($_POST["id_libro"] ?? "");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procesar Nuevo Préstamo - Biblioteca</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="feedback-container">

        <?php if ($id_usuario == "" || $id_libro == ""): ?>
            <h1>Datos Incompletos</h1>
            <div class="alerta">
                <p>Por favor, selecciona un usuario y un libro válidos del formulario.</p>
            </div>
            <a class="boton" href="añadir_prestamo.php">Volver al formulario</a>

        <?php else:
            // 1. Obtener detalles del libro
            $sqlLibroInfo = "SELECT titulo FROM libros WHERE id_libro = ?";
            $stmtLibro = mysqli_prepare($conexion, $sqlLibroInfo);
            mysqli_stmt_bind_param($stmtLibro, "i", $id_libro);
            mysqli_stmt_execute($stmtLibro);
            $resLibroInfo = mysqli_stmt_get_result($stmtLibro);
            $libro = mysqli_fetch_assoc($resLibroInfo);
            mysqli_stmt_close($stmtLibro);

            // 2. Obtener detalles del usuario
            $sqlUsuarioInfo = "SELECT nombre, apellidos FROM usuarios WHERE id_usuario = ?";
            $stmtUsuario = mysqli_prepare($conexion, $sqlUsuarioInfo);
            mysqli_stmt_bind_param($stmtUsuario, "i", $id_usuario);
            mysqli_stmt_execute($stmtUsuario);
            $resUsuarioInfo = mysqli_stmt_get_result($stmtUsuario);
            $usuario = mysqli_fetch_assoc($resUsuarioInfo);
            mysqli_stmt_close($stmtUsuario);

            if (!$libro || !$usuario):
            ?>
                <h1>Error de Selección</h1>
                <div class="alerta">
                    <p>El libro o el usuario seleccionado no existen en el sistema.</p>
                </div>
                <a class="boton" href="añadir_prestamo.php">Volver al formulario</a>

            <?php else:
                // 3. Comprobar si el libro ya está prestado (seguridad adicional concurrente)
                $sqlVerificar = "SELECT * FROM prestamos WHERE id_libro = ? AND devuelto = 0";
                $stmtVerificar = mysqli_prepare($conexion, $sqlVerificar);
                mysqli_stmt_bind_param($stmtVerificar, "i", $id_libro);
                mysqli_stmt_execute($stmtVerificar);
                $resVerificar = mysqli_stmt_get_result($stmtVerificar);

                if (mysqli_num_rows($resVerificar) > 0):
                    mysqli_stmt_close($stmtVerificar);
                ?>
                    <h1>Libro No Disponible</h1>
                    <div class="alerta">
                        <p>El libro "<strong><?php echo htmlspecialchars($libro['titulo']); ?></strong>" ya se encuentra prestado actualmente.</p>
                    </div>
                    <a class="boton" href="añadir_prestamo.php">Volver al formulario</a>

                <?php else:
                    mysqli_stmt_close($stmtVerificar);
                    // 4. Registrar el préstamo
                    $sqlInsertar = "INSERT INTO prestamos (id_usuario, id_libro, fecha_prestamo, devuelto) VALUES (?, ?, CURDATE(), 0)";
                    $stmtInsertar = mysqli_prepare($conexion, $sqlInsertar);
                    mysqli_stmt_bind_param($stmtInsertar, "ii", $id_usuario, $id_libro);

                    if (mysqli_stmt_execute($stmtInsertar)):
                        mysqli_stmt_close($stmtInsertar);
                    ?>
                        <h1>¡Préstamo Registrado!</h1>
                        <div class="alerta-exito">
                            <p>El libro "<strong><?php echo htmlspecialchars($libro['titulo']); ?></strong>" ha sido prestado con éxito a <strong><?php echo htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellidos']); ?></strong>.</p>
                        </div>
                        <a class="boton" href="../index.php">Volver al inicio</a>
                    <?php else:
                        $error_db = mysqli_stmt_error($stmtInsertar);
                        mysqli_stmt_close($stmtInsertar);
                    ?>
                        <h1>Error de Registro</h1>
                        <div class="alerta">
                            <p>Error al procesar el préstamo en la base de datos: <?php echo htmlspecialchars($error_db); ?></p>
                        </div>
                        <a class="boton" href="añadir_prestamo.php">Volver al formulario</a>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>

    </div>
</body>
</html>
<?php
mysqli_close($conexion);
?>
