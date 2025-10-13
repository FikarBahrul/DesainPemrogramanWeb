<!DOCTYPE html>
<html>
    <head>
        <title>HTML Injection</title>
    </head>
    <body>
    <h2>Form Input</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="input">Nama:</label>
        <input type="text" name="input" id="input" required><br><br>
        <label for="email">Email:</label>
        <input type="text" name="email" id="email" required><br><br>
        <input type="submit" value="Submit">
    </form>

    <br><br>
    
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        //Check Nama
        if (isset($_POST['input'])) {
            $input = $_POST['input'];
            $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
            echo '<div>Nama aman: ' . $input . '</div>';
        } else {
            echo "Input nama tidak ditemukan.<br>";
        }
        //Check Email
        if (isset($_POST['email'])) { 
            $email = $_POST['email'];

            $clean_email = filter_var($email, FILTER_SANITIZE_EMAIL); 

            if (filter_var($clean_email, FILTER_VALIDATE_EMAIL)) {
                echo "Email valid dan aman: " . htmlspecialchars($clean_email) . "<br>";
            } else {
                echo "Email tidak valid. masukkan format email yang benar.<br>";
            }
        } else {
            echo "Input email tidak ditemukan.<br>";
        }

    }
    ?>
    </body>
</html>