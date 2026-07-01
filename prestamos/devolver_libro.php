<?php
require_once "../config/conexion.php";

$id = trim($_GET["id"] ?? "");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devolver Libro - Biblioteca</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="feedback-container">
        <?php if ($id == ""): ?>
            <h1>Parámetro Inválido</h1>
            <div class="alerta">
                <p>No se especificó ningún préstamo para realizar la devolución.</p>
            </div>
            <a class="boton" href="prestamos_activos.php">Ver préstamos activos</a>
        <?php else:
            // Obtener información del libro y usuario para mostrar en el mensaje
            $sqlInfo = "SELECT libros.titulo, usuarios.nombre, usuarios.apellidos 
                        FROM prestamos
                        INNER JOIN libros ON prestamos.id_libro = libros.id_libro
                        INNER JOIN usuarios ON prestamos.id_usuario = usuarios.id_usuario
                        WHERE prestamos.id_prestamo = ?";
            $stmtInfo = mysqli_prepare($conexion, $sqlInfo);
            mysqli_stmt_bind_param($stmtInfo, "i", $id);
            mysqli_stmt_execute($stmtInfo);
            $resInfo = mysqli_stmt_get_result($stmtInfo);
            $info = mysqli_fetch_assoc($resInfo);
            mysqli_stmt_close($stmtInfo);

            if (!$info): ?>
                <h1>Registro No Encontrado</h1>
                <div class="alerta">
                    <p>El préstamo especificado no existe en la base de datos.</p>
                </div>
                <a class="boton" href="prestamos_activos.php">Ver préstamos activos</a>
            <?php else:
                // Actualizar el préstamo
                $sqlUpdate = "UPDATE prestamos SET devuelto = 1, fecha_devolucion = CURDATE() WHERE id_prestamo = ?";
                $stmtUpdate = mysqli_prepare($conexion, $sqlUpdate);
                mysqli_stmt_bind_param($stmtUpdate, "i", $id);
                
                if (mysqli_stmt_execute($stmtUpdate)):
                    mysqli_stmt_close($stmtUpdate);
                ?>
                    <h1>Devolución Registrada</h1>
                    <div class="alerta-exito">
                        <p>El libro "<strong><?php echo htmlspecialchars($info['titulo']); ?></strong>" prestado a <strong><?php echo htmlspecialchars($info['nombre'] . ' ' . $info['apellidos']); ?></strong> ha sido devuelto con éxito.</p>
                    </div>
                    <div style="display: flex; gap: 12px; justify-content: center; margin-top: 24px;">
                        <a class="boton" href="prestamos_activos.php">Ver préstamos activos</a>
                        <a class="boton" style="background-color: var(--primary-color);" href="listar_prestamos.php">Historial de Préstamos</a>
                    </div>
                <?php else:
                    $error_db = mysqli_stmt_error($stmtUpdate);
                    mysqli_stmt_close($stmtUpdate);
                ?>
                    <h1>Error de Devolución</h1>
                    <div class="alerta">
                        <p>Error al intentar registrar la devolución: <?php echo htmlspecialchars($error_db); ?></p>
                    </div>
                    <a class="boton" href="prestamos_activos.php">Volver atrás</a>
                <?php endif;
            endif;
        endif; ?>
    </div>
</body>
</html>
<?php mysqli_close($conexion); ?>

