<?php
require('../pdf/fpdf.php');
include('../CONEXION/conexion.php');
session_start();
if (isset($_SESSION['id_usuario'])) {
    $id_usuario = $_SESSION["id_usuario"];

    $consulta = "SELECT * FROM clientes WHERE correo='$id_usuario'";
    $resultado = mysqli_query($conn, $consulta);

    if (mysqli_num_rows($resultado) == 1) {
        $usuario = mysqli_fetch_assoc($resultado);
    }
}
$consulta = "SELECT * FROM compra,productos WHERE productos.id_producto=compra.id_produ
and id_usuario='$id_usuario'";
$resultado = mysqli_query($conn, $consulta);
$date = date('d-m-y');

class PDFH extends FPDF
{

    function header()
    {
        $this->Cell(-200);
        $this->Image('../IMG/logo-removebg-preview2.png', 150, 10, 50);
        $this->Ln(10);
        $this->SetFont('Arial', '', 40);
        $this->Write(18, 'Factura');
        $this->Cell(-200);
        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(0, 0, 0);
    }
}
$pdf = new PDFH();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);
$pdf->SetX(10);
$pdf->SetY(60);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(10, 155, 255);
$pdf->Cell(38, 6, 'Nombre :', 0, 0, 'C', 1);
$pdf->SetFillColor(240, 245, 255);
$pdf->Cell(38, 6, $usuario["usuario"], 0, 0, 'C', 1);
$pdf->SetFillColor(255, 255, 255);
$pdf->Cell(38, 6, '', 0, 0, 'C', 1);
$pdf->Cell(38, 6, '', 0, 0, 'C', 1);
$pdf->SetFillColor(10, 155, 255);
$pdf->Cell(38, 6, 'Fecha: ', 0, 1, 'C', 1);
$pdf->SetFillColor(240, 245, 255);
$pdf->SetFillColor(255, 255, 255);
$pdf->Cell(47, 6, '', 0, 0, 'C', 1);
$pdf->Cell(45, 6, '', 0, 0, 'C', 1);
$pdf->Cell(60, 6, '', 0, 0, 'C', 1);
$pdf->SetFillColor(240, 245, 255);
$pdf->Cell(38, 6, $date, 0, 1, 'C', 1);
$pdf->SetFillColor(10, 155, 255);
$pdf->Cell(38, 6, 'Telefono :', 0, 0, 'C', 1);
$pdf->SetFillColor(240, 245, 255);
$pdf->Cell(38, 6, $usuario["telefono"], 0, 1, 'C', 1);
$pdf->SetFillColor(10, 155, 255);
$pdf->Cell(38, 6, 'Direccion :', 0, 0, 'C', 1);
$pdf->SetFillColor(240, 245, 255);
$pdf->Cell(38, 6, $usuario["direccion"], 0, 1, 'C', 1);
$pdf->SetFont('Arial', '', 10);


$pdf->SetFont('Arial', '', 10);
$pdf->SetY(120);
$pdf->SetX(10);
$pdf->SetTextColor(0.0, 0);
$pdf->SetFillColor(10, 155, 255);
$pdf->Cell(40, 6, 'Tipo Producto', 0, 0, 'C', 1);
$pdf->Cell(80, 6, 'Producto', 0, 0, 'C', 1);
$pdf->Cell(20, 6, 'Cantidad', 0, 0, 'C', 1);
$pdf->Cell(25, 6, 'Precio Unitario', 0, 0, 'C', 1);
$pdf->Cell(20, 6, 'Total', 0, 1, 'C', 1);


$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(240, 245, 255);
$tot = 0;
while ($fila = mysqli_fetch_assoc($resultado)) {
    if (isset($_POST[$fila["id_produ"]])) {
        $au = $fila["id_produ"];
        $cantidad = $fila["canti"];
        $pdf->SetX(10);
        $pdf->Cell(40, 9, $fila['tipo_produc'], 0, 0, 'C', 1);
        $pdf->Cell(80, 9, $fila['Nombre_prod'], 0, 0, 0, 1);
        $pdf->Cell(20, 9, $fila['canti'], 0, 0, 'C', 1);
        $numeroFormateado = number_format($fila["precio"], 0);
        $pdf->Cell(25, 9, strval($numeroFormateado), 0, 0, 'C', 1);
        $total = $fila["canti"] * $fila["precio"];
        $numeroFormateado = number_format($total, 0);
        $pdf->Cell(20, 9, strval($numeroFormateado), 0, 1, 'C', 1);
        $total = $fila["canti"] * $fila["precio"];
        $tot = $tot + $total;
        $numeroFormateado = number_format($total, 0);
    }
}
$pdf->SetX(150);
$pdf->SetY(160);
$pdf->SetFillColor(10, 155, 255);
$pdf->Cell(40, 9, 'PRECIO SUBTOTAL: ', 0, 0, 'C', 1);
$pdf->SetFillColor(240, 245, 255);
$subtotal = number_format($tot, 0);
$pdf->Cell(40, 9, $subtotal, 0, 1, 'C', 1);
$pdf->SetFillColor(10, 155, 255);
$pdf->Cell(40, 9, 'PRECIO ENVIO: ', 0, 0, 'C', 1);
$pdf->SetFillColor(240, 245, 255);
$pdf->Cell(40, 9, "8,000", 0, 1, 'C', 1);
$totalpagar = $tot + 8000;
$pagar = number_format($totalpagar, 0);
$pdf->SetFillColor(10, 155, 255);
$pdf->Cell(40, 9, 'PRECIO TOTAL: ', 0, 0, 'C', 1);
$pdf->SetFillColor(240, 245, 255);
$pdf->Cell(40, 9, $pagar, 0, 1, 'C', 1);
$pdf->SetY(200);
$pdf->SetFillColor(10, 155, 255);
$pdf->Cell(40, 9, 'METODO DE PAGO: ', 0, 0, 'C', 1);
$pdf->SetFillColor(240, 245, 255);
if ($_POST["radio"] = 'Nequi') {
    $pdf->Cell(40, 9, $_POST["radio"], 0, 1, 'C', 1);
} else if ($_POST["radio"] = 'Daviplata') {
    $pdf->Cell(40, 9, $_POST["radio"], 0, 1, 'C', 1);
} else if ($_POST["radio"] = 'Bancolombia') {
    $pdf->Cell(40, 9, $_POST["radio"], 0, 1, 'C', 1);
}
$pdf->SetY(220);
$pdf->SetFillColor(10, 155, 255);
$pdf->Cell(45, 9, 'CUENTA NEQUI: ', 0, 0, 'C', 1);
$pdf->SetFillColor(240, 245, 255);
$pdf->Cell(40, 9, "3245231321", 0, 1, 'C', 1);
$pdf->SetFillColor(10, 155, 255);
$pdf->Cell(45, 9, 'CUENTA DAVIPLATA: ', 0, 0, 'C', 1);
$pdf->SetFillColor(240, 245, 255);
$pdf->Cell(40, 9, "3245231321", 0, 1, 'C', 1);
$pdf->SetFillColor(10, 155, 255);
$pdf->Cell(45, 9, 'CUENTA BANCOLOMBIA: ', 0, 0, 'C', 1);
$pdf->SetFillColor(240, 245, 255);
$pdf->Cell(40, 9, "143245643", 0, 1, 'C', 1);
$pdf->SetY(260);
$pdf->SetX(70);
$pdf->SetFillColor(10, 155, 255);
$pdf->Cell(60, 15, "FIRMA ELECTROHOP", 0, 1, 'C', 1);


$pdf->Output();


?>