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
                <button class="actualizar" type="submit" name="cerrar" id="cerrar">CERRAR SESION</button>
            </form>
        </header>
        <div class="contenido">
            <a class="volver" href="../PAGINA/paginausuario.php?=<?php echo $id_usuario ?>">VOLVER</a>
            <h1>ACTUALIZAR DATOS</h1>
            <form method="post">
                <div class="user-box">
                    <input class="mayus" type="text" id="usuario" name="usuario" value="<?php echo $fila['usuario']; ?>">
                    <label for="usuario">usuario</label>
                </div>
                <div class="user-box">
                    <input class="mayus" type="email" id="correo" name="correo" value="<?php echo $fila['correo']; ?>">
                    <label for="correo">correo</label>
                </div>
                <div class="user-box">
                    <input class="mayus" type="text" id="direccion" name="direccion" value="<?php echo $fila['direccion']; ?>">
                    <label for="direccion">direccion</label>
                </div>
                <div class="user-box">
                    <input class="mayus" type="text" id="telefono" name="telefono" maxlength="10"
                        value="<?php echo $fila['telefono']; ?>">
                    <label for="telefono">telefono</label>
                </div>
                <div class="user-box" id="pass1">
                    <input type="text" id="password1" name="password1">
                    <label for="password1">nueva password</label>
                </div>
                <div class="user-box" id="pass2">
                    <input type="text" id="password2" name="password2">
                    <label for="password2">confirmar nueva password</label>
                </div>


                <button class="actualizar" type="submit" value="Actualizar" name="btnactualizar">Actualizar datos</button>
            </form>
            <a class="button" id="ver">CAMBIAR CONTRASEÑA</a>
            <a class="button" id="ver2">OCULTAR CONTRASEÑA</a>
            <button type="submit" id='mostrar' class="mostrar">
            <button type="submit" id='mostrar2' class="mostrar2">
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
                    ?>
                    <div class="caja-mensaje">
                        <div class="mensaje">
                            <p>se actualizo correctamente</p>
                            <a href="../PAGINA/paginausuario.php">Cerrar</a>
                        </div>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="caja-mensaje">
                        <div class="mensaje">
                            <p>error al actualizar</p>
                            <a href="../PAGINA/paginausuario.php">Cerrar</a>
                        </div>
                    </div>
                    <?php
                }

            } else {
                if (!empty($password1) || !empty($confirmacion) && $password1 == $confirmacion) {
                    $sqlgrabar = "UPDATE clientes SET  usuario = '$nombre', correo='$email', direccion='$direccion', telefono='$telefono',password='$password1' WHERE correo ='$email'";
                    if (mysqli_query($conn, $sqlgrabar)) {
                        ?>
                        <div class="caja-mensaje">
                            <div class="mensaje">
                                <p>se actualizo correctamente</p>
                                <a href="../PAGINA/paginausuario.php">Cerrar</a>
                            </div>
                        </div>
                        <?php
                    } else {
                        ?>
                        <div class="caja-mensaje">
                            <div class="mensaje">
                                <p>error al actualizar</p>
                                <a href="../PAGINA/paginausuario.php">Cerrar</a>
                            </div>
                        </div>
                        <?php

                    }
                } else {
                    ?>
                    <div class="caja-mensaje">
                        <div class="mensaje">
                            <p>las claves deben ser iguales</p>
                            <a href="../PAGINA/paginausuario.php">Cerrar</a>
                        </div>
                    </div>
                    <?php
                }
            }

        }
        ?>
    </div>
    <script>
        let pass1 = document.querySelector("#pass1")
        let pass2 = document.querySelector("#pass2")
        let ver = document.querySelector("#ver")
        let ver2 = document.querySelector("#ver2")
        ver.addEventListener("click", function () {
            pass1.style.display = "block"
            pass2.style.display = "block"
            ver2.style.display = "block"
            ver.style.display = "none"
            ver.style.display = "none"
            mostrar.style.display = 'block';
            mostrar2.style.display = 'block';
        })

        ver2.addEventListener("click", function () {
            pass1.style.display = "none"
            pass2.style.display = "none"
            ver2.style.display = "none"
            ver.style.display = "block"
            mostrar.style.display = 'none';
            mostrar2.style.display = 'none';
        })
    </script>
    <script>
        let password1 = document.querySelector('#password1')
        let password2 = document.querySelector('#password2')
        let mostrar = document.querySelector('#mostrar')
        let mostrar2 = document.querySelector('#mostrar2')
        mostrar.addEventListener('click', function () {
            if (password1.type == 'password') {
                password1.type = 'text';
                mostrar.style.backgroundImage = "url('../IMG/1915455.png')";
                mostrar.style.bottom = '325px';
            } else {
                password1.type = 'password';
                mostrar.style.backgroundImage = "url('../IMG/icons8-ojo-cerrado-30.png')";
                mostrar.style.bottom = '330px';
            }
        })

        mostrar2.addEventListener('click', function () {
            if (password2.type == 'password') {
                password2.type = 'text';
                mostrar2.style.backgroundImage = "url('../IMG/1915455.png')";
                mostrar2.style.bottom = '295px';
            } else {
                password2.type = 'password';
                mostrar2.style.backgroundImage = "url('../IMG/icons8-ojo-cerrado-30.png')";
                mostrar2.style.bottom = '300px';
            }
        })
    </script>
</body>

</html>