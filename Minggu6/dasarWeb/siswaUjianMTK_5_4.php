<?php
$siswa = [
    ["nama" => "Alice", "nilai" => 85],
    ["nama" => "Bob", "nilai" => 92],
    ["nama" => "Charlie", "nilai" => 78],
    ["nama" => "David", "nilai" => 64],
    ["nama" => "Eva", "nilai" => 90]
];

$totalNilai = 0;
for ($i = 0; $i < count($siswa); $i++) {
    $totalNilai += $siswa[$i]["nilai"];
}

$rataRata = $totalNilai / count($siswa);

echo "Nilai rata-rata kelas: $rataRata <br>";
echo "Siswa dengan nilai di atas rata-rata:<br>";

for ($i = 0; $i < count($siswa); $i++) {
    if ($siswa[$i]["nilai"] > $rataRata) {
        echo $siswa[$i]["nama"] . " : " . $siswa[$i]["nilai"] . "<br>";
    }
}
?>
