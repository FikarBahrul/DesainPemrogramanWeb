<?php
session_start();

/* ==================== KONFIGURASI DATABASE ==================== */
$host = 'localhost';
$port = '5432';
$dbname = 'db_obat';
$user = 'postgres';
$pass = 'zemoteno';

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$pass");

if (!$conn) {
    die("Koneksi database gagal!");
}

/* ==================== PROSES REGISTER ==================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'register') {
    $fullname = pg_escape_string($conn, trim($_POST['fullname']));
    $email = pg_escape_string($conn, trim($_POST['email']));
    $username = pg_escape_string($conn, trim($_POST['username']));
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validasi
    if (empty($fullname) || empty($email) || empty($username) || empty($password)) {
        header("Location: register.html?error=empty");
        exit;
    }
    
    if ($password !== $confirm_password) {
        header("Location: register.html?error=password_mismatch");
        exit;
    }
    
    if (strlen($password) < 8) {
        header("Location: register.html?error=password_short");
        exit;
    }
    
    // Cek username sudah ada atau belum
    $checkQuery = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
    $checkResult = pg_query($conn, $checkQuery);
    
    if (pg_num_rows($checkResult) > 0) {
        header("Location: register.html?error=exists");
        exit;
    }
    
    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert user baru
    $insertQuery = "INSERT INTO users (fullname, email, username, password, created_at) 
                    VALUES ('$fullname', '$email', '$username', '$hashedPassword', NOW())";
    
    if (pg_query($conn, $insertQuery)) {
        header("Location: login.html?success=registered");
        exit;
    } else {
        header("Location: register.html?error=failed");
        exit;
    }
}

/* ==================== PROSES LOGIN ==================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['action'])) {
    $username = pg_escape_string($conn, trim($_POST['username']));
    $password = $_POST['password'];
    
    if (empty($username) || empty($password)) {
        header("Location: login.html?error=empty");
        exit;
    }
    
    // Cari user
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = pg_query($conn, $query);
    
    if (pg_num_rows($result) === 1) {
        $user = pg_fetch_assoc($result);
        
        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Set session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['logged_in'] = true;
            
            // Update last login
            $updateQuery = "UPDATE users SET last_login = NOW() WHERE id = " . $user['id'];
            pg_query($conn, $updateQuery);
            
            header("Location: dashboard.php");
            exit;
        } else {
            header("Location: login.html?error=wrong_password");
            exit;
        }
    } else {
        header("Location: login.html?error=user_not_found");
        exit;
    }
}

pg_close($conn);
header("Location: login.html");
exit;
?>