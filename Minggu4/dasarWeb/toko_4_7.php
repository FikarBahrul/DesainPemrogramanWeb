<?php 
$hargaProduk = 120000;
$diskonProduk = 0.2;
$minimalDiskonProduk = 100000;
$hargaBayar = 0;

if ($hargaProduk >= $minimalDiskonProduk) {
    $hargaBayar = $hargaProduk - ($hargaProduk * $diskonProduk);
} else {
    $hargaBayar = $hargaProduk;
}

echo "Harga produk: Rp {$hargaProduk} <br>";
echo "Diskon produk: " . ($diskonProduk * 100) . "% <br>";
echo "Harga yang harus dibayar: Rp {$hargaBayar} <br>";
?>