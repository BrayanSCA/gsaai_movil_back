<?php
include_once('conexion.php');

$data = array();
$id = $_GET['cod_insumo'];

$q = mysqli_query($conn, "SELECT * FROM `lista_insumos` WHERE `cod_insumo` LIKE '%$id%'");

while ($row = mysqli_fetch_object($q)){
    $data[] = $row;
}
echo json_encode($data);
echo mysqli_error($conn);
?>