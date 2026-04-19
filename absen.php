<!-- attendance.php -->
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Attendance List</title>

<link rel="stylesheet" href="style/absen-style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!-- jsPDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

</head>
<body>

<div class="dashboard">

<?php include 'sidebar.php'; ?>

    <!-- Main -->
    <main class="main-content">

        <!-- Top -->
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
        <section class="title">
            <h1>Attendance List</h1>
            <p>Track and manage member attendance</p>
        </section>

        <!-- Filter -->
        <section class="filter-box">

            <div class="grid2">
                <div>
                    <label>Kelas / Jurusan</label>
                    <select>
                        <option>Semua Kelas</option>
                        <option>X IPA 1</option>
                        <option>X IPA 2</option>
                        <option>XI IPS 1</option>
                    </select>
                </div>

                <div>
                    <label>Tanggal</label>
                    <input type="date">
                </div>
            </div>

            <div class="btn-group">
                <button onclick="window.print()" class="print-btn">
                    <i class="fa fa-print"></i> Print
                </button>

                <button onclick="downloadPDF()" class="pdf-btn">
                    <i class="fa fa-file-pdf"></i> Export to PDF
                </button>
            </div>

        </section>

        <!-- Table -->
        <section class="table-box" id="printArea">

            <div class="table-head">
                <h3>Today's Attendance</h3>

                <div class="legend">
                    <span class="green-dot"></span> Masuk : 4
                    <span class="yellow-dot"></span> Telat : 2
                    <span class="red-dot"></span> alpa : 2
                </div>
            </div>

            <small>Minggu, 19 April 2026</small>

            <table>
                <tr>
                    <th>Nama</th>
                    <th>Waktu Masuk</th>
                    <th>Status</th>
                </tr>

                <tr>
                    <td>Ahmad Fauzi</td>
                    <td>08:00</td>
                    <td><span class="badge present">Present</span></td>
                </tr>

                <tr>
                    <td>Siti Nurhaliza</td>
                    <td>08:15</td>
                    <td><span class="badge late">Telat</span></td>
                </tr>

                <tr>
                    <td>Budi Santoso</td>
                    <td>-</td>
                    <td><span class="badge absent">Absent</span></td>
                </tr>

                <tr>
                    <td>Dewi Lestari</td>
                    <td>07:55</td>
                    <td><span class="badge present">Tepat Waktu</span></td>
                </tr>

                <tr>
                    <td>Rizky Pratama</td>
                    <td>08:10</td>
                    <td><span class="badge late">Telat</span></td>
                </tr>

                <tr>
                    <td>Maya Sari</td>
                    <td>08:00</td>
                    <td><span class="badge present">Tepat Waktu</span></td>
                </tr>

                <tr>
                    <td>Andi Wijaya</td>
                    <td>07:58</td>
                    <td><span class="badge present">Tepat waktu</span></td>
                </tr>

                <tr>
                    <td>Rina Kartika</td>
                    <td>-</td>
                    <td><span class="badge absent">Absent</span></td>
                </tr>

            </table>

        </section>

    </main>
</div>

<script>
async function downloadPDF(){

    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    doc.setFontSize(16);
    doc.text("Attendance Report", 20, 20);

    doc.setFontSize(11);
    doc.text("Tanggal: 19 April 2026", 20, 30);

    let y = 45;

    const data = [
        ["Ahmad Fauzi","08:00","Present"],
        ["Siti Nurhaliza","08:15","Late"],
        ["Budi Santoso","-","Absent"],
        ["Dewi Lestari","07:55","Present"],
        ["Rizky Pratama","08:10","Late"],
        ["Maya Sari","08:00","Present"],
        ["Andi Wijaya","07:58","Present"],
        ["Rina Kartika","-","Absent"]
    ];

    doc.text("Name",20,y);
    doc.text("Time",100,y);
    doc.text("Status",150,y);

    y += 10;

    data.forEach(row=>{
        doc.text(row[0],20,y);
        doc.text(row[1],100,y);
        doc.text(row[2],150,y);
        y += 10;
    });

    doc.save("attendance-report.pdf");
}
</script>

</body>
</html>