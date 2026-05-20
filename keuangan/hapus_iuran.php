<?php
session_start();
include "../config/koneksi.php";

// Proteksi: Pastikan hanya Bendahara yang bisa menghapus data
if (!isset($_SESSION['status_login']) || $_SESSION['role'] != 'bendahara') {
    header("location:../auth/login.php?pesan=denied");
    exit;
}

// Ambil ID dari URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk menghapus data berdasarkan ID
    $query = "DELETE FROM iuran_anggota WHERE id = '$id'";

    if (mysqli_query($conn, $query)) {
        // Jika berhasil, kembali ke halaman kas_bendahara dengan pesan sukses
        header("location:../bendahara/kas_bendahara.php?pesan=terhapus");
    } else {
        // Jika gagal, tampilkan pesan error
        echo "Gagal menghapus data: " . mysqli_error($conn);
    }
} else {
    // Jika tidak ada ID di URL, kembali ke halaman utama
    header("location:../bendahara/kas_bendahara.php");
}
?>