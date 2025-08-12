<?php
session_start();
include 'koneksi.php'; // Pastikan koneksi tersambung dan variabel $koneksi tersedia

if (isset($_POST['login'])) {
    // Ambil input dan cegah SQL Injection
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    // Ambil data siswa + nama dari join dengan data_siswa
    $query = "
        SELECT akun_siswa.*, data_siswa.nama_lengkap 
        FROM akun_siswa 
        JOIN data_siswa ON akun_siswa.NISN = data_siswa.NISN 
        WHERE akun_siswa.email = '$email'
    ";

    $result = mysqli_query($koneksi, $query);

    if (!$result) {
        $_SESSION['error'] = "Gagal menjalankan query: " . mysqli_error($koneksi);
        header("Location: loginsiswa.php");
        exit();
    }

    // Jika akun ditemukan
    if (mysqli_num_rows($result) === 1) {
        $data = mysqli_fetch_assoc($result);

        // Cek kecocokan password
        if ($data['password'] === $password) { // Gunakan password_verify() jika password di-hash
            // Cek status akun
            if ($data['status_akun'] === 'Disetujui') {
                // Simpan informasi penting ke session
                $_SESSION['email'] = $data['email'];
                $_SESSION['no_peserta'] = $data['no_peserta'];
                $_SESSION['nama_lengkap'] = $data['nama_lengkap']; // ✅ ini penting agar bisa dipakai di dashboard

                header("Location: dashboardsiswa.php");
                exit();
            } else {
                $_SESSION['error'] = "Akun Anda belum disetujui.";
                header("Location: loginsiswa.php");
                exit();
            }
        } else {
            $_SESSION['error'] = "Kata sandi salah.";
            header("Location: loginsiswa.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Email tidak ditemukan.";
        header("Location: loginsiswa.php");
        exit();
    }
} else {
    header("Location: loginsiswa.php");
    exit();
}
