<?php
session_start();
include "../config/koneksi.php";

// 1. Validasi Keamanan: Cek sesi admin
if (!isset($_SESSION['status_login']) || $_SESSION['role'] != 'admin') {
    header("location:../auth/login.php");
    exit;
}

// 2. Cek apakah ada parameter 'id' yang dikirim melalui URL
if (isset($_GET['id'])) {
    // Mencegah SQL Injection
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // 3. Cari nama file gambar di database sebelum datanya dihapus
    $query = mysqli_query($conn, "SELECT gambar FROM kegiatan WHERE id_kegiatan = '$id'");
    
    if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);
        $nama_gambar = $row['gambar'];
        $path_gambar = "../assets/kegiatan/" . $nama_gambar;

        // 4. Hapus file gambar dari folder jika file fisiknya ada
        if (file_exists($path_gambar) && !empty($nama_gambar)) {
            unlink($path_gambar);
        }
    }

    // 5. Hapus data dari tabel kegiatan yang memiliki id_kegiatan tersebut
    $hapus = mysqli_query($conn, "DELETE FROM kegiatan WHERE id_kegiatan = '$id'");

    // 6. Redirect kembali ke halaman utama dengan pesan alert
    if ($hapus) {
        echo "<script>
                alert('Data kegiatan berhasil dihapus!');
                window.location.href = document.referrer; // Kembali ke halaman sebelumnya
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus data kegiatan!');
                window.location.href = document.referrer;
              </script>";
    }
} else {
    // Jika file diakses langsung tanpa parameter ID
    header("location:../auth/login.php");
    exit;
}
?>