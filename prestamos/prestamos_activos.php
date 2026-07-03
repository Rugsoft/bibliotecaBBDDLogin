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
    prestamos.fecha_devolucion
    FROM prestamos
    INNER JOIN usuarios 
    ON prestamos.id_usuario = usuarios.id_usuario
    INNER JOIN libros 
    ON prestamos.id_libro = libros.id_libro
    WHERE prestamos.devuelto = 0";
$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Préstamos Activos</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <h1>Préstamos Activos</h1>
    <p>Libros actualmente prestados y pendientes de devolución.</p>
    
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Libro</th>
                    <th>Fecha Préstamo</th>
                    <th>Fecha Prevista de Devolución</th>
                    <th>Estado</th>
                    <th style="text-align: center;">Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($prestamo = mysqli_fetch_assoc($resultado)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($prestamo["nombre"] . " " . $prestamo["apellidos"]); ?></td>
                        <td><?php echo htmlspecialchars($prestamo["titulo"]); ?></td>
                        <td><?php echo htmlspecialchars($prestamo["fecha_prestamo"]); ?></td>
                        <td><?php echo htmlspecialchars($prestamo["fecha_devolucion"] ? $prestamo["fecha_devolucion"] : 'Sin fijar'); ?></td>
                        <td>
                            <span class="badge badge-pendiente">Pendiente</span>
                        </td>
                        <td style="text-align: center;">
                            <?php if (($_SESSION['rol'] ?? '') === 'admin'): ?>
                                <a class="btn-tabla btn-devolver" href="devolver_libro.php?id=<?php echo $prestamo['id_prestamo']; ?>" onclick="return confirm('¿Confirmar la devolución de este libro?');">Devolver</a>
                            <?php else: ?>
                                <span style="color: var(--text-muted); font-size: 0.95rem;">Solo admin</span>
                            <?php endif; ?>
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

