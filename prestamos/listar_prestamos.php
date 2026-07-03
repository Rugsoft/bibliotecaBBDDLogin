<?php
include "../config/conexion.php";
define('BASE_PATH', '../');
require_once "../includes/auth.php";
requerir_login();

$sql = "SELECT 
    prestamos.id_prestamo,
    usuarios.nombre,
    usuarios.apellidos,
    libros.titulo,
    prestamos.fecha_prestamo,
    prestamos.fecha_devolucion,
    prestamos.devuelto
    FROM prestamos
    INNER JOIN usuarios 
    ON prestamos.id_usuario = usuarios.id_usuario
    INNER JOIN libros 
    ON prestamos.id_libro = libros.id_libro";
$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Préstamos</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <h1>Listado de Préstamos</h1>
    <p>Historial completo de libros tomados en préstamo por los usuarios.</p>
    
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID Préstamo</th>
                    <th>Usuario</th>
                    <th>Libro</th>
                    <th>Fecha Préstamo</th>
                    <th>Fecha Devolución</th>
                    <th>Estado</th>
                    <th style="text-align: center;">Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($prestamo = mysqli_fetch_assoc($resultado)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($prestamo["id_prestamo"]); ?></td>
                        <td><?php echo htmlspecialchars($prestamo["nombre"] . " " . $prestamo["apellidos"]); ?></td>
                        <td><?php echo htmlspecialchars($prestamo["titulo"]); ?></td>
                        <td><?php echo htmlspecialchars($prestamo["fecha_prestamo"]); ?></td>
                        <td><?php echo htmlspecialchars($prestamo["fecha_devolucion"] ? $prestamo["fecha_devolucion"] : 'En posesión'); ?></td>
                        <td>
                            <?php if ($prestamo["devuelto"] == 1) { ?>
                                <span class="badge badge-devuelto">Devuelto</span>
                            <?php } else { ?>
                                <span class="badge badge-pendiente">Pendiente</span>
                            <?php } ?>
                        </td>
                        <td style="text-align: center; white-space: nowrap;">
                            <?php if ($prestamo["devuelto"] == 0) { ?>
                                <?php if (($_SESSION['rol'] ?? '') === 'admin'): ?>
                                    <a class="btn-tabla btn-devolver" href="devolver_libro.php?id=<?php echo $prestamo['id_prestamo']; ?>" onclick="return confirm('¿Confirmar la devolución de este libro?');">Devolver</a>
                                <?php else: ?>
                                    <span style="color: var(--text-muted); font-size: 0.95rem;">Solo admin</span>
                                <?php endif; ?>
                            <?php } else { ?>
                                <span style="color: var(--text-muted); font-size: 0.95rem;">-</span>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <a class="volver" href="../index.php">← Volver al inicio</a>
</body>
</html>
<?php
mysqli_stmt_close($stmt);
mysqli_close($conexion);
?>

