<?php
header('Content-Type: application/json; charset=utf-8');
include_once "conexion_new.php";

$input = file_get_contents('php://input');
$data = json_decode($input, true);

$bd = new MySQLDB;
$bd->connect();

$body_historial = $data["historial"];
$responsable_id = $body_historial["responsable_id"];
$temperatura_promedio = $body_historial["temperatura_promedio"];
$humedad = $body_historial["humedad"];
$ph = $body_historial["ph"];
$volumen = $body_historial["volumen"];
$densidad = $body_historial["densidad"];
$peso = $body_historial["peso"];
$observaciones = $body_historial["observaciones"];
$fecha = $body_historial["fecha"];

$cod_zona = $data["cod_zona"];

$mover_a = $data["mover_a"];

$historial_insert = $bd->executeInstruction("INSERT INTO historial_pila
    (
        responsable_id,
        temperatura_promedio,
        humedad, 
        ph, 
        volumen, 
        densidad, 
        peso, 
        observaciones, 
        fecha
    ) VALUES (
       ${responsable_id},
       '${temperatura_promedio}',
       '${humedad}',
       ${ph},
       ${volumen},
       ${densidad},
       ${peso},
       '${observaciones}',
       '${fecha}'
    )"
);

if ($historial_insert) {
    $historial_id = $bd->getLastId();

    $zonas = $bd->getData("SELECT * FROM `zonas` WHERE cod_zona=${cod_zona} LIMIT 1");
    $pila_id = $zonas[0]["pila_id"];
    // $pilas_bd = $bd->getData("SELECT * FROM `pila` WHERE pila_id = ${pila_id} LIMIT 1");

    // if (count($pilas_bd) > 0) {
        // $aux_pila_id = $pilas_bd[0]["pila_id"];

         // guardar la pila en la zona
        $bd->executeInstruction("INSERT INTO 
                pila_historial_pila
            (
                pila_id,
                historial_id
            ) VALUES (
                ${pila_id},
                ${historial_id}
            )
        ");

        if (!empty($mover_a)) {
            $bd->executeInstruction("UPDATE `zonas`
                SET pila_id = NULL
                WHERE pila_id = ${pila_id};");
            $bd->executeInstruction("UPDATE `zonas`
                SET pila_id =  ${pila_id}
                WHERE cod_zona = ${mover_a};");
        }

        http_response_code(200);
        echo json_encode(array(
        "message" => "Ok"
        ));
   /*  } else {
        http_response_code(400);
        echo json_encode(array(
            "message" => "Error al guardar el historial"
        ));
    } */
} else {
    http_response_code(400);
    echo json_encode(array(
        "message" => "Error al ingresar la pila"
    ));
}