<?php
/* ==================== KONFIGURASI DATABASE ==================== */
// Data koneksi ke PostgreSQL
$host = 'localhost';
$port = '5432';
$dbname = 'db_obat';
$user = 'postgres';
$pass = 'zemoteno';

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$pass");// Membuat koneksi ke database PostgreSQL


/* ==================== HANDLE REQUEST AJAX (TAMBAH OBAT) ==================== */
// Cek apakah request dari JavaScript menggunakan POST dan JSON ada di body
$rawInput = file_get_contents('php://input'); //ambil isi body dari request
$contentType = $_SERVER["CONTENT_TYPE"] ?? ''; //ambil tipe konten dari header

// Jalankan blok ini HANYA jika POST JSON (AJAX)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && str_contains($contentType, 'application/json') && !empty($rawInput)) {
    
    header('Content-Type: application/json'); //difungsikan untuk memberitahu browser bahwa respon yang dikirim berformat JSON
    
    $data = json_decode($rawInput, true);
    
    // Validasi agar kolom tidak kosong
    if (empty($data['nama']) || empty($data['jenis']) || empty($data['dosis'])) {
        echo json_encode(['success' => false, 'message' => 'Semua field harus diisi']);
        exit;
    }
    
    $query = sprintf(//buat string dengan format tertentu
        "INSERT INTO obat (nama, jenis, dosis, keterangan, penggunaan) VALUES ('%s', '%s', '%s', '%s', '%s')",// Buat query INSERT dengan data yang sudah di-escape (keamanan dari SQL injection)
        pg_escape_string($conn, $data['nama']),//pg_escape_string menghalang SQL injection
        pg_escape_string($conn, $data['jenis']),
        pg_escape_string($conn, $data['dosis']),
        pg_escape_string($conn, $data['keterangan']),
        pg_escape_string($conn, $data['penggunaan'])
    );
    
    // Eksekusi query dan kirim response
    $result = pg_query($conn, $query); //menjalankan insert tadi
    echo json_encode(['success' => (bool)$result, 'message' => $result ? 'Berhasil' : pg_last_error($conn)]);//bool merubah result dari false menjadi true
    exit;
}


/* ==================== FITUR CRUD TAMBAHAN (EDIT & HAPUS) ==================== */
if (isset($_GET['hapus'])) { // Jika tombol hapus diklik
    $id = (int) $_GET['hapus'];
    pg_query($conn, "DELETE FROM obat WHERE id = $id");
    header("Location: tambahObat.php");
    exit;
}

// 🔧 Tangani form update/edit (bukan request JSON)
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
        echo "<p style='color:red; text-align:center;'>Gagal mengupdate data: " . pg_last_error($conn) . "</p>";
    }
}


/* ==================== HALAMAN HTML yang link ke database ==================== */
// Jika bukan request AJAX, ambil semua data obat untuk ditampilkan
$result = pg_query($conn, "SELECT * FROM obat ORDER BY nama ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Obat Database</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #e0f2fe; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 30px; border-radius: 12px; }
        h1 { color: #0369a1; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #0284c7; color: white; padding: 12px; text-align: left; }
        td { padding: 12px; border-bottom: 1px solid #e2e8f0; }
        tr:hover { background: rgba(14,165,233,0.1); }
        .btn { padding: 10px 20px; background: #0284c7; color: white; text-decoration: none; 
               border-radius: 8px; display: inline-block; margin-bottom: 20px; }
        .btn:hover { background: #0369a1; }
        .aksi-btn { background: #0ea5e9; padding: 6px 12px; border-radius: 6px; color: white; text-decoration: none; margin-right: 5px; }
        .hapus-btn { background: #dc2626; }
    </style>
</head>
<body>
    <div class="container">
        <!-- JUDUL HALAMAN -->
        <h1>📋 Daftar Obat dari Database</h1>

        <!-- Tampilkan notifikasi jika update sukses -->
        <?php if (isset($_GET['status']) && $_GET['status'] === 'updated'): ?>
            <p style="background:#d1fae5; color:#065f46; padding:10px; border-radius:8px; text-align:center;">
                ✅ Data berhasil diperbarui!
            </p>
        <?php endif; ?>
        
        <!-- FORM UPDATE (hanya muncul jika mode edit) -->
        <?php if (isset($_GET['edit'])): 
            $id = (int) $_GET['edit'];
            $editData = pg_query($conn, "SELECT * FROM obat WHERE id = $id");
            $obat = pg_fetch_assoc($editData);
        ?>
        <h2 style="color:#0284c7;">✏️ Edit Data Obat</h2>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?= $obat['id'] ?>">
            <label>Nama:</label><br>
            <input type="text" name="nama" value="<?= htmlspecialchars($obat['nama']) ?>" required><br><br>
            <label>Jenis:</label><br>
            <input type="text" name="jenis" value="<?= htmlspecialchars($obat['jenis']) ?>" required><br><br>
            <label>Dosis:</label><br>
            <input type="text" name="dosis" value="<?= htmlspecialchars($obat['dosis']) ?>" required><br><br>
            <label>Keterangan:</label><br>
            <input type="text" name="keterangan" value="<?= htmlspecialchars($obat['keterangan']) ?>"><br><br>
            <label>Penggunaan:</label><br>
            <input type="text" name="penggunaan" value="<?= htmlspecialchars($obat['penggunaan']) ?>"><br><br>
            <button type="submit" name="update" style="background:#0369a1; color:white; padding:10px 20px; border:none; border-radius:8px;">💾 Simpan Perubahan</button>
            <a href="tambahObat.php" style="margin-left:10px;">Batal</a>
        </form>
        <hr>
        <?php endif; ?>
        
        <!-- TABEL DAFTAR OBAT -->
        <?php if (pg_num_rows($result) > 0): ?>
            <!-- Tampilkan jumlah total obat -->
            <p>Total: <strong><?= pg_num_rows($result) ?></strong> obat</p> <!--hitung jumlah baris-->
            <table>
                <tr>
                    <th>No</th>
                    <th>Nama Obat</th>
                    <th>Jenis</th>
                    <th>Dosis</th>
                    <th>Keterangan</th>
                    <th>Cara Penggunaan</th>
                    <th>Aksi</th>
                </tr>
                <!-- Loop semua data obat dari database -->
                <?php $no = 1; while ($row = pg_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><strong><?= htmlspecialchars($row['nama']) ?></strong></td>
                    <td><?= ucfirst($row['jenis']) ?></td>
                    <td><?= ucfirst($row['dosis']) ?></td>
                    <td><?= htmlspecialchars($row['keterangan']) ?></td>
                    <td><?= htmlspecialchars($row['penggunaan']) ?></td>
                    <td>
                        <a class="aksi-btn" href="?edit=<?= $row['id'] ?>">Edit</a>
                        <a class="aksi-btn hapus-btn" href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <!-- Pesan jika database masih kosong -->
            <p style="text-align:center; color:#64748b; padding:40px;">Belum ada data obat</p>
        <?php endif; ?>

        <div style="text-align:center; margin:40px 0;">
            <a href="indexObat.html" 
                style="padding:12px 20px; background:#0369a1; color:white; text-decoration:none; border-radius:8px;">
                🔄 Kembali ke Halaman Pencarian
            </a>
        </div>
    </div>
</body>
</html>
<?php 
// Tutup koneksi database setelah selesai
pg_close($conn); 
?>