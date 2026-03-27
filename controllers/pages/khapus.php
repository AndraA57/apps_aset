<?php
// Controller untuk halaman Penghapusan Aset
// Memproses logika CRUD penghapusan

// Buat table jika belum ada (dengan kolom penyetuju)
mysqli_query($koneksi, "CREATE TABLE IF NOT EXISTS penghapusan (
    id_hapus INT AUTO_INCREMENT PRIMARY KEY,
    id_aset INT,
    penyetuju VARCHAR(255),
    tgl_hapus DATE,
    keterangan TEXT
)");

// Tambahkan kolom penyetuju jika belum ada
$check_col = mysqli_query($koneksi, "SHOW COLUMNS FROM penghapusan LIKE 'penyetuju'");
if(mysqli_num_rows($check_col) == 0) {
    mysqli_query($koneksi, "ALTER TABLE penghapusan ADD COLUMN penyetuju VARCHAR(255) AFTER id_aset");
}

// --- LOGIKA HAPUS ---
if (isset($_GET['hapus'])) {
    $id_hapus = mysqli_real_escape_string($koneksi, $_GET['hapus']);
    
    // Dapatkan id_aset terlebih dahulu untuk dihapus permanen
    $get_aset = mysqli_query($koneksi, "SELECT id_aset FROM penghapusan WHERE id_hapus = '$id_hapus'");
    if($get_aset && mysqli_num_rows($get_aset) > 0) {
        $id_aset = mysqli_fetch_assoc($get_aset)['id_aset'];
        
        // Hapus foto terkait sebelum menghapus record
        $q_foto = mysqli_query($koneksi, "SELECT foto FROM aset WHERE id_aset='$id_aset'");
        if($q_foto && mysqli_num_rows($q_foto) > 0) {
            $foto_lama = mysqli_fetch_assoc($q_foto)['foto'];
            if(!empty($foto_lama) && file_exists("assets/img/aset/$foto_lama")) {
                unlink("assets/img/aset/$foto_lama");
            }
        }
        
        // Hapus permanen dari tabel aset
        mysqli_query($koneksi, "DELETE FROM aset WHERE id_aset = '$id_aset'");
    }

    $query = mysqli_query($koneksi, "DELETE FROM penghapusan WHERE id_hapus = '$id_hapus'");
    if($query) echo "<script>alert('Data Penghapusan & Aset dihapus permanen!'); window.location='?pg=" . ($_GET['pg'] ?? '') . "&fl=" . ($_GET['fl'] ?? '') . "';</script>";
}

// --- LOGIKA SIMPAN DARI FORM PAGE ---
if (isset($_POST['simpan_hapus'])) {
    $id_aset = mysqli_real_escape_string($koneksi, $_POST['id_aset']);
    $penyetuju = mysqli_real_escape_string($koneksi, $_POST['penyetuju']);
    $tgl_hapus = mysqli_real_escape_string($koneksi, $_POST['tgl_hapus']);
    $keterangan = mysqli_real_escape_string($koneksi, $_POST['keterangan']);

    $query = mysqli_query($koneksi, "INSERT INTO penghapusan (id_aset, penyetuju, tgl_hapus, keterangan) VALUES ('$id_aset', '$penyetuju', '$tgl_hapus', '$keterangan')");
    
    if($query) {
        echo "<script>alert('Penghapusan aset berhasil ditambahkan!'); window.location='index.php?pg=khapus&fl=list';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal menambah data: " . mysqli_error($koneksi) . "');</script>";
    }
}
?>
