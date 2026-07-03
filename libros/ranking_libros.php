<?php
include "../config/conexion.php";
define('BASE_PATH', '../');
require_once "../includes/auth.php";
requerir_login();

// Consulta agregada para ordenar los libros por número de préstamos
$sql = "SELECT 
    libros.titulo,
    libros.autor,
    COUNT(prestamos.id_prestamo) AS total_prestamos
    FROM libros
    INNER JOIN prestamos 
    ON libros.id_libro = prestamos.id_libro
    GROUP BY libros.id_libro, libros.titulo, libros.autor
    ORDER BY total_prestamos DESC";
$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ranking de Libros</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <h1>Ranking de Libros Más Prestados</h1>
    <p>Estadísticas del catálogo ordenadas por la popularidad de los ejemplares.</p>
    
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Posición</th>
                    <th>Libro</th>
                    <th>Autor</th>
                    <th>Total de Préstamos</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $posicion = 1;
                while ($libro = mysqli_fetch_assoc($resultado)) { 
                ?>
                    <tr>
                        <td><strong>#<?php echo $posicion++; ?></strong></td>
                        <td><?php echo htmlspecialchars($libro["titulo"]); ?></td>
                        <td><?php echo htmlspecialchars($libro["autor"]); ?></td>
                        <td><?php echo htmlspecialchars($libro["total_prestamos"]); ?> préstamos</td>
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

