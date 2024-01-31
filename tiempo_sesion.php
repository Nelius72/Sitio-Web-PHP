<?php

// Comprobar si se ha iniciado sesión
if (!isset($_SESSION['logueado']) || $_SESSION['logueado'] !== true) {
  // Si no se ha iniciado sesión, redirigir a la página de inicio de sesión
  header('Location: login.php');
  exit;
}

// Comprobar si ha pasado más de 5 minutos desde la última acción
if (isset($_SESSION['last_action']) && (time() - $_SESSION['last_action'] > 300)) {
  // Si han pasado más de 5 minutos, destruir la sesión y redirigir a la página de inicio de sesión
  session_unset();
  session_destroy();
  header('Location: login.php');
  exit;
}

// Actualizar la hora de la última acción
$_SESSION['last_action'] = time();
?>