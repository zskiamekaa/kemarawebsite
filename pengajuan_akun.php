<?php include 'includes/header_form_pendaftaran.php';?>
<?php
include 'koneksi.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama           = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $nisn           = mysqli_real_escape_string($conn, $_POST['NISN']);
    $npsn           = mysqli_real_escape_string($conn, $_POST['NPSN']);
    $nik            = mysqli_real_escape_string($conn, $_POST['NIK']);
    $jenis_kelamin  = mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);
    $tempat_lahir   = mysqli_real_escape_string($conn, $_POST['tempat_lahir']);
    $tanggal_lahir  = mysqli_real_escape_string($conn, $_POST['tanggal_lahir']);
    $agama          = mysqli_real_escape_string($conn, $_POST['agama']);
    $alamat         = mysqli_real_escape_string($conn, $_POST['alamat']);
    $rt             = mysqli_real_escape_string($conn, $_POST['RT']);
    $rw             = mysqli_real_escape_string($conn, $_POST['RW']);
    $kelurahan      = mysqli_real_escape_string($conn, $_POST['kelurahan']);
    $kecamatan      = mysqli_real_escape_string($conn, $_POST['kecamatan']);

    $query = "
            SELECT * FROM Data_Siswa
            WHERE 
                nama_lengkap = '$nama' AND
                NISN = '$nisn' AND
                NPSN = '$npsn' AND
                NIK = '$nik' AND
                jenis_kelamin = '$jenis_kelamin' AND
                tempat_lahir = '$tempat_lahir' AND
                tanggal_lahir = '$tanggal_lahir' AND
                agama = '$agama' AND
                alamat = '$alamat' AND
                RT = '$rt' AND
                RW = '$rw' AND
                kelurahan = '$kelurahan' AND
                kecamatan = '$kecamatan'
            ";    
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // Data cocok, simpan ke session untuk dipakai di halaman unggah berkas
        $_SESSION['NISN'] = $nisn;
        $_SESSION['nama_lengkap'] = $nama;

        header("Location: unggah_berkas.php");
        exit();
    } else {
        echo "<h3>Data tidak ditemukan. Silakan periksa kembali keseluruhan data Anda.</h3>";
        echo "<a href='pengajuan_akun.php'>Kembali</a>";
    }
} else {
    echo "";
}
?>
    <div class="form-title">
        <h1>Pengajuan Akun Siswa Baru T.A. 2026/2027</h1>
    </div>

    <section class="formulir">
        <div class="progress-container">
            <div class="progress-step active">1</div>
            <div class="progress-line"></div>
            <div class="progress-step">2</div>
            <div class="progress-line"></div>
            <div class="progress-step">3</div>
            <div class="progress-line"></div>
            <div class="progress-step">4</div>
        </div>
        <form action="pengajuan_akun.php" method="POST">
            <h1>A. Data Peserta</h1>

            <label>Nama Lengkap:</label>
            <input type="text" name="nama_lengkap" required>

            <label>NISN:</label>
            <input type="number" name="NISN" required>

            <label>NPSN:</label>
            <input type="number" name="NPSN" required>

            <label>NIK:</label>
            <input type="number" name="NIK" required>

            <label>Jenis Kelamin:</label>
            <div class="radio-group">
                <label><input type="radio" name="jenis_kelamin" value="Laki-laki" required> Laki-laki</label>
                <label><input type="radio" name="jenis_kelamin" value="Perempuan"> Perempuan</label>
            </div>

            <!-- Tempat & Tanggal Lahir -->
            <div class="form-row">
                <div class="form-col">
                    <label>Tempat Lahir:</label>
                    <input type="text" name="tempat_lahir" required>
                </div>
                <div class="form-col">
                    <label>Tanggal Lahir:</label>
                    <input type="date" name="tanggal_lahir" required>
                </div>
            </div>

            <label for="agama">Agama:</label>
            <select name="agama" id="agama" required>
                <option value="Islam">Islam</option>
                <option value="Kristen">Kristen</option>
                <option value="Katolik">Katolik</option>
                <option value="Hindu">Hindu</option>
                <option value="Buddha">Buddha</option>
                <option value="Konghucu">Konghucu</option>
                <option value="Kepercayaan terhadap Tuhan YME">Kepercayaan terhadap Tuhan YME</option>
            </select>

            <label>Alamat:</label>
            <textarea name="alamat" rows="3" required></textarea>

            <div class="form-row">
                <div class="form-col">
                    <label>RT:</label>
                    <input type="number" name="RT" required>
                </div>
                <div class="form-col">
                    <label>RW:</label>
                    <input type="number" name="RW" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-col">
                    <label>Kelurahan:</label>
                    <input type="text" name="kelurahan" required>
                </div>
                <div class="form-col">
                    <label>Kecamatan:</label>
                    <input type="text" name="kecamatan" required>
                </div>
            </div>

            <button type="submit" class="btn-daftar">Next</button>
        </form>
    </section>