<?php
include_once('conexion.php');
$input = file_get_contents('php://input');
$datos = json_decode($input, true);
$message = array();
$fecha = $datos['fecha'];
$cod = $datos['cod_ficha'];
$nom = $datos['nom_ficha'];
$codactual = $datos['codactual']; 

$q = mysqli_query($conn, "UPDATE fichas SET fecha= '$fecha', cod_ficha='$cod', nom_ficha='$nom' WHERE cod_ficha = '$codactual'"); 

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