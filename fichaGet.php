<?php
include_once('conexion.php');

$data = array();
$id = $_GET['cod_ficha'];

$q = mysqli_query($conn, "SELECT * FROM `fichas` WHERE `cod_ficha` LIKE '%$id%'");

while ($row = mysqli_fetch_object($q)){
    $data[] = $row;
}
echo json_encode($data);
echo mysqli_error($conn);
?>