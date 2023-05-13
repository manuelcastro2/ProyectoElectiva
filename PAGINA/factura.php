<?php
include("../CONEXION/conexion.php");
session_start();
if (isset($_SESSION['id_usuario'])) {
    $id_usuario = $_SESSION["id_usuario"];

    $consulta = "SELECT * FROM clientes WHERE correo='$id_usuario'";
    $resultado = mysqli_query($conn, $consulta);

    if (mysqli_num_rows($resultado) == 1) {
        $usuario = mysqli_fetch_assoc($resultado);
    }

    if (isset($_POST["cerrar"])) {
        echo ' <script>alert("Cerro la sesion");</script>';
        session_destroy();
        die();
    }
}
$fecha_actual = date("d-m-Y h:i:s");
$consulta1 = "SELECT * FROM compra,productos 
                    where productos.id_producto=compra.id_produ 
                    and id_usuario='$id_usuario'";
$resultado1 = mysqli_query($conn, $consulta1);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>factura</title>
</head>

<body>

    <div class="caja-todo">
        <div>
            <div>
                <figure>logo</figure>
            </div>
            <div>
                <h1>FACTURA ELECTRONICA</h1>
                <h2>ELECTROCHOP</h2>
            </div>
        </div>
        <table border="1">
            <tr>
                <td>Nombre</td>
                <td>
                    <?php echo $usuario["usuario"] ?>
                </td>
                <td rowspan="3">fecha</td>
                <td rowspan="3">
                    <?php echo $fecha_actual; ?>
                </td>
            </tr>
            <tr>
                <td>Direcccion</td>
                <td>
                    <?php echo $usuario["direccion"] ?>
                </td>
            </tr>
            <tr>
                <td>telefomo</td>
                <td>
                    <?php echo $usuario["telefono"] ?>
                </td>
            </tr>
        </table>

        <table border="1">
            <thead>
                <td>cantidad</td>
                <td>tipo producto</td>
                <td>producto</td>
                <td>valor unitario</td>
                <td>total</td>
            </thead>
            <tbody>
                <?php
                while ($fila = mysqli_fetch_array($resultado1)) {
                    if (isset($_POST[$fila["id_produ"]])) {
                        ?>
                        <tr>
                            <td>
                                <?php echo $fila["canti"]; ?>
                            </td>
                        </tr> 
                        <?php
                    } else {
                        echo 'error';
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    </div>

</body>

</html>