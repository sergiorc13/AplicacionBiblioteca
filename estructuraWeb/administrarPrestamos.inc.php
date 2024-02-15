<div>
    <a href="?ruta=administracion" class="boton-volver">Volver</a>
</div><br><br>

<p class = "usuarios">Estos son todos los préstamos que hay activos en nuestra aplicación:</p>

<?php

require_once("./conexion/establecerConexionBD.php");

$mysqli = mysqli_connect($host, $usuarioBD, $passwordBD, $nombreBD);

// Llamada a la función mostrarPrestamo
mostrarPrestamo($mysqli);

// Cerrar la conexión cuando hayas terminado
mysqli_close($mysqli);
?>

