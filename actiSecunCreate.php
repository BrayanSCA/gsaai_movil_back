<?php
include_once('conexion.php');
$input = file_get_contents('php://input');
$datos = json_decode($input, true); // llamar datos del formulario
$message = array();
$fecha = $datos['fecha'];
$cod = $datos['cod_secund'];
$nom = $datos['nom_acti_sec'];

if ($datos) {
    $q = mysqli_query($conn, "INSERT INTO `actividades_secun` (`cod_secund`, `fecha`, `nom_acti_sec`)
     VALUES ('$cod','$fecha','$nom')");

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