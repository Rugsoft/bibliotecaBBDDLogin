<?php
require_once "../config/conexion.php";

$username = trim($_POST["username"] ?? "");
$password = $_POST["password"] ?? "";
$confirm_password = $_POST["confirm_password"] ?? "";
$nombre = trim($_POST["nombre"] ?? "");
$apellidos = trim($_POST["apellidos"] ?? "");
$email = trim($_POST["email"] ?? "");
$telefono = trim($_POST["telefono"] ?? "");
$fecha_registro = date("Y-m-d");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procesar Nuevo Usuario - Biblioteca</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>
    <div class="feedback-container">

        <?php if ($username == "" || $password == "" || $confirm_password == "" || $nombre == "" || $apellidos == "" || $email == "" || $telefono == ""): ?>
            <h1>Datos Incompletos</h1>
            <div class="alerta">
                <p>Faltan datos en el formulario. Vuelve atrás y revisa todos los campos.</p>
            </div>
            <a class="boton" href="añadir_usuario.php">Volver al formulario</a>

        <?php elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)): ?>
            <h1>Email Inválido</h1>
            <div class="alerta">
                <p>El formato del correo electrónico "<strong><?php echo htmlspecialchars($email); ?></strong>" no es válido.</p>
            </div>
            <a class="boton" href="añadir_usuario.php">Volver al formulario</a>

        <?php elseif ($password !== $confirm_password): ?>
            <h1>Contraseñas no coinciden</h1>
            <div class="alerta">
                <p>La contraseña y su confirmación no coinciden. Por favor, vuelve a intentarlo.</p>
            </div>
            <a class="boton" href="añadir_usuario.php">Volver al formulario</a>

            <?php else:
            $sqlExiste = "SELECT * FROM usuarios WHERE email = ? OR username = ?";
            $stmtExiste = mysqli_prepare($conexion, $sqlExiste);
            mysqli_stmt_bind_param($stmtExiste, "ss", $email, $username);
            mysqli_stmt_execute($stmtExiste);
            $resultadoExiste = mysqli_stmt_get_result($stmtExiste);

            if (mysqli_num_rows($resultadoExiste) > 0):
                $existe = mysqli_fetch_assoc($resultadoExiste);
                $mensaje_error = ($existe['email'] === $email)
                    ? "El email <strong>" . htmlspecialchars($email) . "</strong> ya está registrado."
                    : "El nombre de usuario <strong>" . htmlspecialchars($username) . "</strong> ya está registrado.";
                mysqli_stmt_close($stmtExiste);
            ?>
                <h1>Usuario Ya Registrado</h1>
                <div class="alerta">
                    <p><?php echo $mensaje_error; ?></p>
                </div>
                <a class="boton" href="añadir_usuario.php">Volver al formulario</a>

                <?php else:
                mysqli_stmt_close($stmtExiste);
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                $sqlInsertar = "INSERT INTO usuarios (username, password_hash, nombre, apellidos, email, telefono, fecha_alta) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmtInsertar = mysqli_prepare($conexion, $sqlInsertar);
                mysqli_stmt_bind_param($stmtInsertar, "sssssss", $username, $password_hash, $nombre, $apellidos, $email, $telefono, $fecha_registro);

                if (mysqli_stmt_execute($stmtInsertar)):
                    mysqli_stmt_close($stmtInsertar);
                ?>
                    <h1>¡Usuario Añadido!</h1>
                    <div class="alerta-exito">
                        <p>El usuario "<strong><?php echo htmlspecialchars($nombre); ?> <?php echo htmlspecialchars($apellidos); ?></strong>" con username <strong><?php echo htmlspecialchars($username); ?></strong> ha sido registrado exitosamente en la biblioteca.</p>
                    </div>
                    <a class="boton" href="../index.php">Volver al inicio</a>
                <?php else:
                    $error_db = mysqli_stmt_error($stmtInsertar);
                    mysqli_stmt_close($stmtInsertar);
                ?>
                    <h1>Error de Registro</h1>
                    <div class="alerta">
                        <p>Error al añadir el usuario en la base de datos: <?php echo htmlspecialchars($error_db); ?></p>
                    </div>
                    <a class="boton" href="añadir_usuario.php">Volver al formulario</a>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>

    </div>
</body>

</html>
<?php
mysqli_close($conexion);
?>