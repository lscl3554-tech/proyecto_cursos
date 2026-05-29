<?php
session_start();
include("../includes/conexion.php");

if(!isset($_SESSION['usuario'])){
    header("Location: ../login.php");
    exit();
}

$idActividad = $_GET['id'];

$sql = "SELECT * FROM actividad WHERE idactividad = $idActividad";
$resultado = mysqli_query($conn, $sql);

$actividad = mysqli_fetch_assoc($resultado);
$usuario_id = $_SESSION['idusuario'];

$sqlEstado = "
SELECT *
FROM progreso_usuario
WHERE usuario_id = $usuario_id
";

$resultadoEstado = mysqli_query($conn, $sqlEstado);

$completado = false;

while($fila = mysqli_fetch_assoc($resultadoEstado)){

    if($fila['modulo_id']){
        $completado = true;
    }
}

if(isset($_POST['completar'])){

    $usuario_id = $_SESSION['idusuario'];

    $sqlModulo = "
    SELECT modulo_id
    FROM modulo_actividad
    WHERE actividad_id = $idActividad
    LIMIT 1
    ";

    $resultadoModulo = mysqli_query($conn, $sqlModulo);

    $moduloData = mysqli_fetch_assoc($resultadoModulo);

    $modulo_id = $moduloData['modulo_id'];

    $sqlCurso = "
    SELECT curso_id
    FROM modulo
    WHERE idmodulo = $modulo_id
    ";

    $resultadoCurso = mysqli_query($conn, $sqlCurso);

    $cursoData = mysqli_fetch_assoc($resultadoCurso);

    $curso_id = $cursoData['curso_id'];

    $sqlVerificar = "
    SELECT *
    FROM progreso_usuario
    WHERE usuario_id = $usuario_id
    AND modulo_id = $modulo_id
    ";

    $resultadoVerificar = mysqli_query($conn, $sqlVerificar);

    if(mysqli_num_rows($resultadoVerificar) == 0){

        $sqlInsertar = "
        INSERT INTO progreso_usuario
        (usuario_id, curso_id, modulo_id, porcentaje, completado)
        VALUES
        ($usuario_id, $curso_id, $modulo_id, 100, 1)
        ";

        mysqli_query($conn, $sqlInsertar);

        echo "<script>alert('Módulo completado');</script>";

    }else{

        echo "<script>alert('Ya completaste este módulo');</script>";

    }

    if(mysqli_query($conn, $sqlInsertar)){

        echo "<script>alert('Módulo completado');</script>";

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
    <title><?php echo $actividad['titulo']; ?></title>

    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="sidebar">
    <h2>SkillCert</h2>

    <a href="javascript:history.back()" style="color:white;">
        Volver
    </a>
</div>

<div class="container">

    <div class="main">

    <div class="card">

        <h1>
            <?php echo $actividad['titulo']; ?>
        </h1>

        <p>
            <?php echo $actividad['contenido']; ?>
        </p>

        <?php if($actividad['tipo'] == 'video'){ ?>

            <div class="video-container">

                <video controls class="video-player">

                    <source src="<?php echo $actividad['url']; ?>"
                        type="video/mp4">

                </video>

            </div>

                <source src="<?php echo $actividad['url']; ?>"
                        type="video/mp4">

            </video>

        <?php } ?>

        <br><br>

        <?php if($completado){ ?>

            <p style="
                color:green;
                font-weight:bold;
            ">
                ✅ Módulo completado
            </p>

        <?php }else{ ?>

            <form method="POST">

                <button class="btn" name="completar">
                    Marcar como completado
                </button>

            </form>

        <?php } ?>

    </div>

</div>

</div>

</body>
</html>