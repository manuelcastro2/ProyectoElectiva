<?php
include("../CONEXION/conexion.php");

session_start();
$id_usuario = $_SESSION["id_usuario"];

$consulta = "SELECT * FROM clientes WHERE correo='$id_usuario'";
$resultado = mysqli_query($conn, $consulta);

if (mysqli_num_rows($resultado) == 1) {
    $usuario = mysqli_fetch_assoc($resultado);
}


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/perfil.css">
    <title>USUARIO</title>
</head>

<body>
    <div class="caja-todo">
        <header>
            <a href="../index.php"></a>
            <form acttion="" method="post">
                <button class="button" type="submit" name="cerrar" id="cerrar">CERRAR SESION</button>
            </form>
        </header>
        <div class="contenido">
            <h1>MIS DATOS</h1>
            <input disabled class="mayus"
                value="<?php echo $usuario["usuario"]; ?>"
            >
            <input disabled class="mayus"
            value="<?php echo $usuario["correo"]; ?>"
            >
            <input disabled class="mayus"
            value="<?php echo $usuario["direccion"]; ?>"
            >
            <input disabled
            value="<?php echo"CEL:", $usuario["telefono"]; ?>"
            >
            <input disabled type="password" id="password1"
            value="<?php echo"PASSWORD:", $usuario["password"]; ?>"
            >
            <a href="../ESTRUTURE/modificaciondatos.php?correo=<?php echo $usuario["correo"]; ?>">modificar datos</a>
        </div>
        <?php
        if (isset($_POST["cerrar"])) {
            ?>
            <div class="caja-mensaje">
                <div class="mensaje">
                    <p>SE CERRO CORRECTAMENTE LA SESION</p>
                    <a href="../index.php">Cerrar</a>
                </div>
            </div>
            <?php
            session_destroy();
            die();
        }
        ?>
        <button type="submit" id='mostrar' class="mostrar">
    </div>
    <script>
        let password1 = document.querySelector('#password1')
        let mostrar = document.querySelector('#mostrar')

        mostrar.addEventListener('click', function () {
            if (password1.type == 'password') {
                password1.type = 'text';
                mostrar.style.backgroundImage = "url('../IMG/1915455.png')";
                mostrar.style.top ='-102px'; 
            } else {
                password1.type = 'password';
                mostrar.style.backgroundImage = "url('../IMG/icons8-ojo-cerrado-30.png')";
                mostrar.style.top ='-107px';   
            }
        })
    </script>
</body>

</html>