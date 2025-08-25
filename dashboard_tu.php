<?php
session_start();
include 'koneksi.php';

// Cek apakah sudah login
if (!isset($_SESSION['npsn'])) {
    header("Location: login.php");
    exit;
}

$npsn = $_SESSION['npsn'];

// Ambil data sekolah
$querySekolah = mysqli_query($conn, "SELECT * FROM sekolah WHERE NPSN='$npsn' LIMIT 1");
$dataSekolah = mysqli_fetch_assoc($querySekolah);

// Hitung jumlah siswa berdasarkan NPSN
$querySiswa = mysqli_query($conn, "SELECT COUNT(*) AS total FROM data_siswa WHERE NPSN='$npsn'");
$dataSiswa = mysqli_fetch_assoc($querySiswa);
$totalSiswa = $dataSiswa['total'];

// Ambil daftar siswa sesuai NPSN
$queryDaftarSiswa = mysqli_query($conn, "SELECT * FROM data_siswa WHERE NPSN='$npsn'");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard TU</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f4f6f9;
    }
    .main-content {
      margin-left: 250px; /* lebar sidebar */
      padding: 20px;
    }
    
    h2 {
      font-size: 22px;
      font-weight: bold;
      color: #184769;
    }
    
    .card {
      background: white;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      text-align: center;
      width: 250px;
      margin-bottom: 20px;
    }
    .card h3 {
      margin: 10px 0;
      font-size: 20px;
      color: #333;
    }
    .card p {
      font-size: 28px;
      font-weight: bold;
      color: #184769;
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <?php include 'includes/sidebar_tu.php'; ?>

  <!-- Main Content -->
  <div class="main-content">
        <div class="mb-3">
      <h2>Selamat Datang, <?= $dataSekolah['nama_sekolah']; ?> (NPSN: <?= $npsn; ?>)</h2>
    </div>

    <!-- Card jumlah siswa -->
    <div class="card">
      <i class="fa-solid fa-user-graduate fa-2x" style="color:#184769;"></i>
      <h3>Total Siswa</h3>
      <p><?= $totalSiswa; ?></p>
    </div>

    <!-- Tabel daftar siswa -->
    <div class="card" style="width:100%; text-align:left;">
      <h3>Daftar Siswa</h3>
      <div class="table-responsive">
        <table class="table table-bordered table-striped">
          <thead class="table-dark">
            <tr>
              <th>NISN</th>
              <th>NIK</th>
              <th>Nama Lengkap</th>
              <th>Jenis Kelamin</th>
              <th>Tempat, Tanggal Lahir</th>
              <th>Agama</th>
              <th>Alamat</th>
              <th>RT/RW</th>
              <th>Kelurahan</th>
              <th>Kecamatan</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = mysqli_fetch_assoc($queryDaftarSiswa)) { ?>
              <tr>
                <td><?= $row['NISN']; ?></td>
                <td><?= $row['NIK']; ?></td>
                <td><?= $row['nama_lengkap']; ?></td>
                <td><?= $row['jenis_kelamin']; ?></td>
                <td><?= $row['tempat_lahir'] . ", " . $row['tanggal_lahir']; ?></td>
                <td><?= $row['agama']; ?></td>
                <td><?= $row['alamat']; ?></td>
                <td><?= $row['RT'] . "/" . $row['RW']; ?></td>
                <td><?= $row['kelurahan']; ?></td>
                <td><?= $row['kecamatan']; ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>
