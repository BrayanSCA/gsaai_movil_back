<?php
include_once('conexion.php');

$data = array();
$id = $_GET['cod_sali_abo'];

$q = mysqli_query($conn, "SELECT * FROM `salida_abono` WHERE `cod_sali_abo` LIKE '%$id%'");

while ($row = mysqli_fetch_object($q)){
    $data[] = $row;
}
echo json_encode($data);
echo mysqli_error($conn);
?>