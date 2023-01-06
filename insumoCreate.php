<?php
include_once('conexion.php');
$input = file_get_contents('php://input');
$datos = json_decode($input, true); // llamar datos del formulario
$message = array();
$fecha = $datos['fecha'];
$cod = $datos['cod_insumo'];
$nom = $datos['nom_insumo'];
$car = $datos['caracteristicas'];
$est = $datos['estado'];
$pro = $datos['procedencia'];



if ($datos) {
    $q = mysqli_query($conn, "INSERT INTO `lista_insumos` (`fecha`, `cod_insumo`,`nom_insumo`,`caracteristicas`,`estado`,`procedencia`) 
    VALUES ('$fecha','$cod','$nom','$car','$est','$pro')");

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