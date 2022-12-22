<?php
$host = 'localhost';
$name = 'db-gsaai';
$user = 'root';
$pass = '';

$conn = mysqli_connect($host, $user, $pass, $name);
if(!$conn){
    die('Error en la conexión');
}/* else {
    echo ('Conexión a la base de datos exitosa');
} */
?>