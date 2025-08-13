<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Siswa</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #E8E0D5; margin: 0; padding: 0;">

  <div style="width: 100%; max-width: 400px; margin: 80px auto; background-color: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
    <h2 style="text-align: center; color: #333;">Login Siswa</h2>
    
    <?php
    session_start();
    if (isset($_SESSION['error'])) {
        echo '<p style="color: red; text-align: center; margin-bottom: 15px;">' . $_SESSION['error'] . '</p>';
        unset($_SESSION['error']);
    }
    ?>

    <form action="proses_loginsiswa.php" method="POST">
      <input type="email" name="email" placeholder="Email" required style="width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px;">
      <input type="password" name="password" placeholder="Kata Sandi" required style="width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px;">
      <button type="submit" name="login" style="width: 100%; background-color: #715C41; color: white; border: none; padding: 12px; border-radius: 5px; font-weight: bold; cursor: pointer;">Masuk</button>
    </form>
    
    <p style="text-align: center; margin-top: 15px;">Belum punya akun? <a href="register_siswa.php">Daftar di sini</a></p>
  </div>

</body>
</html>
