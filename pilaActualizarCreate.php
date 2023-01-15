<?php
include_once('conexion.php');
$input = file_get_contents('php://input');
$datos = json_decode($input, true); // llamar datos del formulario
$message = array();
$cod = $datos['historial_id'];
$res = $datos['responsable_id'];
$tem = $datos['temperatura_promedio'];
$hum = $datos['humedad'];
$ph = $datos['ph'];
$vol = $datos['volumen'];
$den = $datos['densidad'];
$pes = $datos['peso'];
$obs = $datos['observaciones'];
$fecha = $datos['fecha'];


if ($datos) {
    $q = mysqli_query($conn, "INSERT INTO `historial_pila` (`historial_id`,`responsable_id`, `temperatura_promedio`, `humedad`, `ph`, `volumen`, `densidad`, `peso`, `observaciones`, `fecha`) 
    VALUES ('$cod','$res', '$tem', '$hum', '$ph', '$vol', '$den', '$pes', '$obs','$fecha')");

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