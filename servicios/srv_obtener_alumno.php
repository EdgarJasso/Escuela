<?php 
include("config/db.php");
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $body = json_decode(file_get_contents("php://input"), true);

    $id = (isset($body["id"])) ? $body["id"] : "";

    if (!isset($id) || empty($id)) {
        header("HTTP/1.1 400 Bad Request");
        echo "error 101";
        exit();
    }else{
        try {
            $sql = "SELECT id_alumno, nombres, apellidos, correo, fecha_nacimiento FROM alumnos WHERE id_alumno = :id_alumno";
            $sentencia = $conexion->prepare($sql);
            $sentencia->bindParam(':id_alumno', $id);
            $sentencia->execute();
            $count = $sentencia->rowCount();
            $datos = $sentencia->fetch(PDO::FETCH_LAZY);
            if ($count > 0 ) {
                $data["id_alumno"] = $datos["id_alumno"];
                $data["nombres"] = $datos["nombres"];
                $data["apellidos"] = $datos["apellidos"];
                $data["correo"] = $datos["correo"];
                $data["fecha_nacimiento"] = $datos["fecha_nacimiento"];
                $response_code = 1;
                $response_text = "datos encontrados";
                $response = array("code" => $response_code, "mensaje" => $response_text, "data" => $data);   
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