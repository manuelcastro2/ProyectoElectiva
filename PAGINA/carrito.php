<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CARRITO</title>
</head>

<body>
    <div>
        <header>
            <span>LOGO</span>
            <nav>
                <a href="../index.php">INICIO</a>
                <a href="conocenos.php">CONOCENOS</a>
                <a href="serviciocliente.php">SERVICIO AL CLIENTE</a>
                <a href="productos.php">PRODUCTOS</a>
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
                    <details>
                        <summary>
                            <?php echo $usuario["usuario"]; ?>
                        </summary>
                        <a href="PAGINA/paginausuario.php?correo=<?php echo $usuario["correo"]; ?>">perfil</a>
                        <form acttion="#" method="post">
                            <button type="submit" name="cerrar" id="cerrar">CERRAR SESION</button>
                        </form>
                        <a href="ESTRUTURE/modificaciondatos.php?correo=<?php echo $usuario["correo"]; ?>">modificar
                            datos</a>
                    </details>
                    <?php
                } else {
                    ?>
                    <a href="../ESTRUTURE/inicio.php">INICIO SESION</a>
                    <?php
                }
                ?>
            </nav>
        </header>
        <main>
            <div>
                <?php
                if (isset($_SESSION['id_usuario'])) {
                $user = $usuario["correo"];
                $consulta = "SELECT * FROM compra,productos where id_usuario='$user'";
                $resultado = mysqli_query($conn, $consulta);
                while ($fila = mysqli_fetch_array($resultado)) {
                    echo $fila["id_producto"];
                    echo $fila["Nombre_prod"];
                }
            }
                ?>
            </div>
            <div>
                <div>
                    <div>
                        <p>metodos de pago</p>
                        <a href="">NEQUI</a>
                        <a href="">DAVIPLATA</a>
                        <a href="">BANCOLOMBIA</a>
                    </div>
                    <div>
                        <p>siguenos</p>
                        <a href="">FACEBOOK</a>
                        <a href="">INSTAGRAN</a>
                        <a href="">TWITTER</a>
                    </div>
                </div>
                <p>info@gmail.com</p>
                <p>estamos actualizando nuestros productos y ofreciendo productos para asegurar las necesidades de
                    nuestros clientes </p>
                <p>@2023 ELECTROSHOP</p>
            </div>
        </main>
    </div>

</body>

</html>