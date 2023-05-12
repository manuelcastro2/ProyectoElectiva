<!DOCTYPE html>
<html lang="es">

<head>
    <title></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style.css" rel="../CSS/pagar.css">
</head>

<body>
    <div class="caja-todo">
        <header>
            <div class="encabezado">
                <span>
                </span>
                <nav>
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
                        ?>
                        <details class="menu">
                            <summary>
                                <?php echo $usuario["usuario"]; ?>
                            </summary>
                            <a href="paginausuario.php?correo=<?php echo $usuario["correo"]; ?>">perfil</a>
                            <form method="post">
                                <button type="submit" name="cerrar" id="cerrar">CERRAR SESION</button>
                            </form>
                        </details>
                        <?php
                    } else {
                        ?>
                        <a class="button" href="../ESTRUTURE/inicio.php">INICIO SESION</a>
                        <?php
                    }
                    $consulta1 = "SELECT * FROM compra,productos 
                    where productos.id_producto=compra.id_produ 
                    and id_usuario='$id_usuario'";
                    $resultado1 = mysqli_query($conn, $consulta1);
                    ?>
                </nav>
            </div>
        </header>
        <main>
            <form method="post">
                <?php
                $tot = 0;
                $id_pagar;
                if (isset($_POST["btnpagar"])) {
                    ?>
                    <div>
                        <p>
                            Direccion de entrega
                        </p>
                        <p>
                            <?php
                            echo $usuario["usuario"], " ", $usuario["telefono"], " ", $usuario["direccion"];
                            ?>
                        </p>
                    </div>
                    <p>
                        productos seleccionados
                    </p>
                    <?php
                    while ($fila = mysqli_fetch_array($resultado1)) {
                        if (isset($_POST[$fila["id_produ"]])) {
                            switch ($fila["id_produ"]) {
                                case $_POST[$fila["id_produ"]]:
                                    ?>
                                    <input type="hidden" name="<?php echo $fila["id_produ"]; ?>" value="<?php echo $fila["id_produ"]; ?>">
                                    <div class="card">
                                        <p>
                                            <?php
                                            echo $fila["tipo_produc"];
                                            ?>
                                        </p>
                                        <span>precio unitario</span>
                                        <span>cantidad</span>
                                        <span>subtotal del articulo</span>
                                        <div>
                                            <p class="produ">
                                                <?php
                                                echo $fila["Nombre_prod"];
                                                ?>
                                            </p>
                                            <div class="conte">
                                                <p class=produ2>
                                                    <?php
                                                    $numeroFormateado = number_format($fila["precio"], 0);
                                                    echo "$ ", strval($numeroFormateado);
                                                    ?>
                                                </p>
                                                <p class=produ2>
                                                    <?php
                                                    echo $fila["canti"];
                                                    ?>
                                                </p>
                                                <p class=produ2>
                                                    <?php
                                                    $total = $fila["canti"] * $fila["precio"];
                                                    $tot = $tot + $total;
                                                    $numeroFormateado = number_format($total, 0);
                                                    echo "$ ", strval($numeroFormateado);
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                            }
                        }
                    }
                }
                ?>
                <div>
                    <p>metodos de pago</p>
                    <div>
                        <label for="nequi"><input type="radio" id="nequi" name="pago" value="nequi"
                                checked>Nequi</label>
                        <label for="daviplata"><input type="radio" id="daviplata" name="pago"
                                value="daviplata">Daviplata</label>
                        <label for="bancolombia"><input type="radio" id="bancolombia" name="pago"
                                value="bancolombia">Bancolombia</label>
                    </div>
                </div>
                <div>
                    <?php
                    $envio = 8000;
                    $totalpagar = $tot + $envio;
                    $numeroFormateado = number_format($tot, 0);
                    $numeroFormateado2 = number_format($envio, 0);
                    $numeroFormateado3 = number_format($totalpagar, 0);
                    ?>
                    <p>
                        <span>
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
                        <span>
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
                        <span>
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
                <div>
                    <button name="enviarpago" id="enviarpago" type="submit">PAGAR</button>
                </div>
            </form>
            <?php
            if (isset($_POST["enviarpago"])) {
                while ($fila = mysqli_fetch_array($resultado1)) {
                    if (isset($_POST[$fila["id_produ"]])) {
                        switch ($fila["id_produ"]) {
                            case $fila["id_produ"]:
                                $au = $fila["id_produ"];
                                $consulta = "DELETE from compra where id_usuario='$id_usuario' and id_produ='$au'";
                                $compra = mysqli_query($conn, $consulta);
                                if (mysqli_affected_rows($conn) > 0) {
                                    ?>
                                    <div class="caja-mensaje">
                                        <div class="mensaje">
                                            <p>SE REALIZO EL PEDIDO CORRECTAMENTE</p>
                                            <a href="carrito.php">Cerrar</a>
                                            <a href="#">factura</a>
                                        </div>
                                    </div>
                                    <?php
                                } else {
                                    echo "<script>alert('error')</script>";
                                }
                                break;
                        }
                    }
                }
            }
            ?>
        </main>
    </div>
</body>

</html>