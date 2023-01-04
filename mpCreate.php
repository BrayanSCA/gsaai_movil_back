<?php
include_once('conexion.php');
$input = file_get_contents('php://input');
$datos = json_decode($input, true); // llamar datos del formulario
$message = array();
$cod = $datos['cod_mp'];
$nom = $datos['nombre_mp'];
$stk = $datos['stock'];
$rel = $datos['relacion_cn'];

if ($datos) {
    $q = mysqli_query($conn, "INSERT INTO `materias_primas` (`cod_mp`,`nombre_mp`,`stock`,`relacion_cn`) VALUES ('$cod','$nom','$stk','$rel')");

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