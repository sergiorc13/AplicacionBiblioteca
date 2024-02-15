
<section class = "section-perfil">
    <p class = "bienvenido">¡Bienvenido, <?php echo $_SESSION["usuario"]; ?>!</p><br>
    <p class="libros"> Estos son los libros disponibles en nuestro catálogo:</p>
        <?php
            require_once("./conexion/establecerConexionBD.php");

            $mysqli = mysqli_connect($host, $usuarioBD, $passwordBD, $nombreBD);

            mostrarLibros($mysqli);

            mysqli_close($mysqli);
        ?>
    
</section>
<?php include_once "estructuraWeb/pie.inc.php"; ?>