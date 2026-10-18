<?php
$page_title = "Verifikasi";
require_once 'includes/header.php';
require_once 'config/database.php';

// Proteksi: Jika bukan bendahara, tendang ke dashboard
if ($_SESSION['role'] != 'bendahara') {
    header("Location: index.php"); exit;
}

// Proses ubah status
if (isset($_POST['update_status'])) {
    $id_tagihan = $_POST['id_tagihan'];
    $status_baru = $_POST['status_tagihan'];
    mysqli_query($koneksi, "UPDATE tagihan SET status_tagihan = '$status_baru' WHERE id_tagihan = '$id_tagihan'");
    echo "<script>alert('Status berhasil diperbarui!'); window.location='verifikasi.php';</script>";
}
?>

<div class="panel">
    <h2>Verifikasi Pembayaran Penghuni</h2>
    <table>
        <tr><th>No</th><th>Penghuni</th><th>Barang</th><th>Jumlah</th><th>Status</th><th>Aksi</th></tr>
        <?php 
        $no=1; 
        $query = "SELECT t.*, p.nama, pg.nama_barang FROM tagihan t 
                  JOIN penghuni p ON t.id_penghuni = p.id_penghuni 
                  JOIN pengeluaran pg ON t.id_pengeluaran = pg.id_pengeluaran";
        $q_list = mysqli_query($koneksi, $query);
        while($r = mysqli_fetch_assoc($q_list)): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $r['nama'] ?></td>
            <td><?= $r['nama_barang'] ?></td>
            <td>Rp <?= number_format($r['jumlah_tagihan'],0,',','.') ?></td>
            <td>
                <span class="badge badge-<?= strtolower($r['status_tagihan']) ?>">
                    <?= $r['status_tagihan'] ?>
                </span>
            </td>
            <td>
                <form method="POST" style="display:flex; gap:5px;">
                    <input type="hidden" name="id_tagihan" value="<?= $r['id_tagihan'] ?>">
                    <select name="status_tagihan" style="padding:5px; border-radius:5px;">
                        <option value="Belum" <?= $r['status_tagihan']=='Belum'?'selected':'' ?>>Belum</option>
                        <option value="Lunas" <?= $r['status_tagihan']=='Lunas'?'selected':'' ?>>Lunas</option>
                    </select>
                    <button type="submit" name="update_status" class="btn btn-primary" style="padding:5px 10px; font-size:12px;">Ubah</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

<?php require_once 'includes/footer.php'; ?>