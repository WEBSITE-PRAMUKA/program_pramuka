<?php
session_start();
include "../config/koneksi.php";
include "../assets/menu/admin-navbar.php";

if (!isset($_SESSION['status_login']) || $_SESSION['role'] != 'admin') {
    header("location:../auth/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Kegiatan - Pembina</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/admin-style.css">
</head>
<body>
    <br><br>
    <div class="main-content">
        <div class="container fade-up">
            <h1 class="page-title">Daftar Jadwal Kegiatan</h1>
            <p class="page-subtitle">
                Kelola seluruh kegiatan pramuka dengan tampilan modern
            </p>
            <div class="card p-4 fade-up">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Gambar</th>
                                <th>Judul & Lokasi</th>
                                <th>Tanggal</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $query = mysqli_query($conn, "SELECT * FROM kegiatan ORDER BY id_kegiatan DESC");
                            while($row = mysqli_fetch_assoc($query)): ?>
                            <tr>
                                <td><img src="../assets/kegiatan/<?= $row['gambar'] ?>" class="kegiatan-img"></td>
                                <td>
                                    <span class="fw-bold"><?= $row['judul'] ?></span><br>
                                    <small class="text-muted"><i class="fa fa-map-marker-alt"></i> <?= $row['lokasi'] ?></small>
                                </td>
                                <td><small><?= $row['tanggal'] ?></small></td>
                                <td class="text-center">
                                    <a href="hapus_kegiatan.php?id=<?= $row['id_kegiatan'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus kegiatan ini?')"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                    <button class="btn btn-danger fw-bold rounded-pill px-4 py-2 shadow-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#modalKegiatan">
                    
                    <i class="fa fa-plus me-1"></i>
                    Tambah Kegiatan
                    </button>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="modalKegiatan" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="border-radius: 20px;">
                    <div class="modal-header border-0">
                        <h5 class="fw-bold">Tambah Kegiatan Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="../kegiatan/proses_kegiatan.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="small fw-bold">Judul Kegiatan</label>
                                <input type="text" name="judul" class="form-control"  required>
                            </div>
                            <div class="mb-3">
                                <label class="small fw-bold">Tanggal</label>
                                <input type="date" name="tanggal" class="form-control"  required>
                            </div>
                            <div class="mb-3">
                                <label class="small fw-bold">Lokasi</label>
                                <input type="text" name="lokasi" class="form-control"  required>
                            </div>
                            <div class="mb-3">
                                <label class="small fw-bold">Deskripsi Singkat</label>
                                <textarea name="deskripsi" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="small fw-bold">Upload Gambar Utama</label>
                                <input type="file" name="gambar" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="submit" class="btn btn-danger w-100 fw-bold py-2">Simpan Kegiatan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>

// navbar effect
window.addEventListener("scroll", function(){

    const navbar = document.querySelector(".navbar");

    if(window.scrollY > 20){
        navbar.classList.add("scrolled");
    }else{
        navbar.classList.remove("scrolled");
    }

});

// animasi scroll
const fadeElements = document.querySelectorAll('.fade-up');

const observer = new IntersectionObserver((entries)=>{
    entries.forEach(entry=>{
        if(entry.isIntersecting){
            entry.target.classList.add('show');
        }
    });
},{
    threshold:0.1
});

fadeElements.forEach(el=>{
    observer.observe(el);
});

</script>
</body>
</html>
<?php include "../assets/menu/footer.php"; ?>