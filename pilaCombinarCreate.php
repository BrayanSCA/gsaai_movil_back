<?php
include_once('conexion.php');
$input = file_get_contents('php://input');
$datos = json_decode($input, true); // llamar datos del formulario
$message = array();
$cod = $datos['cod_conf_pila'];
$fecha = $datos['fecha_inicio'];
$res = $datos['responsable'];
$zon = $datos['zona'];
$obs = $datos['observaciones'];


if ($datos) {
    $q = mysqli_query($conn, "INSERT INTO `conformacion_pila` (`cod_conf_pila`, `fecha_inicio`,`responsable`, `zona`, `observaciones`) 
    VALUES ('$cod','$fecha','$res', '$zon','$obs')");

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