<?php
session_start();

if (!empty($_SESSION['username'])) {
    require '../config/koneksi.php';
    require '../fungsi/pesan_kilat.php';
    require '../fungsi/anti_injection.php';

    if (isset($_GET['jabatan']) && $_GET['jabatan'] === 'tambah') {
        $jabatan = antiinjection($koneksi, $_POST['jabatan']);
        $keterangan = antiinjection($koneksi, $_POST['keterangan']);

        $query = "INSERT INTO jabatan (jabatan, keterangan) VALUES ('$jabatan', '$keterangan')";

        if (mysqli_query($koneksi, $query)) {
            pesan('success', "Jabatan baru berhasil ditambahkan.");
        } else {
            pesan('danger', "Gagal menambahkan jabatan: " . mysqli_error($koneksi));
        }
        header("Location: ../index.php?page=jabatan");
        exit;
    }

    elseif (isset($_GET['anggota']) && $_GET['anggota'] === 'tambah') {
        $username = antiinjection($koneksi, $_POST['username']);
        $password = antiinjection($koneksi, $_POST['password']);
        $level = antiinjection($koneksi, $_POST['level']);
        $jabatan = antiinjection($koneksi, $_POST['jabatan']);
        $nama = antiinjection($koneksi, $_POST['nama']);
        $jenis_kelamin = antiinjection($koneksi, $_POST['jenis_kelamin']);
        $alamat = antiinjection($koneksi, $_POST['alamat']);
        $no_telp = antiinjection($koneksi, $_POST['no_telp']);

        $salt = bin2hex(random_bytes(16));
        $combined_password = $salt . $password;
        $hashed_password = password_hash($combined_password, PASSWORD_BCRYPT);

        $query_user = "INSERT INTO user (username, password, salt, level)
                       VALUES ('$username', '$hashed_password', '$salt', '$level')";
        if (mysqli_query($koneksi, $query_user)) {
            $user_id = mysqli_insert_id($koneksi);

            $query_anggota = "INSERT INTO anggota (nama, jenis_kelamin, alamat, no_telp, user_id, jabatan_id)
                              VALUES ('$nama', '$jenis_kelamin', '$alamat', '$no_telp', '$user_id', '$jabatan')";
            if (mysqli_query($koneksi, $query_anggota)) {
                pesan('success', "Anggota baru Ditambahkan.");
            } else {
                pesan('warning', "Gagal menambah anggota tetapi data login tersimpan karena: " . mysqli_error($koneksi));
            }
        } else {
            pesan('danger', "Gagal menambahkan anggota baru karena: " . mysqli_error($koneksi));
        }
        header("Location: ../index.php?page=anggota");
        exit;
    }
}
?>