<?PHP
$host      = "localhost";
$user      = "root";
$password  = "";
$database  = "pramuka";

$conn = mysqli_connect($host, $user, $password, $database);
if  (!$conn)  {
    die("Koneksi ke database gagal :" . mysqli_connect_error()) ;
}
mysqli_set_charset ($conn, "utf8");
?>
