<?php
// Logica de la aplicación web
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto: Biblioteca</title>
    <link rel="stylesheet" type="text/css" href="css/estilo.css">
</head>
<body>
<?php include_once "estructuraWeb/cabecera.inc.php" ?>
    
<?php

    if(isset($_GET)) {
        if (isset($_GET["ruta"]) && $_GET["ruta"] == "registro") {
            include_once "estructuraWeb/registro.inc.php";
            exit; // Detener la ejecución para que no se muestren los botones
        }
        
        // Manejar la solicitud de inicio de sesión
        if (isset($_GET["ruta"]) && $_GET["ruta"] == "login") {
            include_once "estructuraWeb/login.inc.php";
            exit; // Detener la ejecución para que no se muestren los botones
        }
        
        if(isset($_GET["ruta"]) && $_GET["ruta"] == "perfil") {
            include_once "estructuraWeb/menu.inc.php";
            include_once "estructuraWeb/perfil.inc.php";
            exit; // Detener la ejecución para que no se muestren los botones)
        }

        if(isset($_GET["ruta"]) && $_GET["ruta"] == "logout") {
            include_once "estructuraWeb/logout.inc.php";
            exit; // Detener la ejecución para que no se muestren los botones)
        }

        if(isset($_GET["ruta"]) && $_GET["ruta"] == "busqueda") {
            include_once "estructuraWeb/busqueda.inc.php";
            exit; // Detener la ejecución para que no se muestren los botones)
        }

        if(isset($_GET["ruta"]) && $_GET["ruta"] == "micuenta") {
            
            include_once "estructuraWeb/MiCuenta.inc.php";
        
            exit; // Detener la ejecución para que no se muestren los botones)
        }

        if(isset($_GET["ruta"]) && $_GET["ruta"] == "administracion") {
            
            include_once "estructuraWeb/administracion.inc.php";
            include_once "estructuraWeb/pie.inc.php";
            exit; // Detener la ejecución para que no se muestren los botones)
        }

        if(isset($_GET["ruta"]) && $_GET["ruta"] == "usuarios") {
            
            include_once "estructuraWeb/usuarios.inc.php";
            exit; // Detener la ejecución para que no se muestren los botones)
        }
        
        if(isset($_GET["ruta"]) && $_GET["ruta"] == "libro") {
            
            include_once "estructuraWeb/libros.inc.php";
            
            exit; // Detener la ejecución para que no se muestren los botones)
        }

        if(isset($_GET["ruta"]) && $_GET["ruta"] == "prestamo") {
            
            include_once "estructuraWeb/prestamo.inc.php";
            
            exit; // Detener la ejecución para que no se muestren los botones)
        }

        if(isset($_GET["ruta"]) && $_GET["ruta"] == "mislibros") {
            
            include_once "estructuraWeb/misLibros.inc.php";
            
            exit; // Detener la ejecución para que no se muestren los botones)
        }

        
        if(isset($_GET["ruta"]) && $_GET["ruta"] == "devolver") {
            
            include_once "estructuraWeb/devolver.inc.php";
            
            exit; // Detener la ejecución para que no se muestren los botones)
        }

        if(isset($_GET["ruta"]) && $_GET["ruta"] == "modificarusuario") {
            
            include_once "estructuraWeb/modificarUsuario.inc.php";
            
            exit; // Detener la ejecución para que no se muestren los botones)
        }

        if(isset($_GET["ruta"]) && $_GET["ruta"] == "borrarusuario") {
            
            include_once "estructuraWeb/borrarUsuario.inc.php";
            
            exit; // Detener la ejecución para que no se muestren los botones)
        }

        if(isset($_GET["ruta"]) && $_GET["ruta"] == "administrarLibros") {
            
            include_once "estructuraWeb/administrarLibros.inc.php";
            exit; // Detener la ejecución para que no se muestren los botones)
        }
        
        if(isset($_GET["ruta"]) && $_GET["ruta"] == "borrarLibros") {
            
            include_once "estructuraWeb/borrarLibros.inc.php";
            exit; // Detener la ejecución para que no se muestren los botones)
        }

        if(isset($_GET["ruta"]) && $_GET["ruta"] == "anadirLibros") {
            
            include_once "estructuraWeb/anadirLibros.inc.php";
            exit; // Detener la ejecución para que no se muestren los botones)
        }

        if(isset($_GET["ruta"]) && $_GET["ruta"] == "administrarPrestamos") {
            
            include_once "estructuraWeb/administrarPrestamos.inc.php";
            
            exit; // Detener la ejecución para que no se muestren los botones)
        }

        if (isset($_GET['ruta']) && $_GET['ruta'] == 'eliminarPrestamo' && isset($_GET['nombreUsuario']) && isset($_GET['tituloLibro'])) {

            include_once "estructuraWeb/eliminarPrestamos.inc.php";
            exit;
        }

    }

        
    if(!isset($_GET["ruta"]) || $_GET["ruta"] == "home"){
        include_once('estructuraWeb/home.inc.php');
    }
    
?>


<?php include_once "estructuraWeb/pie.inc.php"; ?>

</body>
</html>
