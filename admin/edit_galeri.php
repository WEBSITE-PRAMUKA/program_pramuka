<?php
session_start();
include "../config/koneksi.php";

// Cek session admin
if (!isset($_SESSION['status_login']) || $_SESSION['role'] != 'admin') {
    header("location:../auth/login.php");
    exit;
}

// Cek apakah ada parameter 'id' di URL (SUDAH DIPERBAIKI JADI 'id')
if (!isset($_GET['id'])) {
    echo "<script>alert('Pilih album yang ingin diedit terlebih dahulu!'); window.location.href='galeri_admin.php';</script>";
    exit;
}

// Ambil ID dari URL (SUDAH DIPERBAIKI JADI 'id')
$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM galeri WHERE id_galeri = '$id'");
$data = mysqli_fetch_assoc($query);

// Jika data tidak ditemukan
if (!$data) {
    echo "<script>alert('Data tidak ditemukan!'); window.location.href='galeri_admin.php';</script>";
    exit;
}

// Proses Update Data jika tombol submit ditekan
if (isset($_POST['update'])) {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $kategori = $_POST['kategori'];
    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $lokasi = mysqli_real_escape_string($conn, $_POST['lokasi']);
    $peserta = mysqli_real_escape_string($conn, $_POST['peserta']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    
    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];

    // Jika admin mengupload foto baru
    if ($foto != "") {
        // Buat nama unik untuk foto baru
        $ext = pathinfo($foto, PATHINFO_EXTENSION);
        $nama_foto_baru = time() . '_' . rand(100,999) . '.' . $ext;
        $path = "../assets/galeri/" . $nama_foto_baru;

        // Hapus foto lama
        $foto_lama = "../assets/galeri/" . $data['foto_cover'];
        if (file_exists($foto_lama) && $data['foto_cover'] != "") {
            unlink($foto_lama);
        }

        // Pindahkan foto baru dan update database
        move_uploaded_file($tmp, $path);
        $update_query = "UPDATE galeri SET judul_galeri='$judul', kategori='$kategori', tanggal='$tanggal', lokasi='$lokasi', peserta='$peserta', deskripsi='$deskripsi', foto_cover='$nama_foto_baru' WHERE id_galeri='$id'";
    } else {
        // Jika tidak upload foto baru, update data teks saja
        $update_query = "UPDATE galeri SET judul_galeri='$judul', kategori='$kategori', tanggal='$tanggal', lokasi='$lokasi', peserta='$peserta', deskripsi='$deskripsi' WHERE id_galeri='$id'";
    }

    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Album berhasil diupdate!'); window.location.href='galeri_admin.php';</script>";
    } else {
        echo "<script>alert('Gagal mengupdate album!');</script>";
    }
}

// Sertakan navbar admin
include "../assets/menu/admin-navbar.php";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Gallery - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/admin-style.css">
</head>
<body>
    <br><br>
<div class="container mb-5">
    <div class="row justify-content-center fade-up show">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold m-0">Edit Album</h2>
                <a href="galeri_admin.php" class="btn btn-secondary btn-sm fw-bold"><i class="fa fa-arrow-left me-1"></i> Kembali</a>
            </div>
            
            <div class="card p-4">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="text-center mb-3">
                        <label class="small fw-bold d-block mb-2">Foto Saat Ini:</label>
                        <img src="../assets/galeri/<?= $data['foto_cover'] ?>" alt="Cover Lama" class="img-thumbnail" style="height: 150px; object-fit: cover; border-radius: 10px;">
                    </div>

                    <div class="mb-4">
                        <label class="small fw-bold">Ganti Foto (Biarkan kosong jika tidak ingin ganti)</label>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="small fw-bold">Judul Album</label>
                            <input type="text" name="judul" class="form-control" value="<?= $data['judul_galeri'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small fw-bold">Kategori</label>
                            <select name="kategori" class="form-select" required>
                                <option value="Upcoming" <?= ($data['kategori'] == 'Upcoming') ? 'selected' : '' ?>>Upcoming</option>
                                <option value="Selesai" <?= ($data['kategori'] == 'Selesai') ? 'selected' : '' ?>>Selesai</option>
                                <option value="Training" <?= ($data['kategori'] == 'Training') ? 'selected' : '' ?>>Training</option>
                                <option value="Camping" <?= ($data['kategori'] == 'Camping') ? 'selected' : '' ?>>Camping</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small fw-bold">Tanggal Pelaksanaan</label>
                            <input type="text" name="tanggal" class="form-control" value="<?= $data['tanggal'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small fw-bold">Lokasi</label>
                            <input type="text" name="lokasi" class="form-control" value="<?= $data['lokasi'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small fw-bold">Jumlah Peserta</label>
                            <input type="text" name="peserta" class="form-control" value="<?= $data['peserta'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small fw-bold">Deskripsi Singkat</label>
                            <textarea name="deskripsi" class="form-control" rows="3" required><?= $data['deskripsi'] ?></textarea>
                        </div>
                    </div>
                    <button type="submit" name="update" class="btn btn-primary px-4 fw-bold w-100">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "../assets/menu/footer.php"; ?>
</body>
</html>