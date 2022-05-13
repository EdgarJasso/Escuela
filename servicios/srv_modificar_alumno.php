<?php 
include("config/db.php");
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $body = json_decode(file_get_contents("php://input"), true);

    $id = (isset($body["id"])) ? $body["id"] : "";
    $nombres = (isset($body["nombres"])) ? $body["nombres"] : "";
    $apellidos = (isset($body["apellidos"])) ? $body["apellidos"] : "";
    $fecha = (isset($body["fecha"])) ? $body["fecha"] : "";
    $correo = (isset($body["correo"])) ? $body["correo"] : "";

    if (!isset($id) || empty($id) ||!isset($nombres) || empty($nombres) || !isset($correo) || empty($correo)) {
        header("HTTP/1.1 400 Bad Request");
        echo "error 101";
        exit();
    }else{
        try {
            $sql = "UPDATE alumnos SET nombres=:nombres, apellidos=:apellidos, fecha_nacimiento=:fecha_nacimiento, correo=:correo WHERE id_alumno = :id;";
            $sentencia = $conexion->prepare($sql);
            $sentencia->bindParam(':id', $id);
            $sentencia->bindParam(':nombres', $nombres);
            $sentencia->bindParam(':apellidos', $apellidos);
            $sentencia->bindParam(':fecha_nacimiento', $fecha);
            $sentencia->bindParam(':correo', $correo);
            $sentencia->execute();
            if ($sentencia) {
                $response_code = 1;
                $response_text = "alumno actualizado";
                $response = array("code" => $response_code, "mensaje" => $response_text);   
            } else {
                $response_code = 0;
                $response_text = "error 1010, fallo al modificar registro";
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