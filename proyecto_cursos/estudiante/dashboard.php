<?php
session_start();
include("../includes/conexion.php");

if(!isset($_SESSION['usuario'])){
    header("Location: ../login.php");
    exit();
}

$sql = "SELECT * FROM curso";
$resultado = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

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

    <h1>
        Bienvenido <?php echo $_SESSION['usuario']; ?>
    </h1>

    <div class="cards">

        <?php while($curso = mysqli_fetch_assoc($resultado)){ ?>

        <?php

        $idcurso = $curso['id_curso'];
        $idusuario = $_SESSION['idusuario'];

        $sqlProgreso = "
        SELECT AVG(porcentaje) AS progreso
        FROM progreso_usuario
        WHERE usuario_id = $idusuario
        AND curso_id = $idcurso
        ";

        $resultadoProgreso = mysqli_query($conn, $sqlProgreso);

        $progresoData = mysqli_fetch_assoc($resultadoProgreso);

        $progreso = round($progresoData['progreso']);

        if(!$progreso){
            $progreso = 0;
        }

        ?>

        <div class="card">

            <h3>
                <?php echo $curso['nombre']; ?>
            </h3>

            <p>
                <?php echo $curso['descripcion']; ?>
            </p>

            <p>
                Progreso:
                <strong><?php echo $progreso; ?>%</strong>
            </p>

            <div class="progress">

                <div class="progress-bar"
                     style="width: <?php echo $progreso; ?>%;">
                </div>

            </div>

            <a class="btn"
               href="curso.php?id=<?php echo $curso['id_curso']; ?>">

               Ver Curso

            </a>

        </div>

        <?php } ?>

    </div>

</div>

</body>
</html>