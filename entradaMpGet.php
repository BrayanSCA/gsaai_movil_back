<?php
include_once('conexion.php');

$data = array();
$id = $_GET['cod_entra_mp'];

$q = mysqli_query($conn, "SELECT * FROM `entrada_mp` WHERE `cod_entra_mp` LIKE '%$id%'");

while ($row = mysqli_fetch_object($q)){
    $data[] = $row;
}
echo json_encode($data);
echo mysqli_error($conn);
?>