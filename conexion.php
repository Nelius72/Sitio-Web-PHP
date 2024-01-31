<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conexion = new mysqli('localhost', 'cornelio', 'cornelio', 'bbddphp') or die ("Error en la conexion");
mysqli_set_charset($conexion, "utf8");

if(!$conexion){
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}else{

}
?>