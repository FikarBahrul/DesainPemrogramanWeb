<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.html");
    exit;
}

/* ==================== KONFIGURASI DATABASE ==================== */
$host = 'localhost';
$port = '5432';
$dbname = 'db_obat';
$user = 'postgres';
$pass = 'zemoteno';

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$pass");

// Hitung statistik
$totalObat = pg_fetch_result(pg_query($conn, "SELECT COUNT(*) FROM obat"), 0);
$totalUsers = pg_fetch_result(pg_query($conn, "SELECT COUNT(*) FROM users"), 0);

// Ambil data obat terbaru
$recentObat = pg_query($conn, "SELECT * FROM obat ORDER BY id DESC LIMIT 5");

pg_close($conn);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Obat</title>
    <link rel="icon" type="image/png" href="icon-obat.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="min-vh-100" style="background: linear-gradient(180deg, #e0f2fe 0%, #f0fdfa 100%);">
    
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">🏥 Sistem Obat</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="indexObat.html">Daftar Obat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="tambahObat.php">Database Obat</a>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link">👤 <?= htmlspecialchars($_SESSION['fullname']) ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-warning" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container my-5">
        <!-- Welcome Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-body p-4">
                <h2 class="text-primary mb-2">Selamat Datang, <?= htmlspecialchars($_SESSION['fullname']) ?>! 👋</h2>
                <p class="text-muted mb-0">Username: <strong><?= htmlspecialchars($_SESSION['username']) ?></strong> | Email: <strong><?= htmlspecialchars($_SESSION['email']) ?></strong></p>
            </div>
        </div>

        <!-- Statistik Cards -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card shadow-sm bg-info text-white">
                    <div class="card-body text-center p-4">
                        <h1 class="display-3 mb-2"><?= $totalObat ?></h1>
                        <h5 class="mb-0">💊 Total Obat</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm bg-success text-white">
                    <div class="card-body text-center p-4">
                        <h1 class="display-3 mb-2"><?= $totalUsers ?></h1>
                        <h5 class="mb-0">👥 Total Pengguna</h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Obat Terbaru -->
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h4 class="text-primary mb-4">📋 Obat Terbaru</h4>
                
                <?php if (pg_num_rows($recentObat) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Obat</th>
                                <th>Jenis</th>
                                <th>Dosis</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = pg_fetch_assoc($recentObat)): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($row['nama']) ?></strong></td>
                                <td><span class="badge bg-primary"><?= ucfirst($row['jenis']) ?></span></td>
                                <td><span class="badge bg-info"><?= ucfirst($row['dosis']) ?></span></td>
                                <td><?= htmlspecialchars($row['keterangan']) ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="alert alert-secondary text-center">Belum ada data obat</div>
                <?php endif; ?>

                <div class="text-center mt-3">
                    <a href="tambahObat.php" class="btn btn-primary">Lihat Semua Obat</a>
                    <a href="indexObat.html" class="btn btn-outline-primary">Cari Obat</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>