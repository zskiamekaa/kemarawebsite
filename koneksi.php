<?php
$host = "localhost";        
$user = "root";             
$password = "";             
$database = "spmb"; 


$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
