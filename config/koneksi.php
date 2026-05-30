<?php
$host     = "mif.myhost.id";
$user     = "mifmyho2_A3";
$password = "@MIF2025";
$database = "mifmyho2_A3";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8");
?>