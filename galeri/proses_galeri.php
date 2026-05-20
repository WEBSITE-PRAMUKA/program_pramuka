<?php
session_start();
include "../config/koneksi.php";

if ($_SESSION['role'] == 'admin') {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $kategori = $_POST['kategori'];
    
    $foto_name = $_FILES['foto']['name'];
    $foto_tmp = $_FILES['foto']['tmp_name'];
    
    // Beri nama unik agar tidak bentrok
    $unique_name = time() . "_" . $foto_name;
    $path = "uploads/galeri/" . $unique_name;

    if (move_uploaded_file($foto_tmp, $path)) {
        mysqli_query($conn, "INSERT INTO galeri (judul_galeri, kategori, foto_cover) VALUES ('$judul', '$kategori', '$unique_name')");
        header("location:../admin/galeri_admin.php");
    }
}
?>