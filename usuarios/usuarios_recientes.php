<?php
include "../config/conexion.php";

// Consulta para ordenar usuarios del más reciente al más antiguo
$sql = "SELECT * FROM usuarios ORDER BY fecha_alta DESC";
$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios Recientes</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <h1>Usuarios Recientes (Ejercicio 2)</h1>
    <p>Lista de usuarios ordenados por fecha de alta, con los más recientes al principio.</p>
    
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Fecha Alta</th>
                    <th>ID Usuario</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($usuario = mysqli_fetch_assoc($resultado)) { ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($usuario["fecha_alta"]); ?></strong></td>
                        <td><?php echo htmlspecialchars($usuario["id_usuario"]); ?></td>
                        <td><?php echo htmlspecialchars($usuario["nombre"]); ?></td>
                        <td><?php echo htmlspecialchars($usuario["apellidos"]); ?></td>
                        <td><?php echo htmlspecialchars($usuario["email"]); ?></td>
                        <td><?php echo htmlspecialchars($usuario["telefono"] ? $usuario["telefono"] : '-'); ?></td>
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

