<?php
// Iniciar una nueva sesión
session_start();

// Destruir todas las variables de sesión
session_destroy();

// Redirigir al usuario a la página de inicio de sesión
header("location: login.php");
exit;
?>