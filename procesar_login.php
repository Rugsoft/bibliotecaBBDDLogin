<?php
define('BASE_PATH', '');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "config/conexion.php";

if (isset($_SESSION['autenticado']) && $_SESSION['autenticado'] === true) {
    header("Location: index.php");
    exit;
}

$email    = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";

function _render_login_error(string $url_volver = "login.php"): void {
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Iniciar Sesión - Biblioteca</title>
        <link rel="stylesheet" href="css/estilos.css">
    </head>
    <body>
        <div class="feedback-container">
            <h1>Iniciar Sesión</h1>
            <div class="alerta">
                <p>Email o contraseña incorrectos.</p>
            </div>
            <a class="boton" href="<?php echo htmlspecialchars($url_volver); ?>">Volver al formulario</a>
        </div>
    </body>
    </html>
    <?php
}

if ($email == "" || $password == "") {
    _render_login_error();
    mysqli_close($conexion);
    exit;
}

$sql = "SELECT id_usuario, nombre, apellidos, email, password_hash, rol FROM usuarios WHERE email = ?";
$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
$usuario = mysqli_fetch_assoc($resultado);
mysqli_stmt_close($stmt);

$login_ok = false;
if ($usuario && $usuario['password_hash'] !== '' && $usuario['password_hash'] !== null) {
    if (password_verify($password, $usuario['password_hash'])) {
        $login_ok = true;
    }
}

if (!$login_ok) {
    _render_login_error();
    mysqli_close($conexion);
    exit;
}

$_SESSION['autenticado'] = true;
$_SESSION['id_usuario']  = (int) $usuario['id_usuario'];
$_SESSION['nombre']      = $usuario['nombre'];
$_SESSION['apellidos']   = $usuario['apellidos'];
$_SESSION['email']       = $usuario['email'];
$_SESSION['rol']         = (!empty($usuario['rol']) ? $usuario['rol'] : 'lector');

mysqli_close($conexion);
header("Location: index.php");
exit;
