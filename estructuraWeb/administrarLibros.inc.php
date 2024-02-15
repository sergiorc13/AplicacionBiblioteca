<div>
    <a href="?ruta=administracion" class = "boton-volver">Volver</a>
</div>
<div>
    <a href="?ruta=anadirLibros" class="boton-anadir-libros">Añadir libros</a>
</div><br>
<p class = "usuarios">Estos son todos los libros que hay en nuestra aplicación:</p>

<div>
<?php
    require_once("./conexion/establecerConexionBD.php");
    $mysqli = mysqli_connect($host, $usuarioBD, $passwordBD, $nombreBD);
    modificarLibros($mysqli);
    mysqli_close($mysqli);
?>
</div>



    