<?php
header('Content-Type: application/json; charset=utf-8');
include_once "conexion_new.php";

$data = json_decode(file_get_contents('php://input'), true);

$bd = new MySQLDB;
$bd->connect();

$materias_ingresadas = $data["materias_ingresadas"];

foreach ($materias_ingresadas as &$materia) {
    $fecha = $materia["fecha"];
    $peso = $materia["peso"];
    $relacion_cn = $materia["relacion_cn"];
    $materia_prima_id = $materia["materia_prima_id"];
    $procedencia_id = $materia["procedencia_id"];
    
    $bd->executeInstruction("INSERT INTO materia_prima_ingresada
        (
            fecha,
            peso, 
            relacion_cn, 
            materia_prima_id, 
            procedencia_id
        ) VALUES (
            '${fecha}',
            ${peso},  
            ${relacion_cn},  
            ${materia_prima_id},  
            ${procedencia_id} 
        );"
    );
}

http_response_code(200);
echo json_encode(array(
    "message" => "Ok"
));