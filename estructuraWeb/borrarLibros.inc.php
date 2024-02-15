<div>
    <a href="?ruta=administrarLibros" class="boton-volver">Volver</a>
</div>



<?php

require_once("./conexion/establecerConexionBD.php");

$mysqli = mysqli_connect($host, $usuarioBD, $passwordBD, $nombreBD);

// Verificar si se ha proporcionado un ID de usuario en la URL
if (isset($_GET['ISBN'])) {
    $ISBN = $_GET['ISBN'];

    // Llamar a la función borrarUsuario
    if (borrarLibros($mysqli, $ISBN)) {
        echo "<h3 class='resultado-prestamo'>El libro se ha borrado correctamente.</h3>";
    } else {
        echo "Error al marcar el usuario como borrado.";
    }

} else {
    echo "hola";
}

mysqli_close($mysqli);

?>
