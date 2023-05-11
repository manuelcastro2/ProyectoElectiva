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
                    ?>
                </nav>
            </div>
        </header>
        <?php
        if (isset($_POST["btnpagar"])) {
            $consulta1 = "SELECT * FROM compra";
            $resultado1 = mysqli_query($conn, $consulta1);
            ?>
            <p>
                <?php
                echo $usuario["usuario"]," ",$usuario["direccion"]
                ?>
            </p>
            <p>
                productos seleccionados
            </p>
            <?php
            while ($fila = mysqli_fetch_array($resultado1)) {
                switch ($fila["id_produ"]) {
                    case $_POST[$fila["id_produ"]]:
                        echo $_POST[$fila["id_produ"]];
                }
            }
        }
        ?>
    </div>
</body>

</html>