<?php
require_once "../config/conexion.php";

$isbn = trim($_POST["isbn"] ?? "");
$titulo = trim($_POST["titulo"] ?? "");
$autor = trim($_POST["autor"] ?? "");
$año_publicacion = trim($_POST["año_publicacion"] ?? "");
$genero = trim($_POST["genero"] ?? "");
$numero_paginas = trim($_POST["numero_paginas"] ?? "");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procesar Nuevo Libro - Biblioteca</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="feedback-container">
        
        <?php if ($isbn == "" || $titulo == "" || $autor == "" || $año_publicacion == "" || $genero == "" || $numero_paginas == ""): ?>
            <h1>Datos Incompletos</h1>
            <div class="alerta">
                <p>Faltan datos en el formulario. Vuelve atrás y revisa todos los campos.</p>
            </div>
            <a class="boton" href="añadir_libro.php">Volver al formulario</a>

        <?php else:
            $sqlExiste = "SELECT * FROM libros WHERE isbn = ?";
            $stmtExiste = mysqli_prepare($conexion, $sqlExiste);
            mysqli_stmt_bind_param($stmtExiste, "s", $isbn);
            mysqli_stmt_execute($stmtExiste);
            $resultadoExiste = mysqli_stmt_get_result($stmtExiste);

            if (mysqli_num_rows($resultadoExiste) > 0):
                mysqli_stmt_close($stmtExiste);
            ?>
                <h1>Libro Ya Registrado</h1>
                <div class="alerta">
                    <p>El libro "<strong><?php echo htmlspecialchars($titulo); ?></strong>" con ISBN <strong><?php echo htmlspecialchars($isbn); ?></strong> ya está registrado en la biblioteca.</p>
                </div>
                <a class="boton" href="añadir_libro.php">Volver al formulario</a>

            <?php else:
                mysqli_stmt_close($stmtExiste);
                $sqlInsertar = "INSERT INTO libros (isbn, titulo, autor, año, genero, paginas) VALUES (?, ?, ?, ?, ?, ?)";
                $stmtInsertar = mysqli_prepare($conexion, $sqlInsertar);
                mysqli_stmt_bind_param($stmtInsertar, "sssssi", $isbn, $titulo, $autor, $año_publicacion, $genero, $numero_paginas);
                
                if (mysqli_stmt_execute($stmtInsertar)):
                    mysqli_stmt_close($stmtInsertar);
                ?>
                    <h1>¡Libro Añadido!</h1>
                    <div class="alerta-exito">
                        <p>El libro "<strong><?php echo htmlspecialchars($titulo); ?></strong>" de <em><?php echo htmlspecialchars($autor); ?></em> ha sido guardado exitosamente en el catálogo.</p>
                    </div>
                    <a class="boton" href="../index.php">Volver al inicio</a>
                <?php else:
                    $error_db = mysqli_stmt_error($stmtInsertar);
                    mysqli_stmt_close($stmtInsertar);
                ?>
                    <h1>Error de Registro</h1>
                    <div class="alerta">
                        <p>Error al añadir el libro en la base de datos: <?php echo htmlspecialchars($error_db); ?></p>
                    </div>
                    <a class="boton" href="añadir_libro.php">Volver al formulario</a>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>

    </div>
</body>
</html>
<?php
mysqli_close($conexion);
?>
