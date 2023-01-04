<?php
include_once('conexion.php');

$data = array();
$id = $_GET['cod_zona'];

$q = mysqli_query($conn, "SELECT * FROM `zonas` WHERE `cod_zona` LIKE '%$id%'");

while ($row = mysqli_fetch_object($q)){
    $data[] = $row;
}
echo json_encode($data);
echo mysqli_error($conn);
?>