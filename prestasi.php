<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Prestasi</title>
<link rel="stylesheet" href="style/prestasi-style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="dashboard">

  <?php include 'sidebar.php'; ?>

 
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
                <h1>Prestasi</h1>
                <p>Track and celebrate member achievements</p>
            </div>

            <button class="btn-add" onclick="openModal()">
                <i class="fa fa-plus"></i> Tambah Prestasi
            </button>
        </section>

        <!-- Achievement List -->
        <section class="achievement-list">

            <div class="item gold">
                <div class="medal"><i class="fa fa-award"></i></div>
                <img src="https://i.pravatar.cc/45?img=12">
                <div class="info">
                    <h3>Ahmad Fauzi</h3>
                    <p>Lomba Morse & Sandi Tingkat Provinsi</p>
                </div>
                <span class="rank first">1st</span>
                <small>15 Maret 2026</small>
            </div>

            <div class="item gold">
                <div class="medal"><i class="fa fa-award"></i></div>
                <img src="https://i.pravatar.cc/45?img=22">
                <div class="info">
                    <h3>Siti Nurhaliza</h3>
                    <p>Best Leader Award 2026</p>
                </div>
                <span class="rank first">1st</span>
                <small>20 Februari 2026</small>
            </div>

            <div class="item silver">
                <div class="medal"><i class="fa fa-award"></i></div>
                <img src="https://i.pravatar.cc/45?img=33">
                <div class="info">
                    <h3>Budi Santoso</h3>
                    <p>Kompetisi P3K Regional</p>
                </div>
                <span class="rank second">2nd</span>
                <small>10 April 2026</small>
            </div>

            <div class="item bronze">
                <div class="medal"><i class="fa fa-award"></i></div>
                <img src="https://i.pravatar.cc/45?img=45">
                <div class="info">
                    <h3>Dewi Lestari</h3>
                    <p>Lomba Pioneering Nasional</p>
                </div>
                <span class="rank third">3rd</span>
                <small>28 Januari 2026</small>
            </div>

        </section>

    </main>
</div>

<!-- Modal -->
<div class="modal" id="modal">
    <div class="modal-box">

        <div class="modal-header">
            <h2>Tambah Prestasi Baru</h2>
            <span onclick="closeModal()">&times;</span>
        </div>

        <form>

            <label>Nama Peserta</label>
            <input type="text" placeholder="e.g. Ahmad Fauzi">

            <label>Nama Lomba</label>
            <input type="text" placeholder="e.g. Lomba Morse & Sandi">

            <div class="grid2">
                <div>
                    <label>Juara</label>
                    <select>
                        <option>1st</option>
                        <option>2nd</option>
                        <option>3rd</option>
                    </select>
                </div>

                <div>
                    <label>Tanggal/Bulan/Tahun</label>
                    <input type="date">
                </div>
            </div>

            <label>Upload Foto</label>
            <div class="upload-box">
                <i class="fa fa-upload"></i><br>
                Upload Foto <br>
                <small>PNG, JPG up to 10MB</small>
            </div>

            <div class="modal-btn">
                <button class="save">Tambah Prestasi</button>
                <button type="button" class="cancel" onclick="closeModal()">Cancel</button>
            </div>

        </form>

    </div>
</div>

<script>
function openModal(){
document.getElementById("modal").style.display="flex";
}
function closeModal(){
document.getElementById("modal").style.display="none";
}
</script>

</body>
</html>

