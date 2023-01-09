<?php
include_once('conexion.php');
$input = file_get_contents('php://input');
$datos = json_decode($input, true); // llamar datos del formulario
$message = array();
$cod = $datos['cod_sali_abo'];
$fecha = $datos['fecha'];
$abo = $datos['abono'];
$can = $datos['cantidad'];
$fin = $datos['finalidad'];
$des = $datos['destino'];
$rec = $datos['recibe'];
$ent = $datos['entrega'];
$obs = $datos['observa'];
$evi = $datos['evidencia'];

if ($datos) {
    $q = mysqli_query($conn, "INSERT INTO `salida_abono` (`cod_sali_abo`, `fecha`, `abono`, `cantidad`, `finalidad`, `destino`, `recibe`, `entrega`, `observa`, `evidencia`)
     VALUES ('$cod','$fecha','$abo','$can','$fin','$des','$rec','$ent','$obs','$evi')");

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