<?php
session_start();
if (isset($_SESSION['status_login'])) {
    if ($_SESSION['role'] == 'admin') header("location:../anggota/index_admin.php");
    elseif ($_SESSION['role'] == 'bendahara') header("location:../bendahara/index_bendahara.php");
    else header("location:../anggota/index_anggota.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Pramuka</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">


<style>

@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
min-height:100vh;

background:
radial-gradient(circle at top left,#dcfce7 0%,transparent 30%),
radial-gradient(circle at bottom right,#dbeafe 0%,transparent 30%),
#f8fafc;

overflow-x:hidden;
}

/* NAVBAR */
.navbar{
    background:rgba(255,255,255,0.8);
    backdrop-filter:blur(14px);
    border-bottom:1px solid rgba(255,255,255,0.3);
    padding:16px 0;
}

.navbar-brand{
    font-size:28px;
    font-weight:700;
    color:#0f172a !important;
}

.navbar .btn{
    border-radius:14px;
    padding:10px 18px;
    font-weight:600;
    transition:0.3s;
}

.navbar .btn:hover{
    transform:translateY(-2px);
}   


.login-card{
background:rgba(255,255,255,0.75);

backdrop-filter:blur(18px);
-webkit-backdrop-filter:blur(18px);

border:1px solid rgba(255,255,255,0.3);

border-radius:28px;

padding:40px 35px;

width:100%;
max-width:100%;

box-shadow:
0 10px 30px rgba(0,0,0,0.08),
0 4px 10px rgba(0,0,0,0.03);

transition:0.4s;
}

.login-card:hover{
transform:translateY(-5px);
box-shadow:
0 20px 40px rgba(0,0,0,0.1),
0 8px 20px rgba(0,0,0,0.05);
}

/* LOGO */
.logo-circle{
width:85px;
height:85px;

border-radius:50%;

background:linear-gradient(135deg,#16a34a,#22c55e);

display:flex;
align-items:center;
justify-content:center;

margin:auto;

color:white;
font-size:32px;
font-weight:700;

box-shadow:0 10px 25px rgba(34,197,94,0.35);
}

/* TITLE */
.login-title{
font-size:30px;
font-weight:700;
color:#0f172a;
margin-top:20px;
}

.login-subtitle{
color:#64748b;
font-size:14px;
margin-bottom:30px;
}

/* FORM */
.form-label{
font-size:14px;
font-weight:600;
color:#334155;
margin-bottom:6px;
}

.form-control{
height:52px;
width:100%;

border-radius:14px;
border:1px solid #e2e8f0;

padding:0 15px;

font-size:14px;

background:#ffffff;

transition:0.3s;
}

.form-control:focus{
border-color:#22c55e;
box-shadow:0 0 0 4px rgba(34,197,94,0.12);
}

/* BUTTON */
.btn-login{
height:52px;

border:none;
border-radius:14px;

background:linear-gradient(135deg,#16a34a,#22c55e);

font-weight:600;
font-size:15px;
color:white;

transition:0.3s;
}

.btn-login:hover{
transform:translateY(-2px);
box-shadow:0 10px 20px rgba(34,197,94,0.3);
}
.row{
margin:0;
}

/* ALERT */
.alert{
border:none;
border-radius:14px;
font-size:14px;
}

/* LINK */
.register-link{
font-size:14px;
color:#64748b;
}

.register-link a{
color:#16a34a;
font-weight:600;
text-decoration:none;
}

.register-link a:hover{
text-decoration:underline;
}

/* RESPONSIVE */
@media(max-width:768px){

.login-card{
padding:30px 25px;
border-radius:24px;
}

.login-title{
font-size:25px;
}

.logo-circle{
width:75px;
height:75px;
font-size:28px;
}

}
/* CONTAINER LOGIN */
.login-wrapper{
min-height:85vh;
display:flex;
align-items:center;
justify-content:center;
}

</style>

</head>

<body>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">Pramuka</a>
        <nav class="navbar navbar-expand-lg">
            <div class="ms-auto">
                <a href="../index.php" class="btn btn-outline-secondary btn-sm">Kembali</a>
                <a href="login.php" class="btn btn-outline-secondary btn-sm">Login</a>
                <a href="daftar.php" class="btn btn-outline-secondary btn-sm">Daftar Anggota</a>
            </div>
        </nav>
    </div>
</nav>
<div class="container login-wrapper">
    <div class="row justify-content-center w-100">
        <div class="col-lg-5 col-md-7 col-sm-11">
            <?php if(isset($_GET['pesan'])): ?>
                <div class="alert alert-warning text-center mb-4">
                    <?php 
                    if($_GET['pesan'] == "gagal") echo "NTA atau Password salah!";
                    elseif($_GET['pesan'] == "logout") echo "Berhasil keluar!";
                    elseif($_GET['pesan'] == "denied") echo "Akses ditolak!";
                    elseif($_GET['pesan'] == "berhasil_daftar") echo "Daftar berhasil, silakan login!";
                    ?>
                </div>
            <?php endif; ?>
            <div class="login-card">
                <div class="text-center h2">
                    <div class="fa fa-user-circle"><br><a>Login</a></div>
                    <p class="login-subtitle"><br>Masuk ke dashboard anggota pramuka</p>
                </div>
                <h5 class="fw-bold mb-2">Selamat Datang</h5>
                <p class="text-muted mb-4">
                    Masukkan NTA dan password anda untuk melanjutkan
                </p>
                <form method="POST" action="proses_login.php">
                    <div class="mb-3">
                        <label class="form-label">
                            (NTA) Nomer Tanda Anggota
                        </label>
                        <input 
                        type="text" 
                        name="username" 
                        class="form-control" 
                        placeholder="00.00.00-000.000"
                        required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">
                            Password
                        </label>
                        <input 
                        type="password" 
                        name="password" 
                        class="form-control" 
                        placeholder="Password"
                        required>
                    </div>
                    <button class="btn btn-login w-100 mt-3">
                        <i class="fa fa-right-to-bracket me-2"></i>
                        Login
                    </button>
                </form>
                <div class="text-center mt-4">
                    <small class="register-link">
                        Belum punya akun?
                        <a href="daftar.php">Daftar di sini</a>
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
