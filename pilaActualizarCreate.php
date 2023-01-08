<?php
include_once('conexion.php');
$input = file_get_contents('php://input');
$datos = json_decode($input, true); // llamar datos del formulario
$message = array();
$cod = $datos['cod_actualiza'];
$fecha = $datos['fecha'];
$evi = $datos['evidencia'];
$res = $datos['responsable'];
$zon = $datos['zona'];
$tem = $datos['temp_prom'];
$hum = $datos['humedad'];
$ph = $datos['ph'];
$vol = $datos['volumen'];
$den = $datos['densidad'];
$pes = $datos['peso'];
$obs = $datos['observa'];


if ($datos) {
    $q = mysqli_query($conn, "INSERT INTO `actualizar_pila` (`cod_actualiza`, `fecha`,`responsable`, `zona`, `temp_prom`, `humedad`, `ph`, `volumen`, `densidad`, `peso`, `observa`) 
    VALUES ('$cod','$fecha','$res', '$zon', '$tem', '$hum', '$ph', '$vol', '$den', '$pes', '$obs')");

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