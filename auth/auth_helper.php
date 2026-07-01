<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function esta_logeado(): bool {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function requerir_login(string $path_prefix = "../"): void {
    if (!esta_logeado()) {
        header("Location: " . $path_prefix . "auth/login.php");
        exit;
    }
}
?>
