<?php
$page_title = "Catat Pengeluaran";
require_once '../includes/header.php';
require_once '../config/database.php';

$pesan = "";

if (isset($_POST['simpan'])) {
    $nama_barang = mysqli_real_escape_string($koneksi, $_POST['nama_barang']);
    $harga       = (int) $_POST['harga'];
    $tanggal     = $_POST['tanggal'];
    $pembayar    = $_POST['id_penghuni_pembayar'];

    // VALIDASI (Aktivitas 6)
    if (empty($nama_barang) || $harga <= 0 || empty($tanggal) || empty($pembayar)) {
        $pesan = "<div style='color:red; margin-bottom:10px;'>Data tidak lengkap! Harga harus lebih dari 0.</div>";
    } else {
        // 1. Simpan ke tabel pengeluaran
        $query = "INSERT INTO pengeluaran (nama_barang, harga, tanggal, id_penghuni_pembayar) 
                  VALUES ('$nama_barang', '$harga', '$tanggal', '$pembayar')";
        mysqli_query($koneksi, $query);
        $id_pengeluaran = mysqli_insert_id($koneksi);

        // 2. Hitung total penghuni aktif
        $q_penghuni = mysqli_query($koneksi, "SELECT id_penghuni FROM penghuni WHERE status_aktif = TRUE");
        $total_penghuni = mysqli_num_rows($q_penghuni);
        
        // 3. Bagi rata (BR-03)
        $tagihan_per_orang = $harga / $total_penghuni;

        // 4. Generate Tagihan (Looping)
        while ($row = mysqli_fetch_assoc($q_penghuni)) {
            $id_penghuni = $row['id_penghuni'];
            $insert_tagihan = "INSERT INTO tagihan (id_penghuni, id_pengeluaran, jumlah_tagihan, status_tagihan) 
                               VALUES ('$id_penghuni', '$id_pengeluaran', '$tagihan_per_orang', 'Belum')";
            mysqli_query($koneksi, $insert_tagihan);
        }
        $pesan = "<div style='color:green; margin-bottom:10px;'>Pengeluaran berhasil dicatat & tagihan otomatis terbuat!</div>";
    }
}

// Ambil data penghuni untuk dropdown
$q_p = mysqli_query($koneksi, "SELECT id_penghuni, nama FROM penghuni WHERE status_aktif = TRUE");
?>

<?= $pesan ?>

<div class="panel" style="max-width: 600px;">
    <h2>Form Catat Pengeluaran</h2>
    <form method="POST">
        <div class="field">
            <label>Nama Barang / Kebutuhan *</label>
            <input type="text" name="nama_barang" placeholder="cth: Token Listrik">
        </div>
        <div class="field">
            <label>Harga (Rp) *</label>
            <input type="number" name="harga" placeholder="cth: 200000">
        </div>
        <div class="field">
            <label>Tanggal *</label>
            <input type="date" name="tanggal" value="<?= date('Y-m-d') ?>">
        </div>
        <div class="field">
            <label>Pembayar *</label>
            <select name="id_penghuni_pembayar">
                <option value="">-- Pilih Pembayar --</option>
                <?php while($p = mysqli_fetch_assoc($q_p)): ?>
                    <option value="<?= $p['id_penghuni'] ?>"><?= $p['nama'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit" name="simpan" class="btn btn-primary">Simpan Pengeluaran</button>
    </form>
</div>

<!-- Tabel Riwayat -->
<div class="panel">
    <h2>Daftar Pengeluaran</h2>
    <table>
        <tr><th>No</th><th>Nama Barang</th><th>Harga</th><th>Tanggal</th></tr>
        <?php 
        $no=1; $q_list = mysqli_query($koneksi, "SELECT * FROM pengeluaran ORDER BY tanggal DESC");
        while($r = mysqli_fetch_assoc($q_list)): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $r['nama_barang'] ?></td>
            <td>Rp <?= number_format($r['harga'],0,',','.') ?></td>
            <td><?= $r['tanggal'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

<?php require_once '../includes/footer.php'; ?>