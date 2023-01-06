<?php
include_once('conexion.php');
$input = file_get_contents('php://input');
$datos = json_decode($input, true);
$message = array();
$fecha = $datos['fecha'];
$cod = $datos['cod_entra_mp'];
$nom = $datos['nom_mp'];
$pes = $datos['peso'];
$pro = $datos['procedencia'];
$codactual = $datos['codactual']; 

$q = mysqli_query($conn, "UPDATE entrada_mp SET cod_entra_mp='$cod', 
fecha= '$fecha', nom_mp='$nom', peso='$pes', procedencia='$pro' WHERE cod_entra_mp = '$codactual'"); 

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