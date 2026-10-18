<?php
$page_title = "Tambah Penghuni";
require_once '../config/database.php';
require_once '../includes/header.php';

if ($_SESSION['role'] != 'bendahara') { header("Location: ../index.php"); exit; }

$error = "";

if (isset($_POST['simpan'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Validasi Required
    if (empty($nama) || empty($username) || empty($password)) {
        $error = "Semua field wajib diisi!";
    } else {
        // Validasi Duplicate Username
        $cek = mysqli_query($koneksi, "SELECT * FROM penghuni WHERE username = '$username'");
        if (mysqli_num_rows($cek) > 0) {
            $error = "Username sudah digunakan, silakan pilih yang lain!";
        } else {
            $query = "INSERT INTO penghuni (nama, username, password, role, status_aktif) 
                      VALUES ('$nama', '$username', '$password', '$role', TRUE)";
            mysqli_query($koneksi, $query);
            
            echo "<script>alert('Penghuni berhasil ditambahkan!'); window.location='index.php';</script>";
        }
    }
}
?>

<div class="panel" style="max-width: 600px;">
    <h2>Form Tambah Penghuni</h2>
    
    <?php if($error): ?>
        <div style="color: red; margin-bottom: 15px;"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="field">
            <label>Nama Lengkap *</label>
            <input type="text" name="nama">
        </div>
        <div class="field">
            <label>Username *</label>
            <input type="text" name="username">
        </div>
        <div class="field">
            <label>Password *</label>
            <input type="text" name="password">
        </div>
        <div class="field">
            <label>Role *</label>
            <select name="role">
                <option value="penghuni">Penghuni</option>
                <option value="bendahara">Bendahara</option>
            </select>
        </div>
        <button type="submit" name="simpan" class="btn btn-primary">Simpan Data</button>
        <a href="index.php" class="btn" style="text-decoration:none; color: #333; background: #eee;">Batal</a>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>