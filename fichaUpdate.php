<?php
include_once('conexion.php');
$datos = json_decode(file_get_contents('php//input'), true);
$message = array();
$fecha = $datos['fecha'];
$nom = $datos['nom_ficha'];
$id = $_GET['cod_ficha'];

$q = mysqli_query($conn, "UPDATE `fichas` SET ('fecha','nom_ficha') VALUES ('$fecha','$nom') WHERE `id` = '{$id}' LIMIT 1");

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