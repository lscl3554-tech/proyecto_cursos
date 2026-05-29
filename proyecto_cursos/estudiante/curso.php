<?php
session_start();
include("../includes/conexion.php");

if(!isset($_SESSION['usuario'])){
    header("Location: ../login.php");
    exit();
}

$idcurso = $_GET['id'];

$sqlCurso = "SELECT * FROM curso WHERE id_curso = $idcurso";
$resultadoCurso = mysqli_query($conn, $sqlCurso);
$curso = mysqli_fetch_assoc($resultadoCurso);

$sqlModulos = "SELECT * FROM modulo WHERE curso_id = $idcurso ORDER BY orden ASC";
$resultadoModulos = mysqli_query($conn, $sqlModulos);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $curso['nombre']; ?></title>

    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="navbar">
    <h2>SkillCert</h2>

    <a href="dashboard.php" style="color:white;">
        Volver
    </a>
</div>

<div class="container">

    <h1>
        <?php echo $curso['nombre']; ?>
    </h1>

    <p>
        <?php echo $curso['descripcion']; ?>
    </p>
    
    <h2>Módulos</h2>

    <div class="cards">

        <?php while($modulo = mysqli_fetch_assoc($resultadoModulos)){ ?>

            <div class="card">

                <h3>
                    <?php echo $modulo['nombre']; ?>
                </h3>

                <p>
                    <?php echo $modulo['descripcion']; ?>
                </p>
                <?php
                $idmodulo = $modulo['idmodulo'];
                $sqlActividades = "
                SELECT actividad.*
                FROM modulo_actividad
                INNER JOIN actividad
                ON modulo_actividad.actividad_id = actividad.idactividad
                WHERE modulo_actividad.modulo_id = $idmodulo
                ORDER BY modulo_actividad.orden ASC
                ";
                $resultadoActividades = mysqli_query($conn, $sqlActividades);
                while ($actividad = mysqli_fetch_assoc($resultadoActividades)) {
                ?>
    
                <a class="btn"
                     href="actividad.php?id=<?php echo $actividad['idactividad']; ?>">

                     <?php echo $actividad['titulo']; ?>
                </a>

                <br><br>
        
                <?php } ?>
                

            </div>

        <?php } ?>

    </div>

</div>

</body>
</html>