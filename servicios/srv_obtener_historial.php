<?php 
include("config/db.php");
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $body = json_decode(file_get_contents("php://input"), true);

    $tipo = (isset($body["tipo"])) ? $body["tipo"] : "";

    if (!isset($tipo) || empty($tipo)) {
        header("HTTP/1.1 400 Bad Request");
        echo "error 101";
        exit();
    }else{
        try {
            $sql = "SELECT * FROM historial_academico ";
            $sentencia = $conexion->prepare($sql);
            $sentencia->execute();
            $datos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            $count = $sentencia->rowCount();

            if ($count > 0 ) {
                $response_code = 1;
                $response_text = "datos encontrados";
                $response = array("code" => $response_code, "mensaje" => $response_text, "data" => $datos);   
            } else {
                $response_code = 0;
                $response_text = "no se encontro informacion";
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