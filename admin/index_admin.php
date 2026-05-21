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
$gugus         = "jember";
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
            $variation = rand(-20, 20) / 100;
            $data_pemasukan[$i] = round($last_masuk * (1 + $variation));
        }
        if ($data_pengeluaran[$i] == 0 && $i > 0) {
            $variation = rand(-15, 15) / 100;
            $data_pengeluaran[$i] = round($last_keluar * (1 + $variation));
        }
    }
}

// Hitung saldo kumulatif
$saldo_awal = 80000;
$data_saldo = [];
$saldo_kumulatif = $saldo_awal;
foreach ($data_pemasukan as $i => $masuk) {
    $keluar = $data_pengeluaran[$i];
    $saldo_kumulatif += ($masuk - $keluar);
    $data_saldo[] = $saldo_kumulatif;
}

// Cari nilai tertinggi dari seluruh rangkaian data untuk standarisasi skala Y-Axis
$all_values = array_merge($data_pemasukan, $data_pengeluaran, $data_saldo);
$highest_val = max($all_values);
$max_global_grid = ceil($highest_val / 50000) * 50000;
if ($max_global_grid < 100000) $max_global_grid = 200000;

// Fungsi modifikasi untuk membuat path kurva halus dengan skala seragam (forced max)
function makeSmoothPathUniform($points, $forced_max, $width = 460, $height = 150, $padding_left = 40, $padding_top = 20) {
    $max_val = $forced_max;
    $min_val = 0;
    $range = $max_val - $min_val;
    if ($range <= 0) $range = 1;

    $count = count($points);
    $chart_width = $width - $padding_left - 30;
    $x_step = $count > 1 ? $chart_width / ($count - 1) : 0;

    $coords = [];
    foreach ($points as $i => $p) {
        $x = $padding_left + ($i * $x_step);
        $y = $padding_top + $height - (($p['v'] - $min_val) / $range * $height);
        $coords[] = ['x' => $x, 'y' => $y, 'v' => $p['v']];
    }

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

    return ['path' => $path, 'coords' => $coords];
}

function rp($n) { return 'Rp '.number_format($n,0,',','.'); }

$pts_masuk = [];
foreach ($data_pemasukan as $v) $pts_masuk[] = ['v' => $v];
$pts_keluar = [];
foreach ($data_pengeluaran as $v) $pts_keluar[] = ['v' => $v];

$chart_masuk = makeSmoothPathUniform($pts_masuk, $max_global_grid);
$chart_keluar = makeSmoothPathUniform($pts_keluar, $max_global_grid);
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
        
            <div class="card p-4 mt-3 border-top border-success border-4 profile-card reveal">
                <h6 class="mb-3 fw-bold text-muted">PROFIL ADMINISTRATOR</h6>
                <div class="row">
                    <div class="col-md-3"><h6><?php echo $nama ?></h6><small class="text-muted">Nama</small></div>
                    <div class="col-md-3"><h6><?php echo $nta ?></h6><small class="text-muted">NTA/ID</small></div>
                    <div class="col-md-3"><h6><?php echo $gugus ?></h6><small class="text-muted">Kwatir Cabang</small></div>
                    <div class="col-md-3"><span class="badge bg-success">Online</span></div>
                </div>
            </div>
        
            <h5 class="section-title reveal">
                <i class="fa fa-layer-group text-success"></i>
                Manajemen Sistem
            </h5>

            <div class="row mt-3">
                <div class="col-md-3 col-6 mb-4 reveal">
                    <a href="manajemen_anggota.php" class="quick-card admin-card-green">
                        <div class="quick-icon"><i class="fa fa-users-cog"></i></div>
                        <h6>Kelola Anggota</h6>
                        <small>Data seluruh anggota</small>
                    </a>
                </div>

                <div class="col-md-3 col-6 mb-4 reveal">
                    <a href="kegiatan_admin.php" class="quick-card admin-card-blue">
                        <div class="quick-icon"><i class="fa-solid fa-campground"></i></div>
                        <h6>Kegiatan</h6>
                        <small>Kelola agenda kegiatan</small>
                    </a>
                </div>

                <div class="col-md-3 col-6 mb-4 reveal">
                    <a href="absensi_admin.php" class="quick-card admin-card-dark">
                        <div class="quick-icon"><i class="fa-solid fa-calendar-check"></i></div>
                        <h6>Absensi</h6>
                        <small>Monitoring kehadiran</small>
                    </a>
                </div>

                <div class="col-md-3 col-6 mb-4 reveal">
                    <a href="materi_admin.php" class="quick-card admin-card-orange">
                        <div class="quick-icon"><i class="fa fa-book-open"></i></div>
                        <h6>Materi</h6>
                        <small>Upload materi pembelajaran</small>
                    </a>
                </div>
            </div>
        
            <h5 class="section-title"><i class="fa fa-chart-line text-success"></i> Grafik Keuangan Organisasi</h5>
        
            <div class="chart-card reveal-left">
                <div class="chart-header-row row align-items-center">
                    <div class="col-6">
                        <h6 class="overview-title text-primary"><i class="fa fa-arrow-down me-1"></i> Total Pemasukan</h6>
                        <div class="overview-total text-primary" style="font-size: 1.4rem;"><?php echo rp(array_sum($data_pemasukan)); ?></div>
                    </div>
                    <div class="col-6 text-end">
                        <h6 class="overview-title text-danger"><i class="fa fa-arrow-up me-1"></i> Total Pengeluaran</h6>
                        <div class="overview-total text-danger" style="font-size: 1.4rem;"><?php echo rp(array_sum($data_pengeluaran)); ?></div>
                    </div>
                </div>
                
                <svg class="chart-svg" viewBox="0 0 500 220">
                    <defs>
                        <linearGradient id="gradMasukAdmin" x1="0%" y1="0%" x2="0%" y2="100%">
                            <stop offset="0%" style="stop-color:#4a90d9;stop-opacity:0.25" />
                            <stop offset="100%" style="stop-color:#4a90d9;stop-opacity:0.00" />
                        </linearGradient>
                        <linearGradient id="gradKeluarAdmin" x1="0%" y1="0%" x2="0%" y2="100%">
                            <stop offset="0%" style="stop-color:#dc3545;stop-opacity:0.2" />
                            <stop offset="100%" style="stop-color:#dc3545;stop-opacity:0.00" />
                        </linearGradient>
                        
                        <filter id="shadowMasuk">
                            <feDropShadow dx="0" dy="2" stdDeviation="2" flood-color="#4a90d9" flood-opacity="0.3"/>
                        </filter>
                        <filter id="shadowKeluar">
                            <feDropShadow dx="0" dy="2" stdDeviation="2" flood-color="#dc3545" flood-opacity="0.3"/>
                        </filter>
                    </defs>
                    
                    <?php for($i=0; $i<=4; $i++): 
                        $y = 25 + (160/4)*$i;
                        $val = round(($max_global_grid/4)*(4-$i));
                    ?>
                    <line x1="45" y1="<?php echo $y; ?>" x2="480" y2="<?php echo $y; ?>" stroke="#e8ecf1" stroke-width="1" <?php if($i>0 && $i<4) echo 'stroke-dasharray="5,5"'; ?>/>
                    <text x="36" y="<?php echo $y+4; ?>" text-anchor="end" font-size="10" fill="#aaa" font-family="Arial"><?php echo number_format($val,0,',','.'); ?></text>
                    <?php endfor; ?>
                    
                    <path d="<?php echo $chart_masuk['path']; ?> L 480 185 L 45 185 Z" fill="url(#gradMasukAdmin)"/>
                    <path d="<?php echo $chart_keluar['path']; ?> L 480 185 L 45 185 Z" fill="url(#gradKeluarAdmin)"/>
                    
                    <path d="<?php echo $chart_masuk['path']; ?>" fill="none" stroke="#4a90d9" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" filter="url(#shadowMasuk)"/>
                    <path d="<?php echo $chart_keluar['path']; ?>" fill="none" stroke="#dc3545" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" filter="url(#shadowKeluar)"/>
                </svg>
                
                <div class="bulan-labels">
                    <?php foreach($bulan_arr as $b): ?><span><?php echo $b; ?></span><?php endforeach; ?>
                </div>
                
                <div class="chart-legend-row d-flex justify-content-center gap-4 mt-2">
                    <div class="chart-legend-item d-flex align-items-center gap-2">
                        <div class="chart-legend-dot" style="background:#4a90d9; width:12px; height:12px; border-radius:3px;"></div>
                        <span class="small fw-bold text-muted">Pemasukan (Iuran)</span>
                    </div>
                    <div class="chart-legend-item d-flex align-items-center gap-2">
                        <div class="chart-legend-dot" style="background:#dc3545; width:12px; height:12px; border-radius:3px;"></div>
                        <span class="small fw-bold text-muted">Pengeluaran (Kas Keluar)</span>
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