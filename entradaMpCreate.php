<?php
include_once('conexion.php');
$input = file_get_contents('php://input');
$datos = json_decode($input, true); // llamar datos del formulario
$message = array();
$fecha = $datos['fecha'];
$cod = $datos['cod_entra_mp'];
$nom = $datos['nom_mp'];
$pes = $datos['peso'];
$pro = $datos['procedencia'];

if ($datos) {
    $q = mysqli_query($conn, "INSERT INTO `entrada_mp` (`cod_entra_mp`, `fecha`, `nom_mp`, `peso`, `procedencia`)
     VALUES ('$cod','$fecha','$nom','$pes','$pro')");

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