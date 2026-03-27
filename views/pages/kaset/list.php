<?php
// Pastikan file komponen dipanggil di baris paling atas!
include_once 'cores/component.php'; 

$koneksi = mysqli_connect("localhost", "root", "", "db_asset");

// --- LOGIKA CRUD (Update & Hapus) ---
if (isset($_GET['hapus'])) {
    $id_aset = $_GET['hapus'];
    // Hapus foto terkait sebelum menghapus record
    $q_foto = mysqli_query($koneksi, "SELECT foto FROM aset WHERE id_aset='$id_aset'");
    if($q_foto && mysqli_num_rows($q_foto) > 0) {
        $foto_lama = mysqli_fetch_assoc($q_foto)['foto'];
        if(!empty($foto_lama) && file_exists("assets/img/aset/$foto_lama")) {
            unlink("assets/img/aset/$foto_lama");
        }
    }
    
    $query = mysqli_query($koneksi, "DELETE FROM aset WHERE id_aset = '$id_aset'");
    if($query) echo "<script>alert('Aset dihapus!'); window.location='?pg=" . ($_GET['pg'] ?? '') . "&fl=" . ($_GET['fl'] ?? '') . "';</script>";
}

if (isset($_POST['tambah_aset'])) {
    $nama_aset = $_POST['nama_aset'];
    $kode_aset = $_POST['kode_aset'];
    $kategori = $_POST['kategori'];
    $lokasi = $_POST['lokasi'] ?? '';

    $tgl_perolehan = $_POST['tgl_perolehan'];
    $kondisi = $_POST['kondisi'];
    $keterangan = $_POST['keterangan'];

    $foto = '';
    if (!empty($_FILES['foto']['name'])) {
        $foto = time() . '_' . $_FILES['foto']['name'];
        if (!is_dir("assets/img/aset")) {
            mkdir("assets/img/aset", 0777, true);
        }
        move_uploaded_file($_FILES['foto']['tmp_name'], "assets/img/aset/$foto");
    }

    $query = mysqli_query($koneksi, "INSERT INTO aset (nama_aset, foto, kode_aset, kategori, lokasi, tgl_perolehan, kondisi, keterangan) VALUES ('$nama_aset', '$foto', '$kode_aset', '$kategori', '$lokasi', '$tgl_perolehan', '$kondisi', '$keterangan')");
    if($query) {
        echo "<script>alert('Aset berhasil ditambahkan!'); window.location='?pg=" . ($_GET['pg'] ?? '') . "&fl=" . ($_GET['fl'] ?? '') . "';</script>";
    }
}

if (isset($_POST['update_aset'])) {
    $id_aset = $_POST['id_aset'];
    $nama_aset = $_POST['nama_aset'];
    $kode_aset = $_POST['kode_aset'];
    $kategori = $_POST['kategori'];
    $lokasi = $_POST['lokasi'] ?? '';

    $tgl_perolehan = $_POST['tgl_perolehan'];
    $kondisi = $_POST['kondisi'];
    $keterangan = $_POST['keterangan'];

    if (!empty($_FILES['foto']['name'])) {
        $foto = time() . '_' . $_FILES['foto']['name'];
        if (!is_dir("assets/img/aset")) {
            mkdir("assets/img/aset", 0777, true);
        }
        if (move_uploaded_file($_FILES['foto']['tmp_name'], "assets/img/aset/$foto")) {
            
            // Hapus foto lama jika diganti
            $q_foto = mysqli_query($koneksi, "SELECT foto FROM aset WHERE id_aset='$id_aset'");
            if($q_foto && mysqli_num_rows($q_foto) > 0) {
                $foto_lama = mysqli_fetch_assoc($q_foto)['foto'];
                if(!empty($foto_lama) && file_exists("assets/img/aset/$foto_lama")) {
                    unlink("assets/img/aset/$foto_lama");
                  }
            }

            $query = mysqli_query($koneksi, "UPDATE aset SET foto='$foto', nama_aset='$nama_aset', kode_aset='$kode_aset', kategori='$kategori', lokasi='$lokasi', tgl_perolehan='$tgl_perolehan', kondisi='$kondisi' WHERE id_aset='$id_aset'");
        }
    } else {
        $query = mysqli_query($koneksi, "UPDATE aset SET nama_aset='$nama_aset', kode_aset='$kode_aset', kategori='$kategori', lokasi='$lokasi', tgl_perolehan='$tgl_perolehan', kondisi='$kondisi' WHERE id_aset='$id_aset'");
    }

    echo "<script>alert('Data aset diperbarui!'); window.location='?pg=" . ($_GET['pg'] ?? '') . "&fl=" . ($_GET['fl'] ?? '') . "';</script>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Aset - Data View</title>
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
    // --- 1. PINDAHKAN LOGIKA FORM CARI KE SINI ---
    
    // --- 2. GANTI TOMBOL CETAK JADI TOMBOL TAMBAH ---
    $btnTambah = '<button class="btn btn-primary btn-sm no-print align-items-center d-flex gap-2" data-bs-toggle="modal" data-bs-target="#modalTambahAset"><i data-lucide="plus" style="width:16px;"></i> Tambah</button>';
    $headerAksi = "<div class='d-flex align-items-center gap-2'>{$btnTambah}</div>";

    // MENGGUNAKAN KOMPONEN PAGE HEADER DENGAN AKSI GABUNGAN
    PageHeader("Data Aset", "Lihat dan kelola seluruh inventaris aset", $headerAksi); 
    ?>

    <div class="row g-4">
        <div class="col-12">
            <?php
            // Siapkan Header Tabel ($th)
            $th = '<th class="ps-3">Nama Aset</th><th>Kategori</th><th>Lokasi</th><th>Status</th><th class="text-end pe-3">Aksi</th>';

            // Siapkan Isi Tabel ($tr)
            $tr = '';
            $keyword = isset($_GET['cari']) ? mysqli_real_escape_string($koneksi, $_GET['cari']) : '';
            $where = $keyword ? "WHERE (nama_aset LIKE '%$keyword%' OR kode_aset LIKE '%$keyword%' OR kategori LIKE '%$keyword%') AND id_aset NOT IN (SELECT id_aset FROM penghapusan)" : "WHERE id_aset NOT IN (SELECT id_aset FROM penghapusan)";
            
            // Prepare dropdown data for edit modal
            $kat_opts = "";
            $q_kat = mysqli_query($koneksi, "SELECT nama_kategori FROM kategori ORDER BY nama_kategori ASC");
            if($q_kat) while($k = mysqli_fetch_assoc($q_kat)) $kat_opts .= "<option value='{$k['nama_kategori']}'>{$k['nama_kategori']}</option>";

            $lok_opts = "";
            $q_lok = mysqli_query($koneksi, "SELECT nama_lokasi FROM lokasi ORDER BY nama_lokasi ASC");
            if($q_lok) while($l = mysqli_fetch_assoc($q_lok)) $lok_opts .= "<option value='{$l['nama_lokasi']}'>{$l['nama_lokasi']}</option>";
            
            // Check if lokasi column exists, if not, it won't crash because we SELECT *
            $tampil = mysqli_query($koneksi, "SELECT * FROM aset $where ORDER BY id_aset DESC");
            
            if(mysqli_num_rows($tampil) > 0) {
                while ($data = mysqli_fetch_array($tampil)) {
                    $badgeClass = 'bg-secondary';
                    if($data['kondisi'] == 'Baik') $badgeClass = 'bg-success text-success bg-opacity-10';
                    if($data['kondisi'] == 'Rusak Ringan') $badgeClass = 'bg-warning text-warning bg-opacity-10';
                    if($data['kondisi'] == 'Rusak Berat') $badgeClass = 'bg-danger text-danger bg-opacity-10';
                    $tgl = date('d/m/y', strtotime($data['tgl_perolehan']));
                    $fotoUrl = !empty($data['foto']) ? "assets/img/aset/".$data['foto'] : "https://via.placeholder.com/45";
                    $lokasi_view = isset($data['lokasi']) && $data['lokasi'] ? $data['lokasi'] : '-';

                    // --- MENGGUNAKAN KOMPONEN DROPDOWN ---
                    $aksiArr = [ 
                        ["default", "#", "edit-3", "Edit", "", "data-bs-toggle='modal' data-bs-target='#modalEditAset' data-id='{$data['id_aset']}' data-nama='{$data['nama_aset']}' data-kode='{$data['kode_aset']}' data-kategori='{$data['kategori']}' data-lokasi='{$lokasi_view}' data-tgl='{$data['tgl_perolehan']}' data-kondisi='{$data['kondisi']}'"],
                        ["qr", "#", "qr-code", "Barcode", "dark", "setQR('{$data['kode_aset']}', '{$data['nama_aset']}')"],
                        ["hr"],
                        ["default", "index.php?pg=khapus&fl=form&id_aset={$data['id_aset']}", "trash-2", "Hapus (Ke Penghapusan)", "danger", ""]
                    ];
                    $btnDropdown = AksiDropdown($aksiArr);

                    $tr .= <<<baris
                    <tr>
                        <td class="ps-3">
                            <div class="d-flex align-items-center gap-3">
                                <img src="{$fotoUrl}" class="aset-foto" alt="Foto">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-dark">{$data['nama_aset']}</span>
                                    <span class="text-muted" style="font-size: 0.75rem;">{$data['kode_aset']} • {$tgl}</span>
                                </div>
                            </div>
                        </td>
                        <td><span class="fw-medium text-secondary">{$data['kategori']}</span></td>
                        <td><span class="fw-medium text-secondary">{$lokasi_view}</span></td>
                        <td><span class="badge {$badgeClass} rounded-pill border">{$data['kondisi']}</span></td>
                        <td class="text-end pe-3 no-print">{$btnDropdown}</td>
                    </tr>
                    baris;
                }
            } else {
                $tr = '<tr><td colspan="5" class="text-center py-4 text-muted">Data Kosong</td></tr>';
            }

            // Render Tabel menggunakan Komponen (Form Cari dikosongkan karena sudah di atas)
            PageContentTabel($th, $tr, "", "");
            ?>
        </div>
    </div>
</div>

<?php 
modalHapus();
modalQRCode();
dialogPrint();
?>

<div class="modal fade" id="modalEditAset" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Edit Aset</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_aset" id="edit_id">
                    <div class="mb-2">
                        <label class="small fw-bold">Foto Aset</label>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                        <small class="text-muted" style="font-size: 11px;">Abaikan jika tidak ingin mengubah foto</small>
                    </div>
                    <div class="mb-2"><label class="small fw-bold">Nama</label><input type="text" name="nama_aset" id="edit_nama" class="form-control" required></div>
                    <div class="row g-2 mb-2">
                        <div class="col-6"><label class="small fw-bold">Kode</label><input type="text" name="kode_aset" id="edit_kode" class="form-control" required></div>
                        <div class="col-6"><label class="small fw-bold">Kategori</label>
                            <select name="kategori" id="edit_kategori" class="form-select" required>
                                <?= $kat_opts; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-6"><label class="small fw-bold">Tgl</label><input type="date" name="tgl_perolehan" id="edit_tgl" class="form-control" required></div>
                        <div class="col-6"><label class="small fw-bold">Kondisi</label>
                            <select name="kondisi" id="edit_kondisi" class="form-select" required>
                                <option value="Baik">Baik</option><option value="Rusak Ringan">Rusak Ringan</option><option value="Rusak Berat">Rusak Berat</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="small fw-bold">Lokasi</label>
                        <select name="lokasi" id="edit_lokasi" class="form-select" required>
                            <?= $lok_opts; ?>
                        </select>
                    </div>
                    <div class="mb-3"><label class="small fw-bold">Keterangan</label><textarea name="keterangan" id="edit_ket" class="form-control"></textarea></div>
                    <?= button("update_aset", "Simpan Perubahan", "primary", "check", "class='w-100'") ?>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Aset -->
<div class="modal fade" id="modalTambahAset" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Tambah Aset</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="mb-2">
                        <label class="small fw-bold">Foto Aset</label>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                        <small class="text-muted" style="font-size: 11px;">Maksimal ukuran foto 2MB</small>
                    </div>
                    <div class="mb-2"><label class="small fw-bold">Nama</label><input type="text" name="nama_aset" class="form-control" required></div>
                    <div class="row g-2 mb-2">
                        <div class="col-6"><label class="small fw-bold">Kode</label><input type="text" name="kode_aset" class="form-control" required></div>
                        <div class="col-6"><label class="small fw-bold">Kategori</label>
                            <select name="kategori" class="form-select" required>
                                <option value="" selected disabled>Pilih...</option>
                                <?= $kat_opts; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-6"><label class="small fw-bold">Tgl Perolehan</label><input type="date" name="tgl_perolehan" class="form-control" required></div>
                        <div class="col-6"><label class="small fw-bold">Kondisi</label>
                            <select name="kondisi" class="form-select" required>
                                <option value="Baik" selected>Baik</option>
                                <option value="Rusak Ringan">Rusak Ringan</option>
                                <option value="Rusak Berat">Rusak Berat</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="small fw-bold">Lokasi</label>
                        <select name="lokasi" class="form-select" required>
                            <option value="" selected disabled>Pilih...</option>
                            <?= $lok_opts; ?>
                        </select>
                    </div>
                    <div class="mb-3"><label class="small fw-bold">Keterangan</label><textarea name="keterangan" class="form-control"></textarea></div>
                    <?= button("tambah_aset", "Simpan Aset", "primary", "check", "class='w-100'") ?>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    lucide.createIcons();

    // JS untuk menangkap data ke Modal Edit
    const modalEdit = document.getElementById('modalEditAset');
    modalEdit.addEventListener('show.bs.modal', function (event) {
        const btn = event.relatedTarget;
        document.getElementById('edit_id').value = btn.getAttribute('data-id');
        document.getElementById('edit_nama').value = btn.getAttribute('data-nama');
        document.getElementById('edit_kode').value = btn.getAttribute('data-kode');
        document.getElementById('edit_kategori').value = btn.getAttribute('data-kategori');
        document.getElementById('edit_lokasi').value = btn.getAttribute('data-lokasi');
        document.getElementById('edit_tgl').value = btn.getAttribute('data-tgl');
        document.getElementById('edit_kondisi').value = btn.getAttribute('data-kondisi');
        document.getElementById('edit_ket').value = btn.getAttribute('data-ket');
    });

    // JS untuk melempar Data ke Modal Hapus (Komponen)
    function setHapus(id) {
        const urlParams = new URLSearchParams(window.location.search);
        urlParams.set('hapus', id);
        document.getElementById('btnLinkHapus').href = '?' + urlParams.toString();
    }

    // JS untuk melempar Data ke Modal QR (Komponen)
    function setQR(kode, nama) {
        document.getElementById('labelKode').innerText = kode;
        document.getElementById('labelNamaAset').innerText = nama;
        document.getElementById('qrcode').innerHTML = `<img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=${kode}" class="img-fluid border p-1 rounded">`;
    }

    // JS untuk Print QR Code
    function printLabel() {
        const areaCetak = document.getElementById('areaCetak').innerHTML;
        const frame = document.getElementById('frameCetak').contentWindow;
        frame.document.open();
        frame.document.write(`
            <html><head>
            <style>
                body { font-family: sans-serif; text-align: center; margin: 0; padding: 10px; }
                .p-4 { padding: 10px; border: 2px dashed #000; display: inline-block; }
                .fw-bold { font-weight: bold; }
                .text-uppercase { text-transform: uppercase; }
                .small { font-size: 10px; color: #555; }
                img { width: 100px; height: 100px; margin: 10px 0; }
            </style>
            </head><body>${areaCetak}</body></html>
        `);
        frame.document.close();
        frame.focus();
        setTimeout(() => frame.print(), 500);
    }
</script>

</body>
</html>
