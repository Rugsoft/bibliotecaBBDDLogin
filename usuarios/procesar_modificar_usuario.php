<?php
include_once "../auth/auth_helper.php";
requerir_login();
require_once "../config/conexion.php";

$id_usuario = trim($_POST["id_usuario"] ?? "");
$nombre = trim($_POST["nombre"] ?? "");
$apellidos = trim($_POST["apellidos"] ?? "");
$email = trim($_POST["email"] ?? "");
$telefono = trim($_POST["telefono"] ?? "");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procesar Modificación de Usuario - Biblioteca</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="feedback-container">
        <?php if ($id_usuario == "" || $nombre == "" || $apellidos == "" || $email == "" || $telefono == ""): ?>
            <h1>Datos Incompletos</h1>
            <div class="alerta">
                <p>Por favor, completa todos los campos del formulario.</p>
            </div>
            <a class="boton" href="modificar_usuario.php?id=<?php echo htmlspecialchars($id_usuario); ?>">Volver al formulario</a>
        <?php else:
            // Verificar si el nuevo email ya lo tiene otro usuario diferente
            $sqlExiste = "SELECT * FROM usuarios WHERE email = ? AND id_usuario != ?";
            $stmtExiste = mysqli_prepare($conexion, $sqlExiste);
            mysqli_stmt_bind_param($stmtExiste, "si", $email, $id_usuario);
            mysqli_stmt_execute($stmtExiste);
            $resultadoExiste = mysqli_stmt_get_result($stmtExiste);

            if (mysqli_num_rows($resultadoExiste) > 0):
                mysqli_stmt_close($stmtExiste);
            ?>
                <h1>Email Duplicado</h1>
                <div class="alerta">
                    <p>El email <strong><?php echo htmlspecialchars($email); ?></strong> ya pertenece a otro usuario registrado.</p>
                </div>
                <a class="boton" href="modificar_usuario.php?id=<?php echo htmlspecialchars($id_usuario); ?>">Volver al formulario</a>
            <?php else:
                mysqli_stmt_close($stmtExiste);
                $sqlUpdate = "UPDATE usuarios SET 
                                nombre = ?, 
                                apellidos = ?, 
                                email = ?, 
                                telefono = ? 
                              WHERE id_usuario = ?";
                $stmtUpdate = mysqli_prepare($conexion, $sqlUpdate);
                mysqli_stmt_bind_param($stmtUpdate, "ssssi", $nombre, $apellidos, $email, $telefono, $id_usuario);

                if (mysqli_stmt_execute($stmtUpdate)):
                    mysqli_stmt_close($stmtUpdate);
                ?>
                    <h1>¡Usuario Modificado!</h1>
                    <div class="alerta-exito">
                        <p>Los datos de "<strong><?php echo htmlspecialchars($nombre . ' ' . $apellidos); ?></strong>" se actualizaron correctamente.</p>
                    </div>
                    <a class="boton" href="listar_usuarios.php">Volver al listado</a>
                <?php else:
                    $error_db = mysqli_stmt_error($stmtUpdate);
                    mysqli_stmt_close($stmtUpdate);
                ?>
                    <h1>Error de Actualización</h1>
                    <div class="alerta">
                        <p>Error al modificar el usuario: <?php echo htmlspecialchars($error_db); ?></p>
                    </div>
                    <a class="boton" href="modificar_usuario.php?id=<?php echo htmlspecialchars($id_usuario); ?>">Volver al formulario</a>
                <?php endif;
            endif;
        endif; ?>
    </div>
</body>
</html>
<?php mysqli_close($conexion); ?>

