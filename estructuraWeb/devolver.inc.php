<div>
    <a href="?ruta=mislibros" class="boton-volver">Volver</a>
</div><br><br><br>

<?php
// Incluir la conexión a la base de datos u otros archivos necesarios
require_once("./conexion/establecerConexionBD.php");

$mysqli = mysqli_connect($host, $usuarioBD, $passwordBD, $nombreBD);

// Verificar si se ha proporcionado un ISBN en la URL
if (isset($_GET['ISBN'])) {
    $isbn = $_GET['ISBN'];

    // Obtener el ID del usuario (puedes ajustar esto según tu implementación)
    $nombreUsuario = $_SESSION["usuario"];
    $idUsuario = obtenerIdUsuario($mysqli, $nombreUsuario);

    // Llamar a la función devolverLibro
    devolverLibro($mysqli, $idUsuario, $isbn);
} else {
    echo "hola";
}

mysqli_close($mysqli);
?>
