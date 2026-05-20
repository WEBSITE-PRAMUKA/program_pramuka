<?php
session_start();
include "../config/koneksi.php";

// Pastikan hanya admin yang bisa memproses
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    die("Akses ditolak!");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul   = mysqli_real_escape_string($conn, $_POST['judul']);
    $tipe    = $_POST['tipe'];
    $tanggal = $_POST['tanggal'];

    // Ambil data file
    $nama_file = $_FILES['berkas']['name'];
    $tmp_file  = $_FILES['berkas']['tmp_name'];
    $ukuran    = $_FILES['berkas']['size'];
    
    // Tentukan lokasi penyimpanan
    $direktori = "../assets/";
    
    // Buat folder uploads jika belum ada
    if (!is_dir($direktori)) {
        mkdir($direktori, 0777, true);
    }

    $path = $direktori . $nama_file;

    // Proses pindahkan file
    if (move_uploaded_file($tmp_file, $path)) {
        // Simpan informasi ke database
        $sql = "INSERT INTO materi (judul_materi, tipe_materi, tanggal_upload, file_materi) 
                VALUES ('$judul', '$tipe', '$tanggal', '$nama_file')";
        
        if (mysqli_query($conn, $sql)) {
            // Jika berhasil, balik ke halaman admin dengan pesan sukses
            header("location:../admin/materi_admin.php?pesan=berhasil");
        } else {
            echo "Error Database: " . mysqli_error($conn);
        }
    } else {
        echo "Gagal mengunggah file. Pastikan folder 'uploads' tersedia dan memiliki izin akses.";
    }
}
?>