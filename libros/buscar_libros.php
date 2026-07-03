<?php
include "../config/conexion.php";
define('BASE_PATH', '../');
require_once "../includes/auth.php";
requerir_login();

$busqueda = "";
if (isset($_GET["busqueda"])) {
    $busqueda = $_GET["busqueda"];
}

// Búsqueda de libros por título o autor
$sql = "SELECT * FROM libros WHERE titulo LIKE ? OR autor LIKE ?";
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
    <title>Buscar Libros</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <h1>Buscar Libros (Ejercicio 4)</h1>
    <p>Realiza búsquedas en el catálogo introduciendo palabras del título o autor.</p>
    
    <form method="GET" action="buscar_libros.php">
        <input type="text" name="busqueda" placeholder="Ej. Quijote, Orwell, George..." value="<?php echo htmlspecialchars($busqueda); ?>">
        <button type="submit">Buscar</button>
    </form>

    <?php if (mysqli_num_rows($resultado) > 0) { ?>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ISBN</th>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>Año</th>
                        <th>Género</th>
                        <th>Páginas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($libro = mysqli_fetch_assoc($resultado)) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($libro["isbn"]); ?></td>
                            <td><?php echo htmlspecialchars($libro["titulo"]); ?></td>
                            <td><?php echo htmlspecialchars($libro["autor"]); ?></td>
                            <td><?php echo htmlspecialchars($libro["año"]); ?></td>
                            <td><?php echo htmlspecialchars($libro["genero"]); ?></td>
                            <td><?php echo htmlspecialchars($libro["paginas"]); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } else { ?>
        <div class="card" style="margin-top: 20px;">
            <h3>Sin resultados</h3>
            <p>No se han encontrado libros que coincidan con la búsqueda "<strong><?php echo htmlspecialchars($busqueda); ?></strong>".</p>
        </div>
    <?php } ?>

    <a class="volver" href="../index.php">← Volver al inicio</a>
</body>
</html>
<?php
mysqli_stmt_close($stmt);
mysqli_close($conexion);
?>

