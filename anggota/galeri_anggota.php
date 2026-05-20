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
    <title>Gallery Kegiatan - Pramuka</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/anggota-style.css">
    
</head>
<body>
    <div class="main-content">

        <div class="container mt-4">
            <div class="row mb-2">
                <div class="col-4 text-center text-md-start">
                    <h3 class="fw-bold mb-1">Album Kegiatan</h3>
                    <p class="text-muted mb-4">Dokumentasi keseruan kegiatan Pramuka kita.</p>
                </div>
            </div>
            
            <div class="row">
                <?php 
                $query = mysqli_query($conn, "SELECT * FROM galeri ORDER BY id_galeri DESC");
                
                if(mysqli_num_rows($query) > 0) {
                    while($row = mysqli_fetch_assoc($query)): 
                ?>
                <div class="col-md-4 mb-4">
                    <div class="card card-galeri shadow-sm h-100">
                        <div class="img-container">
                            <img src="../assets/galeri/<?= $row['foto_cover'] ?>" alt="Cover">
                        </div>
                        <div class="card-body">
                            <span class="badge bg-success mb-2 text-uppercase" style="font-size: 0.7rem;"><?= $row['kategori'] ?></span>
                            <h6 class="fw-bold mb-1 text-dark"><?= $row['judul_galeri'] ?></h6>
                            <small class="text-muted"><i class="fa fa-calendar-alt me-1 small"></i> <?= date('d M Y', strtotime($row['tanggal_dibuat'])) ?></small>
                        </div>
                    </div>
                </div>
                <?php 
                    endwhile; 
                } else {
                    echo '
                    <div class="col-12 text-center py-5">
                        <i class="fa fa-images fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada album foto yang tersedia.</p>
                    </div>';
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