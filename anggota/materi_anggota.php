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
    <title>Materi Pembelajaran - Pramuka</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/anggota-style.css">
</head>
<body>
    <div class="main-content">
        <div class="container py-4">
            <div class="row mb-4">
                <div class="col-12">
                    <h3 class="fw-bold">Materi Pembelajaran</h3>
                    <p class="text-muted">Unduh materi SKU dan panduan kegiatan Pramuka terbaru dari Admin.</p>
                </div>
            </div>
        
            <div class="row">
                <?php 
                // Mengambil data materi dari database
                $query = mysqli_query($conn, "SELECT * FROM materi ORDER BY id_materi DESC");
                
                if(mysqli_num_rows($query) > 0) {
                    while($row = mysqli_fetch_assoc($query)): 
                ?>
                <div class="col-md-4 mb-4">
                    <div class="card card-materi p-4 h-100 d-flex flex-column">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-box me-3">
                                <?php 
                                $tipe = strtoupper($row['tipe_materi']);
                                if($tipe == 'PDF') echo '<i class="fa fa-file-pdf fa-lg text-danger"></i>';
                                elseif($tipe == 'MP4' || $tipe == 'VIDEO') echo '<i class="fa fa-video fa-lg text-primary"></i>';
                                else echo '<i class="fa fa-file-image fa-lg text-success"></i>';
                                ?>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0 text-dark"><?= $row['judul_materi'] ?></h6>
                                <small class="text-muted"><?= date('d M Y', strtotime($row['tanggal_upload'])) ?></small>
                            </div>
                        </div>
                        
                        <div class="mt-auto">
                            <hr class="opacity-25">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge bg-light text-dark border text-uppercase small"><?= $row['tipe_materi'] ?></span>
                            </div>
                            <a href="../assets/<?= $row['file_materi'] ?>" class="btn btn-primary w-100 fw-bold rounded-pill shadow-sm" download>
                                <i class="fa fa-download me-2"></i> Download Materi
                            </a>
                        </div>
                    </div>
                </div>
                <?php 
                    endwhile; 
                } else {
                    echo '
                    <div class="col-12 text-center py-5">
                        <i class="fa fa-folder-open fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada materi yang tersedia.</p>
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