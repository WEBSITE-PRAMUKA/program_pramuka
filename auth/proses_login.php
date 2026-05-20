<?php
session_start();
include "../config/koneksi.php";

if(isset($_POST['username'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']); 

    $query = mysqli_query($conn, "SELECT * FROM users WHERE nta='$username' AND password='$password'");
    
    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);
        
        $_SESSION['status_login'] = true;
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['nta']  = $data['nta'];
        $_SESSION['role'] = $data['role'];
        
        // Arahkan sesuai role
        if ($data['role'] == 'admin') {
            header("location:../admin/index_admin.php");
        } elseif ($data['role'] == 'bendahara') {
            header("location:../bendahara/index_bendahara.php");
        } else {
            header("location:../anggota/index_anggota.php");
        }
    } else {
        header("location:login.php?pesan=gagal");
    }
}
?>