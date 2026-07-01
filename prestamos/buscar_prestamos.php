<?php
include "../config/conexion.php";

$busqueda = "";
if (isset($_GET["busqueda"])) {
    $busqueda = $_GET["busqueda"];
}

// Búsqueda usando LIKE para coincidencia parcial en nombre o apellidos
$sql = "SELECT 
    usuarios.nombre,
    usuarios.apellidos,
    libros.titulo,
    prestamos.fecha_prestamo,
    prestamos.fecha_devolucion,
    prestamos.devuelto
    FROM prestamos
    INNER JOIN usuarios 
    ON prestamos.id_usuario = usuarios.id_usuario
    INNER JOIN libros 
    ON prestamos.id_libro = libros.id_libro
    WHERE usuarios.nombre LIKE ? OR usuarios.apellidos LIKE ?";
$stmt = mysqli_prepare($conexion, $sql);
$busqueda_param = "%" . $busqueda . "%";
mysqli_stmt_bind_param($stmt, "ss", $busqueda_param, $busqueda_param);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Préstamos</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <h1>Buscar Préstamos por Usuario</h1>
    <p>Introduce el nombre o apellido del usuario para filtrar sus préstamos.</p>
    
    <form method="GET" action="buscar_prestamos.php">
        <input type="text" name="busqueda" placeholder="Ej. Laura o Martínez..." value="<?php echo htmlspecialchars($busqueda); ?>">
        <button type="submit">Buscar</button>
    </form>

    <?php if (mysqli_num_rows($resultado) > 0) { ?>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Libro</th>
                        <th>Fecha Préstamo</th>
                        <th>Fecha Devolución</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($prestamo = mysqli_fetch_assoc($resultado)) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($prestamo["nombre"] . " " . $prestamo["apellidos"]); ?></td>
                            <td><?php echo htmlspecialchars($prestamo["titulo"]); ?></td>
                            <td><?php echo htmlspecialchars($prestamo["fecha_prestamo"]); ?></td>
                            <td><?php echo htmlspecialchars($prestamo["fecha_devolucion"] ? $prestamo["fecha_devolucion"] : 'En posesión'); ?></td>
                            <td>
                                <?php if ($prestamo["devuelto"] == 1) { ?>
                                    <span class="badge badge-devuelto">Devuelto</span>
                                <?php } else { ?>
                                    <span class="badge badge-pendiente">Pendiente</span>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } else { ?>
        <div class="card" style="margin-top: 20px;">
            <h3>Sin resultados</h3>
            <p>No se han encontrado préstamos registrados que coincidan con la búsqueda "<strong><?php echo htmlspecialchars($busqueda); ?></strong>".</p>
        </div>
    <?php } ?>

    <a class="volver" href="../index.php">← Volver al inicio</a>
</body>
</html>
<?php
mysqli_stmt_close($stmt);
mysqli_close($conexion);
?>

