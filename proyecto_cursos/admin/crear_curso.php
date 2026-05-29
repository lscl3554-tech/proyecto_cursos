<?php
session_start();
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
    $nivel = $_POST['nivel'];

    $sql = "
    INSERT INTO curso(nombre, descripcion, nivel_id)
    VALUES('$nombre', '$descripcion', '$nivel')
    ";

    if(mysqli_query($conn, $sql)){

        $mensaje = "Curso creado correctamente";

    }else{

        $mensaje = "Error: " . mysqli_error($conn);

    }

}

$sqlNiveles = "SELECT * FROM nivel";
$resultadoNiveles = mysqli_query($conn, $sqlNiveles);
?>

<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Crear Curso</title>

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

        <h1>Crear Curso</h1>

        <br>

        <?php
        if(isset($mensaje)){
            echo "<p>$mensaje</p><br>";
        }
        ?>

        <form method="POST">

            <input type="text"
                   name="nombre"
                   placeholder="Nombre del curso"
                   required>

            <br><br>

            <textarea name="descripcion"
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

            <select name="nivel"
                    required
                    style="
                    width:100%;
                    padding:10px;
                    border-radius:5px;
                    ">

                <option value="">
                    Seleccione nivel
                </option>

                <?php while($nivel = mysqli_fetch_assoc($resultadoNiveles)){ ?>

                    <option value="<?php echo $nivel['idnivel']; ?>">

                        <?php echo $nivel['nombre']; ?>

                    </option>

                <?php } ?>

            </select>

            <br><br>

            <button class="btn"
                    type="submit"
                    name="crear">

                Crear Curso

            </button>

        </form>

    </div>

</div>

</body>
</html>