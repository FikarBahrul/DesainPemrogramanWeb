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
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty(file_get_contents('php://input'))) {
    
    header('Content-Type: application/json'); //difungsikan untuk memberitahu browser bahwa respon yang dikirim berformat JSON
    
    $data = json_decode(file_get_contents('php://input'), true);
    
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
    </style>
</head>
<body>
    <div class="container">
        <!-- JUDUL HALAMAN -->
        <h1>📋 Daftar Obat dari Database</h1>
        
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
                </tr>
                <!-- Loop semua data obat dari database -->
                <?php $no = 1; while ($row = pg_fetch_assoc($result)): ?><!--$no untuk nomor urut,pg_fetch_assoc($result) untuk ambil satu baris array assosiatif lalu disimpan di row -->
                <tr>
                    <td><?= $no++ ?></td>
                    <td><strong><?= htmlspecialchars($row['nama']) ?></strong></td><!--karakter khusus html untuk mencegah serangan XSS-->
                    <td><?= ucfirst($row['jenis']) ?></td><!--ucfirst ngebuat huruf awal menjadi kapital-->
                    <td><?= ucfirst($row['dosis']) ?></td>
                    <td><?= htmlspecialchars($row['keterangan']) ?></td>
                    <td><?= htmlspecialchars($row['penggunaan']) ?></td>
                </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <!-- Pesan jika database masih kosong -->
            <p style="text-align:center; color:#64748b; padding:40px;">Belum ada data obat</p><!--jika tidak ada obat dalam database-->
        <?php endif; ?>
    </div>
</body>
</html>
<?php 
// Tutup koneksi database setelah selesai
pg_close($conn); 
?>