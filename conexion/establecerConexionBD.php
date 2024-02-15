<?php
$host = "localhost"; // Host de la base de datos
$usuarioBD = "sergio"; // Usuario de la base de datos
$passwordBD = "sergio"; // Contraseña de la base de datos
$nombreBD = "proyecto"; // Nombre de la base de datos

// Crear una conexión a la base de datos
$mysqli = mysqli_connect($host, $usuarioBD, $passwordBD, $nombreBD);

// Verificar si la conexión se estableció con éxito
if (!$mysqli) {
    echo "Fallo al conectar con la base de datos: " . mysqli_connect_error();
} 


function usuarioExiste($mysqli, $nombreUsuario) {
    $sql = "SELECT COUNT(*) as total FROM usuarios WHERE Nombre_Usuario = ? AND Borrado = FALSE";

    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "s", $nombreUsuario);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $total);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    return $total > 0;
}

function emailEnUso($mysqli, $email) {
    $sql = "SELECT COUNT(*) as total FROM usuarios WHERE Correo_Electronico = ? AND Borrado = FALSE";

    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $total);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    return $total > 0;
}



function registrarUsuario($mysqli, $nombre, $apellido, $apellido2, $correoElectronico, $nombreUsuario, $password) {
    // Hashea la contraseña
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Evita la inyección SQL utilizando sentencias preparadas
    $sql = "INSERT INTO usuarios (Nombre, Apellido, Apellido2, Correo_Electronico, Nombre_Usuario, Contrasena, Rol)
            VALUES (?, ?, ?, ?, ?, ?, 'lector')";

    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "ssssss", $nombre, $apellido, $apellido2, $correoElectronico, $nombreUsuario, $hashedPassword);

    if (mysqli_stmt_execute($stmt)) {
        return true; // Registro exitoso
    } else {
        return false; // Error al registrar el usuario
    }

    mysqli_stmt_close($stmt);
}

function dameUsuario($mysqli, $nombreUsuario) {
    $sql = "SELECT Nombre FROM usuarios WHERE Nombre_Usuario = ?";

    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "s", $nombreUsuario);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $nombre);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    return $nombre;
}
if (isset($_SESSION["usuario"])) {
    $nombreUsuario = $_SESSION["usuario"];
    $nombreUsuarioObtenido = dameUsuario($mysqli, $nombreUsuario);

    if ($nombreUsuarioObtenido) {
        $nombreUsuario = $nombreUsuarioObtenido;
    }
}

// Función para mostrar libros que no han sido borrados virtualmente
function mostrarLibros($mysqli) {
    // Sentencia SQL para seleccionar todos los libros no borrados virtualmente de la base de datos
    $sql = "SELECT ISBN, Titulo, Autor, Editorial, URL FROM libros WHERE Borrado = FALSE"; 

    $result = mysqli_query($mysqli, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<table class='libros-table'>"; 
        echo "<tr><th>ISBN</th><th>Título</th><th>Autor</th><th>Editorial</th><th>Portada</th><th>Más información</th></tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row["ISBN"] . "</td>";
            echo "<td>" . $row["Titulo"] . "</td>";
            echo "<td>" . $row["Autor"] . "</td>";
            echo "<td>" . $row["Editorial"] . "</td>";
            echo "<td><img src='./img/{$row['URL']}' class='imagen-libro'></td>";
            echo "<td><a href='?ruta=libro&ISBN=" . $row["ISBN"] . "' name='informacion-libro'>Reservar</a></td>";
           
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No se encontraron libros en la base de datos.";
    }
}



// Función para obtener los datos de un libro a partir de su ISBN
function obtenerLibro($mysqli, $isbn) {
    $sql = "SELECT ID, ISBN, Titulo, Autor, Editorial, SINOPSIS, URL FROM libros WHERE ISBN = ?";

    $stmt = mysqli_prepare($mysqli, $sql);

    if ($stmt === false) {
        die('Error en la preparación de la declaración: ' . mysqli_error($mysqli));
    }

    mysqli_stmt_bind_param($stmt, "s", $isbn);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        die('Error al ejecutar la consulta: ' . mysqli_error($mysqli));
    }

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        // Cerrar la declaración después de usarla
        mysqli_stmt_close($stmt);

        return $row; // Devuelve un array asociativo con los datos del libro
    } else {
        // Cerrar la declaración después de usarla
        mysqli_stmt_close($stmt);

        return null; // No se encontró el libro con el ISBN proporcionado
    }
}








function buscarLibros($mysqli, $nombreLibro) {
    $sql = "SELECT ISBN, Titulo, Autor, Editorial, URL FROM libros WHERE Titulo LIKE ?";
    $nombreLibro = "%" . $nombreLibro . "%"; // Agregamos comodines para buscar coincidencias parciales en el título

    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "s", $nombreLibro);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        echo "<table class='libros-table'>";
        echo "<tr><th>ISBN</th><th>Título</th><th>Autor</th><th>Editorial</th><th>Portada</th><th>Más información</th></tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row["ISBN"] . "</td>";
            echo "<td>" . $row["Titulo"] . "</td>";
            echo "<td>" . $row["Autor"] . "</td>";
            echo "<td>" . $row["Editorial"] . "</td>";
            echo "<td><img src='./img/{$row['URL']}' class='imagen-libro'></td>";
            echo "<td><a href='?ruta=libro&ISBN=" . $row["ISBN"] . "' name = 'informacion-libro'>Reservar</a></td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<h3 class='resultado-prestamo'>No se encontraron libros que coincidan con la búsqueda. Prueba otra cosa.</h3>";
    }

    mysqli_stmt_close($stmt);
}




//Funcion para modificar el nombre de usuario
function modificarNombreUsuario($mysqli, $nombreUsuarioActual, $nuevoNombreUsuario) {
    $sql = "UPDATE usuarios SET Nombre_Usuario = ? WHERE Nombre_Usuario = ?";

    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $nuevoNombreUsuario, $nombreUsuarioActual);

    if (mysqli_stmt_execute($stmt)) {
        return true; // Modificación exitosa
    } else {
        return false; // Error al modificar el nombre de usuario
    }

    mysqli_stmt_close($stmt);
}


//Funcion para modificar la contraseña del usuario
function cambiarContrasena($mysqli, $nombreUsuario, $contrasenaActual, $nuevaContrasena) {
    // Verificar si la contraseña actual es correcta
    $sql = "SELECT Contrasena FROM usuarios WHERE Nombre_Usuario = ?";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "s", $nombreUsuario);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $hashedPassword);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if (password_verify($contrasenaActual, $hashedPassword)) {
        // La contraseña actual es correcta, procede a actualizarla
        $nuevaPasswordHash = password_hash($nuevaContrasena, PASSWORD_DEFAULT);
        $sql = "UPDATE usuarios SET Contrasena = ? WHERE Nombre_Usuario = ?";
        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $nuevaPasswordHash, $nombreUsuario);

        if (mysqli_stmt_execute($stmt)) {
            return true; // Modificación exitosa
        } else {
            return false; // Error al modificar la contraseña
        }
    } else {
        return false; // Contraseña actual incorrecta
    }
}


// Función para mostrar todos los usuarios de la base de datos y sus datos
function mostrarUsuarios($mysqli) {
    // Sentencia SQL para seleccionar todos los usuarios no borrados virtualmente de la base de datos
    $sql = "SELECT * FROM usuarios WHERE Borrado = FALSE";

    $result = mysqli_query($mysqli, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<table class='tabla-usuarios'>"; // Puedes agregar una clase CSS para dar estilo a la tabla de usuarios
        echo "<tr><th>ID</th><th>Nombre</th><th>Apellido</th><th>Apellido2</th><th>Correo Electrónico</th><th>Nombre de Usuario</th><th>Rol</th><th>Borrar</th></tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row["ID"] . "</td>";
            echo "<td>" . $row["Nombre"] . "</td>";
            echo "<td>" . $row["Apellido"] . "</td>";
            echo "<td>" . $row["Apellido2"] . "</td>";
            echo "<td>" . $row["Correo_Electronico"] . "</td>";
            echo "<td>" . $row["Nombre_Usuario"] . "</td>";
            echo "<td>" . $row["Rol"] . "</td>";
            echo "<td><a href='?ruta=borrarusuario&ID=" . $row["ID"] . "' class='boton-modificar'>Borrar</a></td>";
            
            //echo "<a href='?ruta=modificarusuario&ID=" . $row["ID"] . "' class='boton-modificar'>Modificar</a>";
                    
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No se encontraron usuarios en la base de datos.";
    }
}




function prestarLibro($mysqli, $ID_Usuario, $ID_Libro) {
    // Obtener la fecha y hora actual
    $inicioPrestamo = date("Y-m-d H:i:s");

    // Calcular la fecha de fin de préstamo (30 días después)
    $finPrestamo = date("Y-m-d H:i:s", strtotime($inicioPrestamo . ' + 30 days'));

    // Sentencia SQL para insertar una fila en la tabla prestamo
    $sql = "INSERT INTO prestamo (ID_Usuario, ID_Libro, Inicio_Prestamo, Fin_Prestamo) VALUES (?, ?, ?, ?)";

    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "iiss", $ID_Usuario, $ID_Libro, $inicioPrestamo, $finPrestamo);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        return true; // Préstamo exitoso
    } else {
        mysqli_stmt_close($stmt);
        return false; // Error al prestar el libro
    }
}


// Función para eliminar préstamos terminados 
function eliminarPrestamosVencidos($mysqli) {
    // Obtener la fecha y hora actual
    $fechaActual = date("Y-m-d H:i:s");

    // Sentencia SQL para eliminar préstamos vencidos
    $sql = "DELETE FROM prestamo WHERE Fin_Prestamo < ?";

    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "s", $fechaActual);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        return true; // Eliminación exitosa
    } else {
        mysqli_stmt_close($stmt);
        return false; // Error al eliminar préstamos vencidos
    }
}



function obtenerIdUsuario($mysqli, $nombreUsuario) {
    $sql = "SELECT ID FROM usuarios WHERE Nombre_Usuario = ?";

    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "s", $nombreUsuario);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $idUsuario);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    return $idUsuario;
}


function librosReservados($mysqli, $nombreUsuario) {
    // Obtener el ID del usuario
    $idUsuario = obtenerIdUsuario($mysqli, $nombreUsuario);

    // Verificar si se pudo obtener el ID del usuario
    if ($idUsuario !== null) {
        // Sentencia SQL para seleccionar los libros reservados para el usuario que no están borrados virtualmente
        $sql = "SELECT l.ISBN, l.Titulo, l.Autor, l.Editorial, l.URL, p.Inicio_Prestamo, p.Fin_Prestamo
                FROM prestamo p
                INNER JOIN libros l ON p.ID_Libro = l.ID
                WHERE p.ID_Usuario = ? AND l.Borrado = FALSE";

        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, "i", $idUsuario);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            echo "<table class='libros-reservados'>";
            echo "<tr><th>ISBN</th><th>Título</th><th>Autor</th><th>Editorial</th><th>Portada</th><th>Inicio Prestamo</th><th>Fin Prestamo</th><th>Devolver</th></tr>";

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["ISBN"] . "</td>";
                echo "<td>" . $row["Titulo"] . "</td>";
                echo "<td>" . $row["Autor"] . "</td>";
                echo "<td>" . $row["Editorial"] . "</td>";
                echo "<td><img src='./img/{$row['URL']}' class='imagen-libro'></td>";
                echo "<td>" . $row["Inicio_Prestamo"] . "</td>";
                echo "<td>" . $row["Fin_Prestamo"] . "</td>";
                echo "<td><a href='?ruta=devolver&ISBN=" . $row["ISBN"] . "' class='boton-devolver devolver-link'>Devolver libro</a></td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<h3 class='resultado-prestamo'>Ahora mismo no tienes libros reservados.</h3>";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error al obtener el ID de usuario. Por favor, inicia sesión.";
    }
}



function reservarLibro($mysqli, $idUsuario, $idLibro) {
    // Verificar si el usuario ya ha reservado el libro
    $sqlVerificar = "SELECT * FROM prestamo WHERE ID_Usuario = ? AND ID_Libro = ?";
    $stmtVerificar = mysqli_prepare($mysqli, $sqlVerificar);
    mysqli_stmt_bind_param($stmtVerificar, "ii", $idUsuario, $idLibro);
    mysqli_stmt_execute($stmtVerificar);
    $resultVerificar = mysqli_stmt_get_result($stmtVerificar);

    if (mysqli_num_rows($resultVerificar) > 0) {
        echo "Ya has reservado este libro anteriormente.";
    } else {
        // Si no ha reservado el libro, realizar la reserva
        $sqlReservar = "INSERT INTO prestamo (ID_Usuario, ID_Libro) VALUES (?, ?)";
        $stmtReservar = mysqli_prepare($mysqli, $sqlReservar);
        mysqli_stmt_bind_param($stmtReservar, "ii", $idUsuario, $idLibro);

        if (mysqli_stmt_execute($stmtReservar)) {
            echo "Has reservado el libro.";
        } else {
            echo "Error al reservar el libro. Por favor, inténtalo de nuevo.";
        }

        mysqli_stmt_close($stmtReservar);
    }

    mysqli_stmt_close($stmtVerificar);
}


function usuarioHaReservadoLibro($mysqli, $idUsuario, $idLibro) {
    $sql = "SELECT * FROM prestamo WHERE ID_Usuario = ? AND ID_Libro = ?";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $idUsuario, $idLibro);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    return mysqli_num_rows($result) > 0;
}



function devolverLibro($mysqli, $idUsuario, $isbn) {
    // Obtener el ID del libro
    $libro = obtenerLibro($mysqli, $isbn);

    if ($libro !== null) {
        $idLibro = $libro['ID'];

        // Verificar si el usuario ha reservado el libro
        if (usuarioHaReservadoLibro($mysqli, $idUsuario, $idLibro)) {
            // Eliminar la reserva del libro
            $sqlEliminarReserva = "DELETE FROM prestamo WHERE ID_Usuario = ? AND ID_Libro = ?";
            $stmtEliminarReserva = mysqli_prepare($mysqli, $sqlEliminarReserva);
            mysqli_stmt_bind_param($stmtEliminarReserva, "ii", $idUsuario, $idLibro);

            if (mysqli_stmt_execute($stmtEliminarReserva)) {
                echo "<h3 class='resultado-prestamo'>Tu reserva se ha eliminado.</h3>";
            } else {
                echo "Error al eliminar la reserva. Por favor, inténtalo de nuevo.";
            }

            mysqli_stmt_close($stmtEliminarReserva);
        } else {
            echo "No has reservado este libro.";
        }
    } else {
        echo "El libro no existe.";
    }
}

//Funcion para borrar usuarios de manera virtual
function borrarUsuario($mysqli, $idUsuario) {
    // Marcar un usuario como borrado (virtualmente)
    $sql = "UPDATE usuarios SET Borrado = TRUE WHERE ID = ?";

    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "i", $idUsuario);

    if (mysqli_stmt_execute($stmt)) {
        return true; // Borrado virtual exitoso
    } else {
        return false; // Error al marcar el usuario como borrado
    }

    mysqli_stmt_close($stmt);
}


function modificarLibros($mysqli) {
    // Sentencia SQL para seleccionar todos los libros no borrados virtualmente de la base de datos
    $sql = "SELECT ISBN, Titulo, Autor, Editorial, URL FROM libros WHERE Borrado = FALSE";

    $result = mysqli_query($mysqli, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<table class='libros-table'>"; // Agrega la clase 'libros-table' a la tabla
        echo "<tr><th>ISBN</th><th>Título</th><th>Autor</th><th>Editorial</th><th>Portada</th><th>Borrar</th></tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row["ISBN"] . "</td>";
            echo "<td>" . $row["Titulo"] . "</td>";
            echo "<td>" . $row["Autor"] . "</td>";
            echo "<td>" . $row["Editorial"] . "</td>";
            echo "<td><img src='./img/{$row['URL']}' class='imagen-libro'></td>";
            echo "<td>
                    <a href='?ruta=borrarLibros&ISBN=" . $row["ISBN"] . "' class='boton-modificar'>Borrar</a>
                  </td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No se encontraron libros en la base de datos.";
    }
}


// Función para borrar libros de manera virtual
function borrarLibros($mysqli, $ISBN) {
    // Marcar un libro como borrado (virtualmente)
    $sql = "UPDATE libros SET Borrado = TRUE WHERE ISBN = ?";

    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "s", $ISBN);

    if (mysqli_stmt_execute($stmt)) {
        return true; // Borrado virtual exitoso
    } else {
        return false; // Error al marcar el libro como borrado
    }

    mysqli_stmt_close($stmt);
}



//Funcion para agregar libros a la base de datos
function agregarLibro($mysqli, $ISBN, $Titulo, $Autor, $Editorial, $Sinopsis, $URL) {
    // Sentencia SQL para insertar una fila en la tabla libros
    $sql = "INSERT INTO libros (ISBN, Titulo, Autor, Editorial, SINOPSIS, URL) VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "ssssss", $ISBN, $Titulo, $Autor, $Editorial, $Sinopsis, $URL);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        return "<h3 class='resultado-prestamo'>Libro añadido correctamente a la base de datos.</h3>";
    } else {
        $error = mysqli_error($mysqli);
        mysqli_stmt_close($stmt);
        return "Error al añadir el libro a la base de datos. Detalles: " . $error;
    }
}

function mostrarPrestamo($mysqli) {
    // Sentencia SQL para seleccionar los préstamos activos de usuarios no borrados
    $sql = "SELECT u.Nombre_Usuario, l.Titulo
            FROM prestamo p
            INNER JOIN usuarios u ON p.ID_Usuario = u.ID
            INNER JOIN libros l ON p.ID_Libro = l.ID
            WHERE l.Borrado = FALSE AND u.Borrado = FALSE";

    $result = mysqli_query($mysqli, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<table class='tabla-prestamos'>";
        echo "<tr><th>Nombre de Usuario</th><th>Título del Libro</th><th>Eliminar</th></tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row["Nombre_Usuario"] . "</td>";
            echo "<td>" . $row["Titulo"] . "</td>";
            echo "<td><a href='?ruta=eliminarPrestamo&nombreUsuario=" . $row["Nombre_Usuario"] . "&tituloLibro=" . $row["Titulo"] . "' class='boton-eliminar'>Eliminar</a></td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No hay préstamos activos en este momento.";
    }
}



function eliminarPrestamo($mysqli, $nombreUsuario, $tituloLibro) {
    // Sentencia SQL para eliminar el préstamo
    $sql = "DELETE FROM prestamo 
            WHERE ID_Usuario = (SELECT ID FROM usuarios WHERE Nombre_Usuario = '$nombreUsuario')
            AND ID_Libro = (SELECT ID FROM libros WHERE Titulo = '$tituloLibro')";

    $result = mysqli_query($mysqli, $sql);

    if ($result) {
        echo "<h3 class='resultado-prestamo'> El préstamo ha sido eliminado correctamente.</h3>";
    } else {
        echo "Error al eliminar el préstamo: " . mysqli_error($mysqli);
    }
}




// Cerrar la conexión cuando hayas terminado
mysqli_close($mysqli);
?>
