<?php

include_once('conexion.php');

$data = json_decode(file_get_contents('php://input'), true);  // agarra los datos de la front
$di = $data['documento'];
$contrasena = $data['contrasena'];

$result = mysqli_query($conn, "SELECT * FROM usuarios WHERE di = '{$di}' AND contrasena = '{$contrasena}'")
or die ('Error en el select');
$rows = array();
while ($r=mysqli_fetch_assoc($result)){
    $rows[] = $r;
}
$respuesta = current($rows);
header('Content-type: application/json');
$json = [];
if(count($rows)===0){
    http_response_code(400);
    $json = ["mensaje" => "El usuario no existe"];
}else{
    http_response_code(200);

    $json = [
        "mensaje" => "ok",
        "usuario"=> [
            'di'=>$respuesta['di'],
            'nombres'=>$respuesta['nombres'],
            'apellidos'=>$respuesta['apellidos'],
            'rol' =>$respuesta['rol'],
            'ficha' =>$respuesta['ficha'],
            'correo' =>$respuesta['correo']
            ]
            
        ];
}

echo json_encode( $json ); 
?>