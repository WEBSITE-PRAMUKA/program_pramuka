<?php
session_start();
include "../config/koneksi.php";

if (!isset($_SESSION['status_login']) || $_SESSION['role'] != 'admin') {
    header("location:../auth/login.php?pesan=denied");
    exit;
}

require('../assets/fpdf/fpdf.php');

$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(190, 10, 'LAPORAN ABSENSI ANGGOTA PRAMUKA', 0, 1, 'C');
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(190, 7, 'SMK Kencong', 0, 1, 'C');

$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 11);
$pdf->SetFillColor(220, 220, 220);

$pdf->Cell(10, 10, 'No', 1, 0, 'C', true);
$pdf->Cell(50, 10, 'Nama Anggota', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'NTA', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Jam Absen', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Status', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Lokasi', 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 10);

$query = mysqli_query($conn, "SELECT h.*, k.nama_kegiatan, k.jam_mulai FROM absensi_hasil h JOIN absensi_kegiatan k ON h.id_kegiatan = k.id_kegiatan ORDER BY h.waktu_absen DESC");

$no = 1;
while ($row = mysqli_fetch_assoc($query)) {
    $jam_absen = date('H:i', strtotime($row['waktu_absen']));
    $status = (strtotime($jam_absen) > strtotime($row['jam_mulai'])) ? 'Terlambat' : 'Tepat';
    $lokasi = strlen($row['lokasi_anggota']) > 28 ? substr($row['lokasi_anggota'], 0, 25) . '...' : $row['lokasi_anggota'];

    $pdf->Cell(10, 9, $no++, 1, 0, 'C');
    $pdf->Cell(50, 9, $row['nama_anggota'], 1, 0);
    $pdf->Cell(30, 9, $row['nta'], 1, 0, 'C');
    $pdf->Cell(40, 9, $jam_absen, 1, 0, 'C');
    $pdf->Cell(30, 9, $status, 1, 0, 'C');
    $pdf->Cell(30, 9, $lokasi, 1, 1);
}

$pdf->Output('D', 'laporan_absensi.pdf');
?>