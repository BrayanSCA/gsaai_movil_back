<?php
include_once('conexion.php');
$input = file_get_contents('php://input');
$datos = json_decode($input, true);
$message = array();
$cod = $datos['cod_mejorador'];
$nom = $datos['nom_mejorador'];
$car = $datos['caracteristicas'];
$codactual = $datos['codactual']; 

$q = mysqli_query($conn, "UPDATE mejoradores SET cod_mejorador='$cod', nom_mejorador='$nom', caracteristicas='$car'
 WHERE cod_mejorador = '$codactual'"); 

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