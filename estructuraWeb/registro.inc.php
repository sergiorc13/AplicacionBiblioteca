<?php
require_once("./conexion/establecerConexionBD.php");

$mysqli = mysqli_connect($host, $usuarioBD, $passwordBD, $nombreBD);

$mensajeError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["registrar"])) {
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $apellido2 = $_POST["apellido2"];
    $email = $_POST["email"];
    $usuario = $_POST["usuario"];
    $password = $_POST["password"];

    // Validar contraseña
    if (strlen($password) < 8 || !preg_match("/\d/", $password)) {
        $mensajeError = "La contraseña debe tener al menos 8 caracteres y contener al menos un número.";
    } else {
        // Verificar si el usuario ya existe
        if (usuarioExiste($mysqli, $usuario)) {
            $mensajeError = "El nombre de usuario ya está en uso. Por favor, elige otro.";
        } elseif (emailEnUso($mysqli, $email)) {
            $mensajeError = "El correo electrónico ya está en uso. Por favor, utiliza otro.";
        } else {
            // Si el usuario no existe, el correo no está en uso y la contraseña es válida, intenta registrarlo
            if (registrarUsuario($mysqli, $nombre, $apellido, $apellido2, $email, $usuario, $password)) {
                // Usuario registrado con éxito
                header("Location: ?ruta=login");
            } else {
                $mensajeError = "Error al registrar el usuario.";
            }
        }
    }
}

mysqli_close($mysqli);

?>


<section class="registro-section">
    <div class="titulo-div">
        <h1 class="titulo-h1">¡Regístrate ya!</h1>
    </div>

    <form class="formulario" method="post" action="">
        <label for="nombre" class="label">Nombre:</label>
        <input type="text" name="nombre" class="input" required><br>

        <label for = "apellido" class="label">Primer apellido:</label>
        <input type="text" name="apellido" class="input" required><br>

        <label for= "apellido2" class="label">Segundo apellido:</label>
        <input type="text" name = "apellido2" class="input" required><br>

        <label for = "email" class="label">Correo electrónico:</label>
        <input type="email" id="email" name="email" class="input" required><br>

        <label for = "usuario" class="label">Nombre de usuario:</label>
        <input type="text" name="usuario" class="input" required><br><br>

        <br> <label for = "password" class="label">Contraseña:</label>
        <input type="password" name="password" class="input" required><br><br>

        <?php if (!empty($mensajeError)): ?>
            <div class="mensaje-error">
                <?php echo $mensajeError; ?>
            </div>
        <?php endif; ?>

        <input type="submit" name="registrar" class="registrar-button" value="Registrarme">
    </form>
</section>





        
