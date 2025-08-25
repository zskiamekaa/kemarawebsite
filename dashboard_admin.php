<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Dashboard Admin - Data Siswa</title>
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#E8E0D5] font-sans">
<?php
$active = 'pendaftar'; 
include 'includes/sidebar.php';
include 'koneksi.php';

$keyword = $_GET['keyword'] ?? '';
$status_filter = $_GET['status'] ?? '';

// Statistik
$count_disetujui = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM akun_siswa WHERE status_akun='Disetujui'"))['total'];
$count_ditolak   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM akun_siswa WHERE status_akun='Ditolak'"))['total'];
$count_menunggu  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM akun_siswa WHERE status_akun='Menunggu Verifikasi'"))['total'];

// Query tabel
$sql = "SELECT * FROM akun_siswa WHERE 1=1";
if ($keyword != '') {
    $sql .= " AND (no_peserta LIKE '%$keyword%' OR NISN LIKE '%$keyword%' OR email LIKE '%$keyword%')";
}
if ($status_filter != '') {
    $sql .= " AND status_akun = '$status_filter'";
}
$result = mysqli_query($conn, $sql);
?>
<!-- KONTEN -->
<div class="p-6 ml-[240px]">
    <h2 class="text-2xl font-bold text-[#184769] mb-6">Dashboard Admin</h2>

    <!-- Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <div class="text-3xl mb-2 text-green-600">✅</div>
            <div class="text-2xl font-bold text-[#184769]"><?= $count_disetujui ?></div>
            <div class="text-sm text-gray-600">Disetujui</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <div class="text-3xl mb-2 text-red-600">❌</div>
            <div class="text-2xl font-bold text-[#184769]"><?= $count_ditolak ?></div>
            <div class="text-sm text-gray-600">Ditolak</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <div class="text-3xl mb-2 text-yellow-500">⏳</div>
            <div class="text-2xl font-bold text-[#184769]"><?= $count_menunggu ?></div>
            <div class="text-sm text-gray-600">Menunggu</div>
        </div>
    </div>

    <!-- Filter -->
    <form method="GET" class="flex flex-col md:flex-row gap-3 mb-6">
        <input type="text" 
               name="keyword" 
               placeholder="Cari No Peserta, NISN, Email" 
               value="<?= htmlspecialchars($keyword) ?>" 
               class="px-3 py-2 border rounded-md text-sm w-full md:w-auto">
        <select name="status" class="px-3 py-2 border rounded-md text-sm w-full md:w-auto">
            <option value="">Semua Status</option>
            <option value="Menunggu Verifikasi" <?= $status_filter == 'Menunggu Verifikasi' ? 'selected' : '' ?>>Menunggu Verifikasi</option>
            <option value="Disetujui" <?= $status_filter == 'Disetujui' ? 'selected' : '' ?>>Disetujui</option>
            <option value="Ditolak" <?= $status_filter == 'Ditolak' ? 'selected' : '' ?>>Ditolak</option>
        </select>
        <button type="submit" class="bg-[#F77E21] text-white px-4 py-2 rounded-md text-sm hover:bg-orange-600">
            Filter
        </button>
        <a href="manajemen_pendaftar.php" class="bg-[#F77E21] text-white px-4 py-2 rounded-md text-sm text-center hover:bg-orange-600">
            Reset
        </a>
    </form>

    <!-- Tabel -->
    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-[#184769] text-white">
                    <th class="px-4 py-2 text-left">No</th>
                    <th class="px-4 py-2 text-left">No Peserta</th>
                    <th class="px-4 py-2 text-left">NISN</th>
                    <th class="px-4 py-2 text-left">Email</th>
                    <th class="px-4 py-2 text-left">No Telp</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-left">Alasan</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php $no = 1; while ($row = mysqli_fetch_assoc($result)) : ?>
                        <tr class="border-b">
                            <td class="px-4 py-2"><?= $no++ ?></td>
                            <td class="px-4 py-2"><?= $row['no_peserta'] ?></td>
                            <td class="px-4 py-2"><?= $row['NISN'] ?></td>
                            <td class="px-4 py-2"><?= $row['email'] ?></td>
                            <td class="px-4 py-2"><?= $row['no_telp'] ?></td>
                            <td class="px-4 py-2">
                                <?php
                                $status = $row['status_akun'];
                                if ($status == 'Menunggu Verifikasi') {
                                    echo '<span class="bg-yellow-100 text-yellow-700 font-semibold px-2 py-1 rounded-md inline-block">🟡 '.$status.'</span>';
                                } elseif ($status == 'Disetujui') {
                                    echo '<span class="bg-green-100 text-green-700 font-semibold px-2 py-1 rounded-md inline-block">🟢 '.$status.'</span>';
                                } elseif ($status == 'Ditolak') {
                                    echo '<span class="bg-red-100 text-red-700 font-semibold px-2 py-1 rounded-md inline-block">🔴 '.$status.'</span>';
                                }
                                ?>
                            </td>
                            <td class="px-4 py-2"><?= $row['alasan'] ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center px-4 py-4 text-gray-500">Tidak ada data ditemukan</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
