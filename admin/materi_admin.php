<?php
session_start();
include "../config/koneksi.php";
include "../assets/menu/admin-navbar.php";

// Proteksi Admin
if (!isset($_SESSION['status_login']) || $_SESSION['role'] != 'admin') {
    header("location:../auth/login.php?pesan=denied");
    exit;
}

$nama = $_SESSION['nama'];
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Materi - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/admin-style.css">
</head>
<body>
    <br>
<div class="main-content">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="page-title">Daftar Materi</h1>
            <p class="page-subtitle">
                Kelola seluruh materi pembelajaran anggota pramuka
            </p>
        </div>
    
        <button class="btn btn-warning shadow-sm"
        data-bs-toggle="modal"
        data-bs-target="#modalTambah">
            <i class="fa fa-plus me-2"></i>
            Tambah Materi
        </button>
    </div>
        
        <?php if(isset($_GET['pesan'])): ?>
            <div class="alert alert-info alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert">
                <i class="fa fa-info-circle me-2"></i>
                <?php 
                    if($_GET['pesan'] == 'berhasil') echo "Materi baru berhasil diunggah!";
                    if($_GET['pesan'] == 'terhapus') echo "Materi telah berhasil dihapus!";
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
    
        <div class="card p-4 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Judul Materi</th>
                            <th>Tipe</th>
                            <th>Tanggal Upload</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $query = mysqli_query($conn, "SELECT * FROM materi ORDER BY id_materi DESC");
                        if(mysqli_num_rows($query) > 0) {
                            while($row = mysqli_fetch_assoc($query)): ?>
                            <tr>
                                <td class="fw-bold text-dark"><?= $row['judul_materi'] ?></td>
                                <td><span class="badge bg-secondary text-uppercase"><?= $row['tipe_materi'] ?></span></td>
                                <td><?= date('d/m/Y', strtotime($row['tanggal_upload'])) ?></td>
                                <td class="text-center">
                                    <a href="../materi/hapus_materi.php?id=<?= $row['id_materi'] ?>" class="btn btn-sm btn-outline-danger px-3 rounded-pill" onclick="return confirm('Hapus materi ini?')">
                                        <i class="fa fa-trash me-1"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; 
                        } else { echo "<tr><td colspan='4' class='text-center py-4 text-muted'>Belum ada materi yang diunggah.</td></tr>"; } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3">
            <div class="modal-header border-0">
                <h4 class="fw-bold">Tambah Materi Baru</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../materi/proses_materi.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="fw-bold small mb-1">Judul Materi</label>
                        <input type="text" name="judul" class="form-control shadow-sm" placeholder="Masukkan judul materi" required>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold small mb-1">Tipe Materi</label>
                        <select name="tipe" class="form-select shadow-sm">
                            <option value="PDF">PDF</option>
                            <option value="MP4">Video (MP4)</option>
                            <option value="JPG/PNG">Gambar (JPG/PNG)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold small mb-1">Tanggal Upload</label>
                        <input type="date" name="tanggal" class="form-control shadow-sm" value="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold small mb-1">Upload File</label>
                        <div class="upload-area shadow-sm">
                            <input type="file" name="berkas" class="form-control mb-2" required>
                            <small class="text-muted small">PNG, JPG, PDF, MP4</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 d-flex justify-content-between px-3">
                    <button type="button" class="btn btn-light px-4 fw-bold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-simpan px-4">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>

window.addEventListener('scroll', function(){

    const navbar = document.querySelector('.navbar');

    if(window.scrollY > 20){
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }

});

</script>
</body>
</html>
<?php include "../assets/menu/footer.php"; ?>