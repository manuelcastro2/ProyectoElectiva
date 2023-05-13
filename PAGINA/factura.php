<?php
require '../vendor/autoload.php';
include("../CONEXION/conexion.php");
session_start();
if (isset($_SESSION['id_usuario'])) {
    $id_usuario = $_SESSION["id_usuario"];

    $consulta = "SELECT * FROM clientes WHERE correo='$id_usuario'";
    $resultado = mysqli_query($conn, $consulta);

    if (mysqli_num_rows($resultado) == 1) {
        $usuario = mysqli_fetch_assoc($resultado);
    }

}
$fecha_actual = date("d-m-Y h:i:s");
$consulta1 = "SELECT * FROM compra,productos 
                    where productos.id_producto=compra.id_produ 
                    and id_usuario='$id_usuario'";
$resultado1 = mysqli_query($conn, $consulta1);
$tot = 0;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/factura.css">
    <title>factura</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            border: none;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #e3e3e3;
        }

        .caja-todo {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            height: 100%;
        }

        header {
            position: relative;
            display: flex;
            width: 100%;
            height: 150px;
            justify-content: center;
            align-items: center;
        }

        header>figure {
            background-image: url(../IMG/logo-removebg-preview2.png);
            background-repeat: no-repeat;
            background-size: cover;
            width: 170px;
            height: 100px;
            position: relative;
            right: 300px;
            top: -5px;
        }

        .titulo {
            display: flex;
            flex-direction: column;
            position: relative;
            right: 90px;
            align-items: center;
        }

        table {
            width: 90%;
            border: 1px solid black;
            border-radius: 10px;
            text-transform: uppercase;
        }

        .head {
            border-radius: 10px 0 0 10px;
            text-align: right;
            width: 150px;
            background: rgb(191, 191, 191);
        }

        .telefono {
            height: 50px;
        }

        .datos {
            height: 10px;
        }

        .muestredatos {
            width: 700px;
            border: 1px solid;
            padding: 3px;
        }

        .fecha {
            text-align: center;
            width: 80px;
            background: rgb(191, 191, 191);
        }

        .muestrefecha {
            border: 1px solid;
            border-radius: 0 10px 10px 0;
        }

        .productos {
            margin-top: 50px;
            height: auto;
        }

        .title-productos {
            text-align: center;
            background: rgb(191, 191, 191);
            border: 1px solid;
        }

        .border-title2 {
            border-radius: 0px 10px 0 0;
        }

        .border-title1 {
            border-radius: 10px 0 0 0;
        }

        .cuerpo {
            text-align: center;
        }

        .caja {
            margin-top: 50px;
            width: 90%;
            height: 80px;
            display: flex;
            align-items: center;
        }

        .metodo {
            border-radius: 10px 0 0 10px;
            border: 1px solid;
            width: 70%;
            height: 100%;
            display: flex;
        }

        .metodo-negrita {
            border-radius: 10px 0 0 10px;
            background: rgb(191, 191, 191);
            width: 40%;
            padding: 25px 30px;
            font-size: 25px;
            font-weight: 800;
            text-transform: uppercase;
        }

        .metodo-mensaje {
            width: 30%;
            padding: 35px 30px;
            font-size: 15px;
            text-transform: uppercase;
        }

        .valores {
            border-radius: 0 10px 10px 0;
            width: 30%;
            height: 100%;
            border: 1px solid;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            justify-content: space-around;
            padding-right: 10px;
        }

        .negrita-valores {
            font-size: 15px;
            font-weight: 700;
        }
    </style>
</head>

<body>

    <div class="caja-todo">
        <header>
            <figure></figure>
            <div class="titulo">
                <h1>FACTURA ELECTRONICA</h1>
                <h2>ELECTROCHOP</h2>
            </div>
        </header>
        <table border="1">
            <tr>
                <td class="head datos">Nombre</td>
                <td class="muestredatos">
                    <?php echo $usuario["usuario"] ?>
                </td>
                <td rowspan="3" class="fecha">fecha</td>
                <td rowspan="3" class="muestrefecha">
                    <?php echo $fecha_actual; ?>
                </td>
            </tr>
            <tr>
                <td class="head datos">Direcccion</td>
                <td class="muestredatos">
                    <?php echo $usuario["direccion"] ?>
                </td>
            </tr>
            <tr>
                <td class="head telefono">telefono</td>
                <td class="muestredatos">
                    <?php echo $usuario["telefono"] ?>
                </td>
            </tr>
        </table>

        <table class="productos">
            <thead class="title-productos">
                <td class="border-title1">cantidad</td>
                <td>tipo producto</td>
                <td>producto</td>
                <td>valor unitario</td>
                <td class="border-title2">total</td>
            </thead>
            <tbody class="cuerpo">
                <?php
                if (isset($_POST["factura"])) {
                    while ($fila = mysqli_fetch_array($resultado1)) {
                        if (isset($_POST[$fila["id_produ"]])) {
                            ?>
                            <tr>
                                <td class="cuerpo-elemento">
                                    <?php echo $fila["canti"]; ?>
                                </td>
                                <td class="cuerpo-elemento">
                                    <?php echo $fila["tipo_produc"]; ?>
                                </td>
                                <td class="cuerpo-elemento">
                                    <?php echo $fila["Nombre_prod"]; ?>
                                </td>
                                <td class="cuerpo-elemento">
                                    <?php
                                    $numeroFormateado = number_format($fila["precio"], 0);
                                    echo "$ ", strval($numeroFormateado);
                                    ?>
                                </td>
                                <td class="cuerpo-elemento">
                                    <?php
                                    $total = $fila["canti"] * $fila["precio"];
                                    $tot = $tot + $total;
                                    $numeroFormateado = number_format($total, 0);
                                    echo "$ ", strval($numeroFormateado);
                                    ?>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                }
                ?>
            </tbody>
        </table>
        <div class="caja">
            <div class="metodo">
                <p class="metodo-negrita">metodo de pago</p>
                <p class="metodo-mensaje">
                    <?php
                    if ($_POST["radio"] == "Nequi") {
                        echo $_POST["radio"];
                    } else if ($_POST["radio"] == "Daviplata") {
                        $_POST["radio"];
                    } else if ($_POST["radio"] == "Bancolombia") {
                        $_POST["radio"];
                    }
                    ?>
                </p>
            </div>
            <div class="valores">
                <?php
                $envio = 8000;
                $totalpagar = $tot + $envio;
                $numeroFormateado = number_format($tot, 0);
                $numeroFormateado2 = number_format($envio, 0);
                $numeroFormateado3 = number_format($totalpagar, 0);
                ?>
                <p>
                    <span class="negrita-valores">
                        <?php
                        echo "SUBTOTAL: ", "$ ";
                        ?>
                    </span>
                    <span>
                        <?php
                        echo strval($numeroFormateado);
                        ?>
                    </span>
                </p>
                <p>
                    <span class="negrita-valores">
                        <?php
                        echo "TOTAL ENVIO: $";
                        ?>
                    </span>
                    <span>
                        <?php
                        echo strval($numeroFormateado2);
                        ?>
                    </span>
                </p>
                <p>
                    <span class="negrita-valores">
                        <?php
                        echo "TOTAL: $";
                        ?>
                    </span>
                    <span>
                        <?php
                        echo strval($numeroFormateado3);
                        ?>
                    </span>
                </p>
            </div>
        </div>
    </div>

</body>

</html>