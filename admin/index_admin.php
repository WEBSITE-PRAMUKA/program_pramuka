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
$total_anggota = "120"; // Ini bisa Anda buat dinamis kedepannya

// === DATA GRAFIK & KEUANGAN ===
// Standarisasi untuk 12 Bulan
$bulan_arr = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
$tahun_ini = 2026; // Anda bisa ubah menjadi date('Y') jika ingin otomatis tahun berjalan

$data_pemasukan = array_fill(0, 12, 0);
$data_pengeluaran = array_fill(0, 12, 0);

// 1. Ambil Grand Total Pemasukan (Iuran Anggota + Kas Masuk)
$query_total_masuk = mysqli_query($conn, "
    SELECT 
        (SELECT COALESCE(SUM(nominal), 0) FROM iuran_anggota) + 
        (SELECT COALESCE(SUM(jumlah), 0) FROM kas WHERE jenis = 'masuk') AS total
");
$total_pemasukan_all = mysqli_fetch_assoc($query_total_masuk)['total'];

// 2. Ambil Grand Total Pengeluaran (Kas Keluar)
$query_total_keluar = mysqli_query($conn, "
    SELECT COALESCE(SUM(jumlah), 0) AS total FROM kas WHERE jenis = 'keluar'
");
$total_pengeluaran_all = mysqli_fetch_assoc($query_total_keluar)['total'];

// 3. Ambil Data Pemasukan per Bulan untuk Grafik (Digabung Iuran & Kas Masuk)
$query_masuk_chart = mysqli_query($conn, "
    SELECT bulan, SUM(total) as total_per_bulan FROM (
        SELECT MONTH(tanggal_bayar) as bulan, nominal as total FROM iuran_anggota WHERE YEAR(tanggal_bayar) = '$tahun_ini'
        UNION ALL
        SELECT MONTH(tanggal) as bulan, jumlah as total FROM kas WHERE jenis = 'masuk' AND YEAR(tanggal) = '$tahun_ini'
    ) AS gabungan_masuk GROUP BY bulan
");
if ($query_masuk_chart) {
    while ($row = mysqli_fetch_assoc($query_masuk_chart)) {
        $index = $row['bulan'] - 1;
        if ($index >= 0 && $index < 12) {
            $data_pemasukan[$index] = (int)$row['total_per_bulan'];
        }
    }
}

// 4. Ambil Data Pengeluaran per Bulan untuk Grafik (Kas Keluar)
$query_keluar_chart = mysqli_query($conn, "
    SELECT MONTH(tanggal) as bulan, SUM(jumlah) as total 
    FROM kas WHERE YEAR(tanggal) = '$tahun_ini' AND jenis = 'keluar' GROUP BY MONTH(tanggal)
");
if ($query_keluar_chart) {
    while ($row = mysqli_fetch_assoc($query_keluar_chart)) {
        $index = $row['bulan'] - 1;
        if ($index >= 0 && $index < 12) {
            $data_pengeluaran[$index] = (int)$row['total'];
        }
    }
}

// Cari nilai tertinggi untuk standarisasi skala Y-Axis grafik
$highest_val = max(array_merge($data_pemasukan, $data_pengeluaran));
if ($highest_val == 0) $highest_val = 100000; // Skala minimum jika data masih 0
$max_global_grid = ceil($highest_val / 50000) * 50000;
if ($max_global_grid < 100000) $max_global_grid = 100000;

// Fungsi pembuatan kurva SVG (Tanpa diubah)
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

$pts_masuk = []; foreach ($data_pemasukan as $v) $pts_masuk[] = ['v' => $v];
$pts_keluar = []; foreach ($data_pengeluaran as $v) $pts_keluar[] = ['v' => $v];

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
                        <div class="overview-total text-primary" style="font-size: 1.4rem;"><?php echo rp($total_pemasukan_all); ?></div>
                    </div>
                    <div class="col-6 text-end">
                        <h6 class="overview-title text-danger"><i class="fa fa-arrow-up me-1"></i> Total Pengeluaran</h6>
                        <div class="overview-total text-danger" style="font-size: 1.4rem;"><?php echo rp($total_pengeluaran_all); ?></div>
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
                        <span class="small fw-bold text-muted">Pemasukan (Iuran + Kas Masuk)</span>
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