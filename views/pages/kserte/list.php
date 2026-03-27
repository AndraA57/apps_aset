<?php
// Pastikan file komponen dipanggil di baris paling atas!
include_once 'cores/component.php'; 

$koneksi = mysqli_connect("localhost", "root", "", "db_asset");

// Buat table jika belum ada
mysqli_query($koneksi, "CREATE TABLE IF NOT EXISTS serah_terima (
    id_serte INT AUTO_INCREMENT PRIMARY KEY,
    id_aset INT,
    penerima VARCHAR(255),
    penyetuju VARCHAR(255),
    tgl_serte DATE,
    keterangan TEXT
)");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Serah Terima Aset</title>
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
    $btnTambah = '<a href="index.php?pg=kserte&fl=form" class="btn btn-primary btn-sm no-print align-items-center d-flex gap-2"><i data-lucide="plus" style="width:16px;"></i> Tambah</a>';
    $headerAksi = "<div class='d-flex align-items-center gap-2'>{$btnTambah}</div>";

    // MENGGUNAKAN KOMPONEN PAGE HEADER DENGAN AKSI GABUNGAN
    PageHeader("Serah Terima Aset", "Lihat dan kelola data serah terima aset", $headerAksi); 
    ?>

    <div class="row g-4">
        <div class="col-12">
            <?php
            // Siapkan Header Tabel ($th)
            $th = '<th class="ps-3">Nama Aset</th><th>Pihak Penerima</th><th>Pihak Penyetuju</th><th>Tanggal</th><th class="text-end pe-3">Aksi</th>';

            // Siapkan Isi Tabel ($tr)
            $tr = '';
            
            // Prepare dropdown options for aset
            $aset_opts = "";
            // exclude deleted
            $q_aset = mysqli_query($koneksi, "SELECT id_aset, nama_aset, kode_aset FROM aset WHERE id_aset NOT IN (SELECT id_aset FROM penghapusan) ORDER BY nama_aset ASC");
            if($q_aset) {
                while($a = mysqli_fetch_assoc($q_aset)) {
                    $aset_opts .= "<option value='{$a['id_aset']}'>{$a['kode_aset']} - {$a['nama_aset']}</option>";
                }
            }

            $tampil = mysqli_query($koneksi, "SELECT s.*, a.nama_aset, a.kode_aset, a.foto FROM serah_terima s JOIN aset a ON s.id_aset = a.id_aset ORDER BY s.id_serte DESC");
            
            if($tampil && mysqli_num_rows($tampil) > 0) {
                while ($data = mysqli_fetch_array($tampil)) {
                    $tgl = date('d/m/y', strtotime($data['tgl_serte']));
                    $fotoUrl = !empty($data['foto']) ? "assets/img/aset/".$data['foto'] : "https://via.placeholder.com/45";

                    $btnDetail = "<a href='index.php?pg=kserte&fl=detail&id={$data['id_serte']}' class='btn btn-sm btn-light text-info border shadow-sm' title='Detail'><i data-lucide='eye' style='width: 16px;'></i></a>";
                    $btnCetakItem = "<a href='index.php?pg=kserte&fl=detail&id={$data['id_serte']}&print=true' class='btn btn-sm btn-light text-secondary border shadow-sm' title='Cetak Surat'><i data-lucide='printer' style='width: 16px;'></i></a>";
                    $btnAksi = "<div class='d-flex gap-1 justify-content-end'>$btnDetail $btnCetakItem</div>";

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
                        <td><span class="fw-medium text-secondary">{$data['penerima']}</span></td>
                        <td><span class="fw-medium text-secondary">{$data['penyetuju']}</span></td>
                        <td><span class="badge bg-light text-dark rounded-pill border">{$tgl}</span></td>
                        <td class="text-end pe-3 no-print">{$btnAksi}</td>
                    </tr>
                    baris;
                }
            } else {
                $tr = '<tr><td colspan="5" class="text-center py-4 text-muted">Data Kosong</td></tr>';
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
