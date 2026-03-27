<?php
// Controller untuk halaman Serah Terima Aset
// Memproses logika CRUD serah terima

// Buat table jika belum ada
mysqli_query($koneksi, "CREATE TABLE IF NOT EXISTS serah_terima (
    id_serte INT AUTO_INCREMENT PRIMARY KEY,
    id_aset INT,
    penerima VARCHAR(255),
    penyetuju VARCHAR(255),
    tgl_serte DATE,
    keterangan TEXT
)");

// --- LOGIKA HAPUS ---
if (isset($_GET['hapus'])) {
    $id_serte = mysqli_real_escape_string($koneksi, $_GET['hapus']);
    
    $query = mysqli_query($koneksi, "DELETE FROM serah_terima WHERE id_serte = '$id_serte'");
    if($query) echo "<script>alert('Data Serah Terima dihapus!'); window.location='?pg=" . ($_GET['pg'] ?? '') . "&fl=" . ($_GET['fl'] ?? '') . "';</script>";
}

// --- LOGIKA TAMBAH ---
if (isset($_POST['tambah_serte'])) {
    $id_aset = mysqli_real_escape_string($koneksi, $_POST['id_aset']);
    $penerima = mysqli_real_escape_string($koneksi, $_POST['penerima']);
    $penyetuju = mysqli_real_escape_string($koneksi, $_POST['penyetuju']);
    $tgl_serte = mysqli_real_escape_string($koneksi, $_POST['tgl_serte']);
    $keterangan = mysqli_real_escape_string($koneksi, $_POST['keterangan']);

    $query = mysqli_query($koneksi, "INSERT INTO serah_terima (id_aset, penerima, penyetuju, tgl_serte, keterangan) VALUES ('$id_aset', '$penerima', '$penyetuju', '$tgl_serte', '$keterangan')");
    echo "<script>alert('Data Serah Terima ditambahkan!'); window.location='?pg=" . ($_GET['pg'] ?? '') . "&fl=" . ($_GET['fl'] ?? '') . "';</script>";
}

// --- LOGIKA UPDATE ---
if (isset($_POST['update_serte'])) {
    $id_serte = mysqli_real_escape_string($koneksi, $_POST['id_serte']);
    $id_aset = mysqli_real_escape_string($koneksi, $_POST['id_aset']);
    $penerima = mysqli_real_escape_string($koneksi, $_POST['penerima']);
    $penyetuju = mysqli_real_escape_string($koneksi, $_POST['penyetuju']);
    $tgl_serte = mysqli_real_escape_string($koneksi, $_POST['tgl_serte']);
    $keterangan = mysqli_real_escape_string($koneksi, $_POST['keterangan']);

    $query = mysqli_query($koneksi, "UPDATE serah_terima SET id_aset='$id_aset', penerima='$penerima', penyetuju='$penyetuju', tgl_serte='$tgl_serte', keterangan='$keterangan' WHERE id_serte='$id_serte'");
    
    echo "<script>alert('Data Serah Terima diperbarui!'); window.location='?pg=" . ($_GET['pg'] ?? '') . "&fl=" . ($_GET['fl'] ?? '') . "';</script>";
}

// --- LOGIKA SIMPAN DARI FORM PAGE ---
if (isset($_POST['simpan_serte'])) {
    $id_aset = mysqli_real_escape_string($koneksi, $_POST['id_aset']);
    $penerima = mysqli_real_escape_string($koneksi, $_POST['penerima']);
    $penyetuju = mysqli_real_escape_string($koneksi, $_POST['penyetuju']);
    $tgl_serte = mysqli_real_escape_string($koneksi, $_POST['tgl_serte']);
    $keterangan = mysqli_real_escape_string($koneksi, $_POST['keterangan']);

    $query = mysqli_query($koneksi, "INSERT INTO serah_terima (id_aset, penerima, penyetuju, tgl_serte, keterangan) VALUES ('$id_aset', '$penerima', '$penyetuju', '$tgl_serte', '$keterangan')");
    
    if($query) {
        echo "<script>alert('Serah terima aset berhasil ditambahkan!'); window.location='index.php?pg=kserte&fl=list';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal menambah data: " . mysqli_error($koneksi) . "');</script>";
    }
}
?>
