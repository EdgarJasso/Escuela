<?php 
include("config/db.php");
header('Content-Type: application/json');
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $body = json_decode(file_get_contents("php://input"), true);

    $correo = (isset($body["correo"])) ? $body["correo"] : "";
    $pass = (isset($body["pass"])) ? $body["pass"] : "";

    if (!isset($correo) || empty($correo) || !isset($pass) || empty($pass)) {
        header("HTTP/1.1 400 Bad Request");
        echo "error 101";
        exit();
    }else{
        try {
            $sql = "SELECT id_usuario, nombre FROM usuario WHERE correo = :correo AND pass = :pass";
            $sentencia = $conexion->prepare($sql);
            $sentencia->bindParam(':correo', $correo, PDO::PARAM_STR);
            $sentencia->bindParam(':pass', $pass, PDO::PARAM_STR);
            $sentencia->execute();
            $datos = $sentencia->fetch(PDO::FETCH_LAZY);
            $count = $sentencia->rowCount();

            if ($count > 0 ) {
                $response_code = 1;
                $response_text = "acceso correcto";
                $response_url = "main.php";
                $_SESSION["log"] = true;
                $_SESSION["id_usuario"] = $datos["id_usuario"];
                $_SESSION["nombre"] = $datos["nombre"];
                $response = array("code" => $response_code, "mensaje" => $response_text, "url" => $response_url);   
            } else {
                $response_code = 0;
                $response_text = "credenciales incorrectas, intente nuevamente";
                $response = array("code" => $response_code, "mensaje" => $response_text);
            }
            $conexion = null;
            $sentencia = null;
            header("HTTP/1.1 200 OK");
            echo json_encode($response);
            exit();
        } catch (PDOException $ex) {
           echo  $ex->getMessage();
        }
    }
} else {
    header("HTTP/1.1 400 Bad Request");
    echo "error 100";
    exit();
}

?>