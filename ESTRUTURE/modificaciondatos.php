<?php
session_start();
include("../CONEXION/conexion.php");
$id_usuario = $_GET["correo"];
$consulta = "SELECT * FROM clientes WHERE correo='$id_usuario'";
$resultado = mysqli_query($conn, $consulta);
$fila = mysqli_fetch_assoc($resultado);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/actualizar.css">
    <title>ACTUALIZAR DATOS</title>
</head>

<body>
    <div class="caja-todo">
        <header>
            <span></span>
            <form acttion="" method="post">
                <button type="submit" name="cerrar" id="cerrar">CERRAR SESION</button>
            </form>
        </header>
        <div class="contenido">
            <a href="../PAGINA/paginausuario.php?=<?php echo $id_usuario ?>">VOLVER</a>
            <h1>ACTUALIZAR DATOS</h1>
            <form method="post">
                <div class="user-box">
                    <input type="text" id="usuario" name="usuario" required="" value="<?php echo $fila['usuario']; ?>">
                    <label for="usuario">usuario</label>
                </div>
                <div class="user-box">
                    <input type="email" id="correo" name="correo" required="" value="<?php echo $fila['correo']; ?>">
                    <label for="correo">correo</label>
                </div>
                <div class="user-box">
                    <input type="text" id="direccion" name="direccion" required="" value="<?php echo $fila['direccion']; ?>">
                    <label for="direccion">direccion</label>
                </div>
                <div class="user-box">
                    <input type="text" id="telefono" name="telefono" required="" maxlength="10"
                    value="<?php echo $fila['telefono']; ?>">
                    <label for="telefono">telefono</label>
                </div>
                <div class="user-box">
                    <input type="text" id="password1" required="" name="password1">
                    <label for="password1">nueva password</label>
                </div>
                <div class="user-box">
                    <input type="text" id="password2" required="" name="password2">
                    <label for="password2">confirmar nueva password</label>
                </div>
                <button type="submit" value="Actualizar" name="btnactualizar">Actualizar datos</button>
            </form>
        </div>
        <?php
        if (isset($_POST["btnactualizar"])) {
            $nombre = $_POST["usuario"];
            $email = $_POST["correo"];
            $direccion = $_POST["direccion"];
            $telefono = $_POST["telefono"];
            $password1 = $_POST["password1"];
            $confirmacion = $_POST["password2"];
            if (empty($password1) || empty($confirmacion)) {
                $sqlgrabar = "UPDATE clientes SET  usuario = '$nombre', correo='$email', direccion='$direccion', telefono='$telefono' WHERE correo ='$email'";
                if (mysqli_query($conn, $sqlgrabar)) {
                    echo '<script> alert("Usuario actualizado"); window.location.href="../index.php"</script>';
                } else {
                    echo '<script>alert("Error al actualizar")</script>';
                }

            } else {
                if ($password1 == $confirmacion) {
                    $sqlgrabar = "UPDATE clientes SET  usuario = '$nombre', correo='$email', direccion='$direccion', telefono='$telefono',password='$password1' WHERE correo ='$email'";
                    if (mysqli_query($conn, $sqlgrabar)) {
                        echo '<script> alert("Usuario actualizado"); window.location.href="../index.php"</script>';
                    } else {
                        echo '<script>alert("Error al actualizar")</script>';
                    }
                } else {
                    echo '<script>alert("ambas contraseñas deben ser iguales")</script>';
                }
            }

        }
        ?>
    </div>
</body>

</html>