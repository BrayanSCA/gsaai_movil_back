<?php
include_once('conexion.php');
$input = file_get_contents('php://input');
$datos = json_decode($input, true);
$message = array();
$fecha = $datos['fecha'];
$cod = $datos['cod_secund'];
$nom = $datos['nom_acti_sec'];
$codactual = $datos['codactual']; 

$q = mysqli_query($conn, "UPDATE actividades_secun SET cod_secund='$cod', 
fecha= '$fecha', nom_acti_sec='$nom' WHERE cod_secund = '$codactual'"); 

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