<?php
// auth/proses_login.php
session_start();
require_once '../config/database.php';

$username = mysqli_real_escape_string($koneksi, $_POST['username']);
$password = $_POST['password'];

// Catatan: Untuk keamanan produksi, gunakan password_verify()
$query = "SELECT * FROM penghuni WHERE username = '$username' AND password = '$password'";
$result = mysqli_query($koneksi, $query);
$user = mysqli_fetch_assoc($result);

if ($user) {
    $_SESSION['user_id'] = $user['id_penghuni'];
    $_SESSION['nama'] = $user['nama'];
    $_SESSION['role'] = $user['role'];
    
    header("Location: ../index.php");
    exit;
} else {
    header("Location: login.php?error=Username atau password salah");
    exit;
}
?>