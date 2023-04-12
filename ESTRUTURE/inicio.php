<?php
session_start();
include("../CONEXION/conexion.php");

if (isset($_POST["btniniciar"])) {
    $email = mysqli_real_escape_string($conn, $_POST["correo"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    $consulta = "SELECT * FROM clientes WHERE correo='$email' AND password='$password'";
    $resultado = mysqli_query($conn, $consulta);

    if (mysqli_num_rows($resultado) > 0) {
        $usuario = mysqli_fetch_assoc($resultado);
        $_SESSION["id_usuario"] = $usuario["correo"];
        $_SESSION["nombre_usuario"] = $usuario["usuario"];
        header("Location: ../index.php"); // redireccionar a la página principal
        exit();
    } else {
        $mensaje = "Correo o contraseña incorrectos";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/inicio.css">
    <title>INICIAR SESION</title>
</head>

<body>
    <div class="caja-volver">
    <form action="../index.php" method="post">
        <button type="submit">volver</button>
    </form>
    </div>
    <div class="caja-todo">
        <div class="caja-intermedia">
            <h1>Iniciar sesión</h1>
            <?php if (isset($mensaje)) {
                echo "<p>$mensaje</p>";
            } ?>
            <form method="POST">
                <div class="caja-contenido">
                    <div class="user-box">
                        <input type="text" name="correo" required="">
                        <label>Correo electrónico</label>
                    </div>
                    <div class="user-box">
                        <input type="password" name="password" required="">
                        <label>Contraseña</label>
                    </div>
                    <button type="submit" name="btniniciar">Iniciar sesión</button>
                </div>
            </form>
            <form action="Registrar.php" method="post">
            <div class="caja-register">
            <p>¿no tienes cuenta?</p>
            <button type="submit">
                REGISTRAR 
            </button>
            </div>
        </form>
        </div>
    </div>
</body>

</html>