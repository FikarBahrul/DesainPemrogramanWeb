<?php
/* ==================== KONFIGURASI DATABASE ==================== */
$host = 'localhost';
$port = '5432';
$dbname = 'db_obat';
$user = 'postgres';
$pass = 'zemoteno';

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$pass");

/* ==================== HANDLE REQUEST AJAX (TAMBAH OBAT) ==================== */
$rawInput = file_get_contents('php://input');
$contentType = $_SERVER["CONTENT_TYPE"] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && str_contains($contentType, 'application/json') && !empty($rawInput)) {
    header('Content-Type: application/json');
    
    $data = json_decode($rawInput, true);
    
    if (empty($data['nama']) || empty($data['jenis']) || empty($data['dosis'])) {
        echo json_encode(['success' => false, 'message' => 'Semua field harus diisi']);
        exit;
    }
    
    $query = sprintf(
        "INSERT INTO obat (nama, jenis, dosis, keterangan, penggunaan) VALUES ('%s', '%s', '%s', '%s', '%s')",
        pg_escape_string($conn, $data['nama']),
        pg_escape_string($conn, $data['jenis']),
        pg_escape_string($conn, $data['dosis']),
        pg_escape_string($conn, $data['keterangan']),
        pg_escape_string($conn, $data['penggunaan'])
    );
    
    $result = pg_query($conn, $query);
    echo json_encode(['success' => (bool)$result, 'message' => $result ? 'Berhasil' : pg_last_error($conn)]);
    exit;
}

/* ==================== FITUR CRUD TAMBAHAN (EDIT & HAPUS) ==================== */
if (isset($_GET['hapus'])) {
    $id = (int) $_GET['hapus'];
    pg_query($conn, "DELETE FROM obat WHERE id = $id");
    header("Location: tambahObat.php");
    exit;
}

if (isset($_POST['update'])) { 
    $id = (int) $_POST['id'];
    $nama = pg_escape_string($conn, $_POST['nama']);
    $jenis = pg_escape_string($conn, $_POST['jenis']);
    $dosis = pg_escape_string($conn, $_POST['dosis']);
    $keterangan = pg_escape_string($conn, $_POST['keterangan']);
    $penggunaan = pg_escape_string($conn, $_POST['penggunaan']);

    $updateQuery = "UPDATE obat 
                    SET nama='$nama', jenis='$jenis', dosis='$dosis', 
                        keterangan='$keterangan', penggunaan='$penggunaan' 
                    WHERE id=$id";
    $updateResult = pg_query($conn, $updateQuery);

    if ($updateResult) {
        header("Location: tambahObat.php?status=updated");
        exit;
    } else {
        echo "<div class='alert alert-danger text-center'>Gagal mengupdate data: " . pg_last_error($conn) . "</div>";
    }
}

/* ==================== HALAMAN HTML ==================== */
$result = pg_query($conn, "SELECT * FROM obat ORDER BY nama ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Obat Database</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="min-vh-100" style="background: linear-gradient(180deg, #e0f2fe 0%, #f0fdfa 100%);">
    <div class="container my-5">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h1 class="text-center text-primary mb-4">📋 Daftar Obat dari Database</h1>

                <?php if (isset($_GET['status']) && $_GET['status'] === 'updated'): ?>
                    <div class="alert alert-success text-center">
                        ✅ Data berhasil diperbarui!
                    </div>
                <?php endif; ?>
                
                <?php if (isset($_GET['edit'])): 
                    $id = (int) $_GET['edit'];
                    $editData = pg_query($conn, "SELECT * FROM obat WHERE id = $id");
                    $obat = pg_fetch_assoc($editData);
                ?>
                <div class="card bg-light mb-4">
                    <div class="card-body">
                        <h2 class="text-primary mb-3">✏️ Edit Data Obat</h2>
                        <form method="POST" action="">
                            <input type="hidden" name="id" value="<?= $obat['id'] ?>">
                            <div class="mb-3">
                                <label class="form-label">Nama:</label>
                                <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($obat['nama']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenis:</label>
                                <input type="text" name="jenis" class="form-control" value="<?= htmlspecialchars($obat['jenis']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Dosis:</label>
                                <input type="text" name="dosis" class="form-control" value="<?= htmlspecialchars($obat['dosis']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Keterangan:</label>
                                <input type="text" name="keterangan" class="form-control" value="<?= htmlspecialchars($obat['keterangan']) ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Penggunaan:</label>
                                <input type="text" name="penggunaan" class="form-control" value="<?= htmlspecialchars($obat['penggunaan']) ?>">
                            </div>
                            <button type="submit" name="update" class="btn btn-primary">💾 Simpan Perubahan</button>
                            <a href="tambahObat.php" class="btn btn-secondary">Batal</a>
                        </form>
                    </div>
                </div>
                <?php endif; ?>
                
                <?php if (pg_num_rows($result) > 0): ?>
                    <p class="mb-3">Total: <strong><?= pg_num_rows($result) ?></strong> obat</p>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="table-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Obat</th>
                                    <th>Jenis</th>
                                    <th>Dosis</th>
                                    <th>Keterangan</th>
                                    <th>Cara Penggunaan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; while ($row = pg_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><strong><?= htmlspecialchars($row['nama']) ?></strong></td>
                                    <td><?= ucfirst($row['jenis']) ?></td>
                                    <td><?= ucfirst($row['dosis']) ?></td>
                                    <td><?= htmlspecialchars($row['keterangan']) ?></td>
                                    <td><?= htmlspecialchars($row['penggunaan']) ?></td>
                                    <td>
                                        <a class="btn btn-sm btn-info text-white" href="?edit=<?= $row['id'] ?>">Edit</a>
                                        <a class="btn btn-sm btn-danger" href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-secondary text-center">Belum ada data obat</div>
                <?php endif; ?>

                <div class="text-center mt-4">
                    <a href="indexObat.html" class="btn btn-primary">🔄 Kembali ke Halaman Pencarian</a>
                </div>
                <div class="text-center mt-4">
                    <a href="dashboard.php" class="btn btn-primary">🔄 Kembali ke Halaman Dashboard</a>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php 
pg_close($conn); 
?>