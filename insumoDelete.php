<?php
include_once('conexion.php');
$input = file_get_contents('php://input');
$datos = json_decode($input, true);
$message = array();
$id = $_GET['cod_insumo'];

$q = mysqli_query($conn, "DELETE FROM `lista_insumos` WHERE `cod_insumo` = '{$id} LIMIT 1'");

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