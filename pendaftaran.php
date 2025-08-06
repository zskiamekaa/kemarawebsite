<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profile - Kemara Schools</title>
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time(); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<?php include 'includes/header.php'; ?>

<section class="pendaftaran-hero" style="background-image: url('assets/img/pendaftaran.png');">
  <div class="pendaftaran-overlay">
    <div class="pendaftaran-content">
      <h1>Shaping Tomorrow’s Leaders, 
Starting with Your First Step Today</h1>
      <p>Mewujudkan Generasi Siap Teknologi</p>
      <a href="#programs" class="cta-button">View our programs →</a>
    </div>
  </div>
</section>

<section class="datasiswa-section">
  <div class="datasiswa-container">
    <h2>Statistik Berdasarkan Umur dan Nilai Siswa<br>T.A. 2026/2027</h2>
    <div class="datasiswa-box">
      <table class="datasiswa-table">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Siswa</th>
            <th>Umur</th>
            <th>Nilai Rata-rata</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Koneksi ke database
          $conn = mysqli_connect("localhost", "root", "", "db_kemara"); // Ganti dengan DB Anda

          if (!$conn) {
              die("Koneksi gagal: " . mysqli_connect_error());
          }

          // Query dengan perhitungan umur & nilai rata-rata langsung di SQL, lalu urutkan
          $sql = "
            SELECT 
              ds.nama_lengkap, 
              ds.tanggal_lahir,
              FLOOR(DATEDIFF(CURDATE(), ds.tanggal_lahir)/365) AS umur,
              ROUND((
                ns.bahasa_indonesia + ns.bahasa_inggris + ns.matematika + 
                ns.IPA + ns.IPS + ns.PPKn
              ) / 6, 2) AS nilai_rata2
            FROM data_siswa ds
            JOIN nilai_siswa ns ON ds.NISN = ns.NISN
            ORDER BY umur DESC, nilai_rata2 DESC
          ";

          $result = mysqli_query($conn, $sql);
          if (!$result) {
              die("Query error: " . mysqli_error($conn));
          }

          $no = 1;
          while ($row = mysqli_fetch_assoc($result)) {
              $nama = $row['nama_lengkap'];
              $umur = $row['umur'];
              $nilai_rata2 = $row['nilai_rata2'];

              echo "<tr>
                      <td>$no</td>
                      <td>$nama</td>
                      <td>{$umur} tahun</td>
                      <td>{$nilai_rata2}</td>
                    </tr>";
              $no++;
          }

          mysqli_close($conn);
          ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

</body>
</html>
