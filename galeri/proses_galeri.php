<?php
session_start();
include "../config/koneksi.php";

if ($_SESSION['role'] == 'admin') {
    $judul     = mysqli_real_escape_string($conn, $_POST['judul']);
    $kategori  = mysqli_real_escape_string($conn, $_POST['kategori']);
    $tanggal   = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $lokasi    = mysqli_real_escape_string($conn, $_POST['lokasi']);
    $peserta   = mysqli_real_escape_string($conn, $_POST['peserta']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    
    $foto_name = $_FILES['foto']['name'];
    $foto_tmp  = $_FILES['foto']['tmp_name'];
    
    // Beri nama unik
    $unique_name = time() . "_" . $foto_name;
    // PENTING: Arahkan ke folder assets agar gambar bisa diload di GaleryLog
    $path = "../assets/galeri/" . $unique_name;

    if (move_uploaded_file($foto_tmp, $path)) {
        $query = "INSERT INTO galeri (judul_galeri, kategori, foto_cover, tanggal, lokasi, peserta, deskripsi) 
                  VALUES ('$judul', '$kategori', '$unique_name', '$tanggal', '$lokasi', '$peserta', '$deskripsi')";
        mysqli_query($conn, $query);
        
        header("location:../admin/galeri_admin.php");
    }
}
?>