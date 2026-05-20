<?php
session_start();
include "../config/koneksi.php";

// Pastikan yang mengakses adalah bendahara atau admin
if ($_SESSION['role'] == 'bendahara' || $_SESSION['role'] == 'admin') {
    
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);
    $jenis      = $_POST['jenis'];
    $jumlah     = $_POST['jumlah'];
    $tanggal    = $_POST['tanggal'];

    $query = "INSERT INTO kas (tanggal, keterangan, jenis, jumlah) 
              VALUES ('$tanggal', '$keterangan', '$jenis', '$jumlah')";

    if (mysqli_query($conn, $query)) {
        header("location:../bendahara/kas_bendahara.php?pesan=sukses");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    header("location:../bendahara/kas_bendahara.php?pesan=denied");
}
?>
