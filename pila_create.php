<?php
header('Content-Type: application/json; charset=utf-8');
include_once "conexion_new.php";

// $data = json_decode(file_get_contents('php://input'), true);
$input = file_get_contents('php://input');
$data = json_decode($input, true);

$bd = new MySQLDB;
$bd->connect();

$body_pila = $data["pila"];
$cod_conf_pila = $body_pila["cod_conf_pila"];
$fecha_inicio = $body_pila["fecha_inicio"];
$responsable_id = $body_pila["responsable_id"];
$observaciones = $body_pila["observaciones"];

$zona_id = $data["zona_id"];
$materia_prima_ingresada = $data["materia_prima"];


/* $cod_conf_pila = $data["cod_conf_pila"];
$fecha_inicio = $data["fecha_inicio"];
$responsable_id = $data["responsable_id"];
$observaciones = $data["observaciones"];
$zona_id = $data["zona_id"];
$materia_prima_ingresada = $data["materia_prima"];
 */
$pila_insert = $bd->executeInstruction("INSERT INTO
    pila
    (
        cod_conf_pila, 
        fecha_inicio, 
        responsable_id, 
        observaciones
    ) VALUES (
        '${cod_conf_pila}',
        '${fecha_inicio}',
        ${responsable_id},
        '${observaciones}'
    )"
);
if ($pila_insert) {
    $pila_id = $bd->getLastId();

    // guardar la pila en la zona
    $bd->executeInstruction("UPDATE
            zonas
        SET pila_id = ${pila_id}
        WHERE cod_zona =  ${zona_id}
    ");
    
    // guardamos la materia prima ingresada en el puente
    foreach ($materia_prima_ingresada as &$materia) {
        $bd->executeInstruction("INSERT INTO 
                pila_materia_prima_ingresada
            (
                pila_id,
                materia_prima_ingresada_id
            ) VALUES (
                ${pila_id},
                ${materia}
            )
        ");
    }

    http_response_code(200);
    echo json_encode(array(
        "message" => "Ok"
    ));
} else {
    http_response_code(400);
    echo json_encode(array(
        "message" => "Error al ingresar la pila"
    ));
}



