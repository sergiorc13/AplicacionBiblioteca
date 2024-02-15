<div>
    <a href="?ruta=perfil" class="boton-volver">Volver</a>
</div><br><br><br>

<?php
require_once("./conexion/establecerConexionBD.php");

$mysqli = mysqli_connect($host, $usuarioBD, $passwordBD, $nombreBD);

// Verificar si se envió el formulario de préstamo
if(isset($_POST['pedirBtn']) && isset($_POST['ISBN'])) {
    $ISBN = $_POST['ISBN'];

    // Obtener información del libro
    $libro = obtenerLibro($mysqli, $ISBN);

    // Verificar si el libro existe
    if($libro !== null) {

        // Verificar si el usuario está autenticado
        if(isset($_SESSION["usuario"])) {

            $nombreUsuario = $_SESSION["usuario"];
            
            // Obtener ID de usuario (puedes ajustar esto según tu aplicación)
            $idUsuario = obtenerIdUsuario($mysqli, $nombreUsuario); // Implementa esta función según tu lógica de autenticación

            // Verificar si se pudo obtener el ID de usuario
            if($idUsuario !== null) {
                // Verificar si el usuario ya ha reservado el libro
                if (usuarioHaReservadoLibro($mysqli, $idUsuario, $libro['ID'])) {
                    echo "<h3 class='resultado-prestamo'>Ya has reservado este libro anteriormente.</h3>";
                } else {
                    // Realizar el préstamo del libro
                    $resultadoPrestamo = prestarLibro($mysqli, $idUsuario, $libro['ID']); // Ajusta la función según tu estructura de base de datos

                    if($resultadoPrestamo) {
                        echo "<h3 class='resultado-prestamo'>Préstamo exitoso. El libro '{$libro['Titulo']}' está reservado para ti.</h3>";
                    } else {
                        echo "Error al realizar el préstamo. Por favor, inténtalo de nuevo.";
                    }
                }
            } else {
                echo "Error al obtener el ID de usuario. Por favor, inicia sesión.";
            }

        } else {
            echo "Error: Usuario no autenticado. Por favor, inicia sesión.";
        }

    } else {
        echo "El libro no existe.";
    }
} else {
    echo "Acceso no autorizado.";
}

// Cerrar la conexión a la base de datos al final de todas las operaciones
mysqli_close($mysqli);
?>
