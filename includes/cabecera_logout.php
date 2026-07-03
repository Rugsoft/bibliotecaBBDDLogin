<?php
function pintar_cabecera_sesion(): void {
    $autenticado = isset($_SESSION['autenticado']) && $_SESSION['autenticado'] === true;
    if ($autenticado) {
        $nombre    = htmlspecialchars($_SESSION['nombre']    ?? '');
        $apellidos = htmlspecialchars($_SESSION['apellidos'] ?? '');
        $rol       = htmlspecialchars($_SESSION['rol']       ?? 'lector');
        $action_url    = 'logout.php';
        $action_label  = 'Cerrar sesión';
        $mensaje = 'Hola, <strong>' . $nombre . ' ' . $apellidos . '</strong> <span class="rol-tag rol-' . strtolower($rol) . '">' . ucfirst($rol) . '</span>';
        ?>
        <div class="cabecera-sesion">
            <span><?php echo $mensaje; ?></span>
            <a class="boton" href="<?php echo $action_url; ?>"><?php echo $action_label; ?></a>
        </div>
        <?php
    } else {
        ?>
        <div class="cabecera-sesion">
            <span>No has iniciado sesión. Accede para ver el contenido.</span>
            <a class="boton" href="login.php">Iniciar sesión</a>
        </div>
        <?php
    }
}
