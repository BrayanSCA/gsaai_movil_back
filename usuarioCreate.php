<?php
include_once('conexion.php');
$input = file_get_contents('php://input');
$datos = json_decode($input, true); // llamar datos del formulario
$message = array();
$di = $datos['di'];
$fecha = $datos['fecha'];
$nom = $datos['nombres'];
$ape = $datos['apellidos'];
$mail = $datos['correo'];
$pass = $datos['contrasena'];
$rol = $datos['rol'];
$ficha = $datos['ficha'];

if ($datos) {
    $q = mysqli_query($conn, "INSERT INTO `usuarios` (`di`,`fecha`,`nombres`,`apellidos`,`correo`,`contrasena`,`rol`,`ficha`) 
    VALUES ('$di','$fecha','$nom','$ape','$mail','$pass','$rol','$ficha')");

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