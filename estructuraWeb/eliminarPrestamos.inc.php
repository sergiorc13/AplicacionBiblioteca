<div>
    <a href="?ruta=administrarPrestamos" class="boton-volver">Volver</a>
</div><br><br>

<?php
require_once("./conexion/establecerConexionBD.php");

$mysqli = mysqli_connect($host, $usuarioBD, $passwordBD, $nombreBD);

// Obtener los valores de la URL
$nombreUsuario = $_GET['nombreUsuario'];
$tituloLibro = $_GET['tituloLibro'];

eliminarPrestamo($mysqli, $nombreUsuario, $tituloLibro);

// Cerrar la conexión cuando hayas terminado
mysqli_close($mysqli);
?>
