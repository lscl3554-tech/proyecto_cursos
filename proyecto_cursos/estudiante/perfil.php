<?php
session_start();
include("../includes/conexion.php");

if(!isset($_SESSION['usuario'])){
    header("Location: ../login.php");
    exit();
}

$idusuario = $_SESSION['idusuario'];

$sql = "
SELECT *
FROM usuario
WHERE idusuario = $idusuario
";

$resultado = mysqli_query($conn, $sql);

$usuario = mysqli_fetch_assoc($resultado);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>

    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="sidebar">

    <h2>SkillCert</h2>

    <a href="dashboard.php">🏠 Dashboard</a>
    <a href="dashboard.php">📚 Cursos</a>
    <a href="perfil.php">👤 Perfil</a>
    <a href="../logout.php">🚪 Cerrar sesión</a>

</div>

<div class="main">

    <div class="card">

        <h1>Mi Perfil</h1>

        <br>

        <p>
            <strong>Nombre:</strong>
            <?php echo $usuario['nombre']; ?>
        </p>

        <br>

        <p>
            <strong>Correo:</strong>
            <?php echo $usuario['correo']; ?>
        </p>

        <br>

        <p>
            <strong>Rol:</strong>
            <?php echo $usuario['rol']; ?>
        </p>

        <br>

        <p>
            <strong>Fecha registro:</strong>
            <?php echo $usuario['fecha_registro']; ?>
        </p>

    </div>

</div>

</body>
</html>