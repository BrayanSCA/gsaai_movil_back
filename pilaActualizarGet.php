<?php
include_once('conexion.php');

$data = array();
$id = $_GET['cod_actualiza'];

$q = mysqli_query($conn, "SELECT * FROM `actualizar_pila` WHERE `cod_actualiza` LIKE '%$id%'");

while ($row = mysqli_fetch_object($q)){
    $data[] = $row;
}
echo json_encode($data);
echo mysqli_error($conn);
?>