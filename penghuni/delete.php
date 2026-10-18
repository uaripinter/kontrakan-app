<?php
// penghuni/delete.php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id'])) { header("Location: ../auth/login.php"); exit; }

$id = $_GET['id'];

// Cek apakah penghuni punya tagihan (Business Rule BR-04)
$cek = mysqli_query($koneksi, "SELECT * FROM tagihan WHERE id_penghuni = '$id'");
if (mysqli_num_rows($cek) > 0) {
    echo "<script>alert('Gagal dihapus! Penghuni masih memiliki tagihan aktif.'); window.location='index.php';</script>";
} else {
    mysqli_query($koneksi, "DELETE FROM penghuni WHERE id_penghuni = '$id'");
    header("Location: index.php");
    exit;
}
?>