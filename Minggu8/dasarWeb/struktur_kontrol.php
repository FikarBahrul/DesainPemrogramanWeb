<?php 
$nilaiNumerik = 92;

if ($nilaiNumerik >= 90 && $nilaiNumerik <= 100) {
    $nilaiHuruf = 'A';
} elseif ($nilaiNumerik >= 80 && $nilaiNumerik < 90) {
    $nilaiHuruf = 'B';
} elseif ($nilaiNumerik >= 70 && $nilaiNumerik < 80) {
    $nilaiHuruf = 'C';
} elseif ($nilaiNumerik < 70){
    $nilaiHuruf = 'D';
}

echo "Nilai numerik: $nilaiNumerik <br>";
echo "Nilai huruf: $nilaiHuruf <br><br>";

$jarakSaatIni = 0;
$jarakTarget = 500;
$peningkatanHarian = 30;
$hari = 0;

while ($jarakSaatIni < $jarakTarget) {
    $jarakSaatIni += $peningkatanHarian;
    $hari++;
}
echo "Atlet tersebut memerlukan waktu $hari hari untuk mencapai jarak 500 kilometer.<br><br>";

$jumlahLahan = 10;
$tanamanPerLahan = 5;
$buahPerTanaman = 10;
$jumlahBuah = 0;

for ($i =1; $i <= $jumlahLahan; $i++){
    $jumlahBuah += ($tanamanPerLahan * $buahPerTanaman);
}
echo "Jumlah buah yang akan dipanen dari seluruh lahan adalah: $jumlahBuah buah.<br><br>";

$skorUjian = [85, 92, 78, 96, 88];
$totalSkor = 0;
foreach ($skorUjian as $skor) {
    $totalSkor += $skor;
}
echo "Total skor ujian adalah: $totalSkor <br><br>";

$nilaiSiswa = [85, 92, 58, 64, 90, 55, 88, 79, 70, 96];
foreach ($nilaiSiswa as $nilai) {
    if ($nilai < 60) {
        echo "Nilai: $nilai - (Tidak Lulus)<br>";
        continue;
    }
        echo "Nilai: $nilai - (Lulus)<br>";
}
?>