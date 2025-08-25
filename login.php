<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login Sekolah</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f4f4;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .login-box {
      background: white;
      padding: 30px;
      border-radius: 10px;
      width: 350px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    .login-box h2 {
      text-align: center;
      margin-bottom: 20px;
    }
    .login-box input {
      width: 100%;
      padding: 10px;
      margin: 8px 0;
      border: 1px solid #ddd;
      border-radius: 6px;
    }
    .login-box button {
      width: 100%;
      padding: 10px;
      background: #184769;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }
    .login-box button:hover {
      background: #0d2c48;
    }
    .error {
      color: red;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="login-box">
    <h2>Login Sekolah</h2>
    <?php if(isset($_SESSION['error'])): ?>
      <p class="error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
    <?php endif; ?>
    <form action="cek_login.php" method="post">
      <input type="text" name="npsn" placeholder="Masukkan NPSN" required>
      <input type="password" name="password" placeholder="Masukkan Password" required>
      <button type="submit">Login</button>
    </form>
  </div>
</body>
</html>
