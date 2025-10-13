<?php 
$poinPemain = 567;
echo "Total poin yang Anda peroleh: $poinPemain <br>";
echo "apakah anda sudah mendapatkan lebih dari 500 poin?";
if ($poinPemain > 500) {
    echo "(YA) ";
    echo "Selamat! Anda mendapatkan hadiah tambahan!";
} else {
    echo "(TIDAK) ";
    echo "Terima kasih telah bermain. Coba lagi untuk mendapatkan hadiah tambahan!";
}
?>