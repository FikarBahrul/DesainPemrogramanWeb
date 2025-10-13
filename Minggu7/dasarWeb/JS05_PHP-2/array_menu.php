<?php
// Menentukan menu multi-level menggunakan array asosiatif
$menu = array(
    "Rumah" => "#home",
    "Tentang Kami" => array(
        "Tim Kami" => "#team",
        "Kisah Kami" => "#story",
        "Misi & Visi" => "#mission"
    ),
    "Layanan" => array(
        "Pengembangan Web" => "#web",
        "Pengembangan Seluler" => "#mobile",
        "Optimasi SEO" => "#seo"
    ),
    "Kontak" => "#contact"
);

// Fungsi untuk menampilkan menu secara rekursif
function displayMenu($menu) {
    echo "<ul>";
    foreach ($menu as $key => $value) {
        // Periksa apakah item menu memiliki sub-menu
        if (is_array($value)) {
            echo "<li>$key";
            displayMenu($value); // Tampilkan sub-menu secara rekursif
            echo "</li>";
        } else {
            echo "<li><a href='$value'>$key</a></li>";
        }
    }
    echo "</ul>";
}

// Panggil fungsi untuk menampilkan menu
displayMenu($menu);
?>
