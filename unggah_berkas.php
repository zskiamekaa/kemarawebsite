<?php include 'includes/header_form_pendaftaran.php';?>
<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['NISN'])) {
    header("Location: pengajuan_akun.php");
    exit();
}

if (isset($_POST["submit"]) && isset($_FILES['files'])) {
    $allowedTypes = ['jpg', 'jpeg', 'png', 'pdf'];
    $maxSize = 500000; // 500 KB
    $uploadDir = "uploads/";

    foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
        $fileName = basename($_FILES['files']['name'][$key]);
        $targetFile = $uploadDir . $fileName;
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $fileSize = $_FILES['files']['size'][$key];
        $fileTmp = $_FILES['files']['tmp_name'][$key];

        // Validasi ukuran file
        if ($fileSize > $maxSize) {
            echo "File {$fileName} terlalu besar.<br>";
            continue;
        }

        // Validasi tipe file
        if (!in_array($fileType, $allowedTypes)) {
            echo "File {$fileName} memiliki tipe yang tidak diizinkan.<br>";
            continue;
        }

        // Upload file
        if (move_uploaded_file($fileTmp, $targetFile)) {
            header("Location: akun_siswa.php");
        } else {
            echo "<p class='upload-error'>Gagal mengunggah file {$fileName}.</p>";
            exit;
        }

    }
}
?>
    <div class="form-title">
        <h1>Pengajuan Akun Siswa Baru T.A. 2026/2027</h1>
    </div>

    <section class="formulir">
        <div class="progress-container">
            <div class="progress-step active">1</div>
            <div class="progress-line"></div>
            <div class="progress-step active">2</div>
            <div class="progress-line"></div>
            <div class="progress-step">3</div>
            <div class="progress-line"></div>
            <div class="progress-step">4</div>
        </div>
        <h1>B. Unggah Dokumen</h1>

        <form action="unggah_berkas.php" method="POST" enctype="multipart/form-data">
            <label for="ijazah">Ijazah/SKL:</label>
            <input type="file" name="files[]" id="ijazah" required><br>

            <label for="kk">Kartu Keluarga:</label>
            <input type="file" name="files[]" id="kk" required><br>

            <label for="akta">Akta Kelahiran:</label>
            <input type="file" name="files[]" id="akta" required><br>

            <label for="rapor1">Rapor Semester 1:</label>
            <input type="file" name="files[]" id="rapor1" required><br>

            <label for="rapor2">Rapor Semester 2:</label>
            <input type="file" name="files[]" id="rapor2" required><br>

            <label for="rapor3">Rapor Semester 3:</label>
            <input type="file" name="files[]" id="rapor3" required><br>

            <label for="rapor4">Rapor Semester 4:</label>
            <input type="file" name="files[]" id="rapor4" required><br>

            <label for="rapor5">Rapor Semester 5:</label>
            <input type="file" name="files[]" id="rapor5" required><br>

            <button type="submit" name="submit" class="btn-daftar">Next</button>
        </form>
        

