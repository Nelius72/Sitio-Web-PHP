<?php
session_start();
require_once "tiempo_sesion.php";
$nombre= $_SESSION["nombre"];

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
    <link rel="stylesheet" href="css/about.css">
    <meta charset="utf-8">

    <title> Quienes Somos </title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css?family=Nunito&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Overpass&display=swap" rel="stylesheet">



</head>

<body>
<div class="navegador">
        <nav>
            <ul>
                <p><?php echo $nombre ?>&nbsp;&nbsp;&nbsp;</p>
                <?php echo '<img src="data:image/jpeg;base64,' . base64_encode($image) . '"title="Avatar" style= "width: 30px; height:30px; border-radius:25px;">' ?>
                <a href="salirsesion.php">Salir a Login</a>
                <a href="index.php">Volver a Principal</a>
            </ul>
        </nav>
</div>
    <div class="logo">
        <span>Sobre Mi </span>
            
    </div>

    <div class="about">
        <h1>Mi Sitio Web (PHP)</h1>
        <h2>Dirección</h2>
        <p>Avenida de Niebla 76, Bonares (Huelva)</p>
        <h2>Teléfono</h2>
        <p>+34 620512993</p>
        <h2>Email</h2>
        <p>cornelioromeroborrero@gmail.com</p>
        <div class="mapa">
            <iframe src="https://witcher3map.com/k/#2/81.6/64.0/w=62.000,42.875" width="500" height="300" />
        </div>
        <div class="inferior">
            <a href="login.php"><b>Volver</b></a>
        </div>
    </div>

</body>

</html>