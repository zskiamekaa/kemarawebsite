<?php
session_start();
include 'koneksi.php';

// Cek login
if (!isset($_SESSION['npsn'])) {
    header("Location: login.php");
    exit;
}

$npsn = $_SESSION['npsn'];

// Data sekolah
$querySekolah = mysqli_query($conn, "SELECT * FROM sekolah WHERE NPSN='$npsn' LIMIT 1");
$dataSekolah = mysqli_fetch_assoc($querySekolah);

// Daftar siswa
$queryDaftarSiswa = mysqli_query($conn, "SELECT * FROM data_siswa WHERE NPSN='$npsn'");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Data Siswa</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <style>
    body {
      background: #f4f6f9;
    }
    .main-content {
      margin-left: 250px; /* kasih jarak sesuai lebar sidebar */
      padding: 20px;
      min-height: 100vh;
      background: #f4f6f9;
    }
    h2 {
      font-size: 22px;
      font-weight: bold;
      color: #184769;
    }
    .table th, .table td {
      vertical-align: middle;
    }
  </style>
</head>

<body>
  <?php include 'includes/sidebar_tu.php'; ?>

  <div class="main-content p-4">
    <div class="mb-3">
      <h2>Selamat Datang, <?= $dataSekolah['nama_sekolah']; ?> (NPSN: <?= $npsn; ?>)</h2>
    </div>

    <!-- Tombol Tambah -->
    <a href="tambah_siswa.php" class="btn btn-primary mb-3">+ Tambah Siswa</a>

    <!-- Tabel -->
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
            <th>Aksi</th>
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
              <td>
                <a href="edit_siswa.php?nisn=<?= $row['NISN']; ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="hapus_siswa.php?nisn=<?= $row['NISN']; ?>" 
                   onclick="return confirm('Yakin hapus data ini?')" 
                   class="btn btn-danger btn-sm">Hapus</a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
