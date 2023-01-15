<?php
header('Content-Type: application/json; charset=utf-8');
include_once "conexion_new.php";

$input = file_get_contents('php://input');
$data = json_decode($input, true);

$bd = new MySQLDB;
$bd->connect();

$materias_prima_ingresada = $bd->getData("SELECT * FROM `materia_prima_ingresada`");

if (count($materias_prima_ingresada) > 0) {
    foreach ($materias_prima_ingresada as &$materia) {
        $procedencia_id = & $materia["procedencia_id"];
        $procedencias_bd = $bd->getData("SELECT * FROM `procedencias` WHERE cod_procedencia = ${procedencia_id}");

        $materia["procedencia"] = $procedencias_bd[0];
        unset($materia["procedencia_id"]);


        $materia_prima_id = & $materia["materia_prima_id"];
        $materias_bd = $bd->getData("SELECT * FROM `materias_primas` WHERE cod_mp = ${materia_prima_id}");

        $materia["materia_prima"] = $materias_bd[0];
        unset($materia["materia_prima_id"]);
    }
}

http_response_code(200);
echo json_encode($materias_prima_ingresada);