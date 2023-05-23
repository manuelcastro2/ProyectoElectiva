<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTRO</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="../CSS/registrar.css">
</head>

<body>
    <div class="caja-volver">
        <form action="../index.php" method="post">
            <button class="button" type="submit">VOLVER</button>
        </form>
    </div>
    <div class="caja-todo">
        <div class="caja-intermedia">
            <h1>REGISTRO</h1>
            <form method="post">
                <div class="caja-contenido">
                    <div class="user-box">
                        <input class="input" type="text" id="usuario" name="usuario">
                        <label for="usuario">usuario</label>
                    </div>
                    <div class="user-box">
                        <input class="input" type="email" id="correo" name="correo">
                        <label for="correo">correo</label>
                    </div>
                    <div class="user-box">
                        <input class="input" type="text" id="direccion" name="direccion">
                        <label for="direccion">direccion</label>
                    </div>
                    <div class="user-box">
                        <input class="input" type="text" id="telefono" name="telefono" maxlength="10">
                        <label for="telefono">telefono</label>
                    </div>
                    <div class="user-box">
                        <input class="input2" type="password" id="password1" name="password1">
                        <label for="password1">contraseña</label>
                    </div>
                    <div class="user-box">
                        <input class="input2" type="password" id="password2" name="password2">
                        <label for="password2">repite la contraseña</label>
                    </div>
                    <button class="button" type="submit" value="Registrar" name="btnregistrar">crear cuenta</button>
                </div>
            </form>
            <button type="submit" id='mostrar' class="mostrar">
                <button type="submit" id='mostrar2' class="mostrar2">
                </button>
                <form action="inicio.php" method="post">
                    <div class="caja-register">
                        <p>¿ya tienes cuenta?</p>
                        <button class="button" type="submit">INICIAR SESION</button>
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
                <div class="caja-mensaje">
                    <div class="mensaje">
                        <p>faltan campos por completar</p>
                        <a href="registrar.php">Cerrar</a>
                    </div>
                </div>
                <?php
            } elseif ($password1 != $confirmacion) {
                ?>
                <div class="caja-mensaje">
                    <div class="mensaje">
                        <p>las claves deben ser iguales</p>
                        <a href="registrar.php">Cerrar</a>
                    </div>
                </div>
                <?php
            } else if (strlen($password1) < 6) {
                ?>
                    <div class="caja-mensaje">
                        <div class="mensaje">
                            <p>la clave debe tener mas de 6 caracteres</p>
                            <a href="registrar.php">Cerrar</a>
                        </div>
                    </div>
                <?php
            } else if (strlen($password1) > 16) {
                ?>
                        <div class="caja-mensaje">
                            <div class="mensaje">
                                <p>la clave no debe tener mas 15 caracteres</p>
                                <a href="registrar.php">Cerrar</a>
                            </div>
                        </div>
                <?php
            } else if (!preg_match('`[a-z]`', $password1)) {
                ?>
                            <div class="caja-mensaje">
                                <div class="mensaje">
                                    <p>la clave debe tener por lo menos una minuscula</p>
                                    <a href="registrar.php">Cerrar</a>
                                </div>
                            </div>
                <?php
            } else if (!preg_match('`[A-Z]`', $password1)) {
                ?>
                                <div class="caja-mensaje">
                                    <div class="mensaje">
                                        <p>la clave debe tener por lo menos una mayuscula</p>
                                        <a href="registrar.php">Cerrar</a>
                                    </div>
                                </div>
                <?php
            } else if (!preg_match('`[0-9]`', $password1)) {
                ?>
                                    <div class="caja-mensaje">
                                        <div class="mensaje">
                                            <p>la clave debe tener por lo menos un numero</p>
                                            <a href="registrar.php">Cerrar</a>
                                        </div>
                                    </div>
                <?php
            } else {
                $consulta = "INSERT INTO clientes(usuario, correo, direccion, telefono, password) 
                     VALUES ('$nombre','$email','$direccion','$telefono','$password1')";
                $resultado = mysqli_query($conn, $consulta);
                if (mysqli_affected_rows($conn) > 0) {
                    ?>
                                        <div class="caja-mensaje">
                                            <div class="mensaje">
                                                <p>cuenta correctamente registrada</p>
                                                <a href="inicio.php">Cerrar</a>
                                            </div>
                                        </div>
                    <?php
                } else {
                    ?>
                                        <div class="caja-mensaje">
                                            <div class="mensaje">
                                                <p>error</p>
                                                <a href="registrar.php">Cerrar</a>
                                            </div>
                                        </div>
                    <?php
                }
            }
        }
        ?>
    </div>
    <script>
        let password1 = document.querySelector('#password1')
        let password2 = document.querySelector('#password2')
        let mostrar = document.querySelector('#mostrar')
        let mostrar2 = document.querySelector('#mostrar2')

        mostrar.addEventListener('click', function () {
            if (password1.type == 'password') {
                password1.type = 'text';
                mostrar.style.backgroundImage = "url('../IMG/1915455.png')";
                mostrar.style.top = '-90px';
            } else {
                password1.type = 'password';
                mostrar.style.backgroundImage = "url('../IMG/icons8-ojo-cerrado-30.png')";
                mostrar.style.top = '-95px';
            }
        })

        mostrar2.addEventListener('click', function () {
            if (password2.type == 'password') {
                password2.type = 'text';
                mostrar2.style.backgroundImage = "url('../IMG/1915455.png')";
                mostrar2.style.top = '-110px';
            } else {
                password2.type = 'password';
                mostrar2.style.backgroundImage = "url('../IMG/icons8-ojo-cerrado-30.png')";
                mostrar2.style.top = '-115px';
            }
        })
    </script>
</body>

</html>