<?php
header('Content-Type: application/json; charset=utf-8');
include_once "conexion_new.php";

$bd = new MySQLDB;
$bd->connect();

$zonas = $bd->getData("SELECT * FROM `zonas`");
if (count($zonas) > 0) {
    $pilas_en_zonas = array();
    // Zonas
    for($i = 0; $i < count($zonas); ++$i) {
        if (empty($zonas[$i]["pila_id"])) {
            $zonas[$i]["pila"] = null;
            unset($zonas[$i]["pila_id"]);
        } else {
            array_push($pilas_en_zonas, array(
                "index" => $i,
                "pila_id" => (int)$zonas[$i]["pila_id"]
            )); 
        }
    }

    // Buscar las pilas de las zonas
    if (count($pilas_en_zonas) > 0) {
        $pilas_ids = array(); // array solo ids de la pila
        foreach ($pilas_en_zonas as &$pila) {
            array_push($pilas_ids, $pila["pila_id"]);
        }
        $pilas_ids = implode(', ', $pilas_ids); // ids separados por coma
        $pilas_bd = $bd->getData("SELECT
                p.pila_id as 'pila_id',
                p.cod_conf_pila as 'pila_cod_conf_pila',
                p.fecha_inicio as 'pila_fecha_inicio',
                p.observaciones as 'pila_observaciones',
                u.di as 'usuario_id',
                u.fecha as 'usuario_fecha',
                u.nombres as 'usuario_nombres',
                u.apellidos as 'usuario_apellidos',
                u.correo as 'usuario_correo',
                u.ficha as 'usuario_ficha',
                r.cod_rol as 'rol_cod_rol',
                r.nom_rol as 'rol_nom_rol',
                f.cod_ficha as 'ficha_cod_ficha',
                f.nom_ficha as 'ficha_nom_ficha'
            FROM
                pila as p,
                usuarios as u,
                roles as r,
                fichas as f
            WHERE pila_id IN (${pilas_ids})
            AND p.responsable_id = u.di
            AND u.rol = r.cod_rol
            AND u.ficha = f.cod_ficha;");
        for($i = 0; $i < count($pilas_bd); ++$i) {
            $pila_bd = $pilas_bd[$i];
            $aux_pila = array(
                "pila_id" => (int)$pila_bd["pila_id"],
                "cod_conf_pila" => $pila_bd["pila_cod_conf_pila"],
                "fecha_inicio" => $pila_bd["pila_fecha_inicio"],
                "observaciones" => $pila_bd["pila_observaciones"],
                "responsable" => array(
                    "di" => (int)$pila_bd["usuario_id"],
                    "fecha" => $pila_bd["usuario_fecha"],
                    "nombres" => $pila_bd["usuario_nombres"],
                    "apellidos" => $pila_bd["usuario_apellidos"],
                    "correo" => $pila_bd["usuario_correo"],
                    "rol" => array(
                        "cod_rol" => (int)$pila_bd["rol_cod_rol"],
                        "nom_rol" => $pila_bd["rol_nom_rol"]
                    ),
                    "ficha" => array(
                        "cod_ficha" => (int)$pila_bd["ficha_cod_ficha"],
                        "nom_ficha" => $pila_bd["ficha_nom_ficha"]
                    )
                )
            );
            $aux_pila_id = $aux_pila["pila_id"];

            // buscar historial de la pila
            $historials_bd = $bd->getData("SELECT
                    h.fecha,
                    h.temperatura_promedio,
                    h.humedad,
                    h.ph,
                    h.volumen,
                    h.densidad,
                    h.peso,
                    h.observaciones,
                    u.di AS 'usuario_id',
                    u.fecha AS 'usuario_fecha',
                    u.nombres AS 'usuario_nombres',
                    u.apellidos AS 'usuario_apellidos',
                    u.correo AS 'usuario_correo',
                    u.ficha AS 'usuario_ficha',
                    r.cod_rol AS 'rol_cod_rol',
                    r.nom_rol AS 'rol_nom_rol',
                    f.cod_ficha AS 'ficha_cod_ficha',
                    f.nom_ficha AS 'ficha_nom_ficha'
                FROM
                    pila_historial_pila AS ph,
                    pila AS p,
                    historial_pila AS h,
                    usuarios AS u,
                    roles AS r,
                    fichas AS f
                WHERE p.pila_id = ${aux_pila_id}
                AND p.pila_id = ph.pila_id
                AND ph.historial_id = h.historial_id
                AND h.responsable_id = u.di
                AND u.rol = r.cod_rol
                AND u.ficha = f.cod_ficha;");
            $histotial = array();

            if (count($historials_bd) > 0) {
                foreach ($historials_bd as &$historial_bd) {
                    array_push($histotial, array(
                        "fecha" => $historial_bd["fecha"],
                        "temperatura_promedio" => $historial_bd["temperatura_promedio"],
                        "humedad" => $historial_bd["humedad"],
                        "ph" => (int)$historial_bd["ph"],
                        "volumen" => (int)$historial_bd["volumen"],
                        "densidad" => (int)$historial_bd["densidad"],
                        "peso" => (int)$historial_bd["peso"],
                        "observaciones" => $historial_bd["observaciones"],
                        "responsable" => array(
                            "di" => (int)$historial_bd["usuario_id"],
                            "fecha" => $historial_bd["usuario_fecha"],
                            "nombres" => $historial_bd["usuario_nombres"],
                            "apellidos" => $historial_bd["usuario_apellidos"],
                            "correo" => $historial_bd["usuario_correo"],
                            "rol" => array(
                                "cod_rol" => (int)$historial_bd["rol_cod_rol"],
                                "nom_rol" => $historial_bd["rol_nom_rol"]
                            ),
                            "ficha" => array(
                                "cod_ficha" => (int)$historial_bd["ficha_cod_ficha"],
                                "nom_ficha" => $historial_bd["ficha_nom_ficha"]
                            )
                        )
                    ));
                }
            }
            // guardamos las historias en la pila
            $aux_pila["historial"] = $histotial;

            // buscar materiales prima de la pila
            $materials_bd = $bd->getData("SELECT
                    mpi.id,
                    mpi.fecha,
                    mpi.peso,
                    mpi.relacion_cn,
                    mp.cod_mp as 'materia_prima_cod',
                    mp.nombre_mp as 'materia_prima_nom',
                    pro.cod_procedencia as 'procedencia_cod',
                    pro.nom_procedencia as 'procedencia_nom'
                FROM
                    pila_materia_prima_ingresada as pm,
                    materia_prima_ingresada as mpi,
                    materias_primas as mp,
                    procedencias as pro,
                    pila as p
                WHERE p.pila_id = ${aux_pila_id}
                AND p.pila_id = pm.pila_id
                AND pm.materia_prima_ingresada_id = mpi.id
                AND mpi.materia_prima_id = mp.cod_mp
                AND mpi.procedencia_id = pro.cod_procedencia;");
            $materials = array();
            if (count($materials_bd) > 0) {
                foreach ($materials_bd as &$material_bd) {
                    array_push($materials, array(
                        "id" => (int)$material_bd["id"],
                        "fecha" => $material_bd["fecha"],
                        "peso" => $material_bd["peso"],
                        "relacion_cn" => $material_bd["relacion_cn"],
                        "materia_prima" => array(
                            "cod_mp" => (int)$material_bd["materia_prima_cod"],
                            "nombre_mp" => $material_bd["materia_prima_nom"],
                        ),
                        "procedencia" => array(
                            "cod_procedencia" => (int)$material_bd["procedencia_cod"],
                            "nom_procedencia" => $material_bd["procedencia_nom"]
                        )
                    ));
                }
            }
            // guardamos las materias primas ingresadas en la pila
            $aux_pila["materia_prima_ingresada"] = $materials;

            $zonas[$pilas_en_zonas[$i]["index"]]["pila"] = $aux_pila;
            unset($zonas[$pilas_en_zonas[$i]["index"]]["pila_id"]);
        }
    }
}

http_response_code(200);
echo json_encode($zonas);