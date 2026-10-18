<?php
$page_title = "Laporan";
require_once 'includes/header.php';
require_once 'config/database.php';

if ($_SESSION['role'] != 'bendahara') { header("Location: index.php"); exit; }

// Hitung total
$total_pengeluaran = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(harga) as total FROM pengeluaran"))['total'] ?? 0;
$total_tagihan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(jumlah_tagihan) as total FROM tagihan"))['total'] ?? 0;
$total_lunas = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(jumlah_tagihan) as total FROM tagihan WHERE status_tagihan='Lunas'"))['total'] ?? 0;
?>

<div class="panel">
    <h2>Rekap Keuangan</h2>
    <div class="cards">
        <div class="card">
            <h3>Total Pengeluaran</h3>
            <div class="value">Rp <?= number_format($total_pengeluaran, 0, ',', '.') ?></div>
        </div>
        <div class="card">
            <h3>Total Tagihan Dibuat</h3>
            <div class="value">Rp <?= number_format($total_tagihan, 0, ',', '.') ?></div>
        </div>
        <div class="card">
            <h3>Sudah Dibayar (Lunas)</h3>
            <div class="value" style="color: #16A34A;">Rp <?= number_format($total_lunas, 0, ',', '.') ?></div>
        </div>
    </div>
    <button class="btn btn-primary" onclick="window.print()">🖨️ Cetak Laporan</button>
</div>

<?php require_once 'includes/footer.php'; ?>