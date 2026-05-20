<?php
session_start();
include "../config/koneksi.php";
include "../assets/menu/admin-navbar.php";

// Proteksi Admin
if (!isset($_SESSION['status_login']) || $_SESSION['role'] != 'admin') {
    header("location:../auth/login.php?pesan=denied");
    exit;
}

$nama_admin = $_SESSION['nama'];

// Proses Ubah Role (Jika tombol ditekan)
if (isset($_GET['ubah_role'])) {
    $id_user = $_GET['id'];
    $role_baru = $_GET['role'];
    
    $query_update = "UPDATE users SET role = '$role_baru' WHERE id = '$id_user'";
    if (mysqli_query($conn, $query_update)) {
        header("location:manajemen_anggota.php?pesan=update_sukses");
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Anggota - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/admin-style.css">
</head>
<body>
    <br><br><br>
    <div class="main-content">
        <div class="container fade-up">
            <h1 class="page-title">Manajemen Hak Akses Anggota</h1>
            <p class="page-subtitle">Kelola role anggota dan bendahara dengan sistem modern</p>
        
            <?php if(isset($_GET['pesan']) && $_GET['pesan'] == 'update_sukses'): ?>
                <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
                    <i class="fa fa-check-circle me-2"></i> Perubahan role berhasil disimpan!
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
        
            <div class="card p-4 fade-up">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>NTA</th>
                                <th>Nama Anggota</th>
                                <th>Role Saat Ini</th>
                                <th class="text-center">Aksi Ubah Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            // Ambil semua user kecuali Admin
                            $query = mysqli_query($conn, "SELECT * FROM users WHERE role != 'admin' ORDER BY nama ASC");
        
                            if(mysqli_num_rows($query) > 0) {
                                while($row = mysqli_fetch_assoc($query)): 
                                    $id_user = $row['id']; // Pastikan nama kolom di DB adalah id_user
                                    $nama_user = $row['nama'];
                                    $curr_role = $row['role'];
                            ?>
                            <tr>
                                <td><span class="badge bg-light text-dark border"><?= $row['nta'] ?></span></td>
                                <td>
                                    <div class="fw-bold"><?= $nama_user ?></div>
                                    <small class="text-muted">Role: <?= $curr_role ?></small>
                                </td>
                                <td>
                                    <span class="role-badge <?= ($curr_role == 'bendahara' ? 'role-bendahara' : 'role-anggota') ?>">
                                        <?= strtoupper($curr_role) ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <?php if($curr_role == 'anggota'): ?>
                                        <a href="manajemen_anggota.php?ubah_role=true&id=<?= $id_user ?>&role=bendahara" 
                                           class="btn btn-sm btn-success rounded-pill px-3" 
                                           onclick="return confirm('Jadikan <?= $nama_user ?> sebagai Bendahara?')">
                                            <i class="fa fa-star me-1"></i> Jadikan Bendahara
                                        </a>
                                    <?php else: ?>
                                        <a href="manajemen_anggota.php?ubah_role=true&id=<?= $id_user ?>&role=anggota" 
                                           class="btn btn-sm btn-outline-secondary rounded-pill px-3"
                                           onclick="return confirm('Kembalikan <?= $nama_user ?> ke role Anggota biasa?')">
                                            <i class="fa fa-user me-1"></i> Lepas Jabatan
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php 
                                endwhile; 
                            } else {
                                echo "<tr><td colspan='4' class='text-center py-4 text-muted'>Belum ada anggota terdaftar.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<script>

// navbar effect
window.addEventListener("scroll", function(){

    const navbar = document.querySelector(".navbar");

    if(window.scrollY > 20){
        navbar.classList.add("scrolled");
    }else{
        navbar.classList.remove("scrolled");
    }

});

// animasi scroll
const fadeElements = document.querySelectorAll('.fade-up');

const observer = new IntersectionObserver((entries)=>{
    entries.forEach(entry=>{
        if(entry.isIntersecting){
            entry.target.classList.add('show');
        }
    });
},{
    threshold:0.1
});

fadeElements.forEach(el=>{
    observer.observe(el);
});

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php include "../assets/menu/footer.php"; ?>