<?php
include ("conexion.php");
session_start();
$nombre_usuario="";
$contrasena="";
$error_nombre_usuario="";
$error_fallos="";
$intentos_fallidos=0;
$current_page="";

if ($_SERVER["REQUEST_METHOD"] == "POST"){

$nombre_usuario = $_POST['usuario'];
$contrasena = $_POST['password'];

$sql = "SELECT * FROM usuario WHERE username = '$nombre_usuario' AND password = '$contrasena'";
$resultado = mysqli_query($conexion, $sql);

$captcha = $_POST['g-recaptcha-response'];
$ip = $_SERVER['REMOTE_ADDR'];
$clave_secreta = '6LcMO64kAAAAANrPUX5uwqQy10BYpn7jrE8BZX5p';

$respuesta = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$clave_secreta&response=$captcha&remoteip=$ip");
$respuesta = json_decode($respuesta);


if (mysqli_num_rows($resultado) == 1 && $respuesta->success == true) {
    // El nombre de usuario y la contraseña son válidos
    $_SESSION["logueado"] = true;
    $_SESSION["nombre"] = $nombre_usuario;
    $current_page = $_SERVER['REQUEST_URI'];
    // Crear una nueva cookie que expire en 1 día
    setcookie('last_visited_page', $current_page, time() + (86400 * 1), '/');
    setcookie("cookie_username", $nombre_usuario, time() + (86400 * 1), "/"); 
    header('Location: index.php');
} else {
    if(isset($_SESSION['intentos_fallidos']) && $_SESSION['intentos_fallidos'] >= 3){
        $_SESSION['intentos_fallidos'] = 1;
    } else {
        $_SESSION['intentos_fallidos'] = isset($_SESSION['intentos_fallidos']) ? $_SESSION['intentos_fallidos']+1 : 1;
        
    }
    if($_SESSION['intentos_fallidos'] >= 3){
        session_destroy();
        header('Location: bloqueo.php');
        
        exit();
    }
    
    // El nombre de usuario y/o la contraseña son inválidos
    $error_nombre_usuario = "El nombre de usuario y/o la contraseña son inválidos";
    
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);


}

?>
<!DOCTYPE HTML>
<html>

<head>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link rel="stylesheet" href="css/login.css">
    <meta charset="utf-8">

    <title> Login </title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css?family=Nunito&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Overpass&display=swap" rel="stylesheet">

    <!-- Link hacia el archivo de estilos css -->
    <link rel="stylesheet" href="css/login.css">

    <style type="text/css">

    </style>

    <script type="text/javascript">

    </script>

</head>

<body>
<span class="logo">Mi sitio Web</span>
    <div class="navegador">
        <nav>
            <ul>
                <a href="registro.php">Crea una cuenta</a>
                
            </ul>
        </nav>
    </div>
    <div id="contenedor">
        <div id="central">
            <div id="login">
                <div class="titulo">
                    Bienvenido
                </div>
                <form id="loginform" method="post">
                    <input type="text" name="usuario" placeholder="Usuario" required>

                    <input type="password" placeholder="Contraseña" name="password" required>
                    <span class="error"><?php echo $error_nombre_usuario; ?></span>
                    
                    <div class="captcha">
                        <div class="g-recaptcha" data-sitekey="6LcMO64kAAAAALsueAye1J5_KT-lKi0bWs7ZhyU8">
                        </div>
                    </div>

                    <button type="submit" title="Ingresar" name="Ingresar"><b>Login</b></button>
                    <span class="error"><?php echo $error_fallos; ?></span>
                </form>
                <div class="pie-form">
                    <a href="#">¿Olvidaste tu Contraseña?</a>
                    <a href="registro.php">¿No tienes Cuenta? Registrate</a>
                </div>
            </div>
            <div class="inferior">

            </div>
        </div>
    </div>
</body>

</html>