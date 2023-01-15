<?php
header('Content-Type: application/json; charset=utf-8');
include_once "conexion_new.php";

$input = file_get_contents('php://input');
$data = json_decode($input, true);


$bd = new MySQLDB;
$bd->connect();

$zona_origen        = $data["zona_origen"];
$zona_destino       = $data["zona_destino"];
$fecha              = $data["fecha"];
$observaciones      = $data["observaciones"];

// guardar la data en la tabla combinaciones
$insert = $bd->executeInstruction("INSERT INTO combinaciones
    (
        zona_origen,
        zona_destino,
        fecha,
        observaciones
    ) VALUES (
        ${zona_origen},
        ${zona_destino},
        '${fecha}',
        '${observaciones}'
    );"
);

if ($insert) {
    // buscamos la zona origen
    $zona_origen_bd = $bd->getData("SELECT * FROM zonas WHERE cod_zona = ${zona_origen} LIMIT 1;");
    if (count($zona_origen_bd) > 0) {
        $pila_id_mover = $zona_origen_bd[0]["pila_id"];
        // buscamos la pila a mover
        $pila_origen = $bd->getData("SELECT * FROM pila WHERE pila_id = ${pila_id_mover};")[0];
        // limpiamos la pila de la zona origen
        $quitar_pila_a_zona_query = $bd->executeInstruction("UPDATE zonas
            SET pila_id = NULL
            WHERE pila_id = ${pila_id_mover};");
    
        if ($quitar_pila_a_zona_query) {
            // buscamos la zona de destino
            $zona_destino_bd = $bd->getData("SELECT * FROM zonas WHERE cod_zona = ${zona_destino} LIMIT 1;");
            if (count($zona_destino_bd) > 0) {
                $pila_id_destino = $zona_destino_bd[0]["pila_id"];
                // comparamos si la zona tiene o no una pila
                if (empty($pila_id_destino)) {
                    // zona sin pila, se agrega la pila de la zona de origen
                    $bd->executeInstruction("UPDATE zonas
                        SET pila_id =  ${pila_id_mover}
                        WHERE cod_zona = ${zona_destino};");
                } else {
                    // zona con pila, la pila origen se roba los registros de la pila origen
                    $bd->executeInstruction("UPDATE pila_historial_pila
                        SET pila_id = ${pila_id_destino}
                        WHERE pila_id = ${pila_id_mover};");

                    $bd->executeInstruction("UPDATE pila_materia_prima_ingresada
                        SET pila_id = ${pila_id_destino}
                        WHERE pila_id = ${pila_id_mover};");

                    $bd->executeInstruction("DELETE FROM pila WHERE pila_id = ${pila_id_mover};");
                }
                http_response_code(200);
                echo json_encode(array(
                    "message" => "Ok"
                    ));
            } else {
                http_response_code(400);
                echo json_encode(array(
                    "message" => "Error buscando la zona de destino"
                ));
            }
        } else {
            http_response_code(400);
            echo json_encode(array(
                "message" => "Error quitandole la pila a la zona de origen"
            ));
        }
    } else {
        http_response_code(400);
        echo json_encode(array(
            "message" => "Error buscando la zona de origen"
        ));
    }
} else {
    http_response_code(400);
    echo json_encode(array(
        "message" => "Error al ingresar la combinaciones"
    ));
}
