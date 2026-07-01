<?php
include "../config/conexion.php";

// Consulta agregada relacional para contar préstamos por usuario
$sql = "SELECT 
    usuarios.nombre,
    usuarios.apellidos,
    COUNT(prestamos.id_prestamo) AS total_prestamos
    FROM usuarios
    INNER JOIN prestamos 
    ON usuarios.id_usuario = prestamos.id_usuario
    GROUP BY usuarios.id_usuario, usuarios.nombre, usuarios.apellidos
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
    <title>Préstamos por Usuario</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <h1>Préstamos por Usuario (Ejercicio 5)</h1>
    <p>Conteo total de préstamos realizados por cada usuario registrados en el historial.</p>
    
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Total de Préstamos Realizados</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($usuario = mysqli_fetch_assoc($resultado)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($usuario["nombre"] . " " . $usuario["apellidos"]); ?></td>
                        <td><strong><?php echo htmlspecialchars($usuario["total_prestamos"]); ?></strong> préstamos</td>
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

