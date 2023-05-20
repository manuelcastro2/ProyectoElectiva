<!DOCTYPE html>
<html lang="es">

<head>
    <title></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../CSS/pagar.css" rel="stylesheet">
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
            <div class="volver">
                <a href="carrito.php">volver</a>
            </div>
            <form method="post">
                <div class="caja-datos">
                    <p class="direccion">
                        Direccion de entrega
                    </p>
                    <p>
                        <span class="nombreytelefono">
                            <?php echo $usuario["usuario"], " ", $usuario["telefono"] ?>
                        </span>
                        <?php echo " ", $usuario["direccion"]; ?>
                    </p>
                </div>
                <?php
                $tot = 0;
                $id_pagar;
                if (!isset($_POST["enviarpago"])) {
                    if (isset($_POST["pagar"])) {
                        ?>
                        <p class="select">
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
                                            <div class="title-card">
                                                <p class="title-single">
                                                    <?php
                                                    echo $fila["tipo_produc"];
                                                    ?>
                                                </p>
                                                <span class="title-single">precio unitarios</span>
                                                <span class="title-single">cantidad</span>
                                                <span class="title-single">subtotal del articulo</span>
                                            </div>
                                            <div class="conte">
                                                <p class="produ">
                                                    <?php
                                                    echo $fila["Nombre_prod"];
                                                    ?>
                                                </p>
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
                                    <?php
                                }
                            }
                        }
                    }
                    ?>
                    <div class="metodos-pago">
                        <p>metodos de pago</p>
                        <div class="radio-input">
                            <label for=""><input name="radio" type="radio" class="input" checked=""
                                    value="Nequi">Nequi</label>
                            <label for=""><input name="radio" type="radio" class="input" value="Daviplata">Daviplata</label>
                            <label for=""><input name="radio" type="radio" class="input"
                                    Value="Bancolombia">Bancolombia</label>
                        </div>
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
                    <div>
                        <button name="enviarpago" id="enviarpago" type="submit">PAGAR</button>
                    </div>
                    <?php
                }
                ?>
            </form>
            <?php
            if (isset($_POST["enviarpago"])) {
                ?>
                <div class="caja-mensaje">
                    <div class="mensaje">
                        <p>SE REALIZO EL PEDIDO CORRECTAMENTE</p>
                        <div>
                            <form method="post" action="factura.php">
                                <?php
                                $metodo=$_POST["radio"];
                                ?>
                                <input type="hidden" name="radio" value="<?php echo $metodo; ?>">
                                <?php
                                $consulta2 = "SELECT * FROM compra,productos 
                                where productos.id_producto=compra.id_produ 
                                and id_usuario='$id_usuario'";
                                $resultado2 = mysqli_query($conn, $consulta2);
                                while ($filo = mysqli_fetch_array($resultado2)) {
                                    if (isset($_POST[$filo["id_produ"]])) {
                                        switch ($filo["id_produ"]) {
                                            case $filo["id_produ"]:
                                                ?>
                                                <input type="text" name="<?php echo $filo["id_produ"]; ?>"
                                                    value="<?php echo $filo["id_produ"]; ?>" hidden>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                                <button type="submit" name="factura">FACTURA</button>
                            </form>
                        </div>
                        <div>
                            <form method="post">
                                <?php
                                while ($fila = mysqli_fetch_array($resultado1)) {
                                    if (isset($_POST[$fila["id_produ"]])) {
                                        switch ($fila["id_produ"]) {
                                            case $fila["id_produ"]:
                                                ?>
                                                <input type="text" name="<?php echo $fila["id_produ"]; ?>"
                                                    value="<?php echo $fila["id_produ"]; ?>" hidden>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                                <button type="submit" name="inter">Cerrar</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
            }
            if (isset($_POST["inter"])) {
                while ($fila = mysqli_fetch_array($resultado1)) {
                    if (isset($_POST[$fila["id_produ"]])) {
                        switch ($fila["id_produ"]) {
                            case $fila["id_produ"]:
                                $au = $fila["id_produ"];
                                $consulta = "DELETE from compra where id_usuario='$id_usuario' and id_produ='$au'";
                                $compra = mysqli_query($conn, $consulta);
                                if (mysqli_affected_rows($conn) > 0) {
                                    header('location: carrito.php');
                                } else {
                                    echo '<script>alert("error")</script>';
                                }
                        }
                    }
                }
            }
            ?>
        </main>
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