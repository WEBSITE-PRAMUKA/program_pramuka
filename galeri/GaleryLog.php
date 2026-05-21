<?php
include "../config/koneksi.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri & Prestasi - Pramuka Indonesia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fdfaf5;
            color: #333;
        }

        /* Navbar Custom */
        .navbar {
            background-color: #fff !important;
            border-bottom: 1px solid #eee;
        }
        .nav-link {
            color: #5d4037 !important;
            font-weight: 500;
        }
        .nav-link.active {
            background-color: #5d4037;
            color: #fff !important;
            border-radius: 5px;
        }

        /* Galeri Cards */
        .card-galeri {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s ease;
            background: #fff;
            height: 100%;
        }
        .card-galeri:hover {
            transform: translateY(-10px);
        }
        .card-img-container {
            position: relative;
        }
        .badge-upcoming {
            position: absolute;
            top: 15px;
            right: 15px;
            background-color: #ffc107;
            color: #000;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 5px 15px;
            border-radius: 20px;
        }
        .card-body {
            padding: 20px;
        }
        .card-title {
            font-weight: 700;
            color: #5d4037;
            font-size: 1.1rem;
            margin-bottom: 15px;
        }
        .info-item {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
        }
        .info-item i {
            width: 20px;
            color: #2d5a27;
        }
        .card-text {
            font-size: 0.85rem;
            color: #777;
            margin-top: 15px;
            line-height: 1.5;
        }

        /* Footer */
        .footer-main {
            background-color: #5d4037;
            color: #fff;
            padding: 50px 0 20px 0;
            margin-top: 80px;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center fw-bold" href="beranda1.php" style="color: #5d4037;">
                <span class="badge bg-secondary me-2" style="background-color: #5d4037 !important;">P</span> Pramuka
            </a>
            <div class="collapse navbar-collapse justify-content-center">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link px-3" href="../pages/beranda1.php">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="../auth/daftar.php">Pendaftaran</a></li>
                    <li class="nav-item"><a class="nav-link px-3 active" href="#">Galeri</a></li>
                </ul>
            </div>
            <div class="d-flex align-items-center">
                <a href="../auth/login.php" class="text-dark me-3"><i class="fas fa-user-circle fs-4"></i></a>
                <button class="btn btn-sm btn-outline-dark px-3">Login</button>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <div class="mb-5" data-aos="fade-right">
            <h2 class="fw-bold" style="color: #5d4037;">Galeri / Prestasi</h2>
            <p class="text-muted">Ikuti berbagai event dan kegiatan pramuka sepanjang tahun</p>
        </div>

        <div class="row g-4">
            <?php 
            $delay = 100;
            // Ambil data dari database, urutkan dari yang terbaru
            $query = mysqli_query($conn, "SELECT * FROM galeri ORDER BY id_galeri DESC");
            
            while($row = mysqli_fetch_assoc($query)): 
            ?>
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?= $delay ?>">
                <div class="card card-galeri">
                    <div class="card-img-container">
                        <img src="../assets/galeri/<?= htmlspecialchars($row['foto_cover'] ?? '') ?>" class="card-img-top" alt="<?= htmlspecialchars($row['judul_galeri'] ?? 'Galeri') ?>" style="height: 200px; object-fit: cover;">
                        <span class="badge-upcoming text-uppercase"><?= htmlspecialchars($row['kategori'] ?? 'Umum') ?></span>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($row['judul_galeri'] ?? 'Tanpa Judul') ?></h5>
                        
                        <div class="info-item"><i class="far fa-calendar-alt"></i> <?= htmlspecialchars($row['tanggal'] ?? '-') ?></div>
                        <div class="info-item"><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($row['lokasi'] ?? 'Lokasi belum ditentukan') ?></div>
                        <div class="info-item"><i class="fas fa-users"></i> <?= htmlspecialchars($row['peserta'] ?? '0') ?> peserta</div>
                        
                        <p class="card-text"><?= htmlspecialchars($row['deskripsi'] ?? 'Belum ada deskripsi untuk kegiatan ini.') ?></p>
                    </div>
                </div>
            </div>
            <?php 
                // Logika agar animasi AOS bervariasi (100, 200, 300)
                $delay += 100;
                if($delay > 300) $delay = 100;
            endwhile; 
            ?>
        </div>
    </div>

    <footer class="footer-main">
        <div class="container">
            <div class="row">
                <div class="col-md-5 mb-4">
                    <h5 class="fw-bold d-flex align-items-center">
                        <span class="badge bg-warning me-2 text-dark">P</span> Pramuka Indonesia
                    </h5>
                    <p class="small mt-3 text-white-50">
                        Gerakan Pramuka Indonesia - Membentuk karakter pemuda yang berakhlak mulia, bertanggung jawab, dan bermanfaat bagi masyarakat.
                    </p>
                </div>
                <div class="col-md-4 mb-4">
                    <h6 class="fw-bold mb-3">Hubungi Kami</h6>
                    <p class="small mb-2"><i class="fas fa-map-marker-alt me-2"></i> Jl. Pramuka No. 123, Jakarta Pusat</p>
                    <p class="small mb-2"><i class="fas fa-phone me-2"></i> (021) 1234-5678</p>
                    <p class="small"><i class="fas fa-envelope me-2"></i> info@pramuka.or.id</p>
                </div>
                <div class="col-md-3 mb-4 text-md-end">
                    <h6 class="fw-bold mb-3">Media Sosial</h6>
                    <div class="d-flex justify-content-md-end gap-3">
                        <a href="#" class="text-white"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
            <div class="text-center pt-4 border-top border-secondary mt-3">
                <p class="small text-white-50">© 2026 Gerakan Pramuka Indonesia. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true
        });
    </script>
</body>
</html>