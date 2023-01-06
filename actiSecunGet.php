<?php
include_once('conexion.php');

$data = array();
$id = $_GET['cod_secund'];

$q = mysqli_query($conn, "SELECT * FROM `actividades_secun` WHERE `cod_secund` LIKE '%$id%'");

while ($row = mysqli_fetch_object($q)){
    $data[] = $row;
}
echo json_encode($data);
echo mysqli_error($conn);
?>