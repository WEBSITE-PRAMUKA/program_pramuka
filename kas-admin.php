<!-- kas-admin.php -->
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kas</title>
<link rel="stylesheet" href="style/kas-style.css">
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
                <input type="text" placeholder="Search here...">
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
                <h1>Kas</h1>
                <p>Track income, expenses, and cash flow</p>
            </div>

            <button class="btn-add" onclick="openModal()">
                <i class="fa fa-plus"></i> Add Transaction
            </button>
        </section>

        <!-- Cards -->
        <section class="cards">

            <div class="card brown">
                <small>Current Balance</small>
                <h2>Rp 6.050.000</h2>
            </div>

            <div class="card green">
                <small>Total Income</small>
                <h2>Rp 8.700.000</h2>
            </div>

            <div class="card red">
                <small>Total Expenses</small>
                <h2>Rp 2.650.000</h2>
            </div>

        </section>

        <!-- Table -->
        <section class="table-box">
            <h3>Transaction History</h3>
            <p>All income and expense records</p>

            <table>
                <tr>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Amount</th>
                    <th>Type</th>
                </tr>

                <tr>
                    <td>18 Apr 2026</td>
                    <td>Iuran Bulanan April</td>
                    <td>Fee</td>
                    <td class="text-green">Rp 2.500.000</td>
                    <td><span class="badge income">+ Income</span></td>
                </tr>

                <tr>
                    <td>17 Apr 2026</td>
                    <td>Pembelian Tenda Camping</td>
                    <td>Equipment</td>
                    <td class="text-red">Rp 1.500.000</td>
                    <td><span class="badge expense">- Expense</span></td>
                </tr>

                <tr>
                    <td>15 Apr 2026</td>
                    <td>Donasi Perusahaan</td>
                    <td>Donation</td>
                    <td class="text-green">Rp 5.000.000</td>
                    <td><span class="badge income">+ Income</span></td>
                </tr>

                <tr>
                    <td>10 Apr 2026</td>
                    <td>Transportasi Kemah</td>
                    <td>Transport</td>
                    <td class="text-red">Rp 800.000</td>
                    <td><span class="badge expense">- Expense</span></td>
                </tr>

                <tr>
                    <td>8 Apr 2026</td>
                    <td>Perlengkapan P3K</td>
                    <td>Equipment</td>
                    <td class="text-red">Rp 350.000</td>
                    <td><span class="badge expense">- Expense</span></td>
                </tr>

            </table>
        </section>

    </main>
</div>

<!-- Modal -->
<div class="modal" id="modal">
    <div class="modal-box">

        <div class="modal-header">
            <h2>Add Transaction</h2>
            <span onclick="closeModal()">&times;</span>
        </div>

        <form>

            <label>Transaction Type</label>
            <select>
                <option>Income</option>
                <option>Expense</option>
            </select>

            <label>Description</label>
            <input type="text" placeholder="e.g. Iuran Bulanan April">

            <div class="grid2">
                <div>
                    <label>Category</label>
                    <select>
                        <option>Fee</option>
                        <option>Donation</option>
                        <option>Equipment</option>
                        <option>Transport</option>
                    </select>
                </div>

                <div>
                    <label>Amount (Rp)</label>
                    <input type="number" placeholder="1000000">
                </div>
            </div>

            <label>Date</label>
            <input type="date">

            <label>Receipt / Proof</label>
            <div class="upload-box">
                <i class="fa fa-upload"></i><br>
                Upload receipt <br>
                <small>PNG, JPG, PDF up to 5MB</small>
            </div>

            <div class="modal-btn">
                <button class="save">Add Transaction</button>
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