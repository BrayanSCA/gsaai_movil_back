<?php
include_once('conexion.php');

$data = array();
$di = $_GET['di'];

$q = mysqli_query($conn, "SELECT * FROM `usuarios` WHERE `di` LIKE '%$di%'");

while ($row = mysqli_fetch_object($q)){
    $data[] = $row;
}
echo json_encode($data);
echo mysqli_error($conn);
?>