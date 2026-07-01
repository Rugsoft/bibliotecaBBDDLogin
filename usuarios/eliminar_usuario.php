<?php
require_once "../config/conexion.php";

$id = trim($_GET["id"] ?? "");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Usuario - Biblioteca</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="feedback-container">
        <?php if ($id == ""): ?>
            <h1>Parámetro Inválido</h1>
            <div class="alerta">
                <p>No se especificó ningún usuario para eliminar.</p>
            </div>
            <a class="boton" href="listar_usuarios.php">Volver al listado</a>
        <?php else:
            // Verificar si el usuario tiene préstamos asociados
            $sqlCheck = "SELECT COUNT(*) AS total FROM prestamos WHERE id_usuario = ?";
            $stmtCheck = mysqli_prepare($conexion, $sqlCheck);
            mysqli_stmt_bind_param($stmtCheck, "i", $id);
            mysqli_stmt_execute($stmtCheck);
            $resCheck = mysqli_stmt_get_result($stmtCheck);
            $check = mysqli_fetch_assoc($resCheck);
            mysqli_stmt_close($stmtCheck);

            if ($check['total'] > 0): ?>
                <h1>No se puede eliminar</h1>
                <div class="alerta">
                    <p>Este usuario tiene historial de préstamos asociados y no puede ser eliminado por integridad referencial.</p>
                </div>
                <a class="boton" href="listar_usuarios.php">Volver al listado</a>
            <?php else:
                // Obtener datos del usuario para el mensaje
                $sqlUsuario = "SELECT nombre, apellidos FROM usuarios WHERE id_usuario = ?";
                $stmtUsuario = mysqli_prepare($conexion, $sqlUsuario);
                mysqli_stmt_bind_param($stmtUsuario, "i", $id);
                mysqli_stmt_execute($stmtUsuario);
                $resUsuario = mysqli_stmt_get_result($stmtUsuario);
                $usuario = mysqli_fetch_assoc($resUsuario);
                $nombreCompleto = $usuario ? ($usuario['nombre'] . ' ' . $usuario['apellidos']) : 'Desconocido';
                mysqli_stmt_close($stmtUsuario);

                $sqlDelete = "DELETE FROM usuarios WHERE id_usuario = ?";
                $stmtDelete = mysqli_prepare($conexion, $sqlDelete);
                mysqli_stmt_bind_param($stmtDelete, "i", $id);
                if (mysqli_stmt_execute($stmtDelete)):
                    mysqli_stmt_close($stmtDelete);
                ?>
                    <h1>Usuario Eliminado</h1>
                    <div class="alerta-exito">
                        <p>El usuario "<strong><?php echo htmlspecialchars($nombreCompleto); ?></strong>" ha sido eliminado exitosamente del sistema.</p>
                    </div>
                    <a class="boton" href="listar_usuarios.php">Volver al listado</a>
                <?php else:
                    $error_db = mysqli_stmt_error($stmtDelete);
                    mysqli_stmt_close($stmtDelete);
                ?>
                    <h1>Error de Borrado</h1>
                    <div class="alerta">
                        <p>Error al intentar borrar el usuario: <?php echo htmlspecialchars($error_db); ?></p>
                    </div>
                    <a class="boton" href="listar_usuarios.php">Volver al listado</a>
                <?php endif;
            endif;
        endif; ?>
    </div>
</body>
</html>
<?php mysqli_close($conexion); ?>

