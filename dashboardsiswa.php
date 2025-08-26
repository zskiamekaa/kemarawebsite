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
$tanggal_daftar = date("d F Y"); 

$stmt->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Siswa</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#E8E0D5] font-sans text-gray-800">

  <!-- Topbar -->
  <div class="flex justify-between items-center bg-[#E8E0D5] px-6 py-4 shadow-md border-b border-[#184769] sticky top-0 z-50">
    <!-- Logo kiri -->
    <div class="flex items-center space-x-3">
      <img src="assets/img/logo_kemara.png" alt="Logo SMP Bina Informatika" class="h-12 w-auto object-contain">
    </div>

    <!-- Menu kanan -->
    <div>
      <a href="logout.php" class="px-4 py-2 rounded-md bg-[#DF7924] text-white font-semibold hover:bg-[#c9651d] transition">
        Logout
      </a>
    </div>
  </div>

  <!-- Welcome -->
  <div class="max-w-5xl mx-auto mt-10 px-4">
    <div class="text-center mb-8">
      <h2 class="text-2xl font-bold text-[#184769]">Selamat Datang, <?= htmlspecialchars($nama) ?>!</h2>
      <p class="text-gray-700">Dashboard Siswa Kemara School</p>
    </div>
  </div>

  <!-- Info Cards -->
  <div class="max-w-4xl mx-auto px-4">
    <div class="grid md:grid-cols-2 gap-6">
      
      <div class="bg-white shadow rounded-xl p-6 text-center">
        <p class="text-gray-600">NAMA LENGKAP</p>
        <h3 class="text-xl font-semibold text-[#184769] mt-1"><?= htmlspecialchars($nama) ?></h3>
      </div>
      
      <div class="bg-white shadow rounded-xl p-6 text-center">
        <p class="text-gray-600">USERNAME</p>
        <h3 class="text-xl font-semibold text-[#184769] mt-1"><?= htmlspecialchars($username) ?></h3>
      </div>
      
      <div class="bg-white shadow rounded-xl p-6 text-center">
        <p class="text-gray-600">STATUS PENDAFTARAN</p>
        <span class="inline-block mt-2 px-4 py-1 rounded-full text-white bg-green-500 text-sm font-bold">
          <?= htmlspecialchars($status_daftar) ?>
        </span>
      </div>
      
      <div class="bg-white shadow rounded-xl p-6 text-center">
        <p class="text-gray-600">TANGGAL PENDAFTARAN</p>
        <h3 class="text-xl font-semibold text-[#184769] mt-1"><?= $tanggal_daftar ?></h3>
      </div>
    
    </div>
  </div>

  <!-- Informasi Penting -->
  <div class="max-w-5xl mx-auto mt-10 px-4">
    <div class="bg-white shadow rounded-xl p-6">
      <h5 class="font-semibold text-[#184769] mb-3">ℹ️ Informasi Penting</h5>
      <div class="bg-yellow-100 border-l-4 border-yellow-400 text-yellow-700 p-4 rounded">
        <p><strong>Pendaftaran Anda berhasil disimpan.</strong></p>
        <p>Silakan menunggu informasi lebih lanjut dari admin sekolah.</p>
      </div>
    </div>
  </div>

</body>
</html>
