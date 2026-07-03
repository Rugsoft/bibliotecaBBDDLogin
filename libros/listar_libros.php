<?php
include "../config/conexion.php";
define('BASE_PATH', '../');
require_once "../includes/auth.php";
requerir_login();

$sql = "SELECT * FROM libros";
$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Libros</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <h1>Listado de Libros</h1>
    <p>Todos los ejemplares disponibles en el catálogo de la biblioteca.</p>
    
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ISBN</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Año</th>
                    <th>Género</th>
                    <th>Páginas</th>
                    <th style="text-align: center;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($libro = mysqli_fetch_assoc($resultado)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($libro["isbn"]); ?></td>
                        <td><?php echo htmlspecialchars($libro["titulo"]); ?></td>
                        <td><?php echo htmlspecialchars($libro["autor"]); ?></td>
                        <td><?php echo htmlspecialchars($libro["año"]); ?></td>
                        <td><?php echo htmlspecialchars($libro["genero"]); ?></td>
                        <td><?php echo htmlspecialchars($libro["paginas"]); ?></td>
                        <td style="text-align: center; white-space: nowrap;">
                            <?php if (($_SESSION['rol'] ?? '') === 'admin'): ?>
                                <a class="btn-tabla btn-modificar" href="modificar_libro.php?id=<?php echo $libro['id_libro']; ?>">Modificar</a>
                                <a class="btn-tabla btn-eliminar" href="eliminar_libro.php?id=<?php echo $libro['id_libro']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este libro?');">Eliminar</a>
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
// Cerrar conexión al terminar
mysqli_stmt_close($stmt);
mysqli_close($conexion);
?>

