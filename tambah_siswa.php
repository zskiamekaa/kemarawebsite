<?php
session_start();
include 'koneksi.php';

// Cek login
if (!isset($_SESSION['npsn'])) {
    header("Location: login.php");
    exit;
}

$npsn = $_SESSION['npsn'];

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nisn           = $_POST['nisn'];
    $nama_lengkap   = $_POST['nama_lengkap'];
    $nik            = $_POST['nik'];
    $jenis_kelamin  = $_POST['jenis_kelamin'];
    $tempat_lahir   = $_POST['tempat_lahir'];
    $tanggal_lahir  = $_POST['tanggal_lahir'];
    $agama          = $_POST['agama'];
    $alamat         = $_POST['alamat'];
    $rt             = $_POST['rt'];
    $rw             = $_POST['rw'];
    $kelurahan      = $_POST['kelurahan'];
    $kecamatan      = $_POST['kecamatan'];

    $insert = mysqli_query($conn, "INSERT INTO data_siswa 
        (NISN, NIK, nama_lengkap, jenis_kelamin, tempat_lahir, tanggal_lahir, agama, alamat, RT, RW, kelurahan, kecamatan, NPSN)
        VALUES
        ('$nisn', '$nik', '$nama_lengkap', '$jenis_kelamin', '$tempat_lahir', '$tanggal_lahir', '$agama', '$alamat', '$rt', '$rw', '$kelurahan', '$kecamatan', '$npsn')
    ");

    if ($insert) {
        echo "<script>alert('Data siswa berhasil ditambahkan!'); window.location='keloladata_tu.php';</script>";
    } else {
        echo "Gagal tambah: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Siswa</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <style>
    body { background: #f4f6f9; }
    .main-content { margin-left: 250px; padding: 20px; }
    .card { border-radius: 12px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
  </style>
</head>
<body>
  <?php include 'includes/sidebar_tu.php'; ?>

  <div class="main-content">
    <div class="card p-4">
      <h3>Tambah Data Siswa</h3>
      <form method="POST">
        <div class="mb-3">
          <label class="form-label">NISN</label>
          <input type="text" name="nisn" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">NIK</label>
          <input type="text" name="nik" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Nama Lengkap</label>
          <input type="text" name="nama_lengkap" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Jenis Kelamin</label>
          <select name="jenis_kelamin" class="form-control" required>
            <option value="">-- Pilih --</option>
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Tempat Lahir</label>
          <input type="text" name="tempat_lahir" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Tanggal Lahir</label>
          <input type="date" name="tanggal_lahir" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Agama</label>
          <input type="text" name="agama" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Alamat</label>
          <textarea name="alamat" class="form-control" rows="2" required></textarea>
        </div>
        <div class="row">
          <div class="col-md-4 mb-3">
            <label class="form-label">RT</label>
            <input type="text" name="rt" class="form-control" required>
          </div>
          <div class="col-md-4 mb-3">
            <label class="form-label">RW</label>
            <input type="text" name="rw" class="form-control" required>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Kelurahan</label>
          <input type="text" name="kelurahan" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Kecamatan</label>
          <input type="text" name="kecamatan" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="keloladata_tu.php" class="btn btn-secondary">Kembali</a>
      </form>
    </div>
  </div>
</body>
</html>
