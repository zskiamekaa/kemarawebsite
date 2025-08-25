<?php
session_start();
include 'koneksi.php'; // koneksi ke database

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // cek data admin di tabel admin
    $query = "SELECT * FROM admin WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        // verifikasi password (harus hash di database)
        if (password_verify($password, $row['password'])) {
            // simpan session admin
            $_SESSION['id_admin'] = $row['id_admin'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['nama_lengkap'] = $row['nama_lengkap'];

            // arahkan ke dashboard admin
            header("Location: dashboard_admin.php");
            exit;
        } else {
            $error = "❌ Password salah!";
        }
    } else {
        $error = "❌ Email tidak ditemukan!";
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login Siswa</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      background-color: #E8E0D5;
      color: #184769;
    }
    .panel-kiri {
      background-color: #DBBAA7;
    }
    .btn-utama {
      background-color: #DF7924;
    }
    .btn-utama:hover {
      background-color: #c4661e;
    }
    .teks-utama {
      color: #184769;
    }
  </style>
</head>
<body class="min-h-screen flex items-center justify-center">

  <div class="w-full max-w-5xl flex bg-white rounded-2xl shadow-lg overflow-hidden">
    
    <!-- Bagian Kiri (gambar ilustrasi) -->
    <div class="hidden md:flex w-1/2 panel-kiri items-center justify-center p-10">
      <img src="assets/img/loginadmin.png" alt="Ilustrasi" class="w-80">
    </div>

    <!-- Bagian Kanan (form login) -->
    <div class="w-full md:w-1/2 p-10 flex flex-col justify-center">
      
      <h2 class="text-3xl font-bold text-center teks-utama mb-6">Selamat Datang Admin</h2>

      <?php if ($error != ""): ?>
        <div class="bg-red-100 text-red-600 px-4 py-2 rounded mb-4 text-center">
          <?= $error ?>
        </div>
      <?php endif; ?>

      <form method="POST" action="" class="space-y-4">

        <div>
          <input type="email" name="email" placeholder="Email"
            class="w-full px-4 py-3 rounded-lg bg-gray-100 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#DF7924]" required>
        </div>

        <div>
          <input type="password" name="password" placeholder="Password"
            class="w-full px-4 py-3 rounded-lg bg-gray-100 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#DF7924]" required>
        </div>


        <button type="submit"
          class="w-full py-3 btn-utama text-white font-semibold rounded-lg shadow transition">
          Log In
        </button>
      </form>
    </div>
  </div>
</body>
</html>
