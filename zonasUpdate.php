<?php
include_once('conexion.php');
$input = file_get_contents('php://input');
$datos = json_decode($input, true);
$message = array();
$fecha = $datos['fecha'];
$cod = $datos['cod_zona'];
$nom = $datos['nom_zona'];
$codactual = $datos['codactual']; 

$q = mysqli_query($conn, "UPDATE zonas SET cod_zona='$cod', fecha= '$fecha', nom_zona='$nom' WHERE cod_zona = '$codactual'"); 

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