<?php
session_start();
include "../config/koneksi.php";

if ($_SESSION['role'] == 'bendahara') {
    $keterangan  = mysqli_real_escape_string($conn, $_POST['keterangan']);
    $jumlah_item = mysqli_real_escape_string($conn, $_POST['jumlah_item']); // Ambil data jumlah barang
    $jumlah      = $_POST['jumlah']; // Nominal uang
    $tanggal     = $_POST['tanggal'];

    // Update Query: Tambahkan jumlah_item
    $sql = "INSERT INTO kas (tanggal, keterangan, jumlah_item, jenis, jumlah) 
            VALUES ('$tanggal', '$keterangan', '$jumlah_item', 'keluar', '$jumlah')";

    if (mysqli_query($conn, $sql)) {
        header("location:../bendahara/pengeluaran.php?pesan=berhasil");
    } else {
        echo "Gagal menyimpan data: " . mysqli_error($conn);
    }
} else {
    header("location:../auth/login.php");
}
?>