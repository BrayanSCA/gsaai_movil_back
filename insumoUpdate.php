<?php
include_once('conexion.php');
$input = file_get_contents('php://input');
$datos = json_decode($input, true);
$message = array();
$fecha = $datos['fecha'];
$cod = $datos['cod_insumo'];
$nom = $datos['nom_insumo'];
$car = $datos['caracteristicas'];
$est = $datos['estado'];
$pro = $datos['procedencia'];
$codactual = $datos['codactual']; 

$q = mysqli_query($conn, "UPDATE lista_insumos SET fecha= '$fecha', cod_insumo='$cod', nom_insumo='$nom', caracteristicas='$car', estado='$est', procedencia='$pro' WHERE cod_insumo = '$codactual'"); 

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