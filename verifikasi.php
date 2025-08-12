<?php
include 'includes/sidebar.php';
include 'koneksi.php';

// Ambil NISN dari URL
$nisn = isset($_GET['nisn']) ? $_GET['nisn'] : null;
if (!$nisn) {
    die("NISN tidak ditemukan.");
}

// Ambil data siswa
$query_siswa = mysqli_query($conn, "SELECT * FROM data_siswa WHERE NISN='$nisn'");
$data_siswa = mysqli_fetch_assoc($query_siswa);

// Ambil nilai siswa
$query_nilai = mysqli_query($conn, "SELECT * FROM nilai_siswa WHERE NISN='$nisn'");

// Ambil berkas siswa
$query_berkas = mysqli_query($conn, "SELECT * FROM berkas_siswa WHERE NISN='$nisn'");
?>

<div style="margin-left:260px; padding:20px; font-family:Arial, sans-serif; background:#f8f9fa; min-height:100vh;">
    <h2 style="margin-bottom:20px; color:#184769;">📄 Detail Data Siswa</h2>

    <!-- Biodata Siswa -->
    <div style="background:white; padding:20px; border-radius:10px; box-shadow:0 2px 5px rgba(0,0,0,0.1); margin-bottom:30px;">
        <h3 style="margin-bottom:15px; border-bottom:2px solid #184769; padding-bottom:5px;">Biodata Lengkap</h3>
        <table style="width:100%; border-collapse:collapse;">
            <tr><th style="text-align:left; padding:8px;">NISN</th><td><?= $data_siswa['NISN'] ?></td></tr>
            <tr><th style="text-align:left; padding:8px;">Nama Lengkap</th><td><?= $data_siswa['nama_lengkap'] ?></td></tr>
            <tr><th style="text-align:left; padding:8px;">Jenis Kelamin</th><td><?= $data_siswa['jenis_kelamin'] ?></td></tr>
            <tr><th style="text-align:left; padding:8px;">Tempat/Tanggal Lahir</th><td><?= $data_siswa['tempat_lahir'] ?>, <?= date('d-m-Y', strtotime($data_siswa['tanggal_lahir'])) ?></td></tr>
            <tr><th style="text-align:left; padding:8px;">Agama</th><td><?= $data_siswa['agama'] ?></td></tr>
            <tr><th style="text-align:left; padding:8px;">Alamat</th>
                <td><?= $data_siswa['alamat'] ?> RT <?= $data_siswa['RT'] ?>/RW <?= $data_siswa['RW'] ?>, <?= $data_siswa['kelurahan'] ?>, <?= $data_siswa['kecamatan'] ?></td></tr>
        </table>
    </div>

    <!-- Nilai Siswa -->
    <div style="background:white; padding:20px; border-radius:10px; box-shadow:0 2px 5px rgba(0,0,0,0.1); margin-bottom:30px;">
        <h3 style="margin-bottom:15px; border-bottom:2px solid #184769; padding-bottom:5px;">Nilai Siswa</h3>
        <table style="width:100%; border-collapse:collapse; text-align:center;">
            <thead>
                <tr style="background:#184769; color:white;">
                    <th style="padding:8px;">Semester</th>
                    <th style="padding:8px;">B. Indonesia</th>
                    <th style="padding:8px;">B. Inggris</th>
                    <th style="padding:8px;">Matematika</th>
                    <th style="padding:8px;">IPA</th>
                    <th style="padding:8px;">IPS</th>
                    <th style="padding:8px;">PPKn</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($nilai = mysqli_fetch_assoc($query_nilai)) { ?>
                <tr style="border-bottom:1px solid #ddd;">
                    <td style="padding:8px;"><?= $nilai['semester'] ?></td>
                    <td style="padding:8px;"><?= $nilai['bahasa_indonesia'] ?></td>
                    <td style="padding:8px;"><?= $nilai['bahasa_inggris'] ?></td>
                    <td style="padding:8px;"><?= $nilai['matematika'] ?></td>
                    <td style="padding:8px;"><?= $nilai['IPA'] ?></td>
                    <td style="padding:8px;"><?= $nilai['IPS'] ?></td>
                    <td style="padding:8px;"><?= $nilai['PPKn'] ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Berkas Siswa -->
    <div style="background:white; padding:20px; border-radius:10px; box-shadow:0 2px 5px rgba(0,0,0,0.1);">
        <h3 style="margin-bottom:15px; border-bottom:2px solid #184769; padding-bottom:5px;">Berkas Upload</h3>
        <ul style="list-style:none; padding:0;">
            <?php while ($berkas = mysqli_fetch_assoc($query_berkas)) { ?>
                <li style="margin-bottom:10px; padding:8px; border:1px solid #ddd; border-radius:5px;">
                    <strong><?= $berkas['jenis_berkas'] ?>:</strong> 
                    <a href="<?= $berkas['path_file'] ?>" target="_blank" style="color:#184769; text-decoration:none;">📂 Lihat</a>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>
