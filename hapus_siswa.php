<?php
session_start();
include 'koneksi.php';

// Cek login
if (!isset($_SESSION['npsn'])) {
    header("Location: login.php");
    exit;
}

$npsn = $_SESSION['npsn'];
$nisn = $_GET['nisn'] ?? '';

if (!$nisn) {
    echo "NISN tidak valid!";
    exit;
}

// Hapus data berdasarkan NISN + NPSN
$hapus = mysqli_query($conn, "DELETE FROM data_siswa WHERE NISN='$nisn' AND NPSN='$npsn'");

if ($hapus) {
    echo "<script>alert('Data siswa berhasil dihapus!'); window.location='keloladata_tu.php';</script>";
} else {
    echo "Gagal menghapus data: " . mysqli_error($conn);
}
?>
