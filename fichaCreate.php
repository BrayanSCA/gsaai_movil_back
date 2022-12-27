<?php
include_once('conexion.php');
$datos = json_decode(file_get_contents('php//input'), true); // llmar datos del formulario
$message = array();
$fecha = $datos['fecha'];
$nom = $datos['nom_ficha'];

$result = mysqli_query($conn, "INSERT INTO `fichas` (`fecha`,`nom_ficha`) VALUES ('$fecha','$nom')");

if($result){
    http_response_code(201);
    $message['status'] - "Success";
}else{
    http_response_code(422);
    $message['status'] - "Error";
}

echo json_encode($message);
echo mysqli_error($conn);
?>