<?php
$page_title = "Data Penghuni";
require_once '../config/database.php'; 

// 1. Mulai session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. CEK ROLE DULU SEBELUM HTML DIMUAT
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'bendahara') {
    header("Location: ../index.php"); 
    exit;
}

// 3. Baru panggil header
require_once '../includes/header.php';  
?>

<div class="panel">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Daftar Penghuni Kontrakan</h2>
        <a href="create.php" class="btn btn-primary" style="text-decoration: none;">+ Tambah Penghuni</a>
    </div>

    <table>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Username</th>
            <th>Role</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        <?php 
        $no = 1; 
        $query = "SELECT * FROM penghuni ORDER BY id_penghuni ASC";
        $result = mysqli_query($koneksi, $query);
        
        while($r = mysqli_fetch_assoc($result)): 
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $r['nama'] ?></td>
            <td><?= $r['username'] ?></td>
            <td><?= ucfirst($r['role']) ?></td>
            <td>
                <span class="badge <?= $r['status_aktif'] ? 'badge-lunas' : 'badge-belum' ?>">
                    <?= $r['status_aktif'] ? 'Aktif' : 'Tidak Aktif' ?>
                </span>
            </td>
            <td>
                <a href="edit.php?id=<?= $r['id_penghuni'] ?>" style="color: #2563EB; margin-right: 10px;">Edit</a>
                <a href="delete.php?id=<?= $r['id_penghuni'] ?>" onclick="return confirm('Yakin ingin menghapus?')" style="color: #DC2626;">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

<?php require_once '../includes/footer.php'; ?>