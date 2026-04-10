<?php
session_start();
include "koneksi.php";

// Proteksi: Cek login DAN cek apakah role-nya BENDAHARA
if (!isset($_SESSION['status_login']) || $_SESSION['role'] != 'bendahara') {
    header("location:login.php?pesan=denied");
    exit;
}

$nama   = $_SESSION['nama'];
$role   = $_SESSION['role'];
$nta    = $_SESSION['nta'];

// Data Khusus Bendahara
$gugus         = "12-001";
$status        = "Bendahara";
$pemasukan     = "Rp 1.250.000";
$total_kas     = "Rp 4.500.000";
$tunggakan     = "12 Orang";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Bendahara - <?php echo $nama ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
        body { background:#f5f1ed; }
        .navbar { background:#ffffff; box-shadow:0 2px 5px rgba(0,0,0,0.1); }
        .card { border:none; border-radius:15px; box-shadow:0 4px 10px rgba(0,0,0,0.05); }
        .quick-card { padding:25px; text-align:center; transition:0.3s; cursor: pointer; text-decoration: none; color: inherit; display: block; }
        .quick-card:hover { transform:translateY(-5px); background: #fff; box-shadow: 0 6px 15px rgba(0,0,0,0.1); }
        .footer { background:#5c3a2e; color:white; padding:40px 0; }
        .badge-aktif { background:#fff4e6; color:#fd7e14; padding:5px 15px; border-radius:20px; font-weight: bold; }
        .badge-role { background:#fd7e14; color:white; padding:3px 10px; border-radius:5px; font-size: 0.75rem; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">Pramuka <span class="text-warning">Finance</span></a>
        <ul class="navbar-nav mx-auto">
            <li class="nav-item"><a class="nav-link" href="#">Input Kas</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Laporan</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Data Iuran</a></li>
        </ul>
        <a href="logout.php" class="btn btn-outline-danger btn-sm rounded-pill px-3">Logout</a>
    </div>
</nav>

<div class="container mt-4">
    <h3 class="fw-bold">Selamat Datang, <?php echo $nama ?>!</h3>
    <p class="text-muted">Kelola keuangan organisasi sebagai <span class="badge-role">Bendahara</span></p>

    <div class="card p-4 mt-3">
        <h6 class="mb-3 fw-bold text-muted">DATA BENDAHARA</h6>
        <div class="row">
            <div class="col-md-3">
                <label class="small text-muted d-block">Nama</label>
                <h6 class="fw-bold"><?php echo $nama ?></h6>
            </div>
            <div class="col-md-3">
                <label class="small text-muted d-block">Akses</label>
                <h6 class="fw-bold">Manajemen Kas</h6>
            </div>
            <div class="col-md-3">
                <label class="small text-muted d-block">Gugus Depan</label>
                <h6 class="fw-bold"><?php echo $gugus ?></h6>
            </div>
            <div class="col-md-3">
                <label class="small text-muted d-block">Jabatan</label>
                <span class="badge-aktif"><?php echo $status ?></span>
            </div>
        </div>
    </div>

    <h5 class="mt-4 fw-bold">Akses Keuangan</h5>
    <div class="row mt-3">
        <div class="col-md-3 col-6 mb-3">
            <a href="#" class="card quick-card"><i class="fa fa-hand-holding-usd fa-2x text-warning mb-2"></i><h6>Input Kas</h6><small class="text-muted">Catat iuran</small></a>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <a href="#" class="card quick-card"><i class="fa fa-file-invoice-dollar fa-2x text-success mb-2"></i><h6>Laporan</h6><small class="text-muted">Bulanan</small></a>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <a href="#" class="card quick-card"><i class="fa fa-users fa-2x text-primary mb-2"></i><h6>Daftar Anggota</h6><small class="text-muted">Cek iuran</small></a>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <a href="#" class="card quick-card"><i class="fa fa-cog fa-2x text-secondary mb-2"></i><h6>Pengaturan</h6><small class="text-muted">Tarif iuran</small></a>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-md-4 mb-3">
            <div class="card p-3 border-start border-success border-4">
                <h6 class="text-muted">Total Kas Global</h6>
                <h3 class="fw-bold text-success mb-0"><?php echo $total_kas ?></h3>
                <small>Saldo tersedia</small>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card p-3 border-start border-primary border-4">
                <h6 class="text-muted">Masuk Bulan Ini</h6>
                <h3 class="fw-bold text-primary mb-0"><?php echo $pemasukan ?></h3>
                <small>Total transaksi terbaru</small>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card p-3 border-start border-danger border-4">
                <h6 class="text-muted">Belum Membayar</h6>
                <h3 class="fw-bold text-danger mb-0"><?php echo $tunggakan ?></h3>
                <small>Anggota periode ini</small>
            </div>
        </div>
    </div>
</div>

<div class="footer mt-5 text-center">
    <small>© 2026 Gerakan Pramuka Indonesia. Keuangan Aman Karakter Nyaman.</small>
</div>
</body>
</html>