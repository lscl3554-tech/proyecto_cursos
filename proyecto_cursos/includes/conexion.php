<?php

$host = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "cursos_db";

$conn = mysqli_connect($host, $usuario, $contrasena, $bd);

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

?>