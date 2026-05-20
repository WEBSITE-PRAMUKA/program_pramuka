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
            
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card card-galeri">
                    <div class="card-img-container">
                        <img src="https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?auto=format&fit=crop&q=80" class="card-img-top" alt="Persami" style="height: 200px; object-fit: cover;">
                        <span class="badge-upcoming text-uppercase">Upcoming</span>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Perkemahan Sabtu Minggu (PERSAMI)</h5>
                        <div class="info-item"><i class="far fa-calendar-alt"></i> 15-16 Maret 2026</div>
                        <div class="info-item"><i class="fas fa-map-marker-alt"></i> Gunung Gede Pangrango</div>
                        <div class="info-item"><i class="fas fa-users"></i> 120 peserta</div>
                        <p class="card-text">Kegiatan camping 2 hari 1 malam dengan berbagai aktivitas kepramukaan dan outbound.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card card-galeri">
                    <div class="card-img-container">
                        <img src="https://images.unsplash.com/photo-1526726533690-5cbe947c9052?auto=format&fit=crop&q=80" class="card-img-top" alt="Jambore" style="height: 200px; object-fit: cover;">
                        <span class="badge-upcoming text-uppercase">Upcoming</span>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Jambore Daerah 2026</h5>
                        <div class="info-item"><i class="far fa-calendar-alt"></i> 5-10 Juli 2026</div>
                        <div class="info-item"><i class="fas fa-map-marker-alt"></i> Cibubur, Jakarta Timur</div>
                        <div class="info-item"><i class="fas fa-users"></i> 500+ peserta</div>
                        <p class="card-text">Pertemuan besar tingkat daerah dengan peserta dari seluruh Gugus Depan di Jakarta.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card card-galeri">
                    <div class="card-img-container">
                        <img src="https://images.unsplash.com/photo-1563805042-7684c019e1cb?auto=format&fit=crop&q=80" class="card-img-top" alt="Pionering" style="height: 200px; object-fit: cover;">
                        <span class="badge-upcoming text-uppercase">Upcoming</span>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Lomba Pionering Tingkat Nasional</h5>
                        <div class="info-item"><i class="far fa-calendar-alt"></i> 20 Agustus 2026</div>
                        <div class="info-item"><i class="fas fa-map-marker-alt"></i> Stadion Gelora Bung Karno</div>
                        <div class="info-item"><i class="fas fa-users"></i> 200 tim</div>
                        <p class="card-text">Kompetisi pionering antar Gugus Depan se-Indonesia dengan berbagai kategori lomba.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card card-galeri">
                    <div class="card-img-container">
                        <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&q=80" class="card-img-top" alt="Baksos" style="height: 200px; object-fit: cover;">
                        <span class="badge-upcoming text-uppercase">Upcoming</span>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Bakti Sosial & Penghijauan</h5>
                        <div class="info-item"><i class="far fa-calendar-alt"></i> 12 September 2026</div>
                        <div class="info-item"><i class="fas fa-map-marker-alt"></i> Desa Cisande, Bogor</div>
                        <div class="info-item"><i class="fas fa-users"></i> 80 peserta</div>
                        <p class="card-text">Kegiatan pengabdian masyarakat dengan menanam 1000 pohon dan membersihkan lingkungan.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card card-galeri">
                    <div class="card-img-container">
                        <img src="https://images.unsplash.com/photo-1517164850305-99a3e65bb47e?auto=format&fit=crop&q=80" class="card-img-top" alt="Pelantikan" style="height: 200px; object-fit: cover;">
                        <span class="badge-upcoming text-uppercase">Upcoming</span>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Pelantikan Anggota Baru</h5>
                        <div class="info-item"><i class="far fa-calendar-alt"></i> 5 Oktober 2026</div>
                        <div class="info-item"><i class="fas fa-map-marker-alt"></i> Gedung Serbaguna Pramuka</div>
                        <div class="info-item"><i class="fas fa-users"></i> 150 peserta</div>
                        <p class="card-text">Upacara pelantikan anggota baru dan penyematan Tanda Kecakapan Umum (TKU).</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card card-galeri">
                    <div class="card-img-container">
                        <img src="https://images.unsplash.com/photo-1478131143081-80f7f84ca84d?auto=format&fit=crop&q=80" class="card-img-top" alt="Kemah Akhir Tahun" style="height: 200px; object-fit: cover;">
                        <span class="badge-upcoming text-uppercase">Upcoming</span>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Kemah Bhakti Akhir Tahun</h5>
                        <div class="info-item"><i class="far fa-calendar-alt"></i> 20-25 Desember 2026</div>
                        <div class="info-item"><i class="fas fa-map-marker-alt"></i> Pantai Anyer, Banten</div>
                        <div class="info-item"><i class="fas fa-users"></i> 250 peserta</div>
                        <p class="card-text">Kemah penutup tahun dengan kegiatan kreativitas, api unggun, dan refleksi tahunan.</p>
                    </div>
                </div>
            </div>

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