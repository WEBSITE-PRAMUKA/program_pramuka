<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg">
    <div class="container">

        <a class="navbar-brand" href="index_admin.php">
            Pramuka <span>Admin</span>
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
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'index_admin.php' ? 'active' : '' ?>"
                       href="index_admin.php">
                        BERANDA
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'materi_admin.php' ? 'active' : '' ?>"
                       href="materi_admin.php">
                        KELOLA MATERI
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'absensi_admin.php' ? 'active' : '' ?>"
                       href="absensi_admin.php">
                        KELOLA ABSENSI
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'galeri_admin.php' ? 'active' : '' ?>"
                       href="galeri_admin.php">
                        KELOLA GALERI
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'kegiatan_admin.php' ? 'active' : '' ?>"
                       href="kegiatan_admin.php">
                        KELOLA KEGIATAN
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'manajemen_anggota.php' ? 'active' : '' ?>"
                       href="manajemen_anggota.php">
                        DATA ANGGOTA
                    </a>
                </li>

            </ul>

            <div class="d-flex align-items-center gap-2">

                <div class="admin-profile">
                    <div class="admin-icon">
                        <i class="fa fa-user"></i>
                    </div>

                    <div class="admin-info">
                        <small>Administrator</small>
                        <span><?= $_SESSION['nama']; ?></span>
                    </div>
                </div>

                <a href="../auth/logout.php"
                   class="btn btn-outline-custom rounded-pill px-4">
                    Logout
                </a>

            </div>

        </div>
    </div>
</nav>