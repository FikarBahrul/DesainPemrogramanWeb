<?php 
$a = 10;
$b = 5;

$hasilTambah = $a + $b;
$hasilKurang = $a - $b;
$hasilKali = $a * $b;
$hasilBagi = $a / $b;
$sisaBagi = $a % $b;
$pangkat = $a ** $b;

$hasilSama = $a == $b;
$hasilTidakSama = $a != $b;
$hasilLebihKecil = $a < $b;
$hasilLebihBesar = $a > $b;
$hasilLebihKecilSamaDengan = $a <= $b;
$hasilLebihBesarSamaDengan = $a >= $b;

$hasilAnd = $a && $b;
$hasilOr = $a || $b;
$hasilNotA = !$a;
$hasilNotB = !$b;

$penugasanTambah = $a += $b;
$penugasanKurang = $a -= $b;
$penugasanKali = $a *= $b;
$penugasanBagi = $a /= $b;
$penugasanModulus = $a %= $b;

$hasilIdentik = $a === $b;
$hasilTidakIdentik = $a !== $b;

echo "Hasil Tambah (10 + 5) : {$hasilTambah} <br>";
echo "Hasil Kurang (10 - 5) : {$hasilKurang} <br>";
echo "Hasil Kali (10 * 5) : {$hasilKali} <br>";
echo "Hasil Bagi (10 / 5) : {$hasilBagi} <br>";
echo "Sisa Bagi (10 % 5) : {$sisaBagi} <br>";
echo "Pangkat (10 ** 5) : {$pangkat} <br><br>";

echo "Hasil Sama (10 == 5) : ".($hasilSama ? 'true' : 'false')." <br>";
echo "Hasil Tidak Sama (10 != 5) : ".($hasilTidakSama ? 'true' : 'false')." <br>";
echo "Hasil Lebih Kecil (10 < 5) : ".($hasilLebihKecil ? 'true' : 'false')." <br>";
echo "Hasil Lebih Besar (10 > 5) : ".($hasilLebihBesar ? 'true' : 'false')." <br>";
echo "Hasil Lebih Kecil Sama Dengan (10 <= 5) : ".($hasilLebihKecilSamaDengan ? 'true' : 'false')." <br>";
echo "Hasil Lebih Besar Sama Dengan (10 >= 5) : ".($hasilLebihBesarSamaDengan ? 'true' : 'false')." <br><br>";

echo "Hasil AND (10 && 5) : ".($hasilAnd ? 'true' : 'false')." <br>";
echo "Hasil OR (10 || 5) : ".($hasilOr ? 'true' : 'false')." <br>";
echo "Hasil NOT A (!10) : ".($hasilNotA ? 'true' : 'false')." <br>";
echo "Hasil NOT B (!5) : ".($hasilNotB ? 'true' : 'false')." <br>";

echo "<br>Penugasan Tambah (a += b) : {$penugasanTambah} <br>";
echo "Penugasan Kurang (a -= b) : {$penugasanKurang} <br>";
echo "Penugasan Kali (a *= b) : {$penugasanKali} <br>";
echo "Penugasan Bagi (a /= b) : {$penugasanBagi} <br>";
echo "Penugasan Modulus (a %= b) : {$penugasanModulus} <br><br>";

echo "Hasil Identik (10 === 5) : ".($hasilIdentik ? 'true' : 'false')." <br>";
echo "Hasil Tidak Identik (10 !== 5) : ".($hasilTidakIdentik ? 'true' : 'false')." <br><br>";
?>