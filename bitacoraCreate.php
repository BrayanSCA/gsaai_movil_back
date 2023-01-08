<?php
include_once('conexion.php');
$input = file_get_contents('php://input');
$datos = json_decode($input, true); // llamar datos del formulario
$message = array();
$cod = $datos['cod_bita'];
$fecha = $datos['fecha'];
$res = $datos['responsable'];
$rut = $datos['rutinarias'];
$nru = $datos['no_rutinarias'];
$num = $datos['num_operarios'];
$ins = $datos['insumos'];
$obs = $datos['observa'];
$evi = $datos['evidencia'];


if ($datos) {
    $q = mysqli_query($conn, "INSERT INTO `bitacoras` (`cod_bita`, `fecha`,`responsable`, `rutinarias`, 
    `no_rutinarias`, `num_operarios`, `insumos`,`observa`) 
    VALUES ('$cod','$fecha','$res', '$rut', '$nru', '$num', '$ins', '$obs')");

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