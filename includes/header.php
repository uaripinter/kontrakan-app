<?php
// Memulai session jika belum dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Proteksi halaman: Jika belum login, tendang ke halaman login
if (!isset($_SESSION['user_id']) && basename($_SERVER['PHP_SELF']) != 'login.php') {
    header("Location: /kontrakan-app/auth/login.php");
    exit;
}
$base_url = "/kontrakan-app";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kontrakan App - <?= isset($page_title) ? $page_title : 'Dashboard' ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', 'Segoe UI', sans-serif; }
        body { background: #F8FAFC; color: #1E293B; display: flex; min-height: 100vh; }
        
        /* Sidebar */
        .sidebar { width: 260px; background: #1E293B; color: #CBD5E1; padding: 20px 0; flex-shrink: 0; }
        .sidebar h2 { color: #fff; font-size: 18px; padding: 0 20px 20px; border-bottom: 1px solid #334155; }
        .sidebar nav a { display: block; padding: 12px 20px; color: #CBD5E1; text-decoration: none; border-left: 3px solid transparent; }
        .sidebar nav a .menu-title { display: block; font-size: 14px; font-weight: 600; }
        .sidebar nav a .menu-sub { display: block; font-size: 11px; color: #94A3B8; margin-top: 2px; }
        .sidebar nav a:hover { background: #334155; color: #fff; }
        .sidebar nav a.active { background: #2563EB; color: #fff; border-left: 3px solid #93C5FD; }
        
        /* Main Content */
        .main { flex: 1; padding: 24px 32px; }
        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid #E2E8F0; }
        .topbar h1 { font-size: 20px; }
        
        /* Cards & Panels */
        .cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px; }
        .card { background: #fff; padding: 20px; border-radius: 12px; border: 1px solid #E2E8F0; }
        .card h3 { font-size: 13px; color: #64748B; font-weight: 500; margin-bottom: 8px; }
        .card .value { font-size: 24px; font-weight: 700; color: #1E293B; }
        .panel { background: #fff; padding: 24px; border-radius: 12px; border: 1px solid #E2E8F0; margin-bottom: 24px; }
        .panel h2 { font-size: 16px; margin-bottom: 16px; }
        
        /* Tabel & Form */
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        table th, table td { padding: 10px 12px; text-align: left; border-bottom: 1px solid #E2E8F0; }
        table th { background: #F1F5F9; font-weight: 600; }
        .badge { padding: 4px 10px; border-radius: 999px; font-size: 12px; font-weight: 600; }
        .badge-lunas { background: #DCFCE7; color: #166534; }
        .badge-belum { background: #FEE2E2; color: #991B1B; }
        
        .field { margin-bottom: 16px; }
        .field label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; }
        .field input, .field select { width: 100%; padding: 10px 12px; border: 1px solid #CBD5E1; border-radius: 8px; }
        
        .btn { padding: 10px 18px; border-radius: 8px; border: none; font-weight: 600; cursor: pointer; }
        .btn-primary { background: #2563EB; color: #fff; }
        .btn-primary:hover { background: #1D4ED8; }
    </style>
</head>
<body>

    <!-- Sidebar Navigasi -->
    <aside class="sidebar">
        <h2>🏠 Kontrakan App</h2>
        <nav>
            <!-- Menu Dashboard -->
            <a href="<?= $base_url ?>/index.php" class="<?= ($page_title == 'Dashboard') ? 'active' : '' ?>">
                <span class="menu-title">📊 Dashboard</span>
                <span class="menu-sub">Ringkasan informasi</span>
            </a>
            
            <!-- Menu Khusus Bendahara: Penghuni -->
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'bendahara'): ?>
                <a href="<?= $base_url ?>/penghuni/index.php" class="<?= ($page_title == 'Data Penghuni') ? 'active' : '' ?>">
                    <span class="menu-title">👥 Penghuni</span>
                    <span class="menu-sub">Kelola data penghuni</span>
                </a>
            <?php endif; ?>
            
            <!-- Menu Khusus Bendahara: Pengeluaran -->
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'bendahara'): ?>
                <a href="<?= $base_url ?>/pengeluaran/catat.php" class="<?= ($page_title == 'Catat Pengeluaran') ? 'active' : '' ?>">
                    <span class="menu-title">💰 Pengeluaran</span>
                    <span class="menu-sub">Catat & lihat data</span>
                </a>
            <?php endif; ?>

            <!-- Menu Tagihan (Bisa diakses semua) -->
            <a href="<?= $base_url ?>/tagihan.php" class="<?= ($page_title == 'Tagihan') ? 'active' : '' ?>">
                <span class="menu-title">📋 Tagihan</span>
                <span class="menu-sub">Daftar tagihan</span>
            </a>

            <!-- Menu Khusus Bendahara: Verifikasi & Laporan -->
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'bendahara'): ?>
                <a href="<?= $base_url ?>/verifikasi.php" class="<?= ($page_title == 'Verifikasi') ? 'active' : '' ?>">
                    <span class="menu-title">✅ Verifikasi Pembayaran</span>
                    <span class="menu-sub">Kelola status bayar</span>
                </a>
                <a href="<?= $base_url ?>/laporan.php" class="<?= ($page_title == 'Laporan') ? 'active' : '' ?>">
                    <span class="menu-title">📈 Laporan</span>
                    <span class="menu-sub">Rekap keuangan</span>
                </a>
            <?php endif; ?>

            <!-- Menu Logout -->
            <a href="<?= $base_url ?>/auth/logout.php">
                <span class="menu-title">🚪 Logout</span>
                <span class="menu-sub">Keluar sistem</span>
            </a>
        </nav>
    </aside>

    <!-- Konten Utama -->
    <main class="main">
        <div class="topbar">
            <h1><?= isset($page_title) ? $page_title : 'Dashboard' ?></h1>
            <div>Login sebagai: <strong><?= isset($_SESSION['nama']) ? $_SESSION['nama'] : 'Guest' ?></strong></div>
        </div>