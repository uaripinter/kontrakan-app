<?php
$page_title = "Dashboard";
require_once 'includes/header.php';
require_once 'config/database.php'; // WAJIB DIPANGGIL DI SINI SEBELUM QUERY

// 1. Ambil data total pengeluaran
$q_total = mysqli_query($koneksi, "SELECT SUM(harga) as total FROM pengeluaran");
$total = mysqli_fetch_assoc($q_total)['total'] ?? 0;

// 2. Ambil data tagihan belum bayar
$q_belum = mysqli_query($koneksi, "SELECT COUNT(*) as jml FROM tagihan WHERE status_tagihan = 'Belum'");
$belum = mysqli_fetch_assoc($q_belum)['jml'] ?? 0;

// 3. Ambil data tagihan lunas
$q_lunas = mysqli_query($koneksi, "SELECT COUNT(*) as jml FROM tagihan WHERE status_tagihan = 'Lunas'");
$lunas = mysqli_fetch_assoc($q_lunas)['jml'] ?? 0;

// 4. Ambil jumlah penghuni
$q_penghuni = mysqli_query($koneksi, "SELECT COUNT(*) as jml FROM penghuni");
$jumlah_penghuni = mysqli_fetch_assoc($q_penghuni)['jml'] ?? 0;
?>

<div class="cards">
    <div class="card">
        <h3>Total Pengeluaran Bulan Ini</h3>
        <div class="value">Rp <?= number_format($total, 0, ',', '.') ?></div>
    </div>
    <div class="card">
        <h3>Tagihan Belum Bayar</h3>
        <div class="value" style="color: #DC2626;"><?= $belum ?></div>
    </div>
    <div class="card">
        <h3>Tagihan Lunas</h3>
        <div class="value" style="color: #16A34A;"><?= $lunas ?></div>
    </div>
    <div class="card">
        <h3>Jumlah Penghuni</h3>
        <div class="value"><?= $jumlah_penghuni ?></div>
    </div>
</div>

<div class="panel">
    <h2>Aksi Cepat</h2>
    <!-- Pastikan menggunakan tombol dengan class btn agar tampilannya rapi -->
    <a href="/kontrakan-app/pengeluaran/catat.php" class="btn btn-primary" style="text-decoration:none; display:inline-block;">+ Catat Pengeluaran</a>
    <a href="/kontrakan-app/tagihan.php" class="btn btn-secondary" style="text-decoration:none; display:inline-block; margin-left: 10px; border: 1px solid #2563EB; color: #2563EB; background: transparent;">Lihat Tagihan</a>
</div>

<?php require_once 'includes/footer.php'; ?>