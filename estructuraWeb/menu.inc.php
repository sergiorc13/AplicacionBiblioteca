<nav class="menu">
    <?php

  
    if (isset($_SESSION["usuario"]) && !empty($_SESSION["usuario"])) {
        // Si el usuario está autenticado, muestra el formulario de búsqueda de libros
        ?>
    <form action="<?php echo "?ruta=busqueda"?>" method="post" class="buscar">
            <input type="text" name="query" placeholder="Buscar libros">
            <input type="submit" value="Buscar" name="searchlibro">
        </form>
    <?php }

    if (isset($_SESSION["usuario"]) && !empty($_SESSION["usuario"])) {
        if ($_SESSION["ROL"] == "ADMIN") {
            // Si el usuario es un administrador, muestra un enlace a la sección de administración
            ?>
            <a href="?ruta=administracion" class = "boton-administracion">Administración</a> 
           
        <?php }
    }

    // Botón "Cerrar sesión"
    ?>
    <a href="?ruta=mislibros" class="mis-libros">Mis Libros</a>
    <a href="?ruta=micuenta" class="mi-cuenta">Mi Cuenta</a>
    <a href="?ruta=logout" class="cerrar-sesion">Cerrar sesión</a> <br>
</nav>
