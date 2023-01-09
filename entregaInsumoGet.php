<?php
include_once('conexion.php');

$data = array();
$id = $_GET['cod_entra_insu'];

$q = mysqli_query($conn, "SELECT * FROM `entrada_insumos` WHERE `cod_entra_insu` LIKE '%$id%'");

while ($row = mysqli_fetch_object($q)){
    $data[] = $row;
}
echo json_encode($data);
echo mysqli_error($conn);
?>