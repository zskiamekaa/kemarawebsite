<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Dashboard Admin - Manajemen Pendaftar</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#E8E0D5] font-sans">

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

<div class="ml-64 p-6">
    <h2 class="text-2xl font-bold text-[#184769] mb-6">Manajemen Pendaftar</h2>

   
    <form method="GET" class="flex flex-col md:flex-row gap-3 mb-6">
        <input type="text" name="keyword" placeholder="Cari Nama, No Peserta, NISN, Email" 
               value="<?= htmlspecialchars($keyword) ?>"
               class="px-3 py-2 border rounded-md text-sm w-full md:w-auto focus:ring focus:ring-blue-300 outline-none">

        <select name="status" class="px-3 py-2 border rounded-md text-sm w-full md:w-auto focus:ring focus:ring-blue-300 outline-none">
            <option value="">Semua Status</option>
            <option value="Menunggu Verifikasi" <?= $status_filter == 'Menunggu Verifikasi' ? 'selected' : '' ?>>Menunggu Verifikasi</option>
            <option value="Disetujui" <?= $status_filter == 'Disetujui' ? 'selected' : '' ?>>Disetujui</option>
            <option value="Ditolak" <?= $status_filter == 'Ditolak' ? 'selected' : '' ?>>Ditolak</option>
        </select>

        <button type="submit" class="bg-[#F77E21] hover:bg-orange-600 text-white px-4 py-2 rounded-md text-sm">Filter</button>
    </form>

   
    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full table-fixed text-sm">
            <thead class="bg-[#184769] text-white">
                <tr>
                    <th class="px-3 py-2 text-left w-6">No</th>
                    <th class="px-3 py-2 text-left w-24">No Peserta</th>
                    <th class="px-3 py-2 text-left w-24">NISN</th>
                    <th class="px-3 py-2 text-left w-48">Email</th>
                    <th class="px-3 py-2 text-left w-32">No Telp</th>
                    <th class="px-3 py-2 text-left w-32">Status</th>
                    <th class="px-3 py-2 text-left w-36">Aksi</th>
                    <th class="px-3 py-2 text-left">Alasan</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-3 py-1"><?= $no++ ?></td>
                        <td class="px-3 py-1"><?= $row['no_peserta'] ?></td>
                        <td class="px-3 py-1"><?= $row['NISN'] ?></td>
                        <td class="px-3 py-1 truncate" title="<?= $row['email'] ?>"><?= $row['email'] ?></td>
                        <td class="px-3 py-1"><?= $row['no_telp'] ?></td>
                        <td class="px-3 py-1">
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
                        <td class="px-3 py-1">
                            <form method="POST" action="ubah_status.php" class="flex flex-col gap-1" onsubmit="return validateForm(this)">
                                <input type="hidden" name="no_peserta" value="<?= $row['no_peserta'] ?>">
                                <select name="status" class="px-2 py-1 border rounded-md text-xs w-full">
                                    <option value="Menunggu Verifikasi" <?= $row['status_akun'] == 'Menunggu Verifikasi' ? 'selected' : '' ?>>Menunggu</option>
                                    <option value="Disetujui" <?= $row['status_akun'] == 'Disetujui' ? 'selected' : '' ?>>Disetujui</option>
                                    <option value="Ditolak" <?= $row['status_akun'] == 'Ditolak' ? 'selected' : '' ?>>Ditolak</option>
                                </select>
                                <div class="alasan-box hidden mt-1">
                                    <textarea name="alasan" placeholder="Isi alasan penolakan..." 
                                              class="w-full px-2 py-1 border rounded-md text-xs min-h-[60px]"><?= htmlspecialchars($row['alasan']) ?></textarea>
                                </div>
                                <button type="submit" class="bg-[#F77E21] hover:bg-orange-600 text-white px-3 py-1 rounded-md text-xs font-medium w-full">Update</button>
                            </form>
                        </td>
                        <td class="px-3 py-1 truncate" title="<?= $row['alasan'] ?>"><?= htmlspecialchars($row['alasan']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('select[name="status"]').forEach(function (select) {
        toggleAlasan(select); 
        select.addEventListener('change', function () {
            toggleAlasan(select);
        });
    });

    function toggleAlasan(select) {
        const alasanBox = select.closest('form').querySelector('.alasan-box');
        const textarea = alasanBox.querySelector('textarea');

        if (select.value === 'Ditolak') {
            alasanBox.classList.remove('hidden');
            alasanBox.classList.add('block'); 
            textarea.required = true;
        } else {
            alasanBox.classList.add('hidden');
            textarea.required = false;
        }
    }
});

function validateForm(form) {
    const status = form.querySelector('select[name="status"]').value;
    const alasan = form.querySelector('textarea')?.value.trim();
    if (status === 'Ditolak' && alasan === '') {
        alert('Mohon isi alasan penolakan sebelum Update!');
        return false;
    }
    return true;
}
</script>

</body>
</html>
