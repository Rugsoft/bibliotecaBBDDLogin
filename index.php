<?php
define('BASE_PATH', '');
require_once "includes/auth.php";
requerir_login();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control - Biblioteca</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <?php require_once "includes/cabecera_logout.php"; pintar_cabecera_sesion(); ?>
    <h1>Panel de Control de la Biblioteca</h1>
    <p>Administración y consultas de la base de datos relacional de usuarios, catálogo e historial de préstamos.</p>

    <!-- 1. GESTIÓN DE LIBROS -->
    <h2 class="section-title">Gestión de Libros</h2>
    <div class="dashboard-grid">
        <a href="libros/listar_libros.php" class="card">
            <h3>Catálogo Completo</h3>
            <p>Visualizar el listado general de libros, con opciones para modificar y eliminar ejemplares.</p>
        </a>
        <a href="libros/añadir_libro.php" class="card">
            <h3>Añadir Nuevo Libro</h3>
            <p>Agregar un nuevo ejemplar al inventario especificando título, autor, ISBN y paginación.</p>
        </a>
        <a href="libros/buscar_libros.php" class="card">
            <h3>Buscar Libros (Ej. 4)</h3>
            <p>Buscador interactivo de ejemplares por título o nombre del autor.</p>
        </a>
        <a href="libros/libros_genero.php" class="card">
            <h3>Libros por Género (Ej. 1)</h3>
            <p>Filtrar y visualizar ejemplares ordenados según su temática o género literario.</p>
        </a>
        <a href="libros/ranking_libros.php" class="card">
            <h3>Ranking de Popularidad</h3>
            <p>Informe estadístico de los libros más solicitados en préstamo por los usuarios.</p>
        </a>
    </div>

    <!-- 2. GESTIÓN DE USUARIOS -->
    <h2 class="section-title">Gestión de Usuarios</h2>
    <div class="dashboard-grid">
        <a href="usuarios/listar_usuarios.php" class="card">
            <h3>Listado de Usuarios</h3>
            <p>Ver todas las personas dadas de alta en el sistema, con opciones de edición y baja.</p>
        </a>
        <a href="usuarios/añadir_usuario.php" class="card">
            <h3>Añadir Nuevo Usuario</h3>
            <p>Registrar un nuevo lector en el sistema guardando su contacto y fecha de alta.</p>
        </a>
        <a href="usuarios/usuarios_recientes.php" class="card">
            <h3>Usuarios Recientes (Ej. 2)</h3>
            <p>Consultar los últimos usuarios registrados ordenados de forma cronológica.</p>
        </a>
        <a href="prestamos/prestamos_por_usuario.php" class="card">
            <h3>Préstamos por Usuario (Ej. 5)</h3>
            <p>Informe agregado con la cantidad total de libros tomados por cada lector.</p>
        </a>
    </div>

    <!-- 3. GESTIÓN DE PRÉSTAMOS -->
    <h2 class="section-title">Gestión de Préstamos</h2>
    <div class="dashboard-grid">
        <a href="prestamos/añadir_prestamo.php" class="card">
            <h3>Registrar Préstamo</h3>
            <p>Registrar la salida de un libro disponible de la biblioteca a nombre de un lector.</p>
        </a>
        <a href="prestamos/listar_prestamos.php" class="card">
            <h3>Historial General</h3>
            <p>Listado histórico de todas las transacciones de préstamo y sus fechas asociadas.</p>
        </a>
        <a href="prestamos/prestamos_activos.php" class="card">
            <h3>Préstamos Activos</h3>
            <p>Ver únicamente los ejemplares que aún están en posesión de los lectores para su devolución.</p>
        </a>
        <a href="prestamos/prestamos_devueltos.php" class="card">
            <h3>Préstamos Devueltos (Ej. 3)</h3>
            <p>Consultar la bitácora de transacciones históricas finalizadas con éxito.</p>
        </a>
        <a href="prestamos/buscar_prestamos.php" class="card">
            <h3>Búsqueda de Préstamos</h3>
            <p>Buscar transacciones activas e históricas filtrando por el nombre del lector.</p>
        </a>
    </div>
</body>

</html>
