<div>
    <a href="?ruta=perfil" class="boton-volver">Volver</a>
</div><br><br><br>

<?php
// Incluir la conexión a la base de datos u otros archivos necesarios
require_once("./conexion/establecerConexionBD.php");

$mysqli = mysqli_connect($host, $usuarioBD, $passwordBD, $nombreBD);

// Verificar si se ha proporcionado un ISBN en la URL
if(isset($_GET['ISBN'])) {
    $ISBN = $_GET['ISBN'];

    // Llamar a la función obtenerLibro para obtener los datos del libro
    $libro = obtenerLibro($mysqli, $ISBN);
?>

<div class="cuadricula">
    <div class="portada">
        <img src='./img/<?php echo $libro['URL']; ?>' alt='Portada del libro' class='imagen-libro'>
    </div>
    <div class="informacion-libro">
        <h2>Detalles del Libro</h2>
        <p><strong><h3>Título:</strong> <?php echo $libro['Titulo']; ?></h3></p><br>
        <p><strong>Autor:</strong> <?php echo $libro['Autor']; ?></p><br>
        <p><strong>Editorial:</strong> <?php echo $libro['Editorial']; ?></p><br>
        <p><strong>ISBN:</strong> <?php echo $libro['ISBN']; ?></p><br>
        <p><strong>Sinopsis:</strong> <?php echo $libro['SINOPSIS']; ?></p><br>
    </div>
</div>

<form method="post" action="?ruta=prestamo">
    <input type="hidden" name="ISBN" value="<?php echo $libro['ISBN']; ?>">
    <button type="submit" name="pedirBtn" class = "reservar">Pedir</button>
</form>

<?php
}

// Cerrar la conexión a la base de datos al final de todas las operaciones
mysqli_close($mysqli);

?>

