<?php
include("includes/conexion.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

    $sql = "
    INSERT INTO usuario(nombre, correo, contrasena)
    VALUES('$nombre', '$correo', '$contrasena')
    ";

    if(mysqli_query($conn, $sql)){

        header("Location: login.php");
        exit();

    } else {

        echo "Error: " . mysqli_error($conn);

    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registro</title>

    <link rel="stylesheet" href="assets/css/style.css">

</head>
<body>

<div class="auth-container">

    <div class="auth-card">

        <h2>Crear Cuenta</h2>

        <form method="POST">

            <input type="text"
                   name="nombre"
                   placeholder="Nombre"
                   required>

            <input type="email"
                   name="correo"
                   placeholder="Correo"
                   required>

            <input type="password"
                   name="contrasena"
                   placeholder="Contraseña"
                   required>

            <button class="btn" type="submit">
                Registrarse
            </button>

        </form>

        <br>

        <p style="text-align:center;">

            ¿Ya tienes cuenta?

            <a href="login.php">
                Iniciar sesión
            </a>

        </p>

    </div>

</div>

</body>
</html>