<?php
include_once('conexion.php');
$data = array();
$q = mysqli_query($conn, "SELECT * FROM `lista_insumos`");

while ($row = mysqli_fetch_object($q)){
    $data[] = $row;
}
echo json_encode($data);
echo mysqli_error($conn);
?>