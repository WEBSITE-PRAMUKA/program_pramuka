<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

$current = basename($_SERVER['PHP_SELF']);
?>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg">
    <div class="container">

        <a class="navbar-brand" href="index_anggota.php">
            Pramuka <span style="color:#16a34a;">Anggota</span>
        </a>

        <button class="navbar-toggler border-0 shadow-none"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav">

            <i class="fa fa-bars"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav mx-auto">

                <li class="nav-item">
                    <a class="nav-link <?= $current == 'index_anggota.php' ? 'active' : '' ?>"
                       href="index_anggota.php">
                        BERANDA
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= $current == 'materi_anggota.php' ? 'active' : '' ?>"
                       href="materi_anggota.php">
                        MATERI
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= $current == 'absensi_anggota.php' ? 'active' : '' ?>"
                       href="absensi_anggota.php">
                        ABSENSI
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= $current == 'galeri_anggota.php' ? 'active' : '' ?>"
                       href="galeri_anggota.php">
                        GALERI
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= $current == 'kegiatan_anggota.php' ? 'active' : '' ?>"
                       href="kegiatan_anggota.php">
                        KEGIATAN
                    </a>
                </li>   
            </ul>

            <div class="d-flex align-items-center gap-2">

                <div class="admin-profile">

                    <div class="admin-icon" style="background:linear-gradient(135deg,#16a34a,#3b82f6);">
                        <i class="fa fa-user"></i>
                    </div>

                    <div class="admin-info">
                        <small>
                            <?= ucfirst($_SESSION['role']); ?>
                        </small>

                        <span>
                            <?= $_SESSION['nama']; ?>
                        </span>
                    </div>

                </div>

                <a href="../auth/logout.php"
                   class="btn btn-outline-success rounded-pill px-4">
                    Logout
                </a>

            </div>

        </div>
    </div>
</nav>