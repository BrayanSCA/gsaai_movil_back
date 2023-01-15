<?php
include_once('conexion.php');
$input = file_get_contents('php://input');
$datos = json_decode($input, true); // llamar datos del formulario
$message = array();
$id = $datos['id'];
$fecha = $datos['fecha'];
$pes = $datos['peso'];
$rcn = $datos['relacion_cn'];
$nom = $datos['materia_prima_id'];
$pro = $datos['procedencia_id'];

if ($datos) {
    $q = mysqli_query($conn, "INSERT INTO `materia_prima_ingresada` (`id`, `fecha`, `peso`, `relacion_cn`, `materia_prima_id`, `procedencia_id`)
     VALUES ('$id','$fecha','$pes','$rcn','$nom','$pro')");

    if ($q) {
        http_response_code(201);
        $message['status'] = "Success";
    } else {
        http_response_code(422);
        $message['status'] = "Error";
    }

    echo json_encode($message);
    echo mysqli_error($conn);
}
?>