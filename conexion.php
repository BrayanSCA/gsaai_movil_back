<?php
$host = 'localhost';
$name = 'gsaai-db';
$user = 'root';
$pass = '';

$conn = mysqli_connect($host, $user, $pass, $name);
if(!$conn){
    die('Error en la conexión');
}/* else {
    echo ('Conexión a la base de datos exitosa');
} */
?>