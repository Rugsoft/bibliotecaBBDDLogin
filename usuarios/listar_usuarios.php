<?php
include "../config/conexion.php";

$sql = "SELECT * FROM usuarios";
$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Usuarios</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <h1>Listado de Usuarios</h1>
    <p>Todas las personas dadas de alta en el sistema de biblioteca.</p>
    
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID Usuario</th>
                    <th>Username</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Fecha de Alta</th>
                    <th style="text-align: center;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($usuario = mysqli_fetch_assoc($resultado)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($usuario["id_usuario"]); ?></td>
                        <td><strong><?php echo htmlspecialchars($usuario["username"] ?? '-'); ?></strong></td>
                        <td><?php echo htmlspecialchars($usuario["nombre"]); ?></td>
                        <td><?php echo htmlspecialchars($usuario["apellidos"]); ?></td>
                        <td><?php echo htmlspecialchars($usuario["email"]); ?></td>
                        <td><?php echo htmlspecialchars($usuario["telefono"] ? $usuario["telefono"] : '-'); ?></td>
                        <td><?php echo htmlspecialchars($usuario["fecha_alta"]); ?></td>
                        <td style="text-align: center; white-space: nowrap;">
                            <a class="btn-tabla btn-modificar" href="modificar_usuario.php?id=<?php echo $usuario['id_usuario']; ?>">Modificar</a>
                            <a class="btn-tabla btn-eliminar" href="eliminar_usuario.php?id=<?php echo $usuario['id_usuario']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">Eliminar</a>
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

