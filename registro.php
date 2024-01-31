<?php

include("conexion.php");

// Variables para almacenar los datos del formulario
$nombre = "";
$username = "";
$password = "";
$sexo = "";
$fecha_nacimiento = "";
$avatar = "";
$suscripcion = "";
$error_nombre = "";
$error_username = "";
$error_password = "";
$error_fecha_nacimiento = "";
$error_avatar = "";
$fallos = 0;

// Si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validación de los campos
    $nombre = test_input($_POST["usuario"]);
    if (!preg_match("/^[a-zA-Z ]{10,}$/", $nombre)) {
        $error_nombre = "El nombre debe contener al menos 10 caracteres alfabéticos";
        $fallos++;
    }

    $username = test_input($_POST["username"]);
    if (!preg_match("/^[a-zA-Z][a-zA-Z0-9]{7,}$/", $username)) {
        $error_username = "El username debe contener al menos 8 caracteres alfanuméricos, comenzando con una letra";
        $fallos++;
    }

    $password = test_input($_POST["password"]);
    if (!preg_match("/^(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/", $password)) {
        $error_password = "La contraseña debe contener al menos 8 caracteres alfanuméricos/especiales, con al menos una letra mayúscula y un número";
        $fallos++;
    }

    $sexo = test_input($_POST["sexo"]);

    $fecha_nacimiento = test_input($_POST["fnac"]);
    $fecha_nacimiento_timestamp = strtotime($fecha_nacimiento);
    if ($fecha_nacimiento_timestamp === false || strtotime('+16 years', $fecha_nacimiento_timestamp) > time()) {
        $error_fecha_nacimiento = "Debes tener al menos 16 años para registrarte";
        $fallos++;
    }

    // Validación y subida de avatar
    if (isset($_FILES['avatar']) && $_FILES["avatar"]["size"] > 0) {
        // Leer el archivo de imagen en PHP
        $avatar = file_get_contents($_FILES['avatar']['tmp_name']);
    } else if ($sexo == "Masculino") {
        $avatar = file_get_contents('./img/masculino.jpg');
    } else {
        $avatar = file_get_contents('./img/femenino.jpg');
    }

    $suscripcion = test_input($_POST["susc"]);

    if (!$fallos > 0) {
        // Preparar la consulta SQL
        $sql = "INSERT INTO usuario (nombre, username, password, sexo, fecna, avatar,suscripcion) VALUES (?, ?, ?, ?, ?, ?, ?)";

        // Preparar la sentencia
        $stmt = $conexion->prepare($sql);

        // Adjuntar los valores a la sentencia
        $stmt->bind_param("sssssss", $nombre, $username, $password, $sexo, $fecha_nacimiento, $avatar, $suscripcion);

        // Ejecutar la sentencia
        if ($stmt->execute()) {
            header('Location: login.php');
        } else {
            // Error
        }
    }
}
// Función para limpiar y validar los datos del formulario
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE HTML>
<html>

<head>

    <link rel="stylesheet" href="css/registro.css">
    <meta charset="utf-8">

    <title> Registro </title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css?family=Nunito&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Overpass&display=swap" rel="stylesheet">

    <!-- Link hacia el archivo de estilos css -->
    <link rel="stylesheet" href="css/registro.css">

    <style type="text/css">

    </style>

    <script type="text/javascript">

    </script>

</head>

<body>

    <div class="reg">
        <div id="contenedor">
            <div id="central">
                <div id="login">
                    <div class="titulo">
                        Registro de Usuario
                    </div>
                    <form id="registroform" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">

                        <div class="avatar">
                            <img id="avatar-img" name="icono" src="img/masculino.jpg" alt="Avatar Masculino">
                        </div>
                        <div class="cambio">
                            <input type="file" name="avatar" accept="image/*" onchange="cargarAvatar(event)" style="width: 180px">
                            <span class="error"><?php echo $error_avatar; ?></span>
                        </div>
                        <br>
                        <input type="text" name="usuario" id="nombre" placeholder="Nombre" value="<?php echo $nombre; ?>" required>
                        <span class="error"><?php echo $error_nombre; ?></span>
                        <input type="text" name="username" id="username" placeholder="UserName" value="<?php echo $username; ?>" required>
                        <span class="error"><?php echo $error_username; ?></span>
                        <input type="password" id="password" placeholder="Contraseña" name="password" required>
                        <span class="error"><?php echo $error_password; ?></span>
                        <h4>Sexo</h4>
                        <div class="sexo">
                            <input type="radio" name="sexo" id="sexo_masculino" value="Masculino" <?php if ($sexo == "Masculino") {
                                                                                                        echo "checked";
                                                                                                    } ?> onchange="cambiarAvatar()" checked>Masculino
                            <input type="radio" name="sexo" id="sexo_femenino" value="Femenino" <?php if ($sexo == "Femenino") {
                                                                                                    echo "checked";
                                                                                                } ?> onchange="cambiarAvatar()">Femenino
                        </div>
                        <h4>F.Nacimiento</h4>
                        <input type="date" name="fnac" id="fecha_nacimiento" value="<?php echo $fecha_nacimiento; ?>" required>
                        <span class="error"><?php echo $error_fecha_nacimiento; ?></span>

                        <h4>Suscripción</h4>
                        <div class="sus">
                            <input type="radio" name="susc" id="sus_basica" value="Basica" <?php if ($suscripcion == "Basica") {
                                                                                                echo "checked";
                                                                                            } ?> onchange="cambiarAvatar()" checked>Básica
                            <input type="radio" name="susc" id="sus_premium" value="Premium" <?php if ($suscripcion == "Premium") {
                                                                                                    echo "checked";
                                                                                                } ?> onchange="cambiarAvatar()">Premium
                        </div>
                        <button type="submit" title="Ingresar" name="Ingresar"><b>Registrar</b></button>
                    </form>

                </div>
                <div class="inferior">
                    <a href="login.php"><b>Volver</b></a>
                </div>
            </div>
            <?php
            if (isset($_POST['submit'])) {
                // obtener el valor del sexo seleccionado
                $sexo = $_POST['sexo'];

                // mostrar el avatar correspondiente al sexo
                if ($sexo == 'Femenino') {
                    echo '<img src="img/femenino.jpg" alt="Avatar Femenino">';
                } else {
                    echo '<img src="img/masculino.jpg" alt="Avatar Masculino">';
                }
            }

            ?>

        </div>
    </div>
    <script>
        function cambiarAvatar() {
            var avatar = document.getElementById("avatar-img");
            var sexo = document.querySelector('input[name="sexo"]:checked').value;
            if (sexo == "Masculino") {
                avatar.src = "img/masculino.jpg";
            } else {
                avatar.src = "img/femenino.jpg";
            }
        }

        function cargarAvatar(event) {
            var archivo = event.target.files[0];
            var avatarImg = document.querySelector('#avatar-img');
            avatarImg.src = URL.createObjectURL(archivo);
        }
    </script>
</body>

</html>