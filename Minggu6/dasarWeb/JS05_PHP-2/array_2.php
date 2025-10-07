<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <style>
        table {
            width: 50%;
            border-collapse: collapse;
            margin: 20px auto;
            font-family: Arial, sans-serif;
        }
        th, td {
            border: 2px solid #333;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #e6e629ff;
        }
        td {
            background-color: #f9f9f9;
        }
        h2 {
            text-align: center;
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>
    <?php 
        $Dosen = [
            'Nama' => "Elok Nur Hamdana",
            'Domisili' => "Malang",
            'Jenis Kelamin' => "Perempuan"
        ];
        echo "<h2>Data Dosen</h2>";
        echo "<table>";
        foreach ($Dosen as $key => $value) {
            echo "<tr>
                    <th>$key</th>
                    <td>$value</td>
                  </tr>";
        }
        echo "</table>";
    ?>
</body>
</html>
