<?php
session_start();
include("includes/conexion.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    $sql = "SELECT * FROM usuario WHERE correo='$correo'";

    $resultado = mysqli_query($conn, $sql);

    if(mysqli_num_rows($resultado) > 0){

        $usuario = mysqli_fetch_assoc($resultado);

        if(password_verify($contrasena, $usuario['contrasena'])){

            $_SESSION['usuario'] = $usuario['nombre'];
            $_SESSION['idusuario'] = $usuario['idusuario'];

            header("Location: estudiante/dashboard.php");
            exit();

        } else {
            echo "Contraseña incorrecta";
        }

    } else {
        echo "Usuario no encontrado";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>

<h2>Iniciar Sesión</h2>

<form method="POST">

    <input type="email" name="correo" placeholder="Correo" required>
    <br><br>

    <input type="password" name="contrasena" placeholder="Contraseña" required>
    <br><br>

    <button type="submit">Ingresar</button>

</form>

</body>
</html>