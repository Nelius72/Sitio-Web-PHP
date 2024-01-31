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
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/hojacomun.css">
  <title>Cine</title>
  <style>
    body {
      background-image: url(img/fondoaficiones.jpg);
      background-color: white;
      background-size: cover;
      font-weight: bold;
      text-align: center;
      

    }

    div {
      font-weight: bold;
      color: orange;
      text-align: center;
      text-shadow: 1px 1px 1px black;


    }

    div img {
      margin-left: auto;
      margin-right: auto;
      border-radius: 8px;
      border: 3px solid gold;
    }
  </style>
</head>

<body>
<div class="navegador">
        <nav>
            <ul>
                <p><?php echo $nombre ?>&nbsp;&nbsp;&nbsp;</p>
                <?php echo '<img src="data:image/jpeg;base64,' . base64_encode($image) . '"title="Avatar" style= "width: 30px; height:30px; border-radius:25px;">' ?>
                <a href="salirsesion.php">Salir a Login</a>
                <a href="index.php">Volver a Principal</a>
                <a href="about.php">Contáctanos</a>
            </ul>
        </nav>
</div>
  <header>
    <h1>Cine</h1>
  </header>

    <p>Desde siempre me he sentido atraído por el cine. Mi infancia ha estado siempre marcada por las películas Disney.
    </p>
    <p>Con el paso de los años fue aumentando mi pasión por el cine...pasión que continúa a día de hoy.</p>
    <p>A continuación haré referencia a algunas de mis películas favoritas:</p>
    <div>

      <p>Star Wars:<a href="https://www.starwars.com"> La fuerza es intensa en tí. ¡Entra!</a></p>
      <p><img src="img/starwarsbanner.jpg" alt="Banner de Star Wars"></p>
      <p>Jurassic Park:<a href="https://es.wikipedia.org/wiki/Parque_Jurásico_(película)"> ¡Bienvenido a Jurassic
          Park!</a></p>
      <p><img src="img/jurassicparkbanner.jpg" alt="Banner de Jurassic Park"></p>
      <p>El Señor de los Anillos:<a
          href="https://es.wikipedia.org/wiki/Trilogía_cinematográfica_de_El_Señor_de_los_Anillos"> La Tierra Media te
          espera...</a></p>
      <p><img src="img/elseñordelosanillosbanner.jpg" alt="Banner de TLOTR"></p>
      <p>Interstellar:<a href="https://es.wikipedia.org/wiki/Interstellar"> ¿Qué hay más allá? ¡Averígualo!</a></p>
      <p><img src="img/interstellarbanner.jfif" alt="Banner de Interstellar"></p>
      <p>Los Intocables de Elliot Ness:<a href="https://es.wikipedia.org/wiki/The_Untouchables"> ¡Únete a la lucha
          contra el crímen!</a></p>
      <p><img src="img/losintocablesbanner.jpg" alt="Banner de Los Intocables"></p>

    </div>
  
  
</body>

</html>