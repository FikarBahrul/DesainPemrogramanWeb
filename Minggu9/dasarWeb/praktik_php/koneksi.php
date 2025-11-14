<?php
$connect = mysqli_connect("localhost", "root", "", "prakwebdb");

if (!$connect) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
