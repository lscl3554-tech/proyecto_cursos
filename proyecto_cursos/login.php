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
            $_SESSION['rol'] = $usuario['rol'];

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>

    <link rel="stylesheet" href="assets/css/style.css">

</head>
<body>

<div class="auth-container">

    <div class="auth-card">

        <h2>Iniciar Sesión</h2>

        <form method="POST">

            <input type="email"
                   name="correo"
                   placeholder="Correo"
                   required>

            <input type="password"
                   name="contrasena"
                   placeholder="Contraseña"
                   required>

            <button class="btn" type="submit">
                Ingresar
            </button>

        </form>

        <br>

        <p style="text-align:center;">

            ¿No tienes cuenta?

            <a href="registro.php">
                Registrarse
            </a>

        </p>

    </div>

</div>

</body>
</html>