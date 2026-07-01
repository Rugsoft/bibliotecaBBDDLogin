<?php
include_once "../auth/auth_helper.php";
requerir_login();
require_once "../config/conexion.php";

$id_libro = trim($_POST["id_libro"] ?? "");
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
    <title>Procesar Modificación de Libro - Biblioteca</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="feedback-container">
        <?php if ($id_libro == "" || $isbn == "" || $titulo == "" || $autor == "" || $año_publicacion == "" || $genero == "" || $numero_paginas == ""): ?>
            <h1>Datos Incompletos</h1>
            <div class="alerta">
                <p>Por favor, completa todos los campos del formulario.</p>
            </div>
            <a class="boton" href="modificar_libro.php?id=<?php echo htmlspecialchars($id_libro); ?>">Volver al formulario</a>
        <?php else:
            // Verificar si el nuevo ISBN ya lo tiene otro libro diferente
            $sqlExiste = "SELECT * FROM libros WHERE isbn = ? AND id_libro != ?";
            $stmtExiste = mysqli_prepare($conexion, $sqlExiste);
            mysqli_stmt_bind_param($stmtExiste, "si", $isbn, $id_libro);
            mysqli_stmt_execute($stmtExiste);
            $resultadoExiste = mysqli_stmt_get_result($stmtExiste);

            if (mysqli_num_rows($resultadoExiste) > 0):
                mysqli_stmt_close($stmtExiste);
            ?>
                <h1>ISBN Duplicado</h1>
                <div class="alerta">
                    <p>El ISBN <strong><?php echo htmlspecialchars($isbn); ?></strong> ya pertenece a otro libro registrado.</p>
                </div>
                <a class="boton" href="modificar_libro.php?id=<?php echo htmlspecialchars($id_libro); ?>">Volver al formulario</a>
            <?php else:
                mysqli_stmt_close($stmtExiste);
                $sqlUpdate = "UPDATE libros SET 
                                isbn = ?, 
                                titulo = ?, 
                                autor = ?, 
                                año = ?, 
                                genero = ?, 
                                paginas = ? 
                              WHERE id_libro = ?";
                $stmtUpdate = mysqli_prepare($conexion, $sqlUpdate);
                mysqli_stmt_bind_param($stmtUpdate, "sssssii", $isbn, $titulo, $autor, $año_publicacion, $genero, $numero_paginas, $id_libro);

                if (mysqli_stmt_execute($stmtUpdate)):
                    mysqli_stmt_close($stmtUpdate);
                ?>
                    <h1>¡Libro Modificado!</h1>
                    <div class="alerta-exito">
                        <p>Los datos del libro "<strong><?php echo htmlspecialchars($titulo); ?></strong>" se actualizaron correctamente.</p>
                    </div>
                    <a class="boton" href="listar_libros.php">Volver al listado</a>
                <?php else:
                    $error_db = mysqli_stmt_error($stmtUpdate);
                    mysqli_stmt_close($stmtUpdate);
                ?>
                    <h1>Error de Actualización</h1>
                    <div class="alerta">
                        <p>Error al modificar el libro: <?php echo htmlspecialchars($error_db); ?></p>
                    </div>
                    <a class="boton" href="modificar_libro.php?id=<?php echo htmlspecialchars($id_libro); ?>">Volver al formulario</a>
                <?php endif;
            endif;
        endif; ?>
    </div>
</body>
</html>
<?php mysqli_close($conexion); ?>

