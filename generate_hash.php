<?php
// password asli
$password = "meka123";

// bikin hash
$hash = password_hash($password, PASSWORD_DEFAULT);

// tampilkan hasil
echo "Password asli: $password <br>";
echo "Hash: $hash";
