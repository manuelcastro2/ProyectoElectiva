<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="../CSS/serviciocliente.css">
    <title>SERVICIO AL CLIENTE</title>
</head>

<body>
    <div class="caja-todo">
        <header>
            <div class="encabezado">
                <span></span>
                <nav>
                    <a class="navegador item tres" href="../index.php">INICIO</a>
                    <a class="navegador item tres" href="conocenos.php">CONOCENOS</a>
                    <a class="navegador item tres" href="">SERVICIO AL CLIENTE</a>
                    <a class="navegador item tres" href="productos.php">PRODUCTOS</a>
                    <?php
                    include("../CONEXION/conexion.php");
                    session_start();
                    if (isset($_SESSION['id_usuario'])) {
                        $id_usuario = $_SESSION["id_usuario"];

                        $consulta = "SELECT  * FROM clientes WHERE correo='$id_usuario'";
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
                            <form acttion="#" method="post">
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
                <a href="carrito.php">
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
            <div class="caja-soporte">
                <h1>SOPORTE COMPLETO</h1>
                <p>siempre contigo</p>
            </div>
            <div class="caja-siempre">
                <figure>
                    <div class="img1"><!--imagen--></div>
                    <p>EXACTA Y HONESTA</p>
                </figure>
                <figure>
                    <div class="img2"><!--imagen--></div>
                    <p>RAPIDA Y EFICAS</p>
                </figure>
                <figure>
                    <div class="img3"><!--imagen--></div>
                    <p>GARANTIA DE 30 DIAS</p>
                </figure>
            </div>
            <article>
                <h1>PREGUNTAS FERCUENTES</h1>
                <div>
                    <h3>¿PUEDO PRE-ORDENAR ALGÚN ARTÍCULO?</h3>
                    <p>Ingresa tu respuesta aquí. Escribe de forma clara y concisa, y considera agregar ejemplos
                        escritos y visuales. Revisa lo que escribiste y asegúrate de que si fuera la primera vez que
                        visitas el sitio, entiendes la respuesta.</p>
                
                    <h3>¿CUÁL ES SU POLÍTICA DE DEVOLUCIONES?</h3>
                    <p>Ingresa tu respuesta aquí. Escribe de forma clara y concisa, y considera agregar ejemplos
                        escritos y visuales. Revisa lo que escribiste y asegúrate de que si fuera la primera vez que
                        visitas el sitio, entiendes la respuesta.</p>
               
                    <h3>¿TIENES SERVICIO DE ENTREGA PARA TODOS LOS PRODUCTOS QUE MANEJAN?</h3>
                    <p>Ingresa tu respuesta aquí. Escribe de forma clara y concisa, y considera agregar ejemplos
                        escritos y visuales. Revisa lo que escribiste y asegúrate de que si fuera la primera vez que
                        visitas el sitio, entiendes la respuesta.</p>
                </div>
            </article>
            <figure class="imagen"><!--imagen--></figure>
            <div class="caja-contacto">
                <h1>CONTACTE A NUESTROS EQUIPOS DE AYUDA</h1>
                <p>¿como podemos ayudarle?</p>
                <div class="contacto">
                    <form method="post">
                        <input type="text" name="nombre" id="nombre" placeholder="nombre">
                        <input type="email" name="email" id="email" placeholder="email">
                        <select name="tematica" id="tematica">
                            <option value="">elige una tematica</option>
                            <option value="INGRESO">ingresar a la cuenta</option>
                            <option value="PAGO">completar el pago</option>
                            <option value="CONTENIDO">ver el contenido</option>
                            <option value="SUBIDA">subir archivos</option>
                            <option value="OTRO">otro</option>
                        </select>
                        <textarea name="asunto" id="asunto" cols="20" rows="5"
                            placeholder="escribe el asunto"></textarea>
                        <button type="submit" class="neon-azul" name="btncontacto" id="btncontacto">CONTACTAME</button>
                    </form>
                </div>
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
    </div>

</body>

</html>
<?php
if (isset($_POST["btncontacto"])) {
    $nombre = mysqli_real_escape_string($conn, $_POST["nombre"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $tematica = mysqli_real_escape_string($conn, $_POST["tematica"]);
    $asunto = mysqli_real_escape_string($conn, $_POST["asunto"]);
    if (empty($email) || empty($nombre) || empty($tematica)) {
        ?>
        <script>alert("no se llenaron todos los campos")</script>
        <?php
    } else {
        $consulta = "INSERT INTO quejas(nombre, correo, tematica, asunto) 
             VALUES ('$nombre','$email','$tematica','$asunto')";
        $resultado = mysqli_query($conn, $consulta);
        if (mysqli_affected_rows($conn) > 0) {
            ?>
            <script>alert("ayuda enviada")
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