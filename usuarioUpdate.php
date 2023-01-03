<?php
include_once('conexion.php');
$input = file_get_contents('php://input');
$datos = json_decode($input, true);
$message = array();
$di = $datos['di'];
$fecha = $datos['fecha'];
$nom = $datos['nombres'];
$ape = $datos['apellidos'];
$mail = $datos['correo'];
$pass = $datos['contrasena'];
$rol = $datos['rol'];
$ficha = $datos['ficha'];
$codactual = $datos['codactual'];

$q = mysqli_query($conn, "UPDATE usuarios SET di='$di', fecha= '$fecha', nombres='$nom', apellidos='$ape', correo='$mail', contrasena='$pass',
rol='$rol', ficha='ficha' WHERE di = '$codactual'"); 

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