<?php
// Controller untuk halaman Kelola Aset
// Logika CRUD aset akan diproses di sini

// Buat table aset jika belum ada
mysqli_query($koneksi, "CREATE TABLE IF NOT EXISTS aset (
    id_aset INT AUTO_INCREMENT PRIMARY KEY,
    kode_aset VARCHAR(50),
    nama_aset VARCHAR(255),
    kategori VARCHAR(100),
    lokasi VARCHAR(255),
    kondisi VARCHAR(50),
    tgl_perolehan DATE,
    harga DECIMAL(15,2),
    foto VARCHAR(255),
    keterangan TEXT
)");
?>
