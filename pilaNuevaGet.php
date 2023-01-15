<?php
include_once('conexion.php');

$data = array();
$id = $_GET['pila_id'];

$q = mysqli_query($conn, "SELECT * FROM `pila` WHERE `pila_id` LIKE '%$id%'");

while ($row = mysqli_fetch_object($q)){
    $data[] = $row;
}
echo json_encode($data);
echo mysqli_error($conn);
?>