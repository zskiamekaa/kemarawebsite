<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
include 'koneksi.php';
session_start();

if (!isset($_SESSION['NISN'])) {
    header("Location: pengajuan_akun.php");
    exit();
}

function generateNoPeserta($conn) {
    do {
        $angka = str_pad(mt_rand(0, 99999999), 8, '0', STR_PAD_LEFT);
        $no_peserta = "KMRSCH-" . $angka;

        // Pastikan belum ada di database
        $cek = mysqli_query($conn, "SELECT * FROM Akun_Siswa WHERE no_peserta = '$no_peserta'");
    } while (mysqli_num_rows($cek) > 0);

    return $no_peserta;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nisn    = $_SESSION['NISN'];
    $email   = mysqli_real_escape_string($conn, $_POST['email']);
    $no_telp = mysqli_real_escape_string($conn, $_POST['no_telp']);

    // Cek apakah NISN sudah punya akun
    $cek = mysqli_query($conn, "SELECT * FROM Akun_Siswa WHERE NISN = '$nisn'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<h3>Akun untuk NISN ini sudah pernah diajukan.</h3>";
        echo "<a href='akun_siswa.php'>Kembali</a>";
        exit();
    }

    // Generate nomor peserta unik
    $no_peserta = generateNoPeserta($conn);

    // Simpan ke tabel Akun_Siswa
    $query = "INSERT INTO Akun_Siswa (NISN, email, no_telp, no_peserta, status_akun)
              VALUES ('$nisn', '$email', '$no_telp', '$no_peserta', 'Menunggu Verifikasi')";

    if (mysqli_query($conn, $query)) {
        session_destroy(); // Hapus session setelah selesai
        header("Location: dashboard_siswa.php");
        exit();
    } else {
        echo "Gagal menyimpan data: " . mysqli_error($conn);
    }
}
?>
<?php include 'includes/header_form_pendaftaran.php';?>

    <div class="form-title">
        <h1>Pengajuan Akun Siswa Baru T.A. 2026/2027</h1>
    </div>

    <section class="formulir">
        <div class="progress-container">
            <div class="progress-step active">1</div>
            <div class="progress-line"></div>
            <div class="progress-step active">2</div>
            <div class="progress-line"></div>
            <div class="progress-step active">3</div>
            <div class="progress-line"></div>
            <div class="progress-step">4</div>
        </div>
        <?php if (isset($_GET['berhasil'])): ?>
            <h3>Pengajuan akun berhasil!</h3>
        <?php else: ?>
        <form action="akun_siswa.php" method="POST">
        <h1>C. Daftarkan Akun</h1>
            <p>NISN: <strong><?= htmlspecialchars($_SESSION['NISN']); ?></strong></p><br><br>

            <label>Email:</label>
            <input type="email" name="email" required>

            <label>No. Telepon:</label>
            <input type="text" name="no_telp" required>

            <button type="submit" class="btn-daftar">Next</button>
        </form>
        <?php endif; ?>
