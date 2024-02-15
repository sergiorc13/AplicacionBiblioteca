<?php
  //Eliminamos las variables de sesión
  session_unset();
  //Eliminamos la sesión
  session_destroy();
  header("Location: ?ruta=login");
  ?> 
  




