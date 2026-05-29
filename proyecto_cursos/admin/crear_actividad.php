<?php

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

include("../includes/conexion.php");

if(!isset($_SESSION['usuario'])){

    header("Location: ../login.php");
    exit();

}

if($_SESSION['rol'] != 'administrador'){

    echo "Acceso denegado";
    exit();

}

if(isset($_POST['crear'])){

    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];
    $modulo_id = $_POST['modulo_id'];
    $orden = $_POST['orden'];

    $video = $_FILES['video']['name'];

    $rutaTemporal = $_FILES['video']['tmp_name'];

    $rutaDestino = "../assets/uploads/" . $video;

    move_uploaded_file($rutaTemporal, $rutaDestino);

    $urlVideo = "/proyecto_cursos/assets/uploads/" . $video;

    $sqlActividad = "
    INSERT INTO actividad
    (titulo, tipo, contenido, url)
    VALUES
    ('$titulo', 'video', '$contenido', '$urlVideo')
    ";

    if(mysqli_query($conn, $sqlActividad)){

        $actividad_id = mysqli_insert_id($conn);

        $sqlRelacion = "
        INSERT INTO modulo_actividad
        (modulo_id, actividad_id, orden)
        VALUES
        ('$modulo_id', '$actividad_id', '$orden')
        ";

        mysqli_query($conn, $sqlRelacion);

        $mensaje = "Actividad creada correctamente";

    }else{

        $mensaje = "Error: " . mysqli_error($conn);

    }

}

$sqlModulos = "
SELECT modulo.*, curso.nombre AS curso_nombre
FROM modulo
INNER JOIN curso
ON modulo.curso_id = curso.id_curso
ORDER BY curso.nombre ASC
";

$resultadoModulos = mysqli_query($conn, $sqlModulos);

?>

<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Crear Actividad</title>

    <link rel="stylesheet"
          href="../assets/css/style.css">

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

        <h1>Crear Actividad</h1>

        <br>

        <?php
        if(isset($mensaje)){
            echo "<p>$mensaje</p><br>";
        }
        ?>

        <form method="POST"
              enctype="multipart/form-data">

            <input type="text"
                   name="titulo"
                   placeholder="Título actividad"
                   required>

            <br><br>

            <textarea
                name="contenido"
                placeholder="Descripción"
                rows="5"
                style="
                width:100%;
                padding:10px;
                border-radius:5px;
                border:1px solid #ccc;
                ">
            </textarea>

            <br><br>

            <select name="modulo_id"
                    required
                    style="
                    width:100%;
                    padding:10px;
                    border-radius:5px;
                    ">

                <option value="">
                    Seleccione módulo
                </option>

                <?php while($modulo = mysqli_fetch_assoc($resultadoModulos)){ ?>

                    <option value="<?php echo $modulo['idmodulo']; ?>">

                        <?php echo $modulo['curso_nombre']; ?>
                        -
                        <?php echo $modulo['nombre']; ?>

                    </option>

                <?php } ?>

            </select>

            <br><br>

            <input type="number"
                   name="orden"
                   placeholder="Orden actividad"
                   required>

            <br><br>

            <input type="file"
                   name="video"
                   accept="video/mp4"
                   required>

            <br><br>

            <button class="btn"
                    type="submit"
                    name="crear">

                Crear Actividad

            </button>

        </form>

    </div>

</div>

</body>
</html>