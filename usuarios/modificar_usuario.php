<?php
include_once "../auth/auth_helper.php";
requerir_login();
require_once "../config/conexion.php";

$id = trim($_GET["id"] ?? "");
$usuario = null;

if ($id != "") {
    $sql = "SELECT * FROM usuarios WHERE id_usuario = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $usuario = mysqli_fetch_assoc($res);
    mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Usuario - Biblioteca</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <h1>Modificar Usuario</h1>
    <p>Actualizar los datos del usuario seleccionado.</p>

    <?php if (!$usuario): ?>
        <div class="feedback-container">
            <div class="alerta">
                <p>El usuario solicitado no existe o no se especificó un ID válido.</p>
            </div>
            <a class="boton" href="listar_usuarios.php">Volver al listado</a>
        </div>
    <?php else: ?>
        <form action="procesar_modificar_usuario.php" method="POST">
            <input type="hidden" name="id_usuario" value="<?php echo htmlspecialchars($usuario['id_usuario']); ?>">

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>

            <label for="apellidos">Apellidos:</label>
            <input type="text" id="apellidos" name="apellidos" value="<?php echo htmlspecialchars($usuario['apellidos']); ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>

            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($usuario['telefono']); ?>" required>

            <button type="submit">Guardar Cambios</button>
        </form>
        <a class="volver" href="listar_usuarios.php">← Cancelar y Volver</a>
    <?php endif; ?>
</body>
</html>
<?php mysqli_close($conexion); ?>

