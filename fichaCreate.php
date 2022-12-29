<?php
include_once('conexion.php');
$input = file_get_contents('php://input');
$datos = json_decode($input, true); // llmar datos del formulario
$message = array();
$fecha = $datos['fecha'];
$cod = $datos['cod_ficha'];
$nom = $datos['nom_ficha'];

if ($datos) {
    $q = mysqli_query($conn, "INSERT INTO `fichas` (`fecha`, `cod_ficha`,`nom_ficha`) VALUES ('$fecha','$cod','$nom')");

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