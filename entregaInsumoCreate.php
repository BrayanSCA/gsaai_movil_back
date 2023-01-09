<?php
include_once('conexion.php');
$input = file_get_contents('php://input');
$datos = json_decode($input, true); // llamar datos del formulario
$message = array();
$cod = $datos['cod_entra_insu'];
$fecha = $datos['fecha'];
$res = $datos['responsable'];
$nom = $datos['nom_insumo'];
$can = $datos['cantidad'];
$est = $datos['estado'];

if ($datos) {
    $q = mysqli_query($conn, "INSERT INTO `entrada_insumos` (`cod_entra_insu`, `fecha`, `responsable`, `nom_insumo`, `cantidad`, `estado`) 
    VALUES ('$cod', '$fecha', '$res','$nom','$can','$est')");

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