<?php
include_once('conexion.php');
$input = file_get_contents('php://input');
$datos = json_decode($input, true);
$message = array();
$id = $_GET['cod_entra_mp'];

$q = mysqli_query($conn, "DELETE FROM `entrada_mp` WHERE `cod_entra_mp` = '{$id} LIMIT 1'");

if($q){
    http_response_code(201);
    $message['status'] = "Success";
}else{
    http_response_code(422);
    $message['status'] = "Error";
}

echo json_encode($message);
echo mysqli_error($conn);
?>