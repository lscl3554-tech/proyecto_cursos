<?php
session_start();

if(!isset($_SESSION['usuario'])){

    header("Location: ../login.php");
    exit();

}

if($_SESSION['rol'] != 'administrador'){

    echo "Acceso denegado";
    exit();

}
?>

<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin</title>

    <link rel="stylesheet" href="../assets/css/style.css">

</head>
<body>

<div class="sidebar">

    <h2>Admin Panel</h2>

    <a href="dashboard.php">🏠 Dashboard</a>
    <a href="crear_curso.php">📚 Crear Curso</a>
    <a href="crear_modulo.php">🧩 Crear Módulo</a>
    <a href="crear_actividad.php">🎥 Crear Actividad</a>
    <a href="../logout.php">🚪 Cerrar sesión</a>

</div>

<div class="main">

    <div class="card">

        <h1>
            Bienvenido Administrador
        </h1>

        <br>

        <p>
            Desde aquí podrás administrar la plataforma.
        </p>

    </div>

</div>

</body>
</html>