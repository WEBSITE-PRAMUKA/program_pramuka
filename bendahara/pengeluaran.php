<?php
session_start();
include "../config/koneksi.php";
include "../assets/menu/bendahara-navbar.php";

// Proteksi: Hanya Bendahara yang boleh masuk
if (!isset($_SESSION['status_login']) || $_SESSION['role'] != 'bendahara') {
    header("location:../auth/login.php?pesan=denied");
    exit;
}

$nama = $_SESSION['nama'];
$role = $_SESSION['role'];

// --- LOGIKA HITUNG SALDO OTOMATIS ---
$q_masuk = mysqli_query($conn, "SELECT SUM(nominal) as total FROM iuran_anggota");
$d_masuk = mysqli_fetch_assoc($q_masuk);
$total_masuk = $d_masuk['total'] ?? 0;

$q_keluar = mysqli_query($conn, "SELECT SUM(jumlah) as total FROM kas WHERE jenis='keluar'");
$d_keluar = mysqli_fetch_assoc($q_keluar);
$total_keluar = $d_keluar['total'] ?? 0;

$saldo_sekarang = $total_masuk - $total_keluar;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengeluaran Kas - Bendahara</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/bendahara-style.css">
</head>
<body>
    <div class="main-content">

        <div class="container">
            <div class="container py-4">
                <!-- SALDO -->
                <div class="row justify-content-center mb-4">
            
                    <div class="col-lg-6">
            
                        <div class="card saldo-box shadow-sm p-4 text-center">
            
                            <h6 class="text-uppercase opacity-75 small fw-bold">
                                Saldo Kas Saat Ini
                            </h6>
            
                            <h3 class="fw-bold mb-2">
                                Rp <?php echo number_format($saldo_sekarang, 0, ',', '.'); ?>
                            </h3>
            
                            <div class="mt-2 d-flex justify-content-center flex-wrap gap-2">
            
                                <span class="badge bg-success px-3 py-2">
                                    Masuk :
                                    Rp <?php echo number_format($total_masuk, 0, ',', '.'); ?>
                                </span>
            
                                <span class="badge bg-danger px-3 py-2">
                                    Keluar :
                                    Rp <?php echo number_format($total_keluar, 0, ',', '.'); ?>
                                </span>
            
                            </div>
            
                        </div>
            
                    </div>
            
                </div>
            
                <!-- FORM -->
                <div class="row justify-content-center mb-4">
            
                    <div class="col-lg-7">
            
                        <div class="card p-4 border-top border-danger border-4 shadow-sm">
            
                            <h5 class="fw-bold mb-4">
                                Catat Pengeluaran
                            </h5>
            
                            <form action="../keuangan/proses_pengeluaran.php" method="POST">
            
                                <div class="mb-3">
                                    <label class="small fw-bold">
                                        Keterangan
                                    </label>
            
                                    <input type="text"
                                           name="keterangan"
                                           class="form-control"
                                           placeholder="Contoh: Konsumsi"
                                           required>
                                </div>
            
                                <div class="mb-3">
                                    <label class="small fw-bold">
                                        Jumlah Barang / Satuan
                                    </label>
            
                                    <input type="text"
                                           name="jumlah_item"
                                           class="form-control"
                                           placeholder="Contoh: 10 Kotak"
                                           required>
                                </div>
            
                                <div class="mb-3">
                                    <label class="small fw-bold">
                                        Nominal Total (Rp)
                                    </label>
            
                                    <input type="number"
                                           name="jumlah"
                                           class="form-control"
                                           placeholder="0"
                                           required>
                                </div>
            
                                <div class="mb-4">
                                    <label class="small fw-bold">
                                        Tanggal
                                    </label>
            
                                    <input type="date"
                                           name="tanggal"
                                           class="form-control"
                                           value="<?php echo date('Y-m-d'); ?>"
                                           required>
                                </div>
            
                                <button type="submit"
                                        class="btn btn-danger w-100 fw-bold mb-2">
            
                                    <i class="fa fa-save me-2"></i>
                                    Simpan Data
            
                                </button>
            
                                <a href="kas_bendahara.php"
                                   class="btn btn-light w-100 fw-bold small">
            
                                    <i class="fa fa-arrow-left me-2"></i>
                                    Kembali
            
                                </a>
            
                            </form>
            
                        </div>
            
                    </div>
            
                </div>
                <!-- RIWAYAT -->
                <div class="row justify-content-center">
            
                    <div class="col-lg-9">
            
                        <div class="card p-4 shadow-sm">
            
                            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            
                                <h5 class="fw-bold mb-0 text-muted small text-uppercase">
                                    Riwayat Pengeluaran
                                </h5>
            
                                <a href="generate_pdf_pengeluaran.php"
                                   class="btn btn-sm btn-outline-danger">
            
                                    <i class="fa fa-file-pdf me-1"></i>
                                    Unduh PDF
            
                                </a>
            
                            </div>
            
                            <div class="table-responsive">
            
                                <table class="table table-hover align-middle">
            
                                    <thead class="table-light">
            
                                        <tr>
                                            <th>Keterangan</th>
                                            <th>Nominal</th>
                                            <th class="text-center">Hapus</th>
                                        </tr>
            
                                    </thead>
            
                                    <tbody>
            
                                        <?php 
                                        $query = mysqli_query($conn, "SELECT * FROM kas WHERE jenis='keluar' ORDER BY id DESC");
            
                                        if(mysqli_num_rows($query) > 0) {
            
                                            while($row = mysqli_fetch_assoc($query)):
                                        ?>
            
                                        <tr>
            
                                            <td>
            
                                                <span class="fw-bold">
                                                    <?php echo $row['keterangan']; ?>
                                                </span>
            
                                                <span class="badge bg-secondary ms-1">
                                                    <?php echo $row['jumlah_item']; ?>
                                                </span>
            
                                                <br>
            
                                                <small class="text-muted">
                                                    <?php echo date('d/m/Y', strtotime($row['tanggal'])); ?>
                                                </small>
            
                                            </td>
            
                                            <td class="text-danger fw-bold">
                                                - Rp <?php echo number_format($row['jumlah'], 0, ',', '.'); ?>
                                            </td>
            
                                            <td class="text-center">
            
                                                <a href="../keuangan/hapus_pengeluaran.php?id=<?php echo $row['id']; ?>"
                                                   class="btn btn-sm btn-outline-danger"
                                                   onclick="return confirm('Hapus data?')">
            
                                                    <i class="fa fa-trash"></i>
            
                                                </a>
            
                                            </td>
            
                                        </tr>
            
                                        <?php endwhile; } else { ?>
            
                                        <tr>
            
                                            <td colspan="3"
                                                class="text-center py-4 text-muted">
            
                                                Belum ada riwayat pengeluaran.
            
                                            </td>
            
                                        </tr>
            
                                        <?php } ?>
            
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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