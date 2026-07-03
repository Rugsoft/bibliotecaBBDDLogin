<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$ROL_LECTOR = 'lector';
$ROL_ADMIN  = 'admin';

function usuario_actual(): ?array {
    if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
        return null;
    }
    return [
        'id_usuario' => $_SESSION['id_usuario'] ?? null,
        'nombre'     => $_SESSION['nombre']     ?? '',
        'apellidos'  => $_SESSION['apellidos']  ?? '',
        'email'      => $_SESSION['email']      ?? '',
        'rol'        => $_SESSION['rol']        ?? 'lector',
    ];
}

function _base_path(): string {
    return defined('BASE_PATH') ? BASE_PATH : '../';
}

function _render_denegado(string $mensaje, string $volver_path, string $volver_texto): void {
    $base = _base_path();
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Acceso restringido - Biblioteca</title>
        <link rel="stylesheet" href="<?php echo $base; ?>css/estilos.css">
    </head>
    <body>
        <div class="feedback-container">
            <h1>Acceso Restringido</h1>
            <div class="alerta">
                <p><?php echo $mensaje; ?></p>
            </div>
            <a class="boton" href="<?php echo htmlspecialchars($volver_path); ?>"><?php echo htmlspecialchars($volver_texto); ?></a>
        </div>
    </body>
    </html>
    <?php
}

function requerir_login(): void {
    if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
        _render_denegado(
            "Debes iniciar sesión para acceder a esta página.",
            _base_path() . "login.php",
            "Ir al inicio de sesión"
        );
        exit;
    }
}

function requerir_admin(): void {
    if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
        _render_denegado(
            "Debes iniciar sesión para acceder a esta página.",
            _base_path() . "login.php",
            "Ir al inicio de sesión"
        );
        exit;
    }
    if (($_SESSION['rol'] ?? '') !== 'admin') {
        _render_denegado(
            "No tienes permisos para realizar esta acción.",
            _base_path() . "index.php",
            "Volver al inicio"
        );
        exit;
    }
}
