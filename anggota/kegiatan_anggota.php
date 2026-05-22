<?php
session_start();
include "../config/koneksi.php";
include "../assets/menu/anggota-navbar.php";

// Proteksi: Pastikan user sudah login
if (!isset($_SESSION['status_login'])) {
    header("location:../auth/login.php");
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
    <title>Jadwal Kegiatan - Pramuka</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/anggota-style.css">
</head>
<body>
    <div class="main-content">
        <div class="container mt-5">
            <div class="row mb-2">
                <div class="col-12">
                    <h1 class="fw-bold">Kegiatan</h1>
                    <p class="text-muted">Daftar Jadwal Kegiatan Mendatang</p>
                    <hr class="mb-5" style="border-top: 2px dashed #ccc;">
                </div>
            </div>
        
            <div class="row">
                <?php 
                $query = mysqli_query($conn, "SELECT * FROM kegiatan ORDER BY id_kegiatan DESC");
                
                if(mysqli_num_rows($query) > 0) {
                    while($row = mysqli_fetch_assoc($query)): 
                ?>
                <div class="col-md-6 mb-4">
                    <div class="card card-kegiatan">
                        <?php
                        $tanggal_kegiatan = $row['tanggal'];
                        $hari_ini = date('Y-m-d');

                        if ($tanggal_kegiatan >= $hari_ini) {
                            echo '<span class="badge-upcoming">Akan Datang</span>';
                        } else {
                            echo '<span class="badge-upcoming">Sudah Lewat</span>';
                        }
                        ?>
                        <img src="../assets/kegiatan/<?= $row['gambar'] ?>" class="img-kegiatan" alt="Kegiatan">
                        <div class="card-body p-4">
                            <h5 class="text-kegiatan-title mb-3"><?= $row['judul'] ?></h5>
                            <div class="info-item">
                                <i class="fa fa-calendar-alt me-2 text-primary"></i> <?= $row['tanggal'] ?>
                            </div>
                            <div class="info-item mb-3">
                                <i class="fa fa-map-marker-alt me-2 text-success"></i> <?= $row['lokasi'] ?>
                            </div>
                            <p class="small text-muted" style="text-align: justify; line-height: 1.6;">
                                <?= $row['deskripsi'] ?>
                            </p>
                        </div>
                    </div>
                </div>
                <?php 
                    endwhile; 
                } else {
                    echo '<div class="col-12 text-center py-5 text-muted">Belum ada jadwal kegiatan terbaru.</div>';
                }
                ?>
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