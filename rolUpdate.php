<?php
include_once('conexion.php');
$input = file_get_contents('php://input');
$datos = json_decode($input, true);
$message = array();
$fecha = $datos['fecha'];
$cod = $datos['cod_rol'];
$nom = $datos['nom_rol'];
$codactual = $datos['codactual']; 

$q = mysqli_query($conn, "UPDATE fichas SET cod_rol='$cod', fecha= '$fecha', nom_rol='$nom' WHERE cod_rol = '$codactual'");

if($result){
    http_response_code(201);
    $message['status'] = "Success";
}else{
    http_response_code(422);
    $message['status'] = "Error";
}

echo json_encode($message);
echo mysqli_error($conn);
?>