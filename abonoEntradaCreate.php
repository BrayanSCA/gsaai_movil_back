<?php
include_once('conexion.php');
$input = file_get_contents('php://input');
$datos = json_decode($input, true); // llamar datos del formulario
$message = array();
$cod = $datos['cod_abono'];
$fecha = $datos['fecha'];
$lot = $datos['lote_abono'];
$kil = $datos['kilos_abono'];
$mej = $datos['mejorador'];
$can = $datos['cantidad'];
$res = $datos['responsable'];
$obs = $datos['observa'];

if ($datos) {
    $q = mysqli_query($conn, "INSERT INTO `entrada_abono` (`cod_abono`, `fecha`, `lote_abono`, `kilos_abono`, `mejorador`, `cantidad`, `responsable`, `observa`)
     VALUES ('$cod','$fecha','$lot','$kil','$mej','$can','$res','$obs')");

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