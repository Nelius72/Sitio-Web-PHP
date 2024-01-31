<?php
$image="";
session_start();
require_once "tiempo_sesion.php";
$nombre = $_SESSION["nombre"];

require_once 'conexion.php';
$sql = "SELECT avatar FROM usuario WHERE username like '$nombre'";
$result = $conexion->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $image = $row['avatar'];
}


?>

<!DOCTYPE HTML>
<html>

<head>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link rel="stylesheet" href="css/index.css">
    <meta charset="utf-8">

    <title> Index </title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css?family=Nunito&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Overpass&display=swap" rel="stylesheet">

    <!-- Link hacia el archivo de estilos css -->
    <link rel="stylesheet" href="css/index.css">

    <style type="text/css">

    </style>

    <script type="text/javascript">

    </script>

</head>

<body>
    <div class="navegador">
        <nav>
            <ul>
            <p><?php echo $nombre ?>&nbsp;&nbsp;&nbsp;</p>
                <?php echo '<img src="data:image/jpeg;base64,' . base64_encode($image) . '"title="Avatar" style= "width: 30px; height:30px; border-radius:25px;">' ?>
                <a href="salirsesion.php">Salir a Login</a>
                <a href="about.php">Contáctanos</a>
                <a href="tercera.php">Mis Aficiones</a>
            </ul>
        </nav>
    </div>
    <div class="logo">
        <span>Bienvenido a Mi Sitio Web</span>
        
    </div>

    <div class="about">

        <h1>Mi Sitio Web (PHP)</h1>
        <div class="video">
            <iframe src="video/killing_monsters.mp4" width="420" height="240" />
        </div>
        <div class="inferior">
            <a href="login.php"><b>Volver</b></a>
        </div>
    </div>

</body>

</html>