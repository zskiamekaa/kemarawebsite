<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Dashboard Admin - Statistik Pendaftaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#E8E0D5] font-sans flex">

<?php
$active = 'statistik'; 
include 'includes/sidebar.php';
include 'koneksi.php';
?>

<div class="flex-1 p-8 ml-[240px]"> 
    <h1 class="text-2xl font-bold mb-6 text-gray-800">
        📊 Statistik Berdasarkan Umur dan Nilai Siswa
    </h1>

    <!-- Wrapper Tabel -->
    <div class="overflow-x-auto shadow-lg rounded-xl border border-gray-200">
        <table class="min-w-[600px] w-full text-sm text-left">
            <!-- Header -->
            <thead class="bg-[#184769] text-white">
                <tr>
                    <th class="px-4 py-3 text-center">No</th>
                    <th class="px-4 py-3">Nama Siswa</th>
                    <th class="px-4 py-3 text-center">Umur</th>
                    <th class="px-4 py-3 text-center">Nilai Rata-rata</th>
                </tr>
            </thead>

            <!-- Body -->
            <tbody>
                <?php
                $sql = "
                    SELECT 
                        ds.nama_lengkap, 
                        ds.tanggal_lahir,
                        FLOOR(DATEDIFF(CURDATE(), ds.tanggal_lahir)/365) AS umur,
                        ROUND((
                            ns.bahasa_indonesia + ns.bahasa_inggris + ns.matematika + 
                            ns.IPA + ns.IPS + ns.PPKn
                        ) / 6, 2) AS nilai_rata2
                    FROM data_siswa ds
                    JOIN nilai_siswa ns ON ds.NISN = ns.NISN
                    WHERE ns.semester = 1
                    ORDER BY umur DESC, nilai_rata2 DESC
                ";

                $result = mysqli_query($conn, $sql);
                if (!$result) {
                    die("Query error: " . mysqli_error($conn));
                }

                $no = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    $bg = $no % 2 == 0 ? "bg-[#f1f6fa]" : "bg-white"; // striping
                    echo "
                        <tr class='{$bg} hover:bg-[#d9e6f2] transition'>
                            <td class='px-4 py-3 text-center font-medium text-gray-900'>{$no}</td>
                            <td class='px-4 py-3'>{$row['nama_lengkap']}</td>
                            <td class='px-4 py-3 text-center'>{$row['umur']} tahun</td>
                            <td class='px-4 py-3 text-center font-semibold text-gray-700'>{$row['nilai_rata2']}</td>
                        </tr>
                    ";
                    $no++;
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
