<!-- activity.php -->
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kegiatan Siswa</title>
<link rel="stylesheet" href="style/kegiatan-style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="dashboard">

<?php include 'sidebar.php'; ?>    

    <!-- Main -->
    <main class="main-content">

        <!-- Topbar -->
        <header class="topbar">
            <div class="search-box">
                <i class="fa fa-search"></i>
                <input type="text" placeholder="Search Members or Events...">
            </div>

            <div class="profile">
                <img src="https://i.pravatar.cc/40" alt="">
                <div>
                    <h4>Admin Pramuka</h4>
                    <span>Super Admin</span>
                </div>
            </div>
        </header>

        <!-- Title -->
        <section class="title-row">
            <div>
                <h1>Jadwal Kegiatan</h1>
                <p>Create and manage scout activities</p>
            </div>

            <button class="btn-add" onclick="openModal()">
                <i class="fa fa-plus"></i> Tambah Kegiatan Baru
            </button>
        </section>

        <!-- Table -->
        <section class="table-box">
            <table>
                <tr>
                    <th>Nama Kegiatan</th>
                    <th>Tanggal</th>
                    <th>Lokasi</th>
                    <th>Status</th>
                </tr>

                <tr>
                    <td>Latihan Morse & Sandi</td>
                    <td>19 April 2026</td>
                    <td>Lapangan Sekolah</td>
                    <td><span class="badge blue">Upcoming</span></td>
                </tr>

                <tr>
                    <td>Pelatihan P3K</td>
                    <td>22 April 2026</td>
                    <td>Aula Utama</td>
                    <td><span class="badge blue">Upcoming</span></td>
                </tr>

                <tr>
                    <td>Camping Akhir Bulan</td>
                    <td>26 April 2026</td>
                    <td>Gunung Pancar</td>
                    <td><span class="badge blue">Upcoming</span></td>
                </tr>

                <tr>
                    <td>Latihan PBB</td>
                    <td>15 April 2026</td>
                    <td>Lapangan</td>
                    <td><span class="badge gray">Completed</span></td>
                </tr>

                <tr>
                    <td>Kegiatan Bakti Sosial</td>
                    <td>16 April 2026</td>
                    <td>Desa Cibodas</td>
                    <td><span class="badge gray">Completed</span></td>
                </tr>

            </table>
        </section>

    </main>

</div>

<!-- Modal -->
<div class="modal" id="modal">
    <div class="modal-box">

        <div class="modal-header">
            <h2>Tambah Kegiatan Baru</h2>
            <span onclick="closeModal()">&times;</span>
        </div>

        <form>
            <label>Judul Keagiatan</label>
            <input type="text" placeholder="e.g. Latihan Morse & Sandi">

            <label>tanggal</label>
            <input type="date">

            <label>Lokasi</label>
            <input type="text" placeholder="e.g. Lapangan Sekolah">

            <label>Deskripsi</label>
            <textarea rows="4" placeholder="Describe the activity..."></textarea>

            <label>Foto Kegiatan</label>
            <div class="upload-box">
                Click to upload image <br>
                <small>PNG, JPG up to 10MB</small>
            </div>

            <div class="modal-btn">
                <button type="submit" class="save">Tambah Kegiatan</button>
                <button type="button" class="cancel" onclick="closeModal()">Cancel</button>
            </div>

        </form>

    </div>
</div>

<script>
function openModal(){
    document.getElementById("modal").style.display = "flex";
}

function closeModal(){
    document.getElementById("modal").style.display = "none";
}
</script>

</body>
</html>