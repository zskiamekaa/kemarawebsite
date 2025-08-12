<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Dashboard Admin - Data Siswa</title>
    <style>
        /* RESET */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, sans-serif; background-color: #f4f6fa; color: #333; display: flex; }
        .sidebar { width: 250px; height: 100vh; background-color: #184769; color: white; display: flex; flex-direction: column; justify-content: space-between; position: fixed; left: 0; top: 0; padding: 20px; }
        .sidebar a { color: white; text-decoration: none; margin-bottom: 20px; display: block; padding: 10px; border-radius: 8px; transition: background 0.3s; }
        .sidebar a:hover { background-color: #133656; }
        .container { margin-left: 250px; padding: 30px; flex: 1; min-height: 100vh; }
        .filter-form { padding: 20px; border-radius: 12px; margin-bottom: 20px; display: flex; flex-wrap: wrap; gap: 16px; align-items: center; }
        .filter-form input, .filter-form select { padding: 12px 16px; font-size: 15px; border: 1px solid #ccc; border-radius: 8px; width: 240px; transition: border 0.3s; }
        .filter-form button, .reset-btn { padding: 12px 20px; font-size: 15px; border: none; border-radius: 8px; cursor: pointer; }
        .filter-form button { background-color: #184769; color: white; }
        .filter-form button:hover { background-color: #133656; }
        .reset-btn { background-color: #6c757d; color: white; text-decoration: none; }
        .reset-btn:hover { background-color: #5a6268; }
        .table-container { background-color: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        table thead { background-color: #184769; color: white; }
        table th, table td { padding: 12px 16px; border-bottom: 1px solid #ddd; }
        table tbody tr:hover { background-color: #f1f1f1; }
        .btn { padding: 6px 12px; border: none; border-radius: 6px; cursor: pointer; font-size: 13px; }
        .btn-edit { background-color: #007bff; color: white; }
        .btn-edit:hover { background-color: #0069d9; }
        .badge { padding: 4px 8px; border-radius: 6px; font-size: 12px; }
        .badge.waiting { background-color: #ffc107; color: black; }
        .badge.accepted { background-color: #28a745; color: white; }
        .badge.rejected { background-color: #dc3545; color: white; }
        .alasan-box { display: none; margin-top: 6px; }
        .alasan-box textarea { width: 100%; padding: 6px; border-radius: 6px; border: 1px solid #ccc; resize: vertical; font-size: 13px; }
    </style>
</head>
<body>

<?php
$active = 'pendaftar'; 
include 'includes/sidebar.php';
include 'koneksi.php';

$keyword = $_GET['keyword'] ?? '';
$status_filter = $_GET['status'] ?? '';

$sql = "SELECT * FROM akun_siswa WHERE 1=1";
if ($keyword != '') {
    $sql .= " AND (no_peserta LIKE '%$keyword%' OR NISN LIKE '%$keyword%' OR email LIKE '%$keyword%')";
}
if ($status_filter != '') {
    $sql .= " AND status_akun = '$status_filter'";
}
$result = mysqli_query($conn, $sql);
?>

<div class="container">
    <h2>Manajemen Pendaftar</h2>

    <form method="GET" class="filter-form mb-3">
        <input type="text" name="keyword" placeholder="Cari Nama, No Peserta, NISN, Email" value="<?= htmlspecialchars($keyword) ?>">
        <select name="status">
            <option value="">Semua Status</option>
            <option value="Menunggu Verifikasi" <?= $status_filter == 'Menunggu Verifikasi' ? 'selected' : '' ?>>Menunggu Verifikasi</option>
            <option value="Disetujui" <?= $status_filter == 'Disetujui' ? 'selected' : '' ?>>Disetujui</option>
            <option value="Ditolak" <?= $status_filter == 'Ditolak' ? 'selected' : '' ?>>Ditolak</option>
        </select>
        <button type="submit">Filter</button>
        <a href="manajemen_pendaftar.php" class="reset-btn">Reset</a>
    </form>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>No Peserta</th>
                    <th>NISN</th>
                    <th>Email</th>
                    <th>No Telp</th>
                    <th>Status</th>
                    <th>Aksi</th>
                    <th>Alasan</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row['no_peserta'] ?></td>
                        <td><?= $row['NISN'] ?></td>
                        <td><?= $row['email'] ?></td>
                        <td><?= $row['no_telp'] ?></td>
                        <td>
                            <?php
                            if ($row['status_akun'] == 'Menunggu Verifikasi') echo '<span class="badge waiting">🟡 Menunggu Verifikasi</span>';
                            elseif ($row['status_akun'] == 'Disetujui') echo '<span class="badge accepted">🟢 Disetujui</span>';
                            elseif ($row['status_akun'] == 'Ditolak') echo '<span class="badge rejected">🔴 Ditolak</span>';
                            ?>
                        </td>
                        <td>
                            <form method="POST" action="ubah_status.php" style="display:flex; flex-direction:column; gap:4px;" onsubmit="return validateForm(this)">
                                <input type="hidden" name="no_peserta" value="<?= $row['no_peserta'] ?>">
                                <select name="status" class="status-select">
                                    <option value="Menunggu Verifikasi" <?= $row['status_akun'] == 'Menunggu Verifikasi' ? 'selected' : '' ?>>Menunggu</option>
                                    <option value="Disetujui" <?= $row['status_akun'] == 'Disetujui' ? 'selected' : '' ?>>Disetujui</option>
                                    <option value="Ditolak" <?= $row['status_akun'] == 'Ditolak' ? 'selected' : '' ?>>Ditolak</option>
                                </select>
                                <div class="alasan-box">
                                    <textarea name="alasan" placeholder="Isi alasan penolakan..."><?= htmlspecialchars($row['alasan']) ?></textarea>
                                </div>
                                <button type="submit" class="btn btn-edit">Update</button>
                            </form>
                        </td>
                        <td><?= htmlspecialchars($row['alasan']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.status-select').forEach(function (select) {
        toggleAlasan(select);
        select.addEventListener('change', function () {
            toggleAlasan(select);
        });
    });

    function toggleAlasan(select) {
        const alasanBox = select.closest('form').querySelector('.alasan-box');
        if (select.value === 'Ditolak') {
            alasanBox.style.display = 'block';
            alasanBox.querySelector('textarea').required = true;
        } else {
            alasanBox.style.display = 'none';
            alasanBox.querySelector('textarea').required = false;
            alasanBox.querySelector('textarea').value = '';
        }
    }
});

// Validasi sebelum submit
function validateForm(form) {
    const status = form.querySelector('.status-select').value;
    const alasan = form.querySelector('textarea').value.trim();
    if (status === 'Ditolak' && alasan === '') {
        alert('Mohon isi alasan penolakan!');
        return false;
    }
    return true;
}
</script>

</body>
</html>
