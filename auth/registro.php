<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: ../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Administrador - Biblioteca</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body class="auth-body">
    <div class="auth-container">
        <h1>Biblioteca</h1>
        <p>Registro de Administrador</p>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="alerta" style="margin-bottom: 15px; padding: 10px 15px; font-size: 0.95rem;">
                <p><?php echo htmlspecialchars($_GET['error']); ?></p>
            </div>
        <?php endif; ?>

        <form action="procesar_registro.php" method="POST">
            <div>
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div>
                <label for="apellidos">Apellidos:</label>
                <input type="text" id="apellidos" name="apellidos" required>
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div>
                <label for="username">Usuario:</label>
                <input type="text" id="username" name="username" required autocomplete="username">
            </div>
            <div>
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required autocomplete="new-password">
            </div>
            <button type="submit">Registrarse</button>
        </form>
        
        <div class="auth-link">
            ¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a>
        </div>
        <div style="margin-top: 15px;">
            <a href="../index.php" style="color: #FAF6EE; font-family: 'Cinzel', serif; font-size: 0.85rem; text-decoration: none; text-transform: uppercase; letter-spacing: 0.05em;">← Volver al catálogo público</a>
        </div>
    </div>
</body>
</html>
