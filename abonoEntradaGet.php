<?php
include_once('conexion.php');

$data = array();
$id = $_GET['cod_abono'];

$q = mysqli_query($conn, "SELECT * FROM `entrada_abono` WHERE `cod_abono` LIKE '%$id%'");

while ($row = mysqli_fetch_object($q)){
    $data[] = $row;
}
echo json_encode($data);
echo mysqli_error($conn);
?>