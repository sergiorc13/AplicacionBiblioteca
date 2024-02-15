<div>
    <a href="?ruta=administrarLibros" class = "boton-volver">Volver</a>
</div>

<?php
require_once("./conexion/establecerConexionBD.php");

$mysqli = mysqli_connect($host, $usuarioBD, $passwordBD, $nombreBD);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ISBN = $_POST["ISBN"];
    $Titulo = $_POST["Titulo"];
    $Autor = $_POST["Autor"];
    $Editorial = $_POST["Editorial"];
    $Sinopsis = $_POST["Sinopsis"];

    // Manejo del archivo de imagen
    $nombreArchivo = $_FILES["ImagenPortada"]["name"];
    $archivoTemporal = $_FILES["ImagenPortada"]["tmp_name"];
    $rutaBase = $_SERVER['DOCUMENT_ROOT'];
    $carpetaDestino = $rutaBase . "/Prueba/img/" . $nombreArchivo;

    // Mueve el archivo temporal a la carpeta de destino
    if (move_uploaded_file($archivoTemporal, $carpetaDestino)) {
        // Extraer solo el nombre del archivo
        $nombreArchivo = basename($nombreArchivo);

        // Llama a la función para agregar el libro a la base de datos
        $resultado = agregarLibro($mysqli, $ISBN, $Titulo, $Autor, $Editorial, $Sinopsis, $nombreArchivo);

        // Imprime el resultado
        echo $resultado;
    } else {
        echo "Error al subir la imagen.";
    }
}

mysqli_close($mysqli);

?>


<section>
    <h2>Rellena los campos para añadir un nuevo libro:</h2>
    <form action="" method="post" class="formulario-añadir-libros" enctype="multipart/form-data">
        <label for="ISBN">ISBN:</label>
        <input type="text" name="ISBN" required><br>

        <label for="Titulo">Título:</label>
        <input type="text" name="Titulo" required><br>

        <label for="Autor">Autor:</label>
        <input type="text" name="Autor" required><br>

        <label for="Editorial">Editorial:</label>
        <input type="text" name="Editorial" required><br>

        <label for="Sinopsis">Sinopsis:</label>
        <textarea name="Sinopsis" required></textarea><br>

        <label for="URL">Seleccionar Imagen para la Portada:</label>
        <input type="file" name="ImagenPortada" accept="image/*" required><br>

        <input type="submit" value="Añadir Libro">
    </form>
</section>
