<?php
include("includes/conexion.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuario(nombre, correo, contrasena)
            VALUES('$nombre', '$correo', '$contrasena')";

    if(mysqli_query($conn, $sql)){
        echo "Usuario registrado correctamente";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
</head>
<body>

<h2>Registro</h2>

<form method="POST">

    <input type="text" name="nombre" placeholder="Nombre" required>
    <br><br>

    <input type="email" name="correo" placeholder="Correo" required>
    <br><br>

    <input type="password" name="contrasena" placeholder="Contraseña" required>
    <br><br>

    <button type="submit">Registrarse</button>

</form>

</body>
</html>