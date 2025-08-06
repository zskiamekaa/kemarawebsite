<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "db_kemara"; 

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}


$sql_total = "SELECT COUNT(*) AS total FROM data_siswa";
$result_total = $conn->query($sql_total);
$row_total = $result_total->fetch_assoc();
$total = $row_total['total'];


$sql_lk = "SELECT COUNT(*) AS laki FROM data_siswa WHERE jenis_kelamin = 'Laki-laki'";
$result_lk = $conn->query($sql_lk);
$row_lk = $result_lk->fetch_assoc();
$laki = $row_lk['laki'];


$sql_pr = "SELECT COUNT(*) AS perempuan FROM data_siswa WHERE jenis_kelamin = 'Perempuan'";
$result_pr = $conn->query($sql_pr);
$row_pr = $result_pr->fetch_assoc();
$perempuan = $row_pr['perempuan'];

echo "<p>Total siswa diterima: <strong>$total</strong></p>";
echo "<p>Laki-laki: <strong>$laki</strong></p>";
echo "<p>Perempuan: <strong>$perempuan</strong></p>";

$conn->close();
?>
