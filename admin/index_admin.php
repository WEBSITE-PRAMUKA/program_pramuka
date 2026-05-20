<?php
session_start();
include "../config/koneksi.php";
include "../assets/menu/admin-navbar.php";


if (!isset($_SESSION['status_login']) || $_SESSION['role'] != 'admin') {
    header("location:../auth/login.php?pesan=denied");
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

// === DATA GRAFIK ===
$bulan_arr = ['Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

// Ambil data real dari database
$data_pemasukan_real = array_fill(0, 9, 0);
$query_masuk = "SELECT MONTH(tanggal_bayar) as bulan, SUM(nominal) as total 
                FROM iuran_anggota WHERE YEAR(tanggal_bayar) = 2026 GROUP BY MONTH(tanggal_bayar)";
$result_masuk = mysqli_query($conn, $query_masuk);
if ($result_masuk) {
    while ($row = mysqli_fetch_assoc($result_masuk)) {
        $index = $row['bulan'] - 4;
        if ($index >= 0 && $index < 9) $data_pemasukan_real[$index] = (int)$row['total'];
    }
}

$data_pengeluaran_real = array_fill(0, 9, 0);
$query_keluar = "SELECT MONTH(tanggal) as bulan, SUM(jumlah) as total 
                 FROM kas WHERE YEAR(tanggal) = 2026 AND jenis = 'keluar' GROUP BY MONTH(tanggal)";
$result_keluar = mysqli_query($conn, $query_keluar);
if ($result_keluar) {
    while ($row = mysqli_fetch_assoc($result_keluar)) {
        $index = $row['bulan'] - 4;
        if ($index >= 0 && $index < 9) $data_pengeluaran_real[$index] = (int)$row['total'];
    }
}

// Jika data real kosong, gunakan data simulasi yang lebih dinamis
$has_real_data = array_sum($data_pemasukan_real) > 0 || array_sum($data_pengeluaran_real) > 0;

if (!$has_real_data) {
    // Data simulasi dinamis (naik turun natural)
    $data_pemasukan = [150000, 95000, 120000, 80000, 175000, 130000, 160000, 110000, 190000];
    $data_pengeluaran = [70000, 45000, 85000, 30000, 95000, 50000, 75000, 40000, 90000];
} else {
    // Gunakan data real + prediksi untuk bulan depan
    $data_pemasukan = $data_pemasukan_real;
    $data_pengeluaran = $data_pengeluaran_real;
    
    // Isi bulan kosong dengan estimasi
    $last_masuk = 0;
    $last_keluar = 0;
    for ($i = 0; $i < 9; $i++) {
        if ($data_pemasukan[$i] > 0) $last_masuk = $data_pemasukan[$i];
        if ($data_pengeluaran[$i] > 0) $last_keluar = $data_pengeluaran[$i];
        
        if ($data_pemasukan[$i] == 0 && $i > 0) {
            // Variasi random sekitar nilai terakhir
            $variation = rand(-20, 20) / 100;
            $data_pemasukan[$i] = round($last_masuk * (1 + $variation));
        }
        if ($data_pengeluaran[$i] == 0 && $i > 0) {
            $variation = rand(-15, 15) / 100;
            $data_pengeluaran[$i] = round($last_keluar * (1 + $variation));
        }
    }
}

// Hitung saldo
$saldo_awal = 80000;
$data_saldo = [];
$saldo_kumulatif = $saldo_awal;
foreach ($data_pemasukan as $i => $masuk) {
    $keluar = $data_pengeluaran[$i];
    $saldo_kumulatif += ($masuk - $keluar);
    $data_saldo[] = $saldo_kumulatif;
}

// Fungsi untuk membuat path kurva halus (cubic bezier)
function makeSmoothPath($points, $width = 460, $height = 150, $padding_left = 40, $padding_top = 20) {
    $all_y = array_column($points, 'v');
    $max_val = max($all_y);
    $min_val = min($all_y);

    if ($max_val == $min_val) $max_val = $min_val + 50000;

    $range = $max_val - $min_val;
    $max_val += $range * 0.2;
    $range = $max_val - $min_val;

    $count = count($points);
    $chart_width = $width - $padding_left - 30;
    $x_step = $count > 1 ? $chart_width / ($count - 1) : 0;

    // Convert ke koordinat
    $coords = [];
    foreach ($points as $i => $p) {
        $x = $padding_left + ($i * $x_step);
        $y = $padding_top + $height - (($p['v'] - $min_val) / $range * $height);
        $coords[] = ['x' => $x, 'y' => $y, 'v' => $p['v']];
    }

    // Smooth path (lebih modern)
    $path = "M {$coords[0]['x']} {$coords[0]['y']}";

    for ($i = 0; $i < count($coords) - 1; $i++) {
        $p0 = $coords[max($i - 1, 0)];
        $p1 = $coords[$i];
        $p2 = $coords[$i + 1];
        $p3 = $coords[min($i + 2, count($coords) - 1)];

        $cp1x = $p1['x'] + ($p2['x'] - $p0['x']) / 6;
        $cp1y = $p1['y'] + ($p2['y'] - $p0['y']) / 6;

        $cp2x = $p2['x'] - ($p3['x'] - $p1['x']) / 6;
        $cp2y = $p2['y'] - ($p3['y'] - $p1['y']) / 6;

        $path .= " C $cp1x $cp1y, $cp2x $cp2y, {$p2['x']} {$p2['y']}";
    }

    return ['path' => $path, 'coords' => $coords, 'max_val' => $max_val, 'min_val' => $min_val];
}

function rp($n) { return 'Rp '.number_format($n,0,',','.'); }

// Format data untuk fungsi
$pts_masuk = [];
foreach ($data_pemasukan as $v) $pts_masuk[] = ['v' => $v];
$pts_keluar = [];
foreach ($data_pengeluaran as $v) $pts_keluar[] = ['v' => $v];
$pts_saldo = [];
foreach ($data_saldo as $v) $pts_saldo[] = ['v' => $v];

$chart_masuk = makeSmoothPath($pts_masuk);
$chart_keluar = makeSmoothPath($pts_keluar);
$chart_saldo = makeSmoothPath($pts_saldo);

// Max global untuk label Y
$max_global = max($chart_masuk['max_val'], $chart_keluar['max_val'], $chart_saldo['max_val']);
$max_global = ceil($max_global / 50000) * 50000;
if ($max_global < 100000) $max_global = 200000;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - <?php echo $nama ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/admin-style.css">
</head>
<body>
    <div class="main-content">
        <div class="container py-4">
            <h3 class="fw-bold md-1">Selamat Datang, <?php echo $nama ?>!</h3>
            <p class="text-muted">Status Akses: <span class="badge-role"><?php echo ucfirst($role) ?></span></p>
        
            <!-- Profil Admin -->
            <div class="card p-4 mt-3 border-top border-success border-4 profile-card reveal">
                <h6 class="mb-3 fw-bold text-muted">PROFIL ADMINISTRATOR</h6>
                <div class="row">
                    <div class="col-md-3"><h6><?php echo $nama ?></h6><small class="text-muted">Nama</small></div>
                    <div class="col-md-3"><h6><?php echo $nta ?></h6><small class="text-muted">NTA/ID</small></div>
                    <div class="col-md-3"><h6><?php echo $gugus ?></h6><small class="text-muted">Otoritas</small></div>
                    <div class="col-md-3"><span class="badge bg-success">Online</span></div>
                </div>
            </div>
        
            <!-- MENU ADMIN -->
<h5 class="section-title reveal">
    <i class="fa fa-layer-group text-success"></i>
    Manajemen Sistem
</h5>

<div class="row mt-3">

    <!-- KELOLA ANGGOTA -->
    <div class="col-md-3 col-6 mb-4 reveal">
        <a href="manajemen_anggota.php" class="quick-card admin-card-green">

            <div class="quick-icon">
                <i class="fa fa-users-cog"></i>
            </div>

            <h6>Kelola Anggota</h6>

            <small>
                Data seluruh anggota
            </small>

        </a>
    </div>

    <!-- KEGIATAN -->
    <div class="col-md-3 col-6 mb-4 reveal">
        <a href="kegiatan_admin.php" class="quick-card admin-card-blue">

            <div class="quick-icon">
                <i class="fa fa-calendar-plus"></i>
            </div>

            <h6>Kegiatan</h6>

            <small>
                Kelola agenda kegiatan
            </small>

        </a>
    </div>

    <!-- ABSENSI -->
    <div class="col-md-3 col-6 mb-4 reveal">
        <a href="absensi_admin.php" class="quick-card admin-card-dark">

            <div class="quick-icon">
                <i class="fa fa-shield-alt"></i>
            </div>

            <h6>Absensi</h6>

            <small>
                Monitoring kehadiran
            </small>

        </a>
    </div>

    <!-- MATERI -->
    <div class="col-md-3 col-6 mb-4 reveal">
        <a href="materi_admin.php" class="quick-card admin-card-orange">

            <div class="quick-icon">
                <i class="fa fa-book-open"></i>
            </div>

            <h6>Materi</h6>

            <small>
                Upload materi pembelajaran
            </small>

        </a>
    </div>

</div>
        
            <!-- ========== GRAFIK KEUANGAN ========== -->
            <h5 class="section-title"><i class="fa fa-chart-line text-success"></i> Grafik Keuangan Organisasi</h5>
        
            <!-- Grafik Pemasukan -->
            <div class="chart-card reveal-left">
                <div class="chart-header-row">
                    <div>
                        <h6 class="overview-title">Pemasukan</h6>
                        <div class="overview-total"><?php echo rp(array_sum($data_pemasukan)); ?></div>
                        <small class="overview-desc">Total pemasukan tahun ini</small>
                    </div>
                    <div class="text-end">
                        <span class="overview-badge">+4.2%</span>
                        <div class="overview-sub">dibanding bulan lalu</div>
                    </div>
                </div>
                <svg class="chart-svg" viewBox="0 0 500 220">
                    <defs>
                        <linearGradient id="gradMasukAdmin" x1="0%" y1="0%" x2="0%" y2="100%">
                            <stop offset="0%" style="stop-color:#4a90d9;stop-opacity:0.35" />
                            <stop offset="40%" style="stop-color:#4a90d9;stop-opacity:0.1" />
                            <stop offset="100%" style="stop-color:#4a90d9;stop-opacity:0.02" />
                        </linearGradient>
                        <filter id="shadowMasuk">
                            <feDropShadow dx="0" dy="2" stdDeviation="3" flood-color="#4a90d9" flood-opacity="0.3"/>
                        </filter>
                    </defs>
                    
                    <!-- Grid -->
                    <?php for($i=0; $i<=4; $i++): 
                        $y = 25 + (160/4)*$i;
                        $val = round(($max_global/4)*(4-$i));
                    ?>
                    <line x1="45" y1="<?php echo $y; ?>" x2="480" y2="<?php echo $y; ?>" stroke="#e8ecf1" stroke-width="1" <?php if($i>0 && $i<4) echo 'stroke-dasharray="5,5"'; ?>/>
                    <text x="36" y="<?php echo $y+4; ?>" text-anchor="end" font-size="10" fill="#aaa" font-family="Arial"><?php echo number_format($val,0,',','.'); ?></text>
                    <?php endfor; ?>
                    
                    <!-- Area fill -->
                    <path d="<?php echo $chart_masuk['path']; ?> L 480 185 L 45 185 Z" fill="url(#gradMasukAdmin)"/>
                    
                    <!-- Line -->
                    <path d="<?php echo $chart_masuk['path']; ?>" fill="none" stroke="#4a90d9" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" filter="url(#shadowMasuk)"/>
                    
                    <!-- Data points -->
                </svg>
                <div class="bulan-labels">
                    <?php foreach($bulan_arr as $b): ?><span><?php echo $b; ?></span><?php endforeach; ?>
                </div>
                <div class="chart-legend-row">
                    <div class="chart-legend-item">
                        <div class="chart-legend-dot" style="background:#4a90d9;"></div>
                        <span>Pemasukan</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    window.addEventListener('scroll', function(){

    const navbar = document.querySelector('.navbar');

    if(window.scrollY > 20){
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }

});
window.addEventListener('scroll', reveal);

function reveal(){
    const reveals = document.querySelectorAll('.reveal, .reveal-left, .reveal-right');

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