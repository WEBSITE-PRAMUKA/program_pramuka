<?php
include "koneksi.php";

// Pastikan data tidak kosong
if(isset($_POST['nama'])) {
    $nama       = mysql_real_escape_string($conn,$_POST['nama']);
    $nta        = mysql_real_escape_string($conn,$_POST['nta']);
    $gugus      = mysql_real_escape_string($conn,$_POST['gugus']);
    $jk         = mysql_real_escape_string($conn,$_POST['jk']);
    $kontak     = mysql_real_escape_string($conn,$_POST['kontak']);
    $password   = md5($_POST['password']);
    $role       = "anggota";

    $query = "INSERT INTO users (nama, nta, gugus, jk, kontak, password, role) 
              VALUES ('$nama', '$nta', '$gugus', '$jk', '$kontak', '$password', '$role')";
    if (mysqli_query($conn, $query)) {
            header("location:login.php?pesan=berhasil_daftar"); 
    } else {
            echo "Error: " . mysqli_error($conn);
    }
}
?>