<?php
session_start();
include "../config/koneksi.php";

// Proteksi: Hanya Admin yang boleh menghapus
if (!isset($_SESSION['status_login']) || $_SESSION['role'] != 'admin') {
    header("location:../auth/login.php?pesan=denied");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // 1. Cari nama file di database sebelum datanya dihapus
    $cari_file = mysqli_query($conn, "SELECT file_materi FROM materi WHERE id_materi = '$id'");
    $data = mysqli_fetch_assoc($cari_file);
    $nama_file = $data['file_materi'];

    // 2. Hapus file fisik dari folder uploads
    if ($nama_file != "") {
        unlink("../assets/" . $nama_file);
    }

    // 3. Hapus data dari database
    $query = "DELETE FROM materi WHERE id_materi = '$id'";

    if (mysqli_query($conn, $query)) {
        // Kembali ke halaman materi_admin dengan pesan terhapus
        header("location:../admin/materi_admin.php?pesan=terhapus");
    } else {
        echo "Gagal menghapus data: " . mysqli_error($conn);
    }
} else {
    header("location:../admin/materi_admin.php");
}
?>