<div>
    <a href="?ruta=administracion" class = "boton-volver">Volver</a>
</div>
<div>
<br> <br><p class = "usuarios">Estos son todos los usuarios que están registrados en nuestra aplicación:</p>
</div>

    <section  class ="section-usuarios">
        <?php
            require_once("./conexion/establecerConexionBD.php");

            $mysqli = mysqli_connect($host, $usuarioBD, $passwordBD, $nombreBD);

            mostrarUsuarios($mysqli);

            mysqli_close($mysqli);
        ?>
    </section>
    

