<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="../CSS/carrito.css">
    <title>CARRITO</title>
</head>

<body>
    <div class="caja-todo">
        <header>
            <div class="encabezado">
                <a href="productos.php">
                    <span></span>
                </a>
                <nav>
                    <div class="footer">
                        <input type="search" name="buscador" id="buscador">
                    </div>
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

                    ?>
                </nav>
            </div>

        </header>
        <main>
            <div class="contenido">
                <section>
                    <div class="producto">Producto</div>
                    <div class="producto-categoria">
                        <p>precio unitario</p>
                        <p>Cantidad</p>
                        <p>Precio total</p>
                        <p>Acciones</p>
                    </div>
                </section>
                <form method="post">
                    <?php
                    if (isset($_SESSION['id_usuario'])) {
                        $user = $usuario["correo"];
                        $consulta = "SELECT DISTINCT *
                    FROM productos,compra
                    where productos.id_producto=compra.id_produ
                    and id_usuario='$user'";
                        $resultado = mysqli_query($conn, $consulta);
                        while ($fila = mysqli_fetch_array($resultado)) {
                            ?>
                            <div class="card">
                                <p>
                                    <?php
                                    echo $fila["tipo_produc"];
                                    ?>
                                </p>
                                <div>
                                    <p class="produ">
                                        <label class="checkbox-btn">
                                            <label for="checkbox"></label>
                                            <input type="checkbox" class="vali" name="<?php echo $fila["id_producto"]; ?>"
                                                value="<?php echo $fila["id_producto"]; ?>">
                                            <span class="checkmark"></span>
                                        </label>
                                        <span>
                                            <?php
                                            echo $fila["Nombre_prod"];
                                            ?>
                                        </span>
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
                                            $numeroFormateado = number_format($total, 0);
                                            echo "$ ", strval($numeroFormateado);
                                            ?>
                                        </p>
                                        <p class=produ2>
                                            <a class="cambio"
                                                href="carrito.php?aumento=<?php echo $fila["id_producto"]; ?>">+</a>
                                            <a class="cambio"
                                                href="carrito.php?disminuir=<?php echo $fila["id_producto"] ?>">-</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="caja-pagar">
                            <button type="submit" name="btnpagar" id="btnpagar">SELECCIONAR Y PAGAR</button>
                        </div>
                        <?php
                    } else {
                        ?>
                        <h1>inicie sesion para ver los productos en el carrito</h1>
                        <?php
                    }
                    ?>
                </form>
            </div>
            <div class="pie-pagina">
                <div class="caja-enlace">
                    <div class="caja-pagos">
                        <p>metodos de pago</p>
                        <div class="enlace">
                            <div class="caja-ico">
                                <a class="nequi" href=""><i class="fa">NEQUI</i></a>
                            </div>
                            <div class="caja-ico">
                                <a class="daviplata" href=""><i class="fa">DAVIPLATA</i></a>
                            </div>
                            <div class="caja-ico">
                                <a class="banco" href=""><i class="fa">BANCOLOMBIA</i></a>
                            </div>
                        </div>
                    </div>
                    <div class="caja-redes">
                        <p>siguenos</p>
                        <div class="enlace">
                            <div class="caja-iconos">
                                <a target="_blank" href="https://www.facebook.com/profile.php?id=100092195987451&mibextid=ZbWKwL" class="face" href=""> <i class="fa-brands fa-facebook fa"></i></a>
                            </div>
                            <div class="caja-iconos">
                                <a target="_blank" class="insta" href="https://instagram.com/electro_shop3423?igshid=NGExMmI2YTkyZg=="><i class="fa-brands fa-instagram fa"></i></a>

                            </div>
                            <div class="caja-iconos">
                                <a target="_blank" href="https://wa.me/message/2C3ZVKY2CN4BE1" class="twi" href=""><i class="fa-brands fa-whatsapp fa"></i></a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="caja-info">
                    <p>info@gmail.com</p>
                    <p>estamos actualizando nuestros productos y ofreciendo productos para asegurar las necesidades de
                        nuestros clientes </p>
                    <p>@2023 ELECTROSHOP</p>
                </div>
            </div>
        </main>
        <?php
        if (isset($_GET["aumento"])) {
            $user = $usuario["correo"];
            $au = $_GET["aumento"];
            $consulta = "SELECT * FROM compra,productos where productos.id_producto=compra.id_produ
        and id_usuario='$user' and id_produ='$au'";
            $resultado = mysqli_query($conn, $consulta);
            $filo = mysqli_num_rows($resultado);
            if ($filo > 0) {
                while ($fila = mysqli_fetch_array($resultado)) {
                    $aumento = 1 + $fila["canti"];
                    if (intval($fila["cantidad"]) >= $aumento) {
                        $consulta = "UPDATE compra
                    SET canti='$aumento' where id_usuario='$user' and id_produ='$au'";
                        $compra = mysqli_query($conn, $consulta);
                        if (mysqli_affected_rows($conn) > 0) {
                            ?>
                            <div class="caja-mensaje">
                                <div class="mensaje">
                                    <p>se aumento</p>
                                    <a href="carrito.php">Cerrar</a>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        ?>
                        <div class="caja-mensaje">
                            <div class="mensaje">
                                <p>no se puede aumentar mas</p>
                                <a href="carrito.php">Cerrar</a>
                            </div>
                        </div>
                        <?php
                    }
                }
            } else {
                echo '<script>alert("error")</script>';
            }
        } else if (isset($_GET["disminuir"])) {
            $user = $usuario["correo"];
            $au = $_GET["disminuir"];
            $consulta = "SELECT * FROM compra,productos where productos.id_producto=compra.id_produ
        and id_usuario='$user' and id_produ='$au'";
            $resultado = mysqli_query($conn, $consulta);
            $filo = mysqli_num_rows($resultado);
            if ($filo > 0) {
                while ($fila = mysqli_fetch_array($resultado)) {
                    $aumento = -1 + $fila["canti"];
                    if ($aumento > 0) {
                        $consulta = "UPDATE compra
                    SET canti='$aumento' where id_usuario='$user' and id_produ='$au'";
                        $compra = mysqli_query($conn, $consulta);
                        if (mysqli_affected_rows($conn) > 0) {
                            ?>
                                <div class="caja-mensaje">
                                    <div class="mensaje">
                                        <p>se disminuyo</p>
                                        <a href="carrito.php">Cerrar</a>
                                    </div>
                                </div>
                            <?php
                        }
                    } else {
                        $consulta = "DELETE from compra where id_usuario='$user' and id_produ='$au'";
                        $compra = mysqli_query($conn, $consulta);
                        if (mysqli_affected_rows($conn) > 0) {
                            ?>
                                <div class="caja-mensaje">
                                    <div class="mensaje">
                                        <p>se quito producto</p>
                                        <a href="carrito.php">Cerrar</a>
                                    </div>
                                </div>
                            <?php
                        }
                    }
                }
            } else {
                echo '<script>alert("error")</script>';
            }
        }
        ?>
        <?php
        if (isset($_POST["btnpagar"])) {
            ?>
            <?php
            $cont = 0;
            $user = $usuario["correo"];
            $consulta = "SELECT DISTINCT *
                            FROM productos,compra
                            where productos.id_producto=compra.id_produ
                            and id_usuario='$user'";
            $resultado = mysqli_query($conn, $consulta);
            ?>
            <div class="caja-mensaje">
                <div class="mensaje">
                    <form class="cartel" method="post" action="pagar.php">

                        <?php
                        while ($fila = mysqli_fetch_array($resultado)) {
                            if (isset($_POST[$fila["id_produ"]])) {
                                $cont++;
                                ?>
                                <input type="hidden" name="<?php echo $fila["id_producto"]; ?>"
                                    value="<?php echo $fila["id_producto"]; ?>">
                                <?php
                            }
                        }
                        if ($cont > 0) {
                            ?>
                            <p>
                                <?php
                                echo "SELECCIONO ", $cont, " PRODUCTOS";
                                ?>
                            </p>
                            <br>
                            <button name="pagar" type="submit">CONTINUAR</button>
                            <?php
                        } else {
                            ?>
                            <p>
                                <?php
                                echo "NO SELECCIONO PRODUCTOS";
                                ?>
                            </p>
                            <br><a href="carrito.php">CERRAR</a>
                            <?php
                        }
                        ?>
                    </form>
                </div>
            </div>
            <?php
        }
        ?>
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