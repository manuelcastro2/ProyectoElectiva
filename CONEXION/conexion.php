<?php
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "tienda2";
    $conn= mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
    if (!$conn) {
        die("No hay Conexion:" .mysqli_connect_error());
    }
?>