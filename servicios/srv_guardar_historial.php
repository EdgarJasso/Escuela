<?php 
include("config/db.php");
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $body = json_decode(file_get_contents("php://input"), true);

    $id_alumno = (isset($body["id_alumno"])) ? $body["id_alumno"] : "";
    $id_plan = (isset($body["id_plan"])) ? $body["id_plan"] : "";
    $promedio = (isset($body["promedio"])) ? $body["promedio"] : "";

    if (!isset($id_alumno) || empty($id_alumno) || !isset($id_plan) || empty($id_plan)|| !isset($promedio) || empty($promedio)) {
        header("HTTP/1.1 400 Bad Request");
        echo "error 101";
        exit();
    }else{
        try {
            $sql = "INSERT INTO historial_academico (id_alumno , id_plan_estudio , promedio_general) VALUES (:id_alumno, :id_plan, :promedio);";
            $sentencia = $conexion->prepare($sql);
            //recepcion de parametros desde form
            $sentencia->bindParam(':id_alumno', $id_alumno);
            $sentencia->bindParam(':id_plan', $id_plan);
            $sentencia->bindParam(':promedio', $promedio);
            $sentencia->execute();

            if ($sentencia) {
                $response_code = 1;
                $response_text = "historial creado";
                $response = array("code" => $response_code, "mensaje" => $response_text);   
            } else {
                $response_code = 0;
                $response_text = "error 1010, fallo al crear registro";
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