<?php
include "../config/conexion.php";

// Consulta relacional para préstamos ya devueltos
$sql = "SELECT 
    prestamos.id_prestamo,
    usuarios.nombre,
    usuarios.apellidos,
    libros.titulo,
    prestamos.fecha_prestamo,
    prestamos.fecha_devolucion
    FROM prestamos
    INNER JOIN usuarios ON prestamos.id_usuario = usuarios.id_usuario
    INNER JOIN libros ON prestamos.id_libro = libros.id_libro
    WHERE prestamos.devuelto = 1";
$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Préstamos Devueltos</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <h1>Préstamos Devueltos (Ejercicio 3)</h1>
    <p>Historial de préstamos finalizados que ya han sido retornados a la biblioteca.</p>
    
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
                </tr>
            </thead>
            <tbody>
                <?php while ($prestamo = mysqli_fetch_assoc($resultado)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($prestamo["id_prestamo"]); ?></td>
                        <td><?php echo htmlspecialchars($prestamo["nombre"] . " " . $prestamo["apellidos"]); ?></td>
                        <td><?php echo htmlspecialchars($prestamo["titulo"]); ?></td>
                        <td><?php echo htmlspecialchars($prestamo["fecha_prestamo"]); ?></td>
                        <td><?php echo htmlspecialchars($prestamo["fecha_devolucion"]); ?></td>
                        <td>
                            <span class="badge badge-devuelto">Devuelto</span>
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

