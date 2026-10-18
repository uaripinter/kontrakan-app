<?php
$page_title = "Edit Penghuni";
require_once '../config/database.php';
require_once '../includes/header.php';

if ($_SESSION['role'] != 'bendahara') { header("Location: ../index.php"); exit; }

$id = $_GET['id'];
$q_data = mysqli_query($koneksi, "SELECT * FROM penghuni WHERE id_penghuni = '$id'");
$data = mysqli_fetch_assoc($q_data);

if (!$data) { header("Location: index.php"); exit; }

if (isset($_POST['update'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $role = $_POST['role'];
    $status = $_POST['status_aktif'];

    $query = "UPDATE penghuni SET nama='$nama', role='$role', status_aktif='$status' WHERE id_penghuni='$id'";
    mysqli_query($koneksi, $query);
    
    echo "<script>alert('Data berhasil diperbarui!'); window.location='index.php';</script>";
}
?>

<div class="panel" style="max-width: 600px;">
    <h2>Edit Data Penghuni</h2>
    <form method="POST">
        <div class="field">
            <label>Nama Lengkap *</label>
            <input type="text" name="nama" value="<?= $data['nama'] ?>">
        </div>
        <div class="field">
            <label>Username (Tidak dapat diubah)</label>
            <input type="text" value="<?= $data['username'] ?>" disabled style="background: #eee;">
        </div>
        <div class="field">
            <label>Role *</label>
            <select name="role">
                <option value="penghuni" <?= $data['role']=='penghuni'?'selected':'' ?>>Penghuni</option>
                <option value="bendahara" <?= $data['role']=='bendahara'?'selected':'' ?>>Bendahara</option>
            </select>
        </div>
        <div class="field">
            <label>Status</label>
            <select name="status_aktif">
                <option value="1" <?= $data['status_aktif']==1?'selected':'' ?>>Aktif</option>
                <option value="0" <?= $data['status_aktif']==0?'selected':'' ?>>Tidak Aktif (Pindah)</option>
            </select>
        </div>
        <button type="submit" name="update" class="btn btn-primary">Update Data</button>
        <a href="index.php" class="btn" style="text-decoration:none; color: #333; background: #eee;">Batal</a>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>