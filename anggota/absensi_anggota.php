<?php
session_start();
include "../config/koneksi.php";
include "../assets/menu/anggota-navbar.php";

// Proteksi: Pastikan user sudah login sebagai anggota atau bendahara
if (!isset($_SESSION['status_login']) || ($_SESSION['role'] != 'anggota' && $_SESSION['role'] != 'bendahara')) {
    header("location:../auth/login.php");
    exit;
}

$nta = $_SESSION['nta'];
$nama = $_SESSION['nama'];
$role = $_SESSION['role'];

// Proses Absensi
if (isset($_POST['absen_sekarang'])) {
    $id_keg = $_POST['id_kegiatan'];
    $coords = $_POST['lokasi_gps'];
    $waktu  = date('Y-m-d H:i:s');
    
    // Cek apakah anggota sudah absen di kegiatan yang sama
    $cek = mysqli_query($conn, "SELECT id_hasil FROM absensi_hasil WHERE nta='$nta' AND id_kegiatan='$id_keg'");
    
    if (mysqli_num_rows($cek) == 0) {
        // Jika belum, masukkan data
        $insert = mysqli_query($conn, "INSERT INTO absensi_hasil (id_kegiatan, nta, nama_anggota, waktu_absen, lokasi_anggota) 
                            VALUES ('$id_keg', '$nta', '$nama', '$waktu', '$coords')");
        
        if($insert){
            echo "<script>alert('Absensi Berhasil!'); window.location.href='absensi_anggota.php';</script>";
            exit; // PENTING: Menghentikan eksekusi script agar tidak terjadi double insert
        }
    } else {
        // Jika sudah absen
        echo "<script>alert('Anda sudah absen untuk kegiatan ini!'); window.location.href='absensi_anggota.php';</script>";
        exit; // PENTING
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi Anggota - Pramuka</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/anggota-style.css">
</head>
<body>
    <div class="main-content">
        <br><br><br>
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="card p-4 text-center border-top border-danger border-5">
                        <h4 class="fw-bold mb-1">Presensi Digital</h4>
                        <p class="text-muted small">Gerakan Pramuka Indonesia</p>
                        <hr>
        
                        <form method="POST" id="formAbsen">
                            <div class="mb-4 text-start">
                                <label class="small fw-bold mb-2 text-uppercase">Pilih Kegiatan Hari Ini</label>
                                <select name="id_kegiatan" class="form-select form-select-lg shadow-sm" required>
                                    <?php 
                                    $keg = mysqli_query($conn, "SELECT * FROM absensi_kegiatan WHERE tanggal = CURDATE()");
                                    if(mysqli_num_rows($keg) > 0) {
                                        while($d = mysqli_fetch_assoc($keg)){
                                            echo "<option value='".$d['id_kegiatan']."'>".$d['nama_kegiatan']."</option>";
                                        }
                                    } else {
                                        echo "<option disabled selected>Belum ada kegiatan hari ini</option>";
                                    }
                                    ?>
                                </select>
                            </div>
        
                            <input type="hidden" name="lokasi_gps" id="lokasi_gps">
        
                            <button type="button" id="btnProses" onclick="getLocation()" class="btn btn-danger w-100 btn-absen fw-bold shadow">
                                <i class="fa fa-fingerprint me-2"></i> ABSEN SEKARANG
                            </button>
                            
                            <button type="submit" name="absen_sekarang" id="btnSubmit" style="display:none;"></button>
                        </form>
                        
                        <p class="mt-3 text-muted small"><i class="fa fa-info-circle me-1"></i> Pastikan GPS anda aktif sebelum menekan tombol.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
// Menambahkan variabel pengunci untuk mencegah klik berkali-kali
let isProcessing = false;

function getLocation() {
    // Jika sedang diproses, hentikan klik selanjutnya
    if (isProcessing) return; 
    isProcessing = true;

    const btn = document.getElementById("btnProses");
    btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Mendeteksi Lokasi...';
    btn.disabled = true;

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            document.getElementById("lokasi_gps").value = position.coords.latitude + "," + position.coords.longitude;
            document.getElementById("btnSubmit").click();
        }, function(error) {
            alert("Gagal mendeteksi lokasi. Harap izinkan akses lokasi di browser anda!");
            // Reset tombol jika gagal
            btn.innerHTML = '<i class="fa fa-fingerprint me-2"></i> ABSEN SEKARANG';
            btn.disabled = false;
            isProcessing = false;
        }, {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0
        });
    } else {
        alert("Browser anda tidak mendukung fitur GPS.");
        btn.innerHTML = '<i class="fa fa-fingerprint me-2"></i> ABSEN SEKARANG';
        btn.disabled = false;
        isProcessing = false;
    }
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>

</body>
</html>
<?php include "../assets/menu/footer.php"; ?>