<!DOCTYPE html>
<html>
    <head>
    </head>
    <body>
        <h2>Array Terindex</h2>
        <?php 
        $ListDosen = ["Elok Nur Hamdana", "Unggul Pamenang", "Bagas Nugraha"];

        echo $ListDosen[2] . "<br>";
        echo $ListDosen[0] . "<br>";
        echo $ListDosen[1] . "<br>";

        for ($i = 0; $i < count($ListDosen); $i++) {
            echo "<br>";
            echo "Dengan Looping : <br>";
            foreach ($ListDosen as $dosen) {
                echo $dosen . "<br>";
            }
        }
        ?>
    </body>
</html>
