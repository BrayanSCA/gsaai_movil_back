<?php
include_once('conexion.php');
$input = file_get_contents('php://input');
$datos = json_decode($input, true); // llamar datos del formulario
$message = array();
$cod = $datos['cod_mejorador'];
$nom = $datos['nom_mejorador'];
$car = $datos['caracteristicas'];

if ($datos) {
    $q = mysqli_query($conn, "INSERT INTO `mejoradores` (`cod_mejorador`,`nom_mejorador`,`caracteristicas`) VALUES ('$cod','$nom','$car')");

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