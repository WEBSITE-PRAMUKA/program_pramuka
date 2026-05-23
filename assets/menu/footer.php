<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}

$role = $_SESSION['role'];
?>

<footer class="footer mt-5">
    <div class="container text-center">

        <?php if($role == 'admin'): ?>

            <h6 class="fw-bold">Dashboard Admin Pramuka</h6>

            <p class="small opacity-75">
                Bersama Pramuka Membangun Generasi.
            </p>

        <?php elseif($role == 'bendahara'): ?>

            <h6 class="fw-bold">Dashboard Bendahara</h6>

            <p class="small opacity-75">
                Kelola pemasukan, pengeluaran, dan iuran anggota pramuka.
            </p>

        <?php elseif($role == 'anggota'): ?>

            <h6 class="fw-bold">Dashboard Anggota Pramuka</h6>

            <p class="small opacity-75">
                Membentuk karakter pemuda melalui disiplin dan gotong royong.
            </p>

        <?php else: ?>

            <h6 class="fw-bold">Sistem Informasi Pramuka</h6>

            <p class="small opacity-75">
                Platform digital kegiatan gerakan pramuka.
            </p>

        <?php endif; ?>

        <hr class="opacity-25">

        <small>
            © 2026 Sistem Informasi Gerakan Pramuka
        </small>

    </div>
</footer>