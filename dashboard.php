<!-- index.php -->
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard Pramuka</title>
<link rel="stylesheet" href="style/dashboard-style.css">
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
                <i class="fa-regular fa-bell"></i>
                <img src="https://i.pravatar.cc/40" alt="">
                <div>
                    <h4>Admin Pramuka</h4>
                    <span>Super Admin</span>
                </div>
            </div>
        </header>

        <!-- Title -->
        <section class="title">
            <h1>Dashboard Overview</h1>
            <p>Monitor and manage your scout organization</p>
        </section>

        <!-- Cards -->
        <section class="cards">

            <div class="card">
                <div class="icon brown"><i class="fa-solid fa-calendar-days"></i></div>
                <p>Total Kegiatan</p>
                <h2>24</h2>
            </div>

            <div class="card">
                <div class="icon green"><i class="fa-solid fa-users"></i></div>
                <p>Attendance Today</p>
                <h2>87%</h2>
            </div>

            <div class="card">
                <div class="icon orange"><i class="fa-solid fa-image"></i></div>
                <p>New Gallery Photos</p>
                <h2>156</h2>
            </div>

            <div class="card">
                <div class="icon blue"><i class="fa-solid fa-award"></i></div>
                <p>Total Prestasi</p>
                <h2>42</h2>
            </div>

        </section>

        <!-- Chart -->
        <section class="chart-box">
            <h3>Attendance Trends (Last 7 Days)</h3>
            <div class="chart">
                <svg viewBox="0 0 500 220">
                    <polyline fill="none" stroke="#2f8f46" stroke-width="4"
                    points="20,80 90,100 160,60 230,70 300,50 370,120 440,75"/>
                    <circle cx="20" cy="80" r="5"/>
                    <circle cx="90" cy="100" r="5"/>
                    <circle cx="160" cy="60" r="5"/>
                    <circle cx="230" cy="70" r="5"/>
                    <circle cx="300" cy="50" r="5"/>
                    <circle cx="370" cy="120" r="5"/>
                    <circle cx="440" cy="75" r="5"/>
                </svg>
            </div>
        </section>

        <!-- Table -->
        <section class="table-box">
            <h3>Recent Activities</h3>
            <table>
                <tr>
                    <th>Nama Kegiatan</th>
                    <th>Tanggal</th>
                    <th>Lokasi</th>
                    <th>Status</th>
                </tr>

                <tr>
                    <td>Latihan Morse & Sandi</td>
                    <td>April 19, 2026</td>
                    <td>Lapangan Sekolah</td>
                    <td><span class="badge green">Ongoing</span></td>
                </tr>

                <tr>
                    <td>Pelatihan P3K</td>
                    <td>April 22, 2026</td>
                    <td>Aula Utama</td>
                    <td><span class="badge blue">Upcoming</span></td>
                </tr>

                <tr>
                    <td>Camping Akhir Bulan</td>
                    <td>April 26-27</td>
                    <td>Gunung Pancar</td>
                    <td><span class="badge blue">Upcoming</span></td>
                </tr>

                <tr>
                    <td>Latihan PBB</td>
                    <td>April 15</td>
                    <td>Lapangan</td>
                    <td><span class="badge gray">Completed</span></td>
                </tr>

            </table>
        </section>

    </main>
</div>

</body>
</html>