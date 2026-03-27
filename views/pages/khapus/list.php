<?php
// Pastikan file komponen dipanggil di baris paling atas!
include_once 'cores/component.php'; 

$koneksi = mysqli_connect("localhost", "root", "", "db_asset");

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

// --- LOGIKA CRUD (Hapus saja di list) ---
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
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penghapusan Aset - Data View</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { background-color: #f4f6f9; font-family: 'Inter', sans-serif; }
        .form-control:focus, .form-select:focus { border-color: #0d6efd; box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15); }
        .table > :not(caption) > * > * { padding: 0.8rem 0.5rem; vertical-align: middle; }
        @media print { .no-print { display: none !important; } }
        .aset-foto { width: 45px; height: 45px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd; }
    </style>
</head>
<body>

<div class="container-fluid p-4">
    
    <?php 
    $btnTambah = '<a href="index.php?pg=khapus&fl=form" class="btn btn-danger btn-sm no-print align-items-center d-flex gap-2"><i data-lucide="plus" style="width:16px;"></i> Tambah</a>';
    $headerAksi = "<div class='d-flex align-items-center gap-2'>{$btnTambah}</div>";

    // MENGGUNAKAN KOMPONEN PAGE HEADER DENGAN AKSI GABUNGAN
    PageHeader("Penghapusan Aset", "Lihat dan kelola data penghapusan aset inventaris", $headerAksi); 
    ?>

    <div class="row g-4">
        <div class="col-12">
            <?php
            // Siapkan Header Tabel ($th)
            $th = '<th class="ps-3">Nama Aset</th><th>Kategori</th><th>Pihak Penyetuju</th><th>Tanggal Dihapus</th><th>Keterangan</th><th class="text-end pe-3">Aksi</th>';

            // Siapkan Isi Tabel ($tr)
            $tr = '';

            $tampil = mysqli_query($koneksi, "SELECT h.*, a.nama_aset, a.kode_aset, a.foto, a.kategori FROM penghapusan h JOIN aset a ON h.id_aset = a.id_aset ORDER BY h.id_hapus DESC");
            
            if($tampil && mysqli_num_rows($tampil) > 0) {
                while ($data = mysqli_fetch_array($tampil)) {
                    $tgl = date('d/m/y', strtotime($data['tgl_hapus']));
                    $fotoUrl = !empty($data['foto']) ? "assets/img/aset/".$data['foto'] : "https://via.placeholder.com/45";
                    $ketHover = htmlspecialchars($data['keterangan']);
                    $penyetuju = htmlspecialchars($data['penyetuju'] ?? '-');

                    $aksiArr = [ 
                        ["hapus", "#", "trash-2", "Batal Hapus", "danger", "setHapus('{$data['id_hapus']}')"]
                    ];
                    $btnDropdown = AksiDropdown($aksiArr);

                    $tr .= <<<baris
                    <tr>
                        <td class="ps-3">
                            <div class="d-flex align-items-center gap-3">
                                <img src="{$fotoUrl}" class="aset-foto" alt="Foto">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-dark">{$data['nama_aset']}</span>
                                    <span class="text-muted" style="font-size: 0.75rem;">{$data['kode_aset']}</span>
                                </div>
                            </div>
                        </td>
                        <td><span class="fw-medium text-secondary">{$data['kategori']}</span></td>
                        <td><span class="fw-medium text-secondary">{$penyetuju}</span></td>
                        <td><span class="badge bg-danger text-white rounded-pill border">{$tgl}</span></td>
                        <td><span class="fw-medium text-secondary">{$data['keterangan']}</span></td>
                        <td class="text-end pe-3 no-print">{$btnDropdown}</td>
                    </tr>
                    baris;
                }
            } else {
                $tr = '<tr><td colspan="6" class="text-center py-4 text-muted">Data Kosong</td></tr>';
            }

            PageContentTabel($th, $tr, "", "");
            ?>
        </div>
    </div>
</div>

<?php 
modalHapus();
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    lucide.createIcons();

    function setHapus(id) {
        const urlParams = new URLSearchParams(window.location.search);
        urlParams.set('hapus', id);
        document.getElementById('btnLinkHapus').href = '?' + urlParams.toString();
    }
</script>

</body>
</html>
