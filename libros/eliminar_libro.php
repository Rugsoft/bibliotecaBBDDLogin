<?php
require_once "../config/conexion.php";
define('BASE_PATH', '../');
require_once "../includes/auth.php";
requerir_admin();

$id = trim($_GET["id"] ?? "");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Libro - Biblioteca</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="feedback-container">
        <?php if ($id == ""): ?>
            <h1>Parámetro Inválido</h1>
            <div class="alerta">
                <p>No se especificó ningún libro para eliminar.</p>
            </div>
            <a class="boton" href="listar_libros.php">Volver al listado</a>
        <?php else:
            // Verificar si el libro tiene préstamos asociados
            $sqlCheck = "SELECT COUNT(*) AS total FROM prestamos WHERE id_libro = ?";
            $stmtCheck = mysqli_prepare($conexion, $sqlCheck);
            mysqli_stmt_bind_param($stmtCheck, "i", $id);
            mysqli_stmt_execute($stmtCheck);
            $resCheck = mysqli_stmt_get_result($stmtCheck);
            $check = mysqli_fetch_assoc($resCheck);
            mysqli_stmt_close($stmtCheck);

            if ($check['total'] > 0): ?>
                <h1>No se puede eliminar</h1>
                <div class="alerta">
                    <p>Este libro tiene préstamos registrados en su historial y no puede ser eliminado por integridad referencial.</p>
                </div>
                <a class="boton" href="listar_libros.php">Volver al listado</a>
            <?php else:
                // Obtener datos del libro para el mensaje
                $sqlLibro = "SELECT titulo FROM libros WHERE id_libro = ?";
                $stmtLibro = mysqli_prepare($conexion, $sqlLibro);
                mysqli_stmt_bind_param($stmtLibro, "i", $id);
                mysqli_stmt_execute($stmtLibro);
                $resLibro = mysqli_stmt_get_result($stmtLibro);
                $libro = mysqli_fetch_assoc($resLibro);
                $titulo = $libro ? $libro['titulo'] : 'Desconocido';
                mysqli_stmt_close($stmtLibro);

                $sqlDelete = "DELETE FROM libros WHERE id_libro = ?";
                $stmtDelete = mysqli_prepare($conexion, $sqlDelete);
                mysqli_stmt_bind_param($stmtDelete, "i", $id);
                if (mysqli_stmt_execute($stmtDelete)):
                    mysqli_stmt_close($stmtDelete);
                ?>
                    <h1>Libro Eliminado</h1>
                    <div class="alerta-exito">
                        <p>El libro "<strong><?php echo htmlspecialchars($titulo); ?></strong>" ha sido eliminado exitosamente del catálogo.</p>
                    </div>
                    <a class="boton" href="listar_libros.php">Volver al listado</a>
                <?php else:
                    $error_db = mysqli_stmt_error($stmtDelete);
                    mysqli_stmt_close($stmtDelete);
                ?>
                    <h1>Error de Borrado</h1>
                    <div class="alerta">
                        <p>Error al intentar borrar el libro: <?php echo htmlspecialchars($error_db); ?></p>
                    </div>
                    <a class="boton" href="listar_libros.php">Volver al listado</a>
                <?php endif;
            endif;
        endif; ?>
    </div>
</body>
</html>
<?php mysqli_close($conexion); ?>

