<?php
$page_title = "Tagihan";
require_once 'includes/header.php';
require_once 'config/database.php';
?>

<div class="panel">
    <h2>Daftar Tagihan</h2>
    <table>
        <tr><th>No</th><th>Nama Barang</th><th>Jumlah Tagihan</th><th>Status</th></tr>
        <?php 
        $no=1; 
        $query = "SELECT t.*, pg.nama_barang FROM tagihan t 
                  JOIN pengeluaran pg ON t.id_pengeluaran = pg.id_pengeluaran
                  WHERE t.id_penghuni = '{$_SESSION['user_id']}'";
        $q_list = mysqli_query($koneksi, $query);
        while($r = mysqli_fetch_assoc($q_list)): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $r['nama_barang'] ?></td>
            <td>Rp <?= number_format($r['jumlah_tagihan'],0,',','.') ?></td>
            <td>
                <span class="badge badge-<?= strtolower($r['status_tagihan']) ?>">
                    <?= $r['status_tagihan'] ?>
                </span>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

<?php require_once 'includes/footer.php'; ?>