<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTRO</title>
    <link rel="stylesheet" href="../CSS/registrar.css">
</head>

<body>
    <div class="caja-volver">
        <form action="../index.php" method="post">
            <button type="submit">VOLVER</button>
        </form>
    </div>
    <div class="caja-todo">
        <div class="caja-intermedia">
            <h1>REGISTRO</h1>
            <form method="post">
                <div class="caja-contenido">
                    <div class="user-box">
                        <input type="text" id="usuario" name="usuario" required>
                        <label for="usuario">usuario</label>
                    </div>
                    <div class="user-box">
                        <input type="email" id="correo" name="correo" required>
                        <label for="correo">correo</label>
                    </div>
                    <div class="user-box">
                        <input type="text" id="direccion" name="direccion" required>
                        <label for="direccion">direccion</label>
                    </div>
                    <div class="user-box">
                        <input type="text" id="telefono" name="telefono" maxlength="10" required>
                        <label for="telefono">telefono</label>
                    </div>
                    <div class="user-box">
                        <input type="text" id="password1" name="password1" required>
                        <label for="password1">contraseña</label>
                    </div>
                    <div class="user-box">
                        <input type="text" id="password2" name="password2" required>
                        <label for="password2">repite la contraseña</label>
                    </div>
                    <button type="submit" value="Registrar" name="btnregistrar">crear cuenta</button>
                </div>
            </form>
            <form action="inicio.php" method="post">
                <div class="caja-register">
                    <p>¿ya tienes cuenta?</p>
                    <button type="submit">INICIAR SESION</button>
                </div>
            </form>

        </div>
        <?php
        include("../CONEXION/conexion.php");

        if (isset($_POST["btnregistrar"])) {
            $nombre = mysqli_real_escape_string($conn, $_POST["usuario"]);
            $email = mysqli_real_escape_string($conn, $_POST["correo"]);
            $direccion = mysqli_real_escape_string($conn, $_POST["direccion"]);
            $telefono = mysqli_real_escape_string($conn, $_POST["telefono"]);
            $password1 = mysqli_real_escape_string($conn, $_POST["password1"]);
            $confirmacion = mysqli_real_escape_string($conn, $_POST["password2"]);
            if (empty($email) || empty($password1) || empty($confirmacion)) {
                ?>
                <script>alert("faltan campos por completar")</script>
                <?php
            } elseif ($password1 != $confirmacion) {
                ?>
                <script>alert("las claves deben ser iguales")</script>
                <?php
            } else {
                $consulta = "INSERT INTO clientes(usuario, correo, direccion, telefono, password) 
                     VALUES ('$nombre','$email','$direccion','$telefono','$password1')";
                $resultado = mysqli_query($conn, $consulta);
                if (mysqli_affected_rows($conn) > 0) {
                    ?>
                    <script>alert("cuenta correctamente registrada")
                        window.location.href = " inicio.php";
                    </script>
                    <?php
                } else {
                    ?>
                    <script>alert("ups ERROR")</script>
                    <?php
                }
            }
        }
        ?>
    </div>
</body>

</html>