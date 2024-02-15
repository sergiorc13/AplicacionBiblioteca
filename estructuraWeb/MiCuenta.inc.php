<?php
require_once("./conexion/establecerConexionBD.php");

$mysqli = mysqli_connect($host, $usuarioBD, $passwordBD, $nombreBD);

$mensajeUsuario = "";
$mensajeContrasena = "";

if (isset($_POST["cambiar_usuario"])) {
    $nuevoNombreUsuario = $_POST["nuevo_usuario"];
    $nombreUsuarioActual = $_SESSION["usuario"]; // Obtén el nombre de usuario actual de la sesión

    if ($nombreUsuarioActual === $nuevoNombreUsuario) {
        // El nombre de usuario es el mismo que estás usando
        $mensajeUsuario = "El nombre de usuario es el que estás usando actualmente.";
    } else {
        if (modificarNombreUsuario($mysqli, $nombreUsuarioActual, $nuevoNombreUsuario)) {
            $mensajeUsuario = "Nombre de usuario modificado con éxito.";
        } else {
            $mensajeUsuario = "Error al modificar el nombre de usuario.";
        }
    }
}

if (isset($_POST["cambiar_contraseña"])) {
    $contrasenaActual = $_POST["contraseña_actual"];
    $nuevaContrasena = $_POST["nueva_contraseña"];
    $confirmarNuevaContrasena = $_POST["confirmar_nueva_contraseña"];
    $nombreUsuario = $_SESSION["usuario"]; // Obtén el nombre de usuario actual de la sesión

    if ($nuevaContrasena === $confirmarNuevaContrasena) {
        if ($nuevaContrasena === $contrasenaActual) {
            $mensajeContrasena = "La nueva contraseña debe ser diferente de la contraseña actual.";
        } else {
            if (cambiarContrasena($mysqli, $nombreUsuario, $contrasenaActual, $nuevaContrasena)) {
                $mensajeContrasena = "Contraseña modificada con éxito.";
            } else {
                $mensajeContrasena = "Error al modificar la contraseña. Verifica la contraseña actual.";
            }
        }
    } else {
        $mensajeContrasena = "Las contraseñas no coinciden.";
    }
}

mysqli_close($mysqli);
?>

<div>
    <a href="?ruta=perfil" class = "boton-volver">Volver</a>
</div>

<div class="cuadricula">
    <div class="formulario-container">
        <p>Cambiar Nombre de Usuario</p><br>
        <form action="" method="post">
            <label>Nombre de Usuario Actual:</label>
            <input type="text" name="nombre_usuario_actual" value="<?php echo $_SESSION['usuario']; ?>" required><br>
            <label>Nuevo Nombre de Usuario:</label>
            <input type="text" name="nuevo_usuario" required><br>
            <input type="submit" name="cambiar_usuario" value="Cambiar Nombre de Usuario">
        </form><br>

        <!-- Mensaje de respuesta para el nombre de usuario -->
        <?php if (!empty($mensajeUsuario)): ?>
            <div class="mensaje">
                <?php echo $mensajeUsuario; ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="formulario-container">
        <p>Cambiar Contraseña</p><br>
        <form action="" method="post">
            <label>Contraseña Actual:</label>
            <input type="password" name="contraseña_actual" required><br>
            <label>Nueva Contraseña:</label>
            <input type="password" name="nueva_contraseña" required><br>
            <label>Confirmar Nueva Contraseña:</label>
            <input type="password" name="confirmar_nueva_contraseña" required><br>
            <input type="submit" name="cambiar_contraseña" value="Cambiar Contraseña">
        </form><br>

        <!-- Mensaje de respuesta para la contraseña -->
        <?php if (!empty($mensajeContrasena)): ?>
            <div class="mensaje">
                <?php echo $mensajeContrasena; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

