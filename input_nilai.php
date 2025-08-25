<?php
session_start();
include 'koneksi.php';

// Cek login
if (!isset($_SESSION['npsn'])) {
    header("Location: login.php");
    exit;
}

$npsn = $_SESSION['npsn'];

// Ambil data sekolah
$querySekolah = mysqli_query($conn, "SELECT * FROM sekolah WHERE NPSN='$npsn' LIMIT 1");
$dataSekolah = mysqli_fetch_assoc($querySekolah);

// Ambil data nilai siswa (pivot per semester)
$queryNilai = mysqli_query($conn, "
    SELECT 
      ds.NISN,
      ds.nama_lengkap,

      -- Semester 1
      MAX(CASE WHEN ns.semester=1 THEN ns.bahasa_indonesia END) AS indo_smt1,
      MAX(CASE WHEN ns.semester=1 THEN ns.bahasa_inggris END) AS ing_smt1,
      MAX(CASE WHEN ns.semester=1 THEN ns.matematika END) AS mtk_smt1,
      MAX(CASE WHEN ns.semester=1 THEN ns.IPA END) AS ipa_smt1,
      MAX(CASE WHEN ns.semester=1 THEN ns.IPS END) AS ips_smt1,
      MAX(CASE WHEN ns.semester=1 THEN ns.PPKn END) AS ppkn_smt1,

      -- Semester 2
      MAX(CASE WHEN ns.semester=2 THEN ns.bahasa_indonesia END) AS indo_smt2,
      MAX(CASE WHEN ns.semester=2 THEN ns.bahasa_inggris END) AS ing_smt2,
      MAX(CASE WHEN ns.semester=2 THEN ns.matematika END) AS mtk_smt2,
      MAX(CASE WHEN ns.semester=2 THEN ns.IPA END) AS ipa_smt2,
      MAX(CASE WHEN ns.semester=2 THEN ns.IPS END) AS ips_smt2,
      MAX(CASE WHEN ns.semester=2 THEN ns.PPKn END) AS ppkn_smt2,

      -- Semester 3
      MAX(CASE WHEN ns.semester=3 THEN ns.bahasa_indonesia END) AS indo_smt3,
      MAX(CASE WHEN ns.semester=3 THEN ns.bahasa_inggris END) AS ing_smt3,
      MAX(CASE WHEN ns.semester=3 THEN ns.matematika END) AS mtk_smt3,
      MAX(CASE WHEN ns.semester=3 THEN ns.IPA END) AS ipa_smt3,
      MAX(CASE WHEN ns.semester=3 THEN ns.IPS END) AS ips_smt3,
      MAX(CASE WHEN ns.semester=3 THEN ns.PPKn END) AS ppkn_smt3,

      -- Semester 4
      MAX(CASE WHEN ns.semester=4 THEN ns.bahasa_indonesia END) AS indo_smt4,
      MAX(CASE WHEN ns.semester=4 THEN ns.bahasa_inggris END) AS ing_smt4,
      MAX(CASE WHEN ns.semester=4 THEN ns.matematika END) AS mtk_smt4,
      MAX(CASE WHEN ns.semester=4 THEN ns.IPA END) AS ipa_smt4,
      MAX(CASE WHEN ns.semester=4 THEN ns.IPS END) AS ips_smt4,
      MAX(CASE WHEN ns.semester=4 THEN ns.PPKn END) AS ppkn_smt4,

      -- Semester 5
      MAX(CASE WHEN ns.semester=5 THEN ns.bahasa_indonesia END) AS indo_smt5,
      MAX(CASE WHEN ns.semester=5 THEN ns.bahasa_inggris END) AS ing_smt5,
      MAX(CASE WHEN ns.semester=5 THEN ns.matematika END) AS mtk_smt5,
      MAX(CASE WHEN ns.semester=5 THEN ns.IPA END) AS ipa_smt5,
      MAX(CASE WHEN ns.semester=5 THEN ns.IPS END) AS ips_smt5,
      MAX(CASE WHEN ns.semester=5 THEN ns.PPKn END) AS ppkn_smt5

    FROM nilai_siswa ns
    JOIN data_siswa ds ON ns.NISN = ds.NISN
    WHERE ds.NPSN = '$npsn'
    GROUP BY ds.NISN, ds.nama_lengkap
");

// Tetapkan rata-rata umum = 90
$rataUmum = 90;

// Hitung siswa di atas & di bawah rata-rata
$queryHitung = mysqli_query($conn, "
    SELECT ds.NISN, AVG((ns.bahasa_indonesia+ns.bahasa_inggris+ns.matematika+ns.IPA+ns.IPS+ns.PPKn)/6) AS rata
    FROM nilai_siswa ns
    JOIN data_siswa ds ON ns.NISN = ds.NISN
    WHERE ds.NPSN='$npsn'
    GROUP BY ds.NISN
");

$atas = 0;
$bawah = 0;

while ($row = mysqli_fetch_assoc($queryHitung)) {
    if ($row['rata'] >= $rataUmum) {
        $atas++;
    } else {
        $bawah++;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Nilai Siswa</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <style>
    body {
      margin: 0;
      background: #f4f6f9;
      font-family: Arial, sans-serif;
    }
    .main-content {
      margin-left: 250px; /* lebar sidebar */
      padding: 20px;
    }
    .card {
      border-radius: 12px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    h2 {
      font-size: 22px;
      font-weight: bold;
      color: #184769;
    }
    th, td {
      font-size: 13px;
    }
  </style>
</head>

<body>
<?php include 'includes/sidebar_tu.php'; ?>
<div class="main-content p-4">
    <div class="mb-3">
      <h2>Selamat Datang, <?= $dataSekolah['nama_sekolah']; ?> (NPSN: <?= $npsn; ?>)</h2>
    </div>

  <!-- Statistik -->
  <div class="row mb-4">
    <div class="col-md-4">
      <div class="card text-center">
        <div class="card-body">
          <h5>Rata-rata Umum</h5>
          <p class="fs-3 text-primary"><?= number_format($rataUmum,2); ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card text-center">
        <div class="card-body">
          <h5>Di Atas Rata-rata</h5>
          <p class="fs-3 text-success"><?= $atas; ?> siswa</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card text-center">
        <div class="card-body">
          <h5>Di Bawah Rata-rata</h5>
          <p class="fs-3 text-danger"><?= $bawah; ?> siswa</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Tombol Tambah Nilai -->
  <a href="tambah_nilai.php" class="btn btn-primary mb-3">+ Tambah Nilai</a>

  <!-- Tabel Nilai -->
<div class="table-responsive">
  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th rowspan="2">NISN</th>
        <th rowspan="2">Nama</th>
        <th colspan="6">Semester 1</th>
        <th colspan="6">Semester 2</th>
        <th colspan="6">Semester 3</th>
        <th colspan="6">Semester 4</th>
        <th colspan="6">Semester 5</th>
      </tr>
      <tr>
        <th>B.Indo</th><th>B.Ing</th><th>MTK</th><th>IPA</th><th>IPS</th><th>PPKn</th>
        <th>B.Indo</th><th>B.Ing</th><th>MTK</th><th>IPA</th><th>IPS</th><th>PPKn</th>
        <th>B.Indo</th><th>B.Ing</th><th>MTK</th><th>IPA</th><th>IPS</th><th>PPKn</th>
        <th>B.Indo</th><th>B.Ing</th><th>MTK</th><th>IPA</th><th>IPS</th><th>PPKn</th>
        <th>B.Indo</th><th>B.Ing</th><th>MTK</th><th>IPA</th><th>IPS</th><th>PPKn</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      if (mysqli_num_rows($queryNilai) > 0) {
        while($row = mysqli_fetch_assoc($queryNilai)) { ?>
        <tr>
          <td><?= $row['NISN']; ?></td>
          <td><?= $row['nama_lengkap']; ?></td>

          <td><?= $row['indo_smt1']; ?></td>
          <td><?= $row['ing_smt1']; ?></td>
          <td><?= $row['mtk_smt1']; ?></td>
          <td><?= $row['ipa_smt1']; ?></td>
          <td><?= $row['ips_smt1']; ?></td>
          <td><?= $row['ppkn_smt1']; ?></td>

          <td><?= $row['indo_smt2']; ?></td>
          <td><?= $row['ing_smt2']; ?></td>
          <td><?= $row['mtk_smt2']; ?></td>
          <td><?= $row['ipa_smt2']; ?></td>
          <td><?= $row['ips_smt2']; ?></td>
          <td><?= $row['ppkn_smt2']; ?></td>

          <td><?= $row['indo_smt3']; ?></td>
          <td><?= $row['ing_smt3']; ?></td>
          <td><?= $row['mtk_smt3']; ?></td>
          <td><?= $row['ipa_smt3']; ?></td>
          <td><?= $row['ips_smt3']; ?></td>
          <td><?= $row['ppkn_smt3']; ?></td>

          <td><?= $row['indo_smt4']; ?></td>
          <td><?= $row['ing_smt4']; ?></td>
          <td><?= $row['mtk_smt4']; ?></td>
          <td><?= $row['ipa_smt4']; ?></td>
          <td><?= $row['ips_smt4']; ?></td>
          <td><?= $row['ppkn_smt4']; ?></td>

          <td><?= $row['indo_smt5']; ?></td>
          <td><?= $row['ing_smt5']; ?></td>
          <td><?= $row['mtk_smt5']; ?></td>
          <td><?= $row['ipa_smt5']; ?></td>
          <td><?= $row['ips_smt5']; ?></td>
          <td><?= $row['ppkn_smt5']; ?></td>
        </tr>
      <?php 
        } 
      } else { 
      ?>
        <tr>
          <td colspan="32" class="text-center text-muted">Belum ada data nilai siswa</td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
</body>
</html>
