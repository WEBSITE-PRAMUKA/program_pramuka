<?php
session_start();
include "../config/koneksi.php";

// Proteksi Login
if (!isset($_SESSION['status_login']) || $_SESSION['role'] != 'bendahara') {
    header("location:../auth/login.php?pesan=denied");
    exit;
}

require('../assets/fpdf/fpdf.php');

$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();

// Judul
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(190, 10, 'LAPORAN IURAN ANGGOTA PRAMUKA', 0, 1, 'C');

$pdf->SetFont('Arial', '', 11);
$pdf->Cell(190, 7, 'SMK Kencong', 0, 1, 'C');

$pdf->Ln(5);

// Header tabel
$pdf->SetFont('Arial', 'B', 11);
$pdf->SetFillColor(220,220,220);

$pdf->Cell(12,10,'No',1,0,'C',true);
$pdf->Cell(50,10,'Periode',1,0,'C',true);
$pdf->Cell(55,10,'Nama Anggota',1,0,'C',true);
$pdf->Cell(30,10,'NTA',1,0,'C',true);
$pdf->Cell(43,10,'Nominal',1,1,'C',true);

// Data
$pdf->SetFont('Arial','',10);

$query = mysqli_query($conn, "SELECT * FROM iuran_anggota ORDER BY id DESC");

$no = 1;
$total = 0;

while($row = mysqli_fetch_assoc($query)){

    $pdf->Cell(12,9,$no++,1,0,'C');
    $pdf->Cell(50,9,$row['judul_tanggal'],1,0);
    $pdf->Cell(55,9,$row['nama_anggota'],1,0);
    $pdf->Cell(30,9,$row['nta'],1,0,'C');
    $pdf->Cell(43,9,'Rp '.number_format($row['nominal'],0,',','.'),1,1);

    $total += $row['nominal'];
}

// Total
$pdf->SetFont('Arial','B',11);

$pdf->Cell(147,10,'TOTAL PEMASUKAN',1,0,'C');
$pdf->Cell(43,10,'Rp '.number_format($total,0,',','.'),1,1);

$pdf->Output('I', 'laporan_iuran.pdf');
?>