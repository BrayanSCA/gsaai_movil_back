<?php
include_once('conexion.php');

$data = array();
$id = $_GET['cod_mejorador'];

$q = mysqli_query($conn, "SELECT * FROM `mejoradores` WHERE `cod_mejorador` LIKE '%$id%'");

while ($row = mysqli_fetch_object($q)){
    $data[] = $row;
}
echo json_encode($data);
echo mysqli_error($conn);
?>