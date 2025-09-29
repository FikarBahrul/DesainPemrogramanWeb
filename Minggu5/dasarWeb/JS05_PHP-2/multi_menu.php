<?php 
$menu = [
    [
        "nama" => "Beranda"
    ],
    [
        "nama" => "Berita",
        "subMenu" => [
            [
                "nama" => "Wisata",
                "subMenu" => [
                    [ "nama" => "Pantai" ],
                    [ "nama" => "Gunung" ]
                ]
            ],
            [ "nama" => "Kuliner" ],
            [ "nama" => "Hiburan" ]
        ]
    ],
    [
        "nama" => "Tentang"
    ],
    [
        "nama" => "Kontak"
    ],
];

function tampilkanMenuBertingkat(array $menu) {
    echo "<ul>";
    foreach ($menu as $item) {
        echo "<li>{$item['nama']}";
        // statement untuk cek apakah ada subMenu
        if (isset($item['subMenu']) && is_array($item['subMenu'])) {
            // rekursif memanggil fungsi
            tampilkanMenuBertingkat($item['subMenu']);
        }
        echo "</li>";
    }
    echo "</ul>";
}

tampilkanMenuBertingkat($menu);
?>