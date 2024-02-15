<div>
    <a href="?ruta=perfil" class="boton-volver">Volver</a>
</div><br><br><br><br>
<?php
require_once("./conexion/establecerConexionBD.php");

$mysqli = mysqli_connect($host, $usuarioBD, $passwordBD, $nombreBD);

// Verificar si se ha iniciado sesión
if (isset($_SESSION["usuario"])) {
    $nombreUsuario = $_SESSION["usuario"];

    // Llamar a la función para eliminar préstamos vencidos
    eliminarPrestamosVencidos($mysqli);

    // Llamar a la función librosReservados para mostrar los libros reservados
    librosReservados($mysqli, $nombreUsuario);
} else {
    echo "Error: No has iniciado sesión.";
}

// Cerrar la conexión a la base de datos al final de todas las operaciones
mysqli_close($mysqli);
?>
