<?php
session_start();
include "../config/koneksi.php";
include "../assets/menu/anggota-navbar.php";

if (!isset($_SESSION['status_login']) || $_SESSION['role'] != 'anggota') {
    header("location:../auth/login.php?pesan=denied");
    exit;
}

$nama   = $_SESSION['nama'];
$role   = $_SESSION['role'];
$nta    = $_SESSION['nta'];

$gugus         = "12-001";
$status        = "Aktif";
$kehadiran     = "8/10";
$event_count   = "3";

// === DATA GRAFIK IURAN PRIBADI ===
$bulan_arr = ['Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

// Ambil data real iuran anggota
$data_iuran_real = array_fill(0, 9, 0);
$query_iuran = "SELECT MONTH(tanggal_bayar) as bulan, SUM(nominal) as total 
                FROM iuran_anggota 
                WHERE nta = '$nta' AND YEAR(tanggal_bayar) = 2026 
                GROUP BY MONTH(tanggal_bayar)";
$result_iuran = mysqli_query($conn, $query_iuran);
if ($result_iuran) {
    while ($row = mysqli_fetch_assoc($result_iuran)) {
        $index = $row['bulan'] - 4;
        if ($index >= 0 && $index < 9) $data_iuran_real[$index] = (int)$row['total'];
    }
}

// Jika ada data real, gunakan; jika tidak, data simulasi
$has_real_data = array_sum($data_iuran_real) > 0;

if (!$has_real_data) {
    // Data simulasi dinamis untuk contoh
    $data_iuran = [10000, 0, 10000, 0, 10000, 0, 10000, 0, 10000];
} else {
    $data_iuran = $data_iuran_real;
    // Prediksi bulan berikutnya
    $last_val = 0;
    for ($i = 0; $i < 9; $i++) {
        if ($data_iuran[$i] > 0) $last_val = $data_iuran[$i];
        if ($data_iuran[$i] == 0 && $i > 0 && $last_val > 0) {
            $data_iuran[$i] = $last_val; // Asumsikan bayar sama
        }
    }
}

// Fungsi kurva halus untuk anggota
function makeSmoothPathAnggota($values, $width = 460, $height = 150, $padding_left = 40, $padding_top = 20) {
    $max_val = max($values);
    $min_val = min($values);
    
    if ($max_val == $min_val) $max_val = $min_val + 20000;
    
    $range = $max_val - $min_val;
    $max_val = $max_val + ($range * 0.3);
    $range = $max_val - $min_val;
    
    $count = count($values);
    $chart_width = $width - $padding_left - 30;
    $x_step = $count > 1 ? $chart_width / ($count - 1) : 0;
    
    $coords = [];
    foreach ($values as $i => $v) {
        $x = $padding_left + ($i * $x_step);
        $y = $padding_top + $height - (($v - $min_val) / $range * $height);
        $coords[] = ['x' => round($x, 1), 'y' => round($y, 1), 'v' => $v];
    }
    
    $path = "M {$coords[0]['x']} {$coords[0]['y']}";
    
    for ($i = 0; $i < count($coords) - 1; $i++) {
        $current = $coords[$i];
        $next = $coords[$i + 1];
        
        $cp1x = $current['x'] + ($next['x'] - $current['x']) / 3;
        $cp1y = $current['y'];
        $cp2x = $next['x'] - ($next['x'] - $current['x']) / 3;
        $cp2y = $next['y'];
        
        $path .= " C {$cp1x} {$cp1y}, {$cp2x} {$cp2y}, {$next['x']} {$next['y']}";
    }
    
    return ['path' => $path, 'coords' => $coords, 'max_val' => $max_val, 'min_val' => $min_val];
}

function rpAnggota($n) { return 'Rp '.number_format($n,0,',','.'); }

$chart_iuran = makeSmoothPathAnggota($data_iuran);
$total_iuran = array_sum($data_iuran);

$max_global = $chart_iuran['max_val'];
$max_global = ceil($max_global / 10000) * 10000;
if ($max_global < 30000) $max_global = 30000;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Anggota - <?php echo $nama ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="../assets/css/anggota-style.css">
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
                    Anggota
                </span>
            </p>
        </div>

        <!-- PROFILE -->
        <div class="card p-4 mt-3 border-top border-primary border-4 profile-card reveal">

            <h6 class="mb-3 fw-bold text-muted">
                PROFIL ANGGOTA
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
<br>
        <!-- MENU UTAMA -->
<h5 class="section-title reveal">
    <i class="fa fa-layer-group text-primary"></i>
    Menu Utama
</h5>

<div class="row mt-3">

    <!-- PRESENSI -->
    <div class="col-md-3 col-6 mb-4 reveal">
        <a href="absensi_anggota.php" class="quick-card anggota-card-blue">

            <div class="quick-icon">
                <i class="fa fa-qrcode"></i>
            </div>

            <h6>Presensi</h6>

            <small>
                Scan Kehadiran
            </small>

        </a>
    </div>

    <!-- KAS -->
    <div class="col-md-3 col-6 mb-4 reveal">
        <a href="galeri_anggota.php" class="quick-card anggota-card-green">

            <div class="quick-icon">
                <i class="fa fa-image"></i>
            </div>

            <h6>Galeri</h6>

            <small>
                Lihat Kegiatan
            </small>

        </a>
    </div>

    <!-- MATERI -->
    <div class="col-md-3 col-6 mb-4 reveal">
        <a href="materi_anggota.php" class="quick-card anggota-card-orange">

            <div class="quick-icon">
                <i class="fa fa-book-open"></i>
            </div>

            <h6>Materi</h6>

            <small>
                Modul Pembelajaran
            </small>

        </a>
    </div>

    <!-- KEGIATAN -->
    <div class="col-md-3 col-6 mb-4 reveal">
        <a href="kegiatan_anggota.php" class="quick-card anggota-card-red">

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

        <!-- RIWAYAT -->
        <div class="card p-4 mt-4 reveal-right">

            <div class="d-flex justify-content-between align-items-center mb-3">

                <h5 class="fw-bold mb-0">
                    <i class="fa fa-history text-warning me-2"></i>
                    Riwayat Iuran
                </h5>

                <span class="badge bg-light text-dark border">
                    Data Realtime
                </span>

            </div>

            <div class="table-responsive">

                <table class="table align-middle table-hover">

                    <thead>

                        <tr>
                            <th>Periode</th>
                            <th>Tanggal</th>
                            <th>Nominal</th>
                            <th class="text-center">Status</th>
                        </tr>

                    </thead>

                    <tbody>

                    <?php
                    $query_iuran_tabel = mysqli_query($conn,
                    "SELECT * FROM iuran_anggota
                    WHERE nta='$nta'
                    ORDER BY tanggal_bayar DESC");

                    if(mysqli_num_rows($query_iuran_tabel) > 0){

                        while($iuran = mysqli_fetch_assoc($query_iuran_tabel)){
                    ?>

                        <tr>

                            <td class="fw-bold">
                                <?= $iuran['judul_tanggal']; ?>
                            </td>

                            <td>
                                <?= date('d M Y', strtotime($iuran['tanggal_bayar'])); ?>
                            </td>

                            <td class="text-success fw-bold">
                                Rp <?= number_format($iuran['nominal'],0,',','.'); ?>
                            </td>

                            <td class="text-center">
                                <span class="badge bg-success rounded-pill px-3">
                                    Lunas
                                </span>
                            </td>

                        </tr>

                    <?php
                        }

                    } else {
                    ?>

                    <tr>

                        <td colspan="4"
                            class="text-center py-5 text-muted">

                            Belum ada data pembayaran

                        </td>

                    </tr>

                    <?php } ?>

                    </tbody>

                </table>

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