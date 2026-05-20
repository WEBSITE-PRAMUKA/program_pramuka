<?php
session_start();
include "../config/koneksi.php";

if ($_SESSION['role'] == 'admin') {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $tgl = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $lok = mysqli_real_escape_string($conn, $_POST['lokasi']);
    $desc = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    
    $foto_name = time() . "_" . $_FILES['gambar']['name'];
    $foto_tmp = $_FILES['gambar']['tmp_name'];
    $path = "../assets/kegiatan/" . $foto_name;

    if (move_uploaded_file($foto_tmp, $path)) {
        mysqli_query($conn, "INSERT INTO kegiatan (judul, tanggal, lokasi, deskripsi, gambar) 
                            VALUES ('$judul', '$tgl', '$lok', '$desc', '$foto_name')");
        header("location:../admin/kegiatan_admin.php");
    }
}
?>