<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Dashboard Admin - Statistik Pendaftaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Tambahkan Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

    <?php
    // Query data
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

    $nama = [];
    $umur = [];
    $nilai = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $nama[] = $row['nama_lengkap'];
        $umur[] = $row['umur'];
        $nilai[] = $row['nilai_rata2'];
    }
    ?>

    <!-- Canvas untuk Chart -->
    <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-200 overflow-x-auto">
        <!-- Lebar chart dihitung dari jumlah siswa -->
        <div style="min-width: <?php echo count($nama) * 80; ?>px; height:400px;">
            <canvas id="statistikChart"></canvas>
        </div>
    </div>
</div>

<script>
const ctx = document.getElementById('statistikChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($nama); ?>,
        datasets: [
            {
                label: 'Umur (tahun)',
                data: <?php echo json_encode($umur); ?>,
                backgroundColor: 'rgba(24, 71, 105, 0.6)',
                borderColor: 'rgba(24, 71, 105, 1)',
                borderWidth: 1
            },
            {
                label: 'Nilai Rata-rata',
                data: <?php echo json_encode($nilai); ?>,
                backgroundColor: 'rgba(255, 165, 0, 0.6)',
                borderColor: 'rgba(255, 165, 0, 1)',
                borderWidth: 1
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false, // biar tinggi tetap
        plugins: {
            legend: {
                position: 'top',
                labels: { font: { size: 14 } }
            },
            title: {
                display: true,
                text: 'Perbandingan Umur dan Nilai Rata-rata Siswa',
                font: { size: 18 }
            }
        },
        scales: {
            x: {
                ticks: {
                    autoSkip: false,
                    maxRotation: 45,
                    minRotation: 45
                }
            },
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
</body>
</html>
