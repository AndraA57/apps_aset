<?php
// 1. Panggil Koneksi Database
// PENTING: Tanda "../" berarti naik satu folder. Sesuaikan jumlah "../" dengan lokasi file koneksi Anda.
// Jika file ini ada di: views/pages/adm_instansi/
// Dan koneksi ada di: config/koneksi.php
// Maka butuh naik 3-4 kali. Coba sesuaikan path ini:
include '../../../config/koneksi.php'; 

// 2. Ambil ID dari URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // 3. Eksekusi Query Hapus
    // Pastikan nama tabel 'pegawai' dan kolom 'IdPegawai' sesuai database
    $query = mysqli_query($koneksi, "DELETE FROM pegawai WHERE IdPegawai = '$id'");

    // 4. Cek Hasil dan Redirect
    if ($query) {
        echo "<script>
                alert('Data pegawai berhasil dihapus!');
                // Redirect kembali ke halaman index utama
                // Sesuaikan jumlah '../' agar kembali ke root folder tempat index.php berada
                window.location = '../../../../index.php?pg=kpegawai&fl=list'; 
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus data: " . mysqli_error($koneksi) . "');
                window.location = '../../../../index.php?pg=kpegawai&fl=list';
              </script>";
    }
} else {
    // Jika tidak ada ID, kembalikan saja
    echo "<script>window.location = '../../../../index.php?pg=kpegawai&fl=list';</script>";
}
?>
