<?php
session_start();
include 'koneksi.php';

// Cek login
if (!isset($_SESSION['npsn'])) {
    header("Location: login.php");
    exit;
}

$npsn = $_SESSION['npsn'];

// Ambil daftar siswa berdasarkan sekolah
$querySiswa = mysqli_query($conn, "SELECT NISN, nama_lengkap FROM data_siswa WHERE NPSN='$npsn' ORDER BY nama_lengkap ASC");

// Proses simpan data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nisn = $_POST['nisn'];

    // Loop dari semester 1-5
    for ($i = 1; $i <= 5; $i++) {
        $bindo = $_POST['bahasa_indonesia'][$i];
        $bing  = $_POST['bahasa_inggris'][$i];
        $mtk   = $_POST['matematika'][$i];
        $ipa   = $_POST['ipa'][$i];
        $ips   = $_POST['ips'][$i];
        $ppkn  = $_POST['ppkn'][$i];

        // Cek kalau ada input nilainya
        if ($bindo !== '' && $bing !== '' && $mtk !== '' && $ipa !== '' && $ips !== '' && $ppkn !== '') {
            mysqli_query($conn, "INSERT INTO nilai_siswa 
                (NISN, semester, bahasa_indonesia, bahasa_inggris, matematika, IPA, IPS, PPKn) 
                VALUES 
                ('$nisn','$i','$bindo','$bing','$mtk','$ipa','$ips','$ppkn')
            ");
        }
    }

    echo "<script>alert('Data nilai berhasil ditambahkan untuk semua semester!'); window.location='input_nilai.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Nilai Siswa</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <style>
    body {
      margin: 0;
      background: #f4f6f9;
      font-family: Arial, sans-serif;
    }
    .main-content {
      margin-left: 250px;
      padding: 20px;
    }
    .card {
      border-radius: 12px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .semester-card {
      border: 1px solid #ddd;
      padding: 15px;
      margin-bottom: 15px;
      border-radius: 8px;
      background: #fff;
    }
  </style>
</head>
<body>
<?php include 'includes/sidebar_tu.php'; ?>
<div class="main-content">
  <div class="card p-4">
    <h3 class="mb-3">Tambah Nilai Siswa</h3>
    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Nama Siswa</label>
        <select name="nisn" class="form-select" required>
          <option value="">-- Pilih Siswa --</option>
          <?php while($s = mysqli_fetch_assoc($querySiswa)) { ?>
            <option value="<?= $s['NISN']; ?>"><?= $s['nama_lengkap']; ?> (<?= $s['NISN']; ?>)</option>
          <?php } ?>
        </select>
      </div>

      <?php for ($i=1; $i<=5; $i++) { ?>
      <div class="semester-card">
        <h5>Semester <?= $i ?></h5>
        <div class="row">
          <div class="col-md-4 mb-3">
            <label>Bahasa Indonesia</label>
            <input type="number" name="bahasa_indonesia[<?= $i ?>]" class="form-control">
          </div>
          <div class="col-md-4 mb-3">
            <label>Bahasa Inggris</label>
            <input type="number" name="bahasa_inggris[<?= $i ?>]" class="form-control">
          </div>
          <div class="col-md-4 mb-3">
            <label>Matematika</label>
            <input type="number" name="matematika[<?= $i ?>]" class="form-control">
          </div>
          <div class="col-md-4 mb-3">
            <label>IPA</label>
            <input type="number" name="ipa[<?= $i ?>]" class="form-control">
          </div>
          <div class="col-md-4 mb-3">
            <label>IPS</label>
            <input type="number" name="ips[<?= $i ?>]" class="form-control">
          </div>
          <div class="col-md-4 mb-3">
            <label>PPKn</label>
            <input type="number" name="ppkn[<?= $i ?>]" class="form-control">
          </div>
        </div>
      </div>
      <?php } ?>

      <button type="submit" class="btn btn-primary">Simpan Semua Nilai</button>
    </form>
  </div>
</div>
</body>
</html>
