<?php
session_start();
include "../config/koneksi.php";

// Cek apakah admin sudah login
if (!isset($_SESSION['status_login']) || $_SESSION['role'] != 'admin') {
    header("location:../auth/login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil nama file foto dari database terlebih dahulu
    $query = mysqli_query($conn, "SELECT foto_cover FROM galeri WHERE id_galeri = '$id'");
    $data = mysqli_fetch_assoc($query);

    if ($data) {
        $foto_lama = "../assets/galeri/" . $data['foto_cover'];
        
        // Hapus file foto fisik jika ada di folder
        if (file_exists($foto_lama) && $data['foto_cover'] != '') {
            unlink($foto_lama);
        }

        // Hapus data dari database
        $hapus = mysqli_query($conn, "DELETE FROM galeri WHERE id_galeri = '$id'");

        if ($hapus) {
            // Catatan: Ganti 'index.php' dengan nama file halaman utama galerimu
            echo "<script>alert('Album berhasil dihapus!'); window.location.href='../admin/galeri_admin.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus album!'); window.location.href='../galeri/edit_galeri.php';</script>";
        }
    }
} else {
    header("location:galeri_admin.php");
}
?>