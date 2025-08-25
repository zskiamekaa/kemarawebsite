<?php
session_start();
include 'koneksi.php'; // koneksi DB

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil input
    $npsn = trim(mysqli_real_escape_string($conn, $_POST['npsn']));
    $password = trim(mysqli_real_escape_string($conn, $_POST['password']));

    // Cari sekolah berdasarkan NPSN
    $query = "SELECT * FROM sekolah WHERE NPSN='$npsn' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);

        // Verifikasi password (plain text, sesuaikan dengan DB kamu)
        if ($password === $data['Password']) {
            // Simpan session (PAKAI huruf kecil biar konsisten)
            $_SESSION['npsn'] = $data['NPSN'];
            $_SESSION['nama_sekolah'] = $data['nama_sekolah'];

            header("Location: dashboard_tu.php");
            exit;
        } else {
            $_SESSION['error'] = "Password salah!";
        }
    } else {
        $_SESSION['error'] = "NPSN tidak ditemukan!";
    }

    header("Location: login.php");
    exit;
}
?>
