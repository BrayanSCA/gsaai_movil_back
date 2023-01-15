<?php
include_once('conexion.php');

$data = array();
$id = $_GET['historial_id'];

$q = mysqli_query($conn, "SELECT * FROM `historial_pila` WHERE `historial_id` LIKE '%$id%'");

while ($row = mysqli_fetch_object($q)){
    $data[] = $row;
}
echo json_encode($data);
echo mysqli_error($conn);
?>