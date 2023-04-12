<?php
include("../CONEXION/conexion.php");

session_start();
$id_usuario = $_SESSION["id_usuario"];

$consulta = "SELECT * FROM clientes WHERE correo='$id_usuario'";
$resultado = mysqli_query($conn, $consulta);

if (mysqli_num_rows($resultado) == 1) {
    $usuario = mysqli_fetch_assoc($resultado);
}

if (isset($_POST["cerrar"])) {
    ?>
    <script>
        alert("Cerro la sesion")
        window.location.href = "../index.php";
    </script>
    <?php
    session_destroy();
    die();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>USUARIO</title>
</head>

<body>
    <header>
        <a href="../index.php">logo</a>
        <form acttion="" method="post">
            <button type="submit" name="cerrar" id="cerrar">CERRAR SESION</button>
        </form>
    </header>
    <p>
        <?php echo $usuario["usuario"]; ?>
    </p>
    <p>
        <?php echo $usuario["correo"]; ?>
    </p>
    <p>
        <?php echo $usuario["direccion"]; ?>
    </p>
    <p>
        <?php echo $usuario["telefono"]; ?>
    </p>
    <p>
        <?php echo $usuario["password"]; ?>
    </p>
    <a href="../ESTRUTURE/modificaciondatos.php?correo=<?php echo $usuario["correo"]; ?>">modificar
        datos</a>
</body>

</html>