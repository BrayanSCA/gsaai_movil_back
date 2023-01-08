<?php
include_once('conexion.php');

$data = array();
$id = $_GET['cod_conf_pila'];

$q = mysqli_query($conn, "SELECT * FROM `conformacion_pila` WHERE `cod_conf_pila` LIKE '%$id%'");

while ($row = mysqli_fetch_object($q)){
    $data[] = $row;
}
echo json_encode($data);
echo mysqli_error($conn);
?>