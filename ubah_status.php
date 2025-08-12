<?php
// Koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_kemara"; // Ganti sesuai nama DB kamu

$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Jika form dikirim dengan method POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $no_peserta = $_POST['no_peserta'] ?? '';
    $status     = $_POST['status'] ?? '';
    $alasan     = $_POST['alasan'] ?? null;

    // Validasi data
    if (!$no_peserta || !in_array($status, ['Menunggu Verifikasi', 'Disetujui', 'Ditolak'])) {
        echo "<script>alert('Data tidak valid!'); window.location.href='management_akun.php';</script>";
        exit;
    }

    // Jika status ditolak, alasan wajib diisi
    if ($status === 'Ditolak' && (!$alasan || trim($alasan) === '')) {
        echo "<script>alert('Harap isi alasan penolakan terlebih dahulu.'); window.history.back();</script>";
        exit;
    }

    // Update data akun
    $stmt = $conn->prepare("UPDATE akun_siswa SET status_akun = ?, alasan = ? WHERE no_peserta = ?");
    $stmt->bind_param("sss", $status, $alasan, $no_peserta);
    $stmt->execute();
    $stmt->close();

    echo "<script>alert('Status berhasil diubah.'); window.location.href='management_akun.php';</script>";
    exit;
}
?>
  