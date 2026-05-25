<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pramuka Indonesia - Beranda</title>
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Frameworks -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- External CSS -->
    <link rel="stylesheet" href="../assets/css/beranda1-style.css">
</head>
<body>

    <!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top transition-navbar">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center fw-bold" >
                <img src="../assets/LOGO/logo-bg.png" alt="Logo Tunas Kelapa" height="47" class="me-2">
                 <img src="../assets/LOGO/Wosm-Negatif.png" alt="Wosm Negatif" height="55" class="me-2">
                </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="fas fa-bars text-white"></i>
            </button>
            
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav mx-auto gap-3">
                    <li class="nav-item"><a class="nav-link" href="beranda1.php">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="../auth/daftar.php">Pendaftaran</a></li>
                    <li class="nav-item"><a class="nav-link" href="../galeri/GaleryLog.php">Galeri</a></li>
                </ul>
            </div>
            
            <div class="d-none d-lg-flex gap-2">
                <a href="../auth/login.php" class="btn btn-outline-light btn-sm rounded-pill px-3">Login</a>
                <a href="../auth/daftar.php" class="btn btn-pramuka-yellow btn-sm rounded-pill px-3 fw-semibold">Daftar Anggota</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero-section" style="background: linear-gradient(135deg, rgba(27, 58, 26, 0.55), rgba(45, 90, 39, 0.55)), url('../assets/BG/BG.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">
        
        <div class="hero-overlay"></div>
        <div class="container hero-content" data-aos="zoom-in" data-aos-duration="1000">
            <h1 class="display-3 fw-bold hero-title">Satyaku Kudarmabaktikan<br>Darmaku Kubaktikan</h1>
            <p class="lead my-4 mx-auto hero-subtitle">Bergabunglah dengan Gerakan Pramuka Indonesia untuk mengembangkan karakter, keterampilan, dan jiwa kepemimpinan Anda.</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="../auth/daftar.php" class="btn btn-pramuka-yellow btn-lg px-4 py-2 hover-bounce">Daftar Anggota <i class="fas fa-chevron-right ms-1"></i></a>
                <a href="../auth/login.php" class="btn btn-outline-light btn-lg px-4 py-2 hover-float">Masuk</a>
            </div>
        </div>
        
    </header>

    <!-- Profile Section -->
    <section class="container py-5 text-center mt-4">
        <div data-aos="fade-up">
            <h2 class="fw-bold section-title mb-3">Profil</h2>
            <p class="fst-italic text-muted">"Satu pramuka untuk satu Indonesia, ikhlas bakti bina bangsa berbudi bawa laksana."</p>
            
            <div class="row justify-content-center mt-5">
                <div class="col-md-4 mb-4">
                    <div class="profile-box shadow-hover">
                        <div class="icon-wrapper mb-3"><i class="fas fa-bullseye text-success fs-2"></i></div>
                        <h5 class="fw-bold border-bottom pb-2">Visi & Misi</h5>
                        <p class="small text-muted mt-3">"Satyaku Kudarmabaktikan, Darmaku Kubaktikan. Mengembangkan potensi diri menjadi manusia yang berkarakter."</p>
                    </div>
                </div>
                <div class="col-md-8 mb-4 text-start">
                    <div class="profile-box shadow-hover h-100">
                        <div class="text-center mb-3"><i class="fas fa-book-open text-warning fs-2"></i></div>
                        <h5 class="fw-bold border-bottom pb-2 text-center">Sejarah Singkat Kepramukaan</h5>
                        <ul class="small text-muted mt-3 custom-list">
                            <li>Tokoh-tokoh kepramukaan banyak lahir di zaman Perang Dunia Pertama.</li>
                            <li>Baden Powell awalnya membawa kegiatannya ke luar Inggris.</li>
                            <li>Buku "Scouting for Boys" menjadi awal populer kepanduan dunia.</li>
                            <li>Gerakan Pramuka Indonesia resmi diperkenalkan pada 14 Agustus 1961.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="container py-5 bg-light-custom rounded-4">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold section-title">Layanan Sistem</h2>
            <p class="text-muted">Unit layanan digital untuk mendukung administrasi kegiatan kepramukaan</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card service-card p-4 h-100">
                    <div class="service-icon"><i class="fas fa-user-plus"></i></div>
                    <h5 class="fw-bold mt-3">Pendaftaran Anggota</h5>
                    <p class="small text-muted flex-grow-1">Daftarkan diri Anda sebagai anggota secara online dengan cepat dan mudah.</p>
                    <a href="../auth/daftar.php" class="text-success text-decoration-none fw-bold small link-hover">Selengkapnya <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card service-card p-4 h-100">
                    <div class="service-icon"><i class="fas fa-calendar-check"></i></div>
                    <h5 class="fw-bold mt-3">Sistem Absensi</h5>
                    <p class="small text-muted flex-grow-1">Pantau kehadiran anggota Pramuak secara digital dalam setiap kegiatan.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card service-card p-4 h-100">
                    <div class="service-icon"><i class="fas fa-wallet"></i></div>
                    <h5 class="fw-bold mt-3">Manajemen Kas</h5>
                    <p class="small text-muted flex-grow-1">Permudah pencatatan iuran serta laporan kas secara rapi dan terpercaya.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="container py-5 my-5">
        <div class="row align-items-center" data-aos="fade-right">
            <div class="col-md-6 pe-md-5">
                <h2 class="fw-bold mb-4 section-title">Tentang Kami</h2>
                <p class="text-muted" style="line-height: 1.8;">Gerakan Pramuka Indonesia adalah wadah pendidikan non-formal yang membentuk karakter generasi muda berlandaskan kedisiplinan, kepemimpinan, dan pengabdian masyarakat.</p>
                <p class="text-muted" style="line-height: 1.8;">Melalui integrasi teknologi, kami berusaha menghadirkan tata kelola organisasi yang lebih modern tanpa meninggalkan nilai-nilai luhur kepanduan.</p>
            </div>
            <div class="col-md-6 mt-4 mt-md-0" data-aos="zoom-in-left">
                <div class="img-wrapper">
                    <img src="../assets/BG/GETHERING.jpg" class="img-fluid rounded-4 shadow-lg" alt="Pramuka">
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Quote -->
    <div class="footer-top">
        <div class="container" data-aos="fade-up">
            <h3 class="fst-italic fw-light">"Jadilah dirimu sendiri, bukan orang lain. Kenali dirimu, terima dirimu, dan kembangkan dirimu."</h3>
            <p class="mt-3 fw-bold text-warning">- Baden Powell</p>
        </div>
    </div>

    <!-- Main Footer -->
    <footer class="footer-bottom">
        <div class="container text-start">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold text-white mb-3">Pramuka Indonesia</h5>
                    <p class="small text-light-50">Gerakan Pramuka Indonesia melahirkan karakter tangguh, terampil, dan berintegritas untuk masa depan bangsa.</p>
                </div>
                <div class="col-md-4 mb-4 px-md-5">
                    <h6 class="fw-bold text-white mb-3">Hubungi Kami</h6>
                    <p class="small text-light-50 mb-2"><i class="fas fa-map-marker-alt me-2 text-warning"></i> Jl. KH. Abdul Kholiq No.26, Kencong, Jember, Jawa Timur 68167</p>
                    <p class="small text-light-50 mb-2"><i class="fas fa-phone me-2 text-warning"></i> (0336) 3205697</p>
                </div>
                <div class="col-md-4 mb-4 text-md-end">
                    <h6 class="fw-bold text-white mb-3">Media Sosial</h6>
                    <div class="d-flex justify-content-md-end gap-3 fs-4">
                        <a href="https://www.facebook.com/share/17awpEArR1/" target="_blank" rel="noopener noreferrer" class="social-icon">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="https://www.instagram.com/grapaska_yunisma?igsh=MTEybHk4dzI0Y2VuYg==" target="_blank" rel="noopener noreferrer" class="social-icon">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                        <a href="https://www.tiktok.com/@grapaska_yunisma?_r=1&_t=ZS-96bWHdSFUSV" target="_blank" rel="noopener noreferrer" class="social-icon">
                            <i class="fa-brands fa-tiktok"></i>
                        </a>
                    </div>
                </div>
            </div>
            <hr class="border-secondary mt-4">
            <p class="text-center small mb-0 text-light-50">SMK Ma'arif NU Kencong</p>
        </div>
    </footer>

    <!-- JS Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        // Inisialisasi AOS (Animasi Scroll)
        AOS.init({
            duration: 800,
            once: true,
            easing: 'ease-in-out'
        });

        // Efek transisi Navbar saat di-scroll
        window.addEventListener("scroll", function () {
            let navbar = document.querySelector(".navbar");
            if (window.scrollY > 50) {
                navbar.classList.add("navbar-scrolled");
            } else {
                navbar.classList.remove("navbar-scrolled");
            }
        });

        // Tombol Scroll ke Atas
        const btnTop = document.createElement("button");
        btnTop.innerHTML = '<i class="fas fa-arrow-up"></i>';
        btnTop.className = "scroll-to-top";
        document.body.appendChild(btnTop);

        window.addEventListener("scroll", () => {
            if (window.scrollY > 300) {
                btnTop.classList.add("show");
            } else {
                btnTop.classList.remove("show");
            }
        });

        btnTop.onclick = () => {
            window.scrollTo({ top: 0, behavior: "smooth" });
        };
    </script>
</body>
</html>
