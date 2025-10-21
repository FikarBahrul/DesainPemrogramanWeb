<?php 
$nilaiSiswa = [85, 92, 78, 64, 90, 75, 88, 79, 70, 96];
$totalNilai = 0;
$jumlahSiswa = count($nilaiSiswa);

//Sorting nilai dari yang terbesar ke terkecil
for ($i = 0; $i < $jumlahSiswa; $i++) {
    for ($j = $i + 1; $j < $jumlahSiswa; $j++) {
        if ($nilaiSiswa[$i] < $nilaiSiswa[$j]) {
            $temp = $nilaiSiswa[$i];
            $nilaiSiswa[$i] = $nilaiSiswa[$j];
            $nilaiSiswa[$j] = $temp;
        }
    }
}

//$i = 1 adalah nilai tertinggi, $i = $jumlahSiswa - 1 adalah nilai terendah
for ($i = 1; $i < $jumlahSiswa - 1; $i++) {
    $totalNilai += $nilaiSiswa[$i];
}

$nilaiRataRata = $totalNilai / ($jumlahSiswa - 2);

echo "Total nilai: $totalNilai <br>";
echo "Rata-rata nilai: $nilaiRataRata <br>";
?>
