<?php
//membuat fungsi dengan parameter
function perkenalan($nama, $salam){
    echo $salam . ", ";
    echo "Perkenalkan, nama saya " . $nama . "</br>";
    echo "Senang berkenalan dengan Anda";
}
//memanggil fungsi dengan parameter
perkenalan("Hamdana", "Hallo");

echo "</hr>";

$saya = "Elok";
$ucapanSalam = "Selamat pagi";

//memanggil lagi
perkenalan($saya,$ucapanSalam);
?>