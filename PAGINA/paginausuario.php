<?php
include("../CONEXION/conexion.php");

session_start();
$id_usuario = $_SESSION["id_usuario"];

$consulta = "SELECT * FROM clientes WHERE correo='$id_usuario'";
$resultado = mysqli_query($conn, $consulta);

if (mysqli_num_rows($resultado) == 1) {
    $usuario = mysqli_fetch_assoc($resultado);
}


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/perfil.css">
    <title>USUARIO</title>
</head>

<body>
    <div class="caja-todo">
        <header>
            <a href="../index.php"></a>
            <form acttion="" method="post">
                <button type="submit" name="cerrar" id="cerrar">CERRAR SESION</button>
            </form>
        </header>
        <div class="contenido">
            <h1>MIS DATOS</h1>
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
                <?php echo"CEL:", $usuario["telefono"]; ?>
            </p>
            <p>
                <?php echo"PASSWORD:", $usuario["password"]; ?>
            </p>
            <a href="../ESTRUTURE/modificaciondatos.php?correo=<?php echo $usuario["correo"]; ?>">modificar datos</a>
        </div>
        <?php
        if (isset($_POST["cerrar"])) {
            ?>
            <div class="caja-mensaje">
                <div class="mensaje">
                    <p>SE CERRO CORRECTAMENTE LA SESION</p>
                    <a href="../index.php">Cerrar</a>
                </div>
            </div>
            <?php
            session_destroy();
            die();
        }
        ?>
    </div>
</body>

</html>