<?php
include "../config/conexion.php";

// 1. Obtener todos los géneros únicos para el selector dropdown
$gen_sql = "SELECT DISTINCT genero FROM libros";
$gen_stmt = mysqli_prepare($conexion, $gen_sql);
mysqli_stmt_execute($gen_stmt);
$gen_resultado = mysqli_stmt_get_result($gen_stmt);

// 2. Determinar el género activo (por defecto 'Novela')
$genero_seleccionado = "Novela";
if (isset($_GET["genero"])) {
    $genero_seleccionado = $_GET["genero"];
}

// 3. Obtener libros filtrados por el género seleccionado
$sql = "SELECT * FROM libros WHERE genero = ?";
$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, "s", $genero_seleccionado);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libros por Género</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <h1>Libros por Género (Ejercicio 1)</h1>
    <p>Selecciona un género para filtrar los libros.</p>
    
    <form method="GET" action="libros_genero.php">
        <select name="genero" onchange="this.form.submit()">
            <?php while ($gen = mysqli_fetch_assoc($gen_resultado)) { ?>
                <option value="<?php echo htmlspecialchars($gen["genero"]); ?>" <?php echo ($gen["genero"] === $genero_seleccionado) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($gen["genero"]); ?>
                </option>
            <?php } ?>
        </select>
        <button type="submit">Filtrar</button>
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
                            <td><?php echo htmlspecialchars($libro["paginas"]); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } else { ?>
        <p>No se han encontrado libros en este género.</p>
    <?php } ?>

    <a class="volver" href="../index.php">← Volver al inicio</a>
</body>
</html>
<?php
mysqli_stmt_close($gen_stmt);
mysqli_stmt_close($stmt);
mysqli_close($conexion);
?>

