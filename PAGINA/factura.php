<?php
require('../pdf/fpdf.php');
include('../pdf/fpdf.php');
include('../CONEXION/conexion.php');
require('../CONEXION/conexion.php');
session_start();
if (isset($_SESSION['id_usuario'])) {
    $id_usuario = $_SESSION["id_usuario"];

    $consulta = "SELECT * FROM clientes WHERE correo='$id_usuario'";
    $resultado = mysqli_query($conn, $consulta);

    if (mysqli_num_rows($resultado) == 1) {
        $usuario = mysqli_fetch_assoc($resultado);
    }
}

class PDF extends FPDF
{

    function header()
    {
        $this->Cell(-200);
        $this->Image('../IMG/logo-removebg-preview2.png', 0, -10, 220);

        $this->Ln(10);
        $this->SetFont('Arial', '8', 10);
        $this->Cell(-200);
    }

    function Footer()
    {
        $this->SetFillColor(20.05, 19);
        $this->Rect(0, 270, 220, 30, 'F');
        $this->SetY(-20);
        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(255, 255, 255);

        $this->SetX(90);
        $this->Write(5, '     ELECTROSHOP');
        $this->Ln();
    }
}
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

$pdf->SetY(70);
$pdf->SetX(45);
$pdf->SetTextColor(255.255, 255);
$pdf->SetFillColor(79, 59, 120);
$pdf->Cell(59, 9, 'Tipo Producto', 0, 0, 'C', 1);
$pdf->Cell(59, 9, 'Producto', 0, 0, 'C', 1);
$pdf->Cell(59, 9, 'Cantidad', 0, 0, 'C', 1);
$pdf->Cell(59, 9, 'Precio Unitario', 0, 0, 'C', 1);
$pdf->Cell(59, 9, 'Total', 0, 0, 'C', 1);

$consulta = "SELECT * compra where productos.id_producto=compra.id_produ 
and id_usuario='$id_usuario'";
$resultado = mysqli_query($conn, $consulta);

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(240, 245, 255);

while ($fila = mysqli_fetch_array($resultado1)) {
    if (isset($_POST[$fila["id_produ"]])) {
        $pdf->SetX(45);
        $pdf->Cell(59, 9, $fila['tipo_produc'], 0, 0, 'C', 1);
        $pdf->Cell(59, 9, $fila['Nombre_prod'], 0, 0, 'C', 1);
        $pdf->Cell(59, 9, $fila['canti'], 0, 0, 'C', 1);
        $pdf->Cell(59, 9, $fila['precio'], 0, 0, 'C', 1);
        $pdf->Cell(59, 9, $fila['precio'], 0, 0, 'C', 1);

        echo $fila["id_produ"];
    }
}

$pdf->Output();


?>