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
                <span></span>
                <nav>
                    <a class="navegador item tres" href="../index.php">INICIO</a>
                    <a class="navegador item tres" href="conocenos.php">CONOCENOS</a>
                    <a class="navegador item tres" href="serviciocliente.php">SERVICIO AL CLIENTE</a>
                    <a class="navegador item tres" href="productos.php">PRODUCTOS</a>
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

                    ?>
                </nav>
            </div>
            <div class="footer">
                <input type="search" name="buscador" id="buscador">
                <a href="">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                        <path
                            d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z" />
                    </svg>
                    <?php
                    if (isset($_SESSION['id_usuario'])) {
                        $user = $usuario["correo"];
                        $consulta = "SELECT DISTINCT * FROM compra WHERE id_usuario='$user'";
                        $resultado = mysqli_query($conn, $consulta);
                        $num = 0;
                        while ($fila = mysqli_fetch_assoc($resultado)) {
                            $num++;
                        }
                        echo $num;
                    }
                    ?>
                </a>
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
                                <p>
                                    <?php
                                    echo $fila["Nombre_prod"];
                                    ?>
                                </p>
                                <div class="conte">
                                    <p>
                                        <?php
                                        $numeroFormateado = number_format($fila["precio"], 0);
                                        echo "$ ", strval($numeroFormateado);
                                        ?>
                                    </p>
                                    <p>
                                        <?php
                                        echo $fila["canti"];
                                        ?>
                                    </p>
                                    <p>
                                        <?php
                                        $total = $fila["canti"] * $fila["precio"];
                                        $numeroFormateado = number_format($total, 0);
                                        echo "$ ", strval($numeroFormateado);
                                        ?>
                                    </p>
                                    <p>
                                        <a class="cambio" href="carrito.php?aumento=<?php echo $fila["id_producto"]; ?>">+</a>
                                        <a class="cambio" href="carrito.php?disminuir=<?php echo $fila["id_producto"] ?>">-</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <h1>inicie sesion para ver los productos en el carrito</h1>
                    <?php
                }
                ?>
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
                                <a class="face" href=""> <i class="fa-brands fa-facebook fa"></i></a>
                            </div>
                            <div class="caja-iconos">
                                <a class="insta" href=""><i class="fa-brands fa-instagram fa"></i></a>

                            </div>
                            <div class="caja-iconos">
                                <a class="twi" href=""><i class="fa-brands fa-twitter fa"></i></a>

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
    </div>
</body>

</html>