<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['status_login']) || $_SESSION['role'] != 'admin') {
    header("location:login.php?pesan=denied");
    exit;
}

$nama = $_SESSION['nama'];
$role = $_SESSION['role'];
$nta  = $_SESSION['nta'];

// Data Statis Admin
$gugus         = "Kwartir Cabang";
$status_label  = "Administrator";
$total_anggota = "120";
$kas_total     = "Rp 5.000.000";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - <?php echo $nama ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
        body { background:#f5f1ed; }
        .navbar { background:#ffffff; box-shadow:0 2px 5px rgba(0,0,0,0.1); }
        .card { border:none; border-radius:15px; box-shadow:0 4px 10px rgba(0,0,0,0.05); }
        .quick-card { padding:25px; text-align:center; transition:0.3s; cursor: pointer; text-decoration: none; color: inherit; display: block; }
        .quick-card:hover { transform:translateY(-5px); background: #fff; box-shadow: 0 6px 15px rgba(0,0,0,0.1); }
        .footer { background:#5c3a2e; color:white; padding:40px 0; margin-top:50px; }
        .badge-role { background:#6b4a3c; color:white; padding:3px 10px; border-radius:5px; font-size: 0.75rem; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">Pramuka <span class="text-danger">Admin</span></a>
        <a href="logout.php" class="btn btn-outline-danger btn-sm rounded-pill px-3">Logout</a>
    </div>
</nav>

<div class="container mt-4">
    <h3 class="fw-bold">Selamat Datang, <?php echo $nama ?>!</h3>
    <p class="text-muted">Status Akses: <span class="badge-role"><?php echo ucfirst($role) ?></span></p>

    <div class="card p-4 mt-3 border-top border-danger border-4">
        <h6 class="mb-3 fw-bold text-muted">PROFIL ADMINISTRATOR</h6>
        <div class="row">
            <div class="col-md-3"><h6><?php echo $nama ?></h6><small class="text-muted">Nama</small></div>
            <div class="col-md-3"><h6><?php echo $nta ?></h6><small class="text-muted">NTA/ID</small></div>
            <div class="col-md-3"><h6><?php echo $gugus ?></h6><small class="text-muted">Otoritas</small></div>
            <div class="col-md-3"><span class="badge bg-success">System Active</span></div>
        </div>
    </div>

    <h5 class="mt-4 fw-bold">Manajemen Sistem</h5>
    <div class="row mt-3">
        <div class="col-md-3 col-6 mb-3">
            <a href="#" class="card quick-card"><i class="fa fa-users-cog fa-2x text-danger mb-2"></i><h6>Kelola Anggota</h6></a>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <a href="#" class="card quick-card"><i class="fa fa-calendar-plus fa-2x text-primary mb-2"></i><h6>Buat Event</h6></a>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <a href="#" class="card quick-card"><i class="fa fa-shield-alt fa-2x text-dark mb-2"></i><h6>Keamanan</h6></a>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <a href="#" class="card quick-card"><i class="fa fa-print fa-2x text-secondary mb-2"></i><h6>Laporan PDF</h6></a>
        </div>
    </div>
</div>

<div class="footer text-center"><small>© 2026 Gerakan Pramuka Indonesia - Admin Panel</small></div>
</body>
</html>