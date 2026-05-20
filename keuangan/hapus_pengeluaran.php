<?php
session_start();
include "../config/koneksi.php";

// Pastikan hanya bendahara yang bisa menghapus
if ($_SESSION['role'] == 'bendahara') {
    $id = $_GET['id'];
    
    $query = "DELETE FROM kas WHERE id = '$id' AND jenis = 'keluar'";
    
    if (mysqli_query($conn, $query)) {
        header("location:../bendahara/pengeluaran.php?pesan=terhapus");
    } else {
        echo "Gagal menghapus: " . mysqli_error($conn);
    }
} else {
    header("location:../bendahara/pengeluaran.php?pesan=denied");
}
?>