<?php
session_start();
include "../config/koneksi.php";
include "../assets/menu/bendahara-navbar.php";

if (
    !isset($_SESSION['status_login']) || 
    !in_array($_SESSION['role'], ['anggota', 'bendahara'])
) {
    header("location:../auth/login.php?pesan=denied");
    exit;
}

$nama   = $_SESSION['nama'];
$role   = $_SESSION['role'];
$nta    = $_SESSION['nta'];

$gugus       = "12-001";
$status      = "Aktif";
$event_count = "3";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Bendahara</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/bendahara-style.css">
</head>
<body>

<div class="main-content">

    <div class="container py-4">

        <!-- HEADER -->
        <div class="mb-4 reveal">

            <h3 class="fw-bold mb-1">
                Selamat Datang, <?= $nama ?>!
            </h3>

            <p class="text-muted">
                NTA : <?= $nta ?>
                |
                Status :
                <span class="badge-role">
                    Bendahara
                </span>
            </p>

        </div>

        <!-- PROFILE -->
        <div class="card p-4 mt-3 border-top border-success border-4 profile-card reveal">

            <h6 class="mb-3 fw-bold text-muted">
                DATA BENDAHARA
            </h6>

            <div class="row">

                <div class="col-md-3 col-6 mb-3">
                    <small class="text-muted">Nama Lengkap</small>
                    <h6 class="fw-bold mt-1"><?= $nama ?></h6>
                </div>

                <div class="col-md-3 col-6 mb-3">
                    <small class="text-muted">NTA</small>
                    <h6 class="fw-bold mt-1"><?= $nta ?></h6>
                </div>

                <div class="col-md-3 col-6 mb-3">
                    <small class="text-muted">Gugus Depan</small>
                    <h6 class="fw-bold mt-1"><?= $gugus ?></h6>
                </div>

                <div class="col-md-3 col-6 mb-3">
                    <small class="text-muted">Status</small>
                    <br>
                    <span class="badge bg-success px-3 py-2 rounded-pill">
                        <?= $status ?>
                    </span>
                </div>

            </div>

        </div>

        <!-- MENU -->
        <h5 class="section-title reveal">
            <i class="fa fa-layer-group text-success"></i>
            Menu Utama
        </h5>

        <div class="row mt-3">

            <!-- INPUT KAS -->
            <div class="col-md-3 col-6 mb-4 reveal">
                <a href="kas_bendahara.php" class="quick-card bendahara-green">

                    <div class="quick-icon">
                        <i class="fa fa-wallet"></i>
                    </div>

                    <h6>Input Kas</h6>

                    <small>
                        Catat Iuran
                    </small>

                </a>
            </div>

            <!-- PENGELUARAN -->
            <div class="col-md-3 col-6 mb-4 reveal">
                <a href="pengeluaran.php" class="quick-card bendahara-red">

                    <div class="quick-icon">
                        <i class="fa fa-money-bill-wave"></i>
                    </div>

                    <h6>Pengeluaran</h6>

                    <small>
                        Kelola Kas Keluar
                    </small>

                </a>
            </div>

            <!-- DATA KAS -->
            <div class="col-md-3 col-6 mb-4 reveal">
                <a href="../anggota/absensi_anggota.php" class="quick-card bendahara-blue">

                    <div class="quick-icon">
                        <i class="fa fa-qrcode"></i>
                    </div>

                    <h6>Presensi</h6>

                    <small>
                        Scan Kehadiran
                    </small>

                </a>
            </div>

            <!-- KEGIATAN -->
            <div class="col-md-3 col-6 mb-4 reveal">
                <a href="../anggota/kegiatan_anggota.php" class="quick-card bendahara-orange">

                    <div class="quick-icon">
                        <i class="fa fa-calendar-check"></i>
                    </div>

                    <h6>Kegiatan</h6>

                    <small>
                        Event
                    </small>

                </a>
            </div>

        </div>

    </div>

</div>
<script>

window.addEventListener('scroll', function(){

    const navbar = document.querySelector('.navbar');

    if(window.scrollY > 20){
        navbar.classList.add('scrolled');
    }else{
        navbar.classList.remove('scrolled');
    }

});

window.addEventListener('scroll', reveal);

function reveal(){

    const reveals = document.querySelectorAll('.reveal');

    for(let i = 0; i < reveals.length; i++){

        let windowHeight = window.innerHeight;
        let elementTop = reveals[i].getBoundingClientRect().top;
        let elementVisible = 100;

        if(elementTop < windowHeight - elementVisible){
            reveals[i].classList.add('active');
        }

    }

}

reveal();

</script>

</body>
</html>
<?php include "../assets/menu/footer.php"; ?>