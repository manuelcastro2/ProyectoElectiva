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
            <button type="submit" class="button">volver</button>
        </form>
    </div>
    <div class="caja-todo">
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
                ?>
                <div class="caja-mensaje">
                    <div class="mensaje">
                        <p>Correo o contraseña incorrectos</p>
                        <a href="inicio.php">Cerrar</a>
                    </div>
                </div>
                <?php
            }
        }
        ?>
        <div class="caja-intermedia">
            <h1>Iniciar sesión</h1>
            <form method="POST">
                <div class="caja-contenido">
                    <div class="user-box">
                        <input type="text" name="correo" required="">
                        <label>Correo electrónico</label>
                    </div>
                    <div class="user-box">
                        <input type="password" id='password1'name="password" required="">
                        <label>Contraseña</label>
                    </div>
                    <button class="button" type="submit" name="btniniciar">Iniciar sesión</button>
                </div>
            </form>
            <form action="Registrar.php" method="post">
                <div class="caja-register">
                    <p>¿no tienes cuenta?</p>
                    <button class="button" type="submit">
                        REGISTRAR
                    </button>
                </div>
            </form>
            <button type="submit" id='mostrar' class="mostrar">
        </div>
    </div>
    <script>
        let password1 = document.querySelector('#password1')
        let mostrar = document.querySelector('#mostrar')

        mostrar.addEventListener('click', function () {
            if (password1.type == 'password') {
                password1.type = 'text';
                mostrar.style.backgroundImage = "url('../IMG/1915455.png')";
                mostrar.style.top ='-90px'; 
            } else {
                password1.type = 'password';
                mostrar.style.backgroundImage = "url('../IMG/icons8-ojo-cerrado-30.png')";
                mostrar.style.top ='-95px';   
            }
        })
    </script>
</body>

</html>