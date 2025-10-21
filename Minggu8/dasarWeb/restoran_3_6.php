<?php
$seluruh_kursi = 45;
$kursi_terisi = 28;
$kursi_kosong = $seluruh_kursi - $kursi_terisi;

echo "Jumlah kursi kosong di restoran adalah: {$kursi_kosong} kursi. <br><br>";
echo "Persentase kursi yang kosong: " . ($kursi_kosong / $seluruh_kursi * 100) . "%";
?>