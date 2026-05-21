<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pendaftaran Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

*{
    font-family:'Poppins',sans-serif;
}

body{
    background:
    radial-gradient(circle at top left, rgba(34,197,94,0.15), transparent 30%),
    radial-gradient(circle at bottom right, rgba(59,130,246,0.12), transparent 30%),
    #f8fafc;
    
    min-height:100vh;
    color:#0f172a;
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

/* CARD */
.form-card{
    border:none;
    border-radius:30px;
    padding:40px;
    background:rgba(255,255,255,0.85);
    backdrop-filter:blur(20px);

    box-shadow:
    0 15px 50px rgba(15,23,42,0.08),
    inset 0 1px 0 rgba(255,255,255,0.6);
    
    position:relative;
    overflow:hidden;
}

/* EFEK GLOW */
.form-card::before{
    content:'';
    position:absolute;
    width:180px;
    height:180px;
    background:rgba(34,197,94,0.12);
    border-radius:50%;
    top:-60px;
    right:-60px;
}

.form-card::after{
    content:'';
    position:absolute;
    width:140px;
    height:140px;
    background:rgba(59,130,246,0.08);
    border-radius:50%;
    bottom:-40px;
    left:-40px;
}

/* TITLE */
.form-title{
    font-size:30px;
    font-weight:700;
    margin-bottom:8px;
    position:relative;
    z-index:2;
}

.form-subtitle{
    color:#64748b;
    font-size:14px;
    margin-bottom:30px;
    position:relative;
    z-index:2;
}

/* LABEL */
label{
    font-size:14px;
    font-weight:600;
    margin-bottom:8px;
    color:#334155;
}

/* INPUT */
.form-control,
.form-select{
    height:55px;
    border-radius:16px;
    border:1px solid #e2e8f0;
    background:#f8fafc;
    padding:0 18px;
    transition:0.3s;
    font-size:14px;
}

.form-control:focus,
.form-select:focus{
    border-color:#22c55e;
    box-shadow:0 0 0 4px rgba(34,197,94,0.12);
    background:white;
}

/* BUTTON */
.btn-success{
    height:55px;
    border:none;
    border-radius:16px;
    font-weight:600;
    font-size:15px;

    background:linear-gradient(135deg,#22c55e,#16a34a);

    transition:0.3s;
}

.btn-success:hover{
    transform:translateY(-3px);
    box-shadow:0 10px 25px rgba(34,197,94,0.35);
}

/* ICON TOP */
.logo-register{
    width:80px;
    height:80px;
    border-radius:24px;

    background:linear-gradient(135deg,#22c55e,#16a34a);

    display:flex;
    align-items:center;
    justify-content:center;

    color:white;
    font-size:32px;

    margin:auto;
    margin-bottom:25px;

    box-shadow:0 15px 30px rgba(34,197,94,0.3);
}

/* RESPONSIVE */
@media(max-width:768px){

    .form-card{
        padding:30px 22px;
        border-radius:24px;
    }

    .form-title{
        font-size:24px;
    }

}
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">Pramuka</a>
        <div class="ms-auto">
            <a href="../pages/beranda1.php" class="btn btn-outline-secondary btn-sm">Kembali</a>
            <a href="login.php" class="btn btn-outline-secondary btn-sm">Login</a>
            <a href="#" class="btn btn-outline-secondary btn-sm">Daftar Anggota</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card form-card">
                <div class="logo-register">
                    <i class="fa-solid fa-user-plus"></i>
                </div>
                <h2 class="form-title text-center">
                    Daftar Anggota
                </h2>
                <p class="form-subtitle text-center">
                    Lengkapi data untuk membuat akun anggota pramuka
                </p>
                <form action="proses_daftar.php" method="POST">
                    <div class="mt-3">
                        <label>Nama Lengkap *</label>
                        <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" required>
                    </div>
                    <div class="mt-3">
                        <label>NTA (Nomor Tanda Anggota) *</label>
                        <input type="text" name="nta" class="form-control" placeholder="00.00.00-000.000" required>
                    </div>
                    <div class="mt-3">
                        <label>Gugus Depan *</label>
                        <input type="text" name="gugus" class="form-control" placeholder="Gugus Depan" required>
                    </div>
                    <div class="mt-3">
                        <label>Jenis Kelamin *</label>
                        <select name="jk" class="form-select" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="mt-3">
                        <label>Email *</label>
                        <input type="email" name="kontak" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="mt-3">
                        <label>Password Akun *</label>
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100 mt-4">
                        <i class="fa-solid fa-user-check me-2"></i>
                        Daftar Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>