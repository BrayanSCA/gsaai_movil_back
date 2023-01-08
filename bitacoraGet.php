<?php
include_once('conexion.php');

$data = array();
$id = $_GET['cod_bita'];

$q = mysqli_query($conn, "SELECT * FROM `bitacoras` WHERE `cod_bita` LIKE '%$id%'");

while ($row = mysqli_fetch_object($q)){
    $data[] = $row;
}
echo json_encode($data);
echo mysqli_error($conn);
?>