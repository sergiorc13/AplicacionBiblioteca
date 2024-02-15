<?php
require_once("./conexion/establecerConexionBD.php");

$mysqli = mysqli_connect($host, $usuarioBD, $passwordBD, $nombreBD);

$mensajeError = ""; // Variable para almacenar mensajes de error

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["enviar"])) {
    $usuario = $_POST["usuario"];
    $password = $_POST["password"];

    if (usuarioExiste($mysqli, $usuario)) {
        // El usuario existe en la base de datos, verifica que no esté borrado
    
        $sql = "SELECT Contrasena, Nombre, Apellido, Rol FROM usuarios WHERE Nombre_Usuario = ? AND Borrado = FALSE";
        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, "s", $usuario);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $hashedPassword, $nombre, $apellido, $rol);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    
        if (password_verify($password, $hashedPassword)) {
            // La contraseña es correcta y el usuario no está borrado, puedes permitir el acceso
            // Almacena los datos del usuario en la sesión
            session_start();
            $_SESSION["usuario"] = $usuario;
            $_SESSION["ROL"] = $rol;
    
            // Redirige a la página de perfil o realiza otras acciones
            header("Location: ?ruta=perfil");
            exit;
        } else {
            // Contraseña incorrecta
            $mensajeError = "Contraseña incorrecta";
        }
    } else {
        // El usuario no existe en la base de datos o está borrado
        $mensajeError = "El usuario no existe o está borrado";
    }
}

mysqli_close($mysqli);
?>

<section class="section-login">
    <link rel="stylesheet" href="css/estilos2.css">
    <form action="" method="post">

        <label for="usuario">Escribe tu usuario: </label>
        <input type="text" id="usuario" name="usuario" value="<?php if (isset($usuario)) echo $usuario; ?>" required><br>

        <label for="password">Escribe tu contraseña: </label>
        <input type="password" id="password" name="password" required><br>

        <?php
        if (!empty($mensajeError)) {
            // Muestra el mensaje de error en el HTML
            echo "<br><p class='mensaje-error'>$mensajeError</p>";

        }
        ?>

        <input type="submit" id="enviar" name="enviar" value="Iniciar sesión"><br>
    </form>
</section>
<?php include_once "estructuraWeb/pie.inc.php"; ?>
