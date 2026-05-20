<?php
session_start();
include "../config/koneksi.php";
include "../assets/menu/admin-navbar.php";

if (!isset($_SESSION['status_login']) || $_SESSION['role'] != 'admin') {
    header("location:../auth/login.php?pesan=denied");
    exit;
}

// Proses Simpan Jadwal Kegiatan Baru
if (isset($_POST['simpan_kegiatan'])) {
    $tgl = $_POST['tanggal'];
    $nama_keg = mysqli_real_escape_string($conn, $_POST['nama_kegiatan']);
    $jam_m = $_POST['jam_mulai'];
    $lok = mysqli_real_escape_string($conn, $_POST['lokasi']);
    
    $query = "INSERT INTO absensi_kegiatan (tanggal, nama_kegiatan, jam_mulai, lokasi_admin) 
              VALUES ('$tgl', '$nama_keg', '$jam_m', '$lok')";
    
    if (mysqli_query($conn, $query)) {
        header("location:absensi_admin.php?pesan=sukses");
    }
}

// Proses Hapus
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM absensi_hasil WHERE id_hasil = '$id'");
    header("location:absensi_admin.php?pesan=terhapus");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Absensi - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/admin-style.css">
</head>
<body>
    <br><br><br>
<div class="main-content">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="page-title">Absensi</h1>
            <p class="page-subtitle">
                Kelola seluruh absensi kegiatan anggota pramuka
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card p-4 border-top border-danger border-4 reveal">
                <h5 class="fw-bold mb-3">Buat Jadwal Absensi</h5>
                <form method="POST">
                    <div class="mb-3">
                        <label class="small fw-bold">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">Nama Kegiatan</label>
                        <input type="text" name="nama_kegiatan" class="form-control" placeholder="Misal: Latihan Rutin" required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">Jam Mulai (Batas Tepat Waktu)</label>
                        <input type="time" name="jam_mulai" class="form-control" value="08:00" required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">Lokasi Patokan</label>
                        <input type="text" name="lokasi" class="form-control" placeholder="Misal: Sanggar Pramuka" required>
                    </div>
                    <button type="submit" name="simpan_kegiatan" class="btn btn-danger w-100 fw-bold">Buka Absensi</button>
                </form>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card p-4 reveal">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">Kehadiran Anggota</h5>
                    <a href="generate_pdf_absensi.php" class="btn btn-sm btn-outline-danger"><i class="fa fa-file-pdf"></i> Unduh PDF</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Anggota</th>
                                <th>Jam Absen</th>
                                <th>Status</th>
                                <th>GPS</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $res = mysqli_query($conn, "SELECT h.*, k.nama_kegiatan, k.jam_mulai 
                                                        FROM absensi_hasil h 
                                                        JOIN absensi_kegiatan k ON h.id_kegiatan = k.id_kegiatan 
                                                        ORDER BY h.waktu_absen DESC");
                            while($row = mysqli_fetch_assoc($res)): 
                                $waktu_absen = date('H:i:s', strtotime($row['waktu_absen']));
                                $jam_patokan = $row['jam_mulai'];
                                $is_late = ($waktu_absen > $jam_patokan);
                            ?>
                            <tr>
                                <td><span class="fw-bold"><?php echo $row['nama_anggota']; ?></span><br><small><?php echo $row['nta']; ?></small></td>
                                <td><?php echo date('H:i', strtotime($row['waktu_absen'])); ?></td>
                                <td>
                                    <span class="badge <?php echo $is_late ? 'bg-danger' : 'bg-success'; ?>">
                                        <?php echo $is_late ? 'Terlambat' : 'Tepat Waktu'; ?>
                                    </span>
                                </td>
                                <td><a href="https://www.google.com/maps?q=<?php echo $row['lokasi_anggota']; ?>" target="_blank" class="btn btn-sm btn-light border"><i class="fa fa-map-marker-alt text-danger"></i></a></td>
                                <td><a href="absensi_admin.php?hapus=<?php echo $row['id_hasil']; ?>" class="text-secondary" onclick="return confirm('Hapus?')"><i class="fa fa-trash"></i></a></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<br><br><br>
<script>

/* navbar scroll */
window.addEventListener('scroll', function(){

    const navbar = document.querySelector('.navbar');

    if(window.scrollY > 20){
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }

});

/* reveal animation */
function reveal(){
    let reveals = document.querySelectorAll(".reveal");

    for(let i = 0; i < reveals.length; i++){

        let windowHeight = window.innerHeight;
        let elementTop = reveals[i].getBoundingClientRect().top;

        let elementVisible = 100;

        if(elementTop < windowHeight - elementVisible){
            reveals[i].classList.add("active");
        }
    }
}

window.addEventListener("scroll", reveal);
reveal();

</script>
</body>
</html>
<?php include "../assets/menu/footer.php"; ?>