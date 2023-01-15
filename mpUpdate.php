<?php
include_once('conexion.php');
$input = file_get_contents('php://input');
$datos = json_decode($input, true);
$message = array();
$cod = $datos['cod_mp'];
$nom = $datos['nombre_mp'];
$rel = $datos['relacion_cn'];
$codactual = $datos['codactual']; 

$q = mysqli_query($conn, "UPDATE materias_primas SET cod_mp='$cod', nombre_mp='$nom', relacion_cn='$rel' WHERE cod_mp = '$codactual'"); 

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