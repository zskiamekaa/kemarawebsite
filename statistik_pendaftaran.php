<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Dashboard Admin - Statistik Pendaftaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-[#E8E0D5] font-sans flex">

<?php
$active = 'statistik'; 
include 'includes/sidebar.php';
include 'koneksi.php';
?>
📊 Halaman Statistik Data Siswa

<div class="flex-1 p-8 ml-[240px] space-y-8"> 
        <h2 class="text-2xl font-bold text-[#184769] mb-6">📊 Halaman Statistik Data Siswa</h2>


    <?php
    // ================= Chart Umur & Nilai =================
    $sql = "
        SELECT 
            ds.nama_lengkap, 
            ds.tanggal_lahir,
            FLOOR(DATEDIFF(CURDATE(), ds.tanggal_lahir)/365) AS umur,
            ROUND((ns.bahasa_indonesia + ns.bahasa_inggris + ns.matematika + 
                   ns.IPA + ns.IPS + ns.PPKn)/6, 2) AS nilai_rata2
        FROM data_siswa ds
        JOIN nilai_siswa ns ON ds.NISN = ns.NISN
        WHERE ns.semester = 1
        ORDER BY umur DESC, nilai_rata2 DESC
    ";

    $result = mysqli_query($conn, $sql);
    $nama = []; $umur = []; $nilai = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $nama[] = $row['nama_lengkap'];
        $umur[] = $row['umur'];
        $nilai[] = $row['nilai_rata2'];
    }

    // ================= Chart Jenis Kelamin =================
    $sql_gender = "
        SELECT jenis_kelamin, COUNT(*) AS jumlah
        FROM data_siswa
        GROUP BY jenis_kelamin
    ";
    $result_gender = mysqli_query($conn, $sql_gender);
    $gender_labels = [];
    $gender_data = [];
    while ($row = mysqli_fetch_assoc($result_gender)) {
        $gender_labels[] = $row['jenis_kelamin'];
        $gender_data[] = $row['jumlah'];
    }

    // ================= Chart Agama =================
    $sql_agama = "
        SELECT agama, COUNT(*) AS jumlah
        FROM data_siswa
        GROUP BY agama
    ";
    $result_agama = mysqli_query($conn, $sql_agama);
    $agama_labels = [];
    $agama_data = [];
    while ($row = mysqli_fetch_assoc($result_agama)) {
        $agama_labels[] = $row['agama'];
        $agama_data[] = $row['jumlah'];
    }
    ?>

    <!-- Chart Umur & Nilai -->
    <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-200 overflow-x-auto">
        <div style="min-width: <?php echo count($nama) * 80; ?>px; height:400px;">
            <canvas id="statistikChart" class="w-full h-full"></canvas>
        </div>
    </div>

    <!-- Chart Jenis Kelamin dan Agama -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Pie Chart Jenis Kelamin -->
        <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-200 flex flex-col" style="height:400px;">
            <h2 class="text-xl font-semibold mb-2 text-gray-700">👫 Distribusi Jenis Kelamin Siswa</h2>
            <div class="flex-1">
                <canvas id="genderChart" class="w-full h-full"></canvas>
            </div>
        </div>

        <!-- Pie Chart Agama -->
        <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-200 flex flex-col" style="height:400px;">
            <h2 class="text-xl font-semibold mb-2 text-gray-700">🙏 Distribusi Agama Siswa</h2>
            <div class="flex-1">
                <canvas id="agamaChart" class="w-full h-full"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    // Chart Umur & Nilai
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
            maintainAspectRatio: false,
            animation: false, // 🚀 langsung tampil tanpa animasi
            plugins: {
                legend: { position: 'top', labels: { font: { size: 14 } } },
                title: { display: true, text: 'Perbandingan Umur dan Nilai Rata-rata Siswa', font: { size: 18 } }
            },
            scales: {
                x: { ticks: { autoSkip: false, maxRotation: 45, minRotation: 45 } },
                y: { beginAtZero: true }
            }
        }
    });

    // Chart Jenis Kelamin
    const ctxGender = document.getElementById('genderChart').getContext('2d');
    new Chart(ctxGender, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($gender_labels); ?>,
            datasets: [{
                label: 'Jumlah Siswa',
                data: <?php echo json_encode($gender_data); ?>,
                backgroundColor: ['rgba(54, 162, 235, 0.7)', 'rgba(255, 99, 132, 0.7)'],
                borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 1,
            animation: false, // 🚀 langsung tampil
            plugins: {
                legend: { position: 'top', labels: { font: { size: 14 } } },
                title: { display: true, text: 'Proporsi Jenis Kelamin Siswa', font: { size: 16 } }
            }
        }
    });

    // Chart Agama
    const ctxAgama = document.getElementById('agamaChart').getContext('2d');
    new Chart(ctxAgama, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($agama_labels); ?>,
            datasets: [{
                label: 'Jumlah Siswa',
                data: <?php echo json_encode($agama_data); ?>,
                backgroundColor: [
                    '#F87171','#60A5FA','#34D399','#FBBF24','#A78BFA','#F472B6','#10B981'
                ],
                borderColor: '#fff',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 1,
            animation: false, // 🚀 langsung tampil
            plugins: {
                legend: { position: 'bottom', labels: { font: { size: 14 } } },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let total = context.dataset.data.reduce((a,b)=>a+b,0);
                            let value = context.raw;
                            let percentage = ((value/total)*100).toFixed(1)+"%";
                            return `${context.label}: ${value} (${percentage})`;
                        }
                    }
                },
                title: { display: true, text: 'Proporsi Agama Siswa', font: { size: 16 } }
            }
        }
    });
</script>

</body>
</html>
