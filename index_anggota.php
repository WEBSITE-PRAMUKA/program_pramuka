<?php
session_start();
include "koneksi.php";

// Proteksi: Cek login DAN cek apakah role-nya ANGGOTA
if (!isset($_SESSION['status_login']) || $_SESSION['role'] != 'anggota') {
    header("location:login.php?pesan=denied");
    exit;
}

$nama   = $_SESSION['nama'];
$role   = $_SESSION['role'];
$nta    = $_SESSION['nta'];

// Data Dinamis Anggota (Bisa diambil dari database nanti)
$gugus         = "12-001";
$status        = "Aktif";
$kehadiran     = "8/10";
$status_iuran  = "Lunas";
$event         = "3";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pramuka - <?php echo $nama ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
        body { background:#f5f1ed; }
        .navbar { background:#ffffff; box-shadow:0 2px 5px rgba(0,0,0,0.1); }
        .card { border:none; border-radius:15px; box-shadow:0 4px 10px rgba(0,0,0,0.05); }
        .quick-card { padding:25px; text-align:center; transition:0.3s; cursor: pointer; text-decoration: none; color: inherit; display: block; }
        .quick-card:hover { transform:translateY(-5px); background: #fff; box-shadow: 0 6px 15px rgba(0,0,0,0.1); }
        .footer { background:#5c3a2e; color:white; padding:40px 0; }
        .badge-aktif { background:#e6f4ea; color:#28a745; padding:5px 15px; border-radius:20px; font-weight: bold; }
        .badge-role { background:#6b4a3c; color:white; padding:3px 10px; border-radius:5px; font-size: 0.75rem; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">Pramuka</a>
        <ul class="navbar-nav mx-auto">
            <li class="nav-item"><a class="nav-link" href="#">Beranda</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Event</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Materi</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Iuran</a></li>
        </ul>
        <a href="logout.php" class="btn btn-outline-danger btn-sm rounded-pill px-3">Logout</a>
    </div>
</nav>

<div class="container mt-4">
    <h3 class="fw-bold">Selamat Datang, <?php echo $nama ?>!</h3>
    <p class="text-muted">Kelola aktivitas kepramukaan Anda sebagai <span class="badge-role">Anggota</span></p>

    <div class="card p-4 mt-3">
        <h6 class="mb-3 fw-bold text-muted">PROFIL SAYA</h6>
        <div class="row">
            <div class="col-md-3 mb-3 mb-md-0">
                <label class="small text-muted d-block">Nama Lengkap</label>
                <h6 class="fw-bold"><?php echo $nama ?></h6>
            </div>
            <div class="col-md-3 mb-3 mb-md-0">
                <label class="small text-muted d-block">NTA</label>
                <h6 class="fw-bold"><?php echo $nta ?></h6>
            </div>
            <div class="col-md-3 mb-3 mb-md-0">
                <label class="small text-muted d-block">Gugus Depan</label>
                <h6 class="fw-bold"><?php echo $gugus ?></h6>
            </div>
            <div class="col-md-3">
                <label class="small text-muted d-block">Status</label>
                <span class="badge-aktif"><?php echo $status ?></span>
            </div>
        </div>
    </div>

    <h5 class="mt-4 fw-bold">Akses Cepat</h5>
    <div class="row mt-3">
        <div class="col-md-3 col-6 mb-3">
            <a href="#" class="card quick-card"><i class="fa fa-check-circle fa-2x text-success mb-2"></i><h6>Absensi</h6><small class="text-muted">Presensi</small></a>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <a href="#" class="card quick-card"><i class="fa fa-wallet fa-2x text-warning mb-2"></i><h6>Iuran</h6><small class="text-muted">Riwayat</small></a>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <a href="#" class="card quick-card"><i class="fa fa-calendar-alt fa-2x text-primary mb-2"></i><h6>Event</h6><small class="text-muted">Agenda</small></a>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <a href="#" class="card quick-card"><i class="fa fa-book fa-2x text-info mb-2"></i><h6>Materi</h6><small class="text-muted">Belajar</small></a>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-md-4 mb-3">
            <div class="card p-3 border-start border-success border-4">
                <h6 class="text-muted">Kehadiran Latihan</h6>
                <h3 class="fw-bold text-success mb-0"><?php echo $kehadiran ?></h3>
                <small>Pertemuan bulan ini</small>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card p-3 border-start border-warning border-4">
                <h6 class="text-muted">Status Iuran</h6>
                <h3 class="fw-bold text-warning mb-0"><?php echo $status_iuran ?></h3>
                <small>Periode Sekarang</small>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card p-3 border-start border-dark border-4">
                <h6 class="text-muted">Event Mendatang</h6>
                <h3 class="fw-bold mb-0"><?php echo $event ?></h3>
                <small>Kegiatan terdekat</small>
            </div>
        </div>
    </div>
</div>

<div class="footer mt-5 text-center">
    <small>© 2026 Gerakan Pramuka Indonesia. Dashboard Anggota.</small>
</div>
</body>
</html>