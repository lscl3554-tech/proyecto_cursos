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

    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $curso_id = $_POST['curso_id'];
    $orden = $_POST['orden'];

    $sql = "
    INSERT INTO modulo(nombre, descripcion, curso_id, orden)
    VALUES('$nombre', '$descripcion', '$curso_id', '$orden')
    ";

    if(mysqli_query($conn, $sql)){

        $mensaje = "Módulo creado correctamente";

    }else{

        $mensaje = "Error: " . mysqli_error($conn);

    }

}

$sqlCursos = "SELECT * FROM curso";
$resultadoCursos = mysqli_query($conn, $sqlCursos);

?>

<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Crear Módulo</title>

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

        <h1>Crear Módulo</h1>

        <br>

        <?php
        if(isset($mensaje)){
            echo "<p>$mensaje</p><br>";
        }
        ?>

        <form method="POST">

            <input type="text"
                   name="nombre"
                   placeholder="Nombre del módulo"
                   required>

            <br><br>

            <textarea
                name="descripcion"
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

            <select name="curso_id"
                    required
                    style="
                    width:100%;
                    padding:10px;
                    border-radius:5px;
                    ">

                <option value="">
                    Seleccione curso
                </option>

                <?php while($curso = mysqli_fetch_assoc($resultadoCursos)){ ?>

                    <option value="<?php echo $curso['id_curso']; ?>">

                        <?php echo $curso['nombre']; ?>

                    </option>

                <?php } ?>

            </select>

            <br><br>

            <input type="number"
                   name="orden"
                   placeholder="Orden del módulo"
                   required>

            <br><br>

            <button class="btn"
                    type="submit"
                    name="crear">

                Crear Módulo

            </button>

        </form>

    </div>

</div>

</body>
</html>