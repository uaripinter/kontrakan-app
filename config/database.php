<?php
// config/database.php
$host = "localhost";
$user = "root";
$pass = ""; // Di Laragon, password root secara default kosong
$db   = "kontrakan_keuangan";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>