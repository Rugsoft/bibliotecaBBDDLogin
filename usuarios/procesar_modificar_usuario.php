<?php
require_once "../config/conexion.php";
define('BASE_PATH', '../');
require_once "../includes/auth.php";
requerir_admin();

$id_usuario = trim($_POST["id_usuario"] ?? "");
$username = trim($_POST["username"] ?? "");
$password = $_POST["password"] ?? "";
$confirm_password = $_POST["confirm_password"] ?? "";
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
        <?php if ($id_usuario == "" || $username == "" || $nombre == "" || $apellidos == "" || $email == "" || $telefono == ""): ?>
            <h1>Datos Incompletos</h1>
            <div class="alerta">
                <p>Por favor, completa todos los campos requeridos del formulario.</p>
            </div>
            <a class="boton" href="modificar_usuario.php?id=<?php echo htmlspecialchars($id_usuario); ?>">Volver al formulario</a>

        <?php elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)): ?>
            <h1>Email Inválido</h1>
            <div class="alerta">
                <p>El formato del correo electrónico "<strong><?php echo htmlspecialchars($email); ?></strong>" no es válido.</p>
            </div>
            <a class="boton" href="modificar_usuario.php?id=<?php echo htmlspecialchars($id_usuario); ?>">Volver al formulario</a>

        <?php elseif ($password !== "" && $password !== $confirm_password): ?>
            <h1>Contraseñas no coinciden</h1>
            <div class="alerta">
                <p>La nueva contraseña y su confirmación no coinciden. Por favor, vuelve a intentarlo.</p>
            </div>
            <a class="boton" href="modificar_usuario.php?id=<?php echo htmlspecialchars($id_usuario); ?>">Volver al formulario</a>

        <?php else:
            // Verificar si el nuevo email o username ya pertenecen a otro usuario diferente
            $sqlExiste = "SELECT * FROM usuarios WHERE (email = ? OR username = ?) AND id_usuario != ?";
            $stmtExiste = mysqli_prepare($conexion, $sqlExiste);
            mysqli_stmt_bind_param($stmtExiste, "ssi", $email, $username, $id_usuario);
            mysqli_stmt_execute($stmtExiste);
            $resultadoExiste = mysqli_stmt_get_result($stmtExiste);

            if (mysqli_num_rows($resultadoExiste) > 0):
                $existe = mysqli_fetch_assoc($resultadoExiste);
                $mensaje_error = ($existe['email'] === $email) 
                    ? "El email <strong>" . htmlspecialchars($email) . "</strong> ya pertenece a otro usuario."
                    : "El username <strong>" . htmlspecialchars($username) . "</strong> ya pertenece a otro usuario.";
                mysqli_stmt_close($stmtExiste);
            ?>
                <h1>Datos Duplicados</h1>
                <div class="alerta">
                    <p><?php echo $mensaje_error; ?></p>
                </div>
                <a class="boton" href="modificar_usuario.php?id=<?php echo htmlspecialchars($id_usuario); ?>">Volver al formulario</a>
            <?php else:
                mysqli_stmt_close($stmtExiste);
                
                if ($password !== "") {
                    // Si se ha ingresado una nueva contraseña, se hashea y se actualiza
                    $password_hash = password_hash($password, PASSWORD_DEFAULT);
                    $sqlUpdate = "UPDATE usuarios SET 
                                    username = ?, 
                                    password_hash = ?,
                                    nombre = ?, 
                                    apellidos = ?, 
                                    email = ?, 
                                    telefono = ? 
                                  WHERE id_usuario = ?";
                    $stmtUpdate = mysqli_prepare($conexion, $sqlUpdate);
                    mysqli_stmt_bind_param($stmtUpdate, "ssssssi", $username, $password_hash, $nombre, $apellidos, $email, $telefono, $id_usuario);
                } else {
                    // Si la contraseña se deja en blanco, no se altera su columna
                    $sqlUpdate = "UPDATE usuarios SET 
                                    username = ?, 
                                    nombre = ?, 
                                    apellidos = ?, 
                                    email = ?, 
                                    telefono = ? 
                                  WHERE id_usuario = ?";
                    $stmtUpdate = mysqli_prepare($conexion, $sqlUpdate);
                    mysqli_stmt_bind_param($stmtUpdate, "sssssi", $username, $nombre, $apellidos, $email, $telefono, $id_usuario);
                }

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

