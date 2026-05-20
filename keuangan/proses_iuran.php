<?php
session_start();
include "../config/koneksi.php";

if ($_SESSION['role'] == 'bendahara') {
    $judul   = mysqli_real_escape_string($conn, $_POST['judul']);
    $nama    = mysqli_real_escape_string($conn, $_POST['nama']);
    $nta     = mysqli_real_escape_string($conn, $_POST['nta']);
    $tanggal = $_POST['tanggal'];
    $nominal = $_POST['nominal'];

    $sql = "INSERT INTO iuran_anggota (judul_tanggal, nama_anggota, nta, tanggal_bayar, nominal) 
            VALUES ('$judul', '$nama', '$nta', '$tanggal', '$nominal')";

    if (mysqli_query($conn, $sql)) {
        header("location:../bendahara/kas_bendahara.php?pesan=berhasil");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>