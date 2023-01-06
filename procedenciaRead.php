<?php
include_once('conexion.php');
$data = array();
$q = mysqli_query($conn, "SELECT * FROM `procedencias`");

while ($row = mysqli_fetch_object($q)){
    $data[] = $row;
}
http_response_code(200);
echo json_encode($data);
/* echo mysqli_error($conn); */
?>