<?php
include_once('conexion.php');

$data = array();
$id = $_GET['id'];

$q = mysqli_query($conn, "SELECT * FROM `materia_prima_ingresada` WHERE `id` LIKE '%$id%'");

while ($row = mysqli_fetch_object($q)){
    $data[] = $row;
}
echo json_encode($data);
echo mysqli_error($conn);
?>