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
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Iuran Anggota - Bendahara</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/bendahara-style.css">
</head>
<body>
<div class="container mt-4">
    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card p-4 shadow-sm border-top border-success border-4">
                <h5 class="fw-bold mb-3">Form Input Pembayaran</h5>
                
                <?php if(isset($_GET['pesan']) && $_GET['pesan'] == 'berhasil'): ?>
                    <div class="alert alert-success small py-2">Data berhasil disimpan!</div>
                <?php endif; ?>

                <form action="../keuangan/proses_iuran.php" method="POST">
                    <div class="mb-3">
                        <label class="small fw-bold">Judul Periode</label>
                        <input type="text" name="judul" class="form-control" placeholder="Kas April 2026" required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">Nama Anggota</label>
                        <input type="text" name="nama" class="form-control" placeholder="Nama lengkap" required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">NTA</label>
                        <input type="text" name="nta" class="form-control" placeholder="Nomor Tanda Anggota" required>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="small fw-bold">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="small fw-bold">Nominal</label>
                            <input type="number" name="nominal" class="form-control" placeholder="Rp" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success w-100 mt-2 fw-bold">Simpan Pembayaran</button>
                </form>
                <hr>
                <a href="pengeluaran.php" class="btn btn-danger w-100 rounded-pill fw-bold small">
                    <i class="fa fa-minus-circle me-1"></i> Catat Pengeluaran Kas
                </a>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card p-4 shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">Riwayat Input Terakhir</h5>
                    <a href="generate_pdf_iuran.php" class="btn btn-sm btn-outline-danger">
                        <i class="fa fa-file-pdf me-1"></i> Unduh PDF
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Periode</th>
                                <th>Nama / NTA</th>
                                <th>Nominal</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $query = mysqli_query($conn, "SELECT * FROM iuran_anggota ORDER BY id DESC LIMIT 10");
                            if(mysqli_num_rows($query) > 0) {
                                while($row = mysqli_fetch_assoc($query)): ?>
                                <tr>
                                    <td class="small"><?php echo $row['judul_tanggal']; ?></td>
                                    <td>
                                        <span class="fw-bold"><?php echo $row['nama_anggota']; ?></span><br>
                                        <small class="text-muted"><?php echo $row['nta']; ?></small>
                                    </td>
                                    <td class="text-success fw-bold">Rp <?php echo number_format($row['nominal'], 0, ',', '.'); ?></td>
                                    <td class="text-center">
                                        <a href="../keuangan/hapus_iuran.php?id=<?php echo $row['id']; ?>" class="text-danger" onclick="return confirm('Hapus data ini?')">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endwhile; 
                            } else {
                                echo "<tr><td colspan='4' class='text-center py-4 text-muted'>Belum ada riwayat iuran.</td></tr>";
                            } ?>
                        </tbody>
                    </table>
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