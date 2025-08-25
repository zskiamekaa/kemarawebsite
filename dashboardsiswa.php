<?php
session_start();
require 'koneksi.php';

// Pastikan user sudah login
if (!isset($_SESSION['email'])) {
    header("Location: loginsiswa.php");
    exit();
}

$email = $_SESSION['email'];

// Ambil data siswa berdasarkan email login
$sql = "SELECT ds.nama_lengkap, ds.NISN, ak.no_peserta, ak.email, ak.status_akun, ak.alasan
        FROM akun_siswa ak
        JOIN data_siswa ds ON ak.NISN = ds.NISN
        WHERE ak.email = ?";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$siswa = $result->fetch_assoc();

if (!$siswa) {
    die("Data siswa tidak ditemukan!");
}

// Variabel untuk tampilan
$nama          = $siswa['nama_lengkap'];
$username      = explode('@', $siswa['email'])[0]; 
$status_daftar = $siswa['status_akun'];
$status_bayar  = "Menunggu Konfirmasi"; 
$tanggal_daftar = date("d F Y"); 
$last_login    = $_SESSION['last_login'] ?? "Belum pernah login";

$stmt->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Siswa</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

  <div class="topbar">
  <!-- Logo kiri -->
  <div class="logo">
    <img src="assets/img/logo_kemara.png" alt="Logo SMP Bina Informatika">
  </div>

  <!-- Menu kanan -->
  <div class="nav-links">
    <a href="logout.php">Logout</a>
  </div>
</div>


  <div class="container">
    <div class="welcome">
      <h2>Selamat Datang, <?= htmlspecialchars($nama) ?>!</h2>
      <p>Dashboard Siswa Kemara School</p>
    </div>
  </div>

  <div class="container">
    <div class="grid">
      <div class="info-card">NAMA LENGKAP <br><strong><?= htmlspecialchars($nama) ?></strong></div>
      <div class="info-card">USERNAME <br><strong><?= htmlspecialchars($username) ?></strong></div>
      <div class="info-card">STATUS PENDAFTARAN <br>
        <span class="badge-status bg-green"><?= htmlspecialchars($status_daftar) ?></span>
      </div>
      <div class="info-card">STATUS PEMBAYARAN <br>
        <span class="badge-status bg-yellow"><?= htmlspecialchars($status_bayar) ?></span>
      </div>
      <div class="info-card">TANGGAL PENDAFTARAN <br><strong><?= $tanggal_daftar ?></strong></div>
      <div class="info-card">TERAKHIR LOGIN <br><strong><?= $last_login ?></strong></div>
    </div>
  </div>

  <div class="container">
    <div class="info-card">
      <h5><strong>ℹ️ Informasi Penting</strong></h5>
      <div class="alert">
        <strong>Bukti pembayaran telah diupload.</strong><br>
        Tim admin akan memverifikasi bukti pembayaran Anda dalam waktu 1-3 hari kerja. Status akan diperbarui setelah verifikasi selesai.
      </div>
    </div>
  </div>
 
</body>
</html>