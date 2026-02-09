<?php
// Pengaturan Database
$host     = "localhost";
$user     = "root";
$password = "";
$database = "db_asset"; // Ganti dengan nama database kamu

// Mengaktifkan pelaporan error untuk mysqli (sangat berguna saat debugging)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $koneksi = mysqli_connect($host, $user, $password, $database);
    
    // Set charset ke utf8 agar karakter khusus terbaca dengan benar
    mysqli_set_charset($koneksi, "utf8mb4");

} catch (mysqli_sql_exception $e) {
    // Jika koneksi gagal, tampilkan pesan error yang rapi
    die("Gagal terhubung ke database: " . $e->getMessage());
}
?>