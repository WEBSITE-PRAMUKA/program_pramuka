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
    <title>Gallery Management - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/admin-style.css">
</head>
<body>
    <br><br>
<div class="container">
    <div class="row justify-content-center fade-up">
    <div class="col-lg-8">
        <h1 class="page-title">Gallery Management</h1>
        <p class="page-subtitle">
            Kelola dokumentasi kegiatan pramuka dengan tampilan modern
        </p>
            <div class="card p-4 mb-5">
                <h5 class="fw-bold mb-3">Buat Album Baru</h5>
                <form action="../galeri/proses_galeri.php" method="POST" enctype="multipart/form-data">
                    <div class="card upload-card mb-4 fade-up" onclick="document.getElementById('foto').click()" style="cursor: pointer; text-align: center; padding: 20px; border: 2px dashed #ccc;">
                        <i class="fa fa-upload fa-3x text-muted mb-2"></i>
                        <h6 class="fw-bold">Upload Media</h6>
                        <p class="text-muted small">Ketuk untuk mengupload dokumentasi</p>
                        <input type="file" name="foto" id="foto" class="d-none" required onchange="previewText()">
                        <div id="file-name" class="small text-success fw-bold"></div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="small fw-bold">Judul Album</label>
                            <input type="text" name="judul" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small fw-bold">Kategori</label>
                            <input type="text" name="kategori"class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small fw-bold">Tanggal Pelaksanaan</label>
                            <input type="text" name="tanggal" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small fw-bold">Lokasi</label>
                            <input type="text" name="lokasi" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small fw-bold">Jumlah Peserta</label>
                            <input type="text" name="peserta" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small fw-bold">Deskripsi Singkat</label>
                            <textarea name="deskripsi" class="form-control" rows="2" required></textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success px-4 fw-bold">Upload Album</button>
                </form>
            </div>

            <h5 class="fw-bold mb-3">Album</h5>
            <div class="row">
                <?php 
                $query = mysqli_query($conn, "SELECT * FROM galeri ORDER BY id_galeri DESC");
                while($row = mysqli_fetch_assoc($query)): ?>
                <div class="col-md-6 mb-4">
                    <div class="card h-100 fade-up">
                        <img src="../assets/galeri/<?= $row['foto_cover'] ?>" class="album-img" alt="Cover">
                        <div class="card-body">
                            <h6 class="fw-bold mb-1"><?= $row['judul_galeri'] ?></h6>
                            <div class="d-flex align-items-center mb-3">
                                <span class="badge badge-category me-2"><?= $row['kategori'] ?></span>
                                <small class="text-muted"><i class="fa fa-image me-1"></i> 1 Photo</small>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="#" class="btn btn-sm btn-light border w-100 fw-bold"><i class="fa fa-edit me-1"></i> Edit</a>
                                <a href="hapus_galeri.php?id=<?= $row['id_galeri'] ?>" class="btn btn-sm btn-light border w-100 text-danger fw-bold" onclick="return confirm('Hapus album?')"><i class="fa fa-trash me-1"></i> Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>
<script>
function previewText() {
    const file = document.getElementById('foto').files[0];
    if (file) {
        document.getElementById('file-name').innerHTML = "Selected: " + file.name;
    }
}
</script>
<script>

// navbar blur scroll
window.addEventListener("scroll", function(){
    const navbar = document.querySelector(".navbar");

    if(window.scrollY > 20){
        navbar.classList.add("scrolled");
    } else {
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

function previewText() {
    const file = document.getElementById('foto').files[0];

    if (file) {
        document.getElementById('file-name').innerHTML =
        "Selected: " + file.name;
    }
}

</script>
</body>
</html>
<?php include "../assets/menu/footer.php"; ?>