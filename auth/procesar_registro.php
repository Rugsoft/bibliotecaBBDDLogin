<?php
require_once "../config/conexion.php";

$nombre = trim($_POST["nombre"] ?? "");
$apellidos = trim($_POST["apellidos"] ?? "");
$email = trim($_POST["email"] ?? "");
$username = trim($_POST["username"] ?? "");
$password = trim($_POST["password"] ?? "");

if ($nombre == "" || $apellidos == "" || $email == "" || $username == "" || $password == "") {
    header("Location: registro.php?error=" . urlencode("Rellena todos los campos."));
    exit;
}

$sqlExiste = "SELECT id_admin FROM administradores WHERE username = ? OR email = ?";
$stmtExiste = mysqli_prepare($conexion, $sqlExiste);
mysqli_stmt_bind_param($stmtExiste, "ss", $username, $email);
mysqli_stmt_execute($stmtExiste);
$resExiste = mysqli_stmt_get_result($stmtExiste);

if (mysqli_num_rows($resExiste) > 0) {
    mysqli_stmt_close($stmtExiste);
    header("Location: registro.php?error=" . urlencode("Usuario o email ya registrados."));
    exit;
}
mysqli_stmt_close($stmtExiste);

$password_hash = password_hash($password, PASSWORD_BCRYPT);

$sqlInsert = "INSERT INTO administradores (username, password_hash, nombre, apellidos, email) VALUES (?, ?, ?, ?, ?)";
$stmtInsert = mysqli_prepare($conexion, $sqlInsert);
mysqli_stmt_bind_param($stmtInsert, "sssss", $username, $password_hash, $nombre, $apellidos, $email);

if (mysqli_stmt_execute($stmtInsert)) {
    mysqli_stmt_close($stmtInsert);
    header("Location: login.php?registro_exito=1");
    exit;
} else {
    $error_db = mysqli_stmt_error($stmtInsert);
    mysqli_stmt_close($stmtInsert);
    header("Location: registro.php?error=" . urlencode("Error al registrar: " . $error_db));
    exit;
}
mysqli_close($conexion);
?>
