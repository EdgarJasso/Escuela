<?php 
//datos db
$host = "localhost";
$db = "escuela";
$usuario = "root";
$contrasenia = "";
try {
    $conexion = new PDO("mysql:host=$host;dbname=$db", $usuario, $contrasenia);
    if ($conexion) {
        $conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo "conectado... al sistema.<br><br><hr><hr>";
    }
} catch (Exception $ex) {
    echo $ex->getMessage();
}
?>
