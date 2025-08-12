<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Dashboard Admin - Data Siswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 20px;
            margin-left: 260px;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        /* Statistik Box */
        .stats-container {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .stat-box {
            flex: 1;
            background: white;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        .stat-icon {
            font-size: 28px;
            margin-bottom: 8px;
        }

        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .stat-label {
            font-size: 14px;
            color: #666;
        }

        /* Warna per box */
        .stats-container .stat-box:nth-child(1) .stat-icon { color: #28a745; }
        .stats-container .stat-box:nth-child(2) .stat-icon { color: #dc3545; }
        .stats-container .stat-box:nth-child(3) .stat-icon { color: #ffc107; }

        /* Filter form */
        .filter-form {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-bottom: 20px;
        }

        .filter-form input,
        .filter-form select {
            padding: 8px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        .filter-form button {
            background-color: #007bff;
            border: none;
            padding: 8px 14px;
            color: white;
            border-radius: 6px;
            cursor: pointer;
        }

        .filter-form button:hover {
            background-color: #0056b3;
        }

        .reset-btn {
            background-color: #6c757d;
            color: white;
            padding: 8px 14px;
            border-radius: 6px;
            text-decoration: none;
        }

        /* Table */
        .table-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        table th, table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        table th {
            background-color: #184769;
            color: white;
        }

        /* Badge */
        .badge {
            padding: 5px 8px;
            border-radius: 6px;
            font-weight: bold;
            display: inline-block;
        }

        .badge.waiting { background-color: #fff3cd; color: #856404; }
        .badge.accepted { background-color: #d4edda; color: #155724; }
        .badge.rejected { background-color: #f8d7da; color: #721c24; }

        @media (max-width: 768px) {
            .container { margin-left: 0; }
            .stats-container { flex-direction: column; }
            .filter-form { flex-direction: column; align-items: stretch; }
        }
    </style>
</head>
<body>
<?php
$active = 'pendaftar'; 
include 'includes/sidebar.php';
include 'koneksi.php';

$keyword = $_GET['keyword'] ?? '';
$status_filter = $_GET['status'] ?? '';

// Ambil jumlah data untuk statistik
$count_disetujui = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM akun_siswa WHERE status_akun='Disetujui'"))['total'];
$count_ditolak = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM akun_siswa WHERE status_akun='Ditolak'"))['total'];
$count_menunggu = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM akun_siswa WHERE status_akun='Menunggu Verifikasi'"))['total'];

// Query data tabel
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

    <!-- Statistik Box -->
    <div class="stats-container">
        <div class="stat-box">
            <div class="stat-icon">✅</div>
            <div class="stat-number"><?= $count_disetujui ?></div>
            <div class="stat-label">Disetujui</div>
        </div>
        <div class="stat-box">
            <div class="stat-icon">❌</div>
            <div class="stat-number"><?= $count_ditolak ?></div>
            <div class="stat-label">Ditolak</div>
        </div>
        <div class="stat-box">
            <div class="stat-icon">⏳</div>
            <div class="stat-number"><?= $count_menunggu ?></div>
            <div class="stat-label">Menunggu</div>
        </div>
    </div>

    <!-- Filter Form -->
    <form method="GET" class="filter-form">
        <input type="text" name="keyword" placeholder="Cari No Peserta, NISN, Email" value="<?= htmlspecialchars($keyword) ?>">
        <select name="status">
            <option value="">Semua Status</option>
            <option value="Menunggu Verifikasi" <?= $status_filter == 'Menunggu Verifikasi' ? 'selected' : '' ?>>Menunggu Verifikasi</option>
            <option value="Disetujui" <?= $status_filter == 'Disetujui' ? 'selected' : '' ?>>Disetujui</option>
            <option value="Ditolak" <?= $status_filter == 'Ditolak' ? 'selected' : '' ?>>Ditolak</option>
        </select>
        <button type="submit">Filter</button>
        <a href="manajemen_pendaftar.php" class="reset-btn">Reset</a>
    </form>

    <!-- Tabel Data -->
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
                    <th>Alasan</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php $no = 1; while ($row = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row['no_peserta'] ?></td>
                            <td><?= $row['NISN'] ?></td>
                            <td><?= $row['email'] ?></td>
                            <td><?= $row['no_telp'] ?></td>
                            <td>
                                <?php
                                $status = $row['status_akun'];
                                if ($status == 'Menunggu Verifikasi') {
                                    echo '<span class="badge waiting">🟡 '.$status.'</span>';
                                } elseif ($status == 'Disetujui') {
                                    echo '<span class="badge accepted">🟢 '.$status.'</span>';
                                } elseif ($status == 'Ditolak') {
                                    echo '<span class="badge rejected">🔴 '.$status.'</span>';
                                }
                                ?>
                            </td>
                            <td><?= $row['alasan'] ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="7" style="text-align:center;">Tidak ada data ditemukan</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
