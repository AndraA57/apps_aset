<?php
include_once 'cores/component.php'; 

if (isset($_POST['simpan_hapus'])) {
    $id_aset = mysqli_real_escape_string($koneksi, $_POST['id_aset']);
    $penyetuju = mysqli_real_escape_string($koneksi, $_POST['penyetuju']);
    $tgl_hapus = mysqli_real_escape_string($koneksi, $_POST['tgl_hapus']);
    $keterangan = mysqli_real_escape_string($koneksi, $_POST['keterangan']);

    // create table if not exists
    mysqli_query($koneksi, "CREATE TABLE IF NOT EXISTS penghapusan (id_hapus INT AUTO_INCREMENT PRIMARY KEY, id_aset INT, penyetuju VARCHAR(255), tgl_hapus DATE, keterangan TEXT)");

    $query = mysqli_query($koneksi, "INSERT INTO penghapusan (id_aset, penyetuju, tgl_hapus, keterangan) VALUES ('$id_aset', '$penyetuju', '$tgl_hapus', '$keterangan')");
    
    if($query) {
        echo "<script>alert('Penghapusan aset berhasil ditambahkan!'); window.location='index.php?pg=khapus&fl=list';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal menambah data: " . mysqli_error($koneksi) . "');</script>";
    }
}

// 1. Ambil data aset dengan foto (exclude yang sudah dihapus)
$get_id_aset = isset($_GET['id_aset']) ? $_GET['id_aset'] : '';

$aset_opt = "";
$q_aset = mysqli_query($koneksi, "SELECT id_aset, nama_aset, kode_aset, foto FROM aset WHERE id_aset NOT IN (SELECT id_aset FROM penghapusan) ORDER BY nama_aset ASC");
if($q_aset && mysqli_num_rows($q_aset) > 0) {
    while($a = mysqli_fetch_assoc($q_aset)) {
        $fotoClass = !empty($a['foto']) ? "assets/img/aset/".$a['foto'] : "https://via.placeholder.com/45";
        $selected = ($get_id_aset == $a['id_aset']) ? "selected" : "";
        $aset_opt .= "<option value='{$a['id_aset']}' data-foto='{$fotoClass}' $selected>{$a['kode_aset']} - {$a['nama_aset']}</option>";
    }
} else {
    $aset_opt = "<option value=''>Belum ada aset tersedia</option>";
}

// 2. Ambil data pegawai untuk datalist
$pegawai_datalist = "<datalist id='listPegawai'>";
$q_peg = mysqli_query($koneksi, "SELECT Nama FROM pegawai ORDER BY Nama ASC");
if($q_peg && mysqli_num_rows($q_peg) > 0) {
    while($p = mysqli_fetch_assoc($q_peg)) {
        $pegawai_datalist .= "<option value=\"{$p['Nama']}\">";
    }
}
$pegawai_datalist .= "</datalist>";

$btnBatal  = buttonhref("index.php?pg=khapus&fl=list", "Batal", "light border text-muted px-4", "", "");
$btnSimpan = button("simpan_hapus", "Hapus Aset Ini", "danger px-4 shadow", "trash-2", "style='border:none;'");

$tgl_default = date('Y-m-d');

// Menambahkan CDN Select2 dan jQuery
$formContent = <<<HTML
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* Styling select2 agar senada dengan bootstrap */
    .select2-container .select2-selection--single {
        height: auto;
        padding: 0.2rem 0;
        border: none;
        background: transparent;
        box-shadow: none;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 28px; }
    .select2-container--default .select2-selection--single .select2-selection__arrow { height: 36px; }
</style>

$pegawai_datalist

<form action="" method="POST">
    <div class="d-flex flex-column gap-4">

        <div>
            <label class="form-label small fw-bold text-secondary text-uppercase mb-2">Pilih Aset untuk Penghapusan</label>
            <div class="input-group border rounded-3 overflow-hidden shadow-sm bg-light">
                <span class="input-group-text bg-transparent border-0 text-muted ps-3"><i data-lucide="box" style="width:18px"></i></span>
                <select name="id_aset" id="selectAsset" class="form-select bg-transparent border-0 shadow-none py-2" style="width: 85%;" required>
                    <option value="" selected disabled>Pilih Aset...</option>
                    $aset_opt
                </select>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label small fw-bold text-secondary text-uppercase mb-2">Pihak Penyetuju</label>
                <div class="input-group border rounded-3 overflow-hidden shadow-sm bg-light">
                    <span class="input-group-text bg-transparent border-0 text-muted ps-3"><i data-lucide="user-check" style="width:18px"></i></span>
                    <input type="text" name="penyetuju" list="listPegawai" class="form-control bg-transparent border-0 shadow-none py-2" placeholder="Ketik atau pilih nama..." required autocomplete="off">
                </div>
                <small class="text-muted" style="font-size: 11px;">Bisa diketik manual atau dipilih dari daftar pegawai</small>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-bold text-secondary text-uppercase mb-2">Tanggal Penghapusan</label>
                <input type="date" name="tgl_hapus" class="form-control bg-light border rounded-3 py-2 shadow-sm" required value="$tgl_default">
            </div>
        </div>

        <div>
            <label class="form-label small fw-bold text-secondary text-uppercase mb-2">Alasan / Keterangan</label>
            <textarea name="keterangan" class="form-control bg-light border rounded-3 shadow-sm p-3" rows="3" placeholder="Informasi alasan aset dihapus..." required></textarea>
        </div>

        <div class="mt-4 pt-3 border-top d-flex flex-column flex-sm-row justify-content-end gap-2">
            $btnBatal
            $btnSimpan
        </div>

    </div>
</form>
HTML;

echo '<div class="row justify-content-center pt-4">';
echo '  <div class="col-12 col-lg-8">';
            PageHeader("Tambah Penghapusan Aset", "Daftarkan penghapusan aset ke dalam sistem");
            PageContentForm($formContent);
echo '  </div>';
echo '</div>';
?>

<!-- Include JQuery & Select2 JS sebelum menutup -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    lucide.createIcons();
    
    $(document).ready(function() {
        function formatAsset (asset) {
            if (!asset.id) {
                return asset.text;
            }
            var foto = $(asset.element).data('foto');
            var $asset = $(
                '<span><img src="' + foto + '" style="width: 30px; height: 30px; border-radius: 4px; object-fit: cover; margin-right: 10px;" /> ' + asset.text + '</span>'
            );
            return $asset;
        };

        $('#selectAsset').select2({
            templateResult: formatAsset,
            templateSelection: formatAsset
        });
    });
</script>
