<?php
session_start();
if (!empty($_SESSION['username'])) {
    require '../config/koneksi.php';
    require '../fungsi/pesan_kilat.php';
    require '../fungsi/anti_injection.php';
    if (!empty($_GET['jabatan'])) {
        $id = antiinjection($koneksi, $_POST['id']);
        $jabatan = antiinjection($koneksi, $_POST['jabatan']);
        $keterangan = antiinjection($koneksi, $_POST['keterangan']);
        $query = "UPDATE jabatan SET jabatan = '$jabatan', keterangan = '$keterangan' WHERE id = '$id'";
        if (mysqli_query($koneksi, $query)) {
            pesan('success', "Jabatan Telah Diubah.");
        } else {
            pesan('danger', "Mengubah Jabatan Gagal Karena: " . mysqli_error($koneksi));
        }
        header("Location: ../index.php?page=jabatan");
    }
}
if (!empty($_GET['anggota'])) {
    $id = antiinjection($koneksi, $_POST['id']);
    $nama = antiinjection($koneksi, $_POST['nama']);
    $jabatan = antiinjection($koneksi, $_POST['jabatan']);
    $jenis_kelamin = antiinjection($koneksi, $_POST['jenis_kelamin']);
    $alamat = antiinjection($koneksi, $_POST['alamat']);
    $no_telp = antiinjection($koneksi, $_POST['no_telp']);
    $username = antiinjection($koneksi, $_POST['username']);
    $password = antiinjection($koneksi, $_POST['password']);
    
    $query_anggota = "UPDATE anggota SET nama = '$nama', jenis_kelamin = '$jenis_kelamin', alamat = '$alamat', no_telp = '$no_telp', jabatan_id = '$jabatan' WHERE user_id = '$id'";
    
    if (mysqli_query($koneksi, $query_anggota)) {
        if (!empty($_POST['password'])) {
            $salt = bin2hex(random_bytes(16));
            $combined_password = $salt . $password;
            $hashed_password = password_hash($combined_password, PASSWORD_BCRYPT);
            $query_user = "UPDATE user SET username = '$username', password = '$hashed_password', salt = '$salt' WHERE id = '$id'";
            
            if (mysqli_query($koneksi, $query_user)) {
                pesan('success', "Anggota Telah Diubah.");
            } else {
                pesan('warning', "Data Anggota Berhasil Diubah, Tetapi Password Gagal Diubah Karena: " . mysqli_error($koneksi));
            }
        } else {
            $query_user = "UPDATE user SET username = '$username' WHERE id = '$id'";
            
            if (mysqli_query($koneksi, $query_user)) {
                pesan('success', "Anggota Telah Diubah.");
            } else {
                pesan('warning', "Data Anggota Berhasil Diubah, Tetapi Username Gagal Diubah Karena: " . mysqli_error($koneksi));
            }
        }
    } else {
        pesan('danger', "Mengubah Anggota Karena: " . mysqli_error($koneksi));
    }
    header("Location: ../index.php?page=anggota");
}
?>