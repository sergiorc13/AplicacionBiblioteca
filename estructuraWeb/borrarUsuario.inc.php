<div>
    <a href="?ruta=usuarios" class="boton-volver">Volver</a>
</div>

<?php
// Incluir la conexión a la base de datos u otros archivos necesarios
require_once("./conexion/establecerConexionBD.php");

$mysqli = mysqli_connect($host, $usuarioBD, $passwordBD, $nombreBD);

// Verificar si se ha proporcionado un ID de usuario en la URL
if (isset($_GET['ID'])) {
    $idUsuarioABorrar = $_GET['ID'];

    // Llamar a la función borrarUsuario
    if (borrarUsuario($mysqli, $idUsuarioABorrar)) {
        echo "<h3 class='resultado-prestamo'>El usuario se ha borrado correctamente.</h3>";
    } else {
        echo "Error al marcar el usuario como borrado.";
    }

} else {
    echo "hola";
}

mysqli_close($mysqli);
?>

