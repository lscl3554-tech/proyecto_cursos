<?php
session_start();

if(isset($_SESSION['usuario'])){
    header("Location: estudiante/dashboard.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>SkillCert</title>
</head>
<body>

    <h1>Bienvenido a SkillCert</h1>

    <a href="login.php">Iniciar Sesión</a>
    <br><br>
    <a href="registro.php">Registrarse</a>

</body>
</html>