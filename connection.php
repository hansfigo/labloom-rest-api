<?php
// Mendapatkan nilai dari environment variable "PROD"
$PROD = getenv("PROD");

// Jika "PROD" tidak ada di environment atau bernilai false, atur nilainya ke false
if ($PROD === false) {
    $PROD = false;
}else{
    $PROD = true;
}

if ($PROD) {
    // Informasi koneksi ke database produksi
    $host = "sql203.infinityfree.com"; // Ganti dengan host database produksi Anda
    $username = "if0_35306657"; // Ganti dengan username database produksi Anda
    $password = "lKwWGdaXQl"; // Ganti dengan password database produksi Anda
    $database = "if0_35306657_db_asisten"; // Ganti dengan nama database produksi Anda
} else {
    // Informasi koneksi ke database lokal
    $host = "localhost"; // Ganti dengan host database lokal Anda
    $username = "root"; // Ganti dengan username database lokal Anda
    $password = ""; // Ganti dengan password database lokal Anda
    $database = "db_asisten"; // Ganti dengan nama database lokal Anda
}

// Membuat koneksi ke database
$conn = new mysqli($host, $username, $password, $database);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
