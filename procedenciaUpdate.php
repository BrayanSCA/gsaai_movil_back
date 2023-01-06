<?php
include_once('conexion.php');
$input = file_get_contents('php://input');
$datos = json_decode($input, true);
$message = array();
$nom = $datos['nom_procedencia'];
$id = $datos['cod_procedencia'];

$q = mysqli_query($conn, "UPDATE procedencias SET nom_procedencia='$nom' WHERE cod_procedencia = '$id'"); 

if($q){
    http_response_code(201);
    $message['status'] = "Success";
}else{
    http_response_code(422);
    $message['status'] = "Error";
}

echo json_encode($message);
/* echo mysqli_error($conn); */
?>