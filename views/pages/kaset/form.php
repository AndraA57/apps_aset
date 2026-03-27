<?php
include_once 'cores/component.php'; 

if (isset($_POST['simpan_aset'])) {
    $nama_aset = $_POST['nama_aset'];
    $kode_aset = $_POST['kode_aset'];
    $kategori = $_POST['kategori'];
    $lokasi = $_POST['lokasi'];

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
        echo "<script>alert('Aset berhasil ditambahkan!'); window.location='index.php?pg=kaset&fl=list';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal menambah aset: " . mysqli_error($koneksi) . "');</script>";
    }
}

// Ambil data kategori dan lokasi untuk dropdown
$kategori_opt = "";
$q_kat = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY nama_kategori ASC");
if($q_kat && mysqli_num_rows($q_kat) > 0) {
    while($k = mysqli_fetch_assoc($q_kat)) {
        $kategori_opt .= "<option value='{$k['nama_kategori']}'>{$k['nama_kategori']}</option>";
    }
} else {
    $kategori_opt = "<option value='Elektronik'>Elektronik</option><option value='Furniture'>Furniture</option><option value='Kendaraan'>Kendaraan</option>";
}

$lokasi_opt = "";
$q_lok = mysqli_query($koneksi, "SELECT * FROM lokasi ORDER BY nama_lokasi ASC");
if($q_lok && mysqli_num_rows($q_lok) > 0) {
    while($l = mysqli_fetch_assoc($q_lok)) {
        $lokasi_opt .= "<option value='{$l['nama_lokasi']}'>{$l['nama_lokasi']} - {$l['deskripsi']}</option>";
    }
} else {
    $lokasi_opt = "<option value=''>Belum ada opsi lokasi</option>";
}


$btnBatal  = buttonhref("index.php?pg=kaset&fl=list", "Batal", "light border text-muted px-4", "", "");
$btnSimpan = button("simpan_aset", "Simpan Aset", "primary px-4 shadow", "save", "style='background-color: var(--accent); border:none;'");

$formContent = <<<HTML
<form action="" method="POST" enctype="multipart/form-data">
    <div class="d-flex flex-column gap-4">
        
        <div>
            <label class="form-label small fw-bold text-secondary text-uppercase mb-2">Foto Aset</label>
            <div class="input-group border rounded-3 overflow-hidden shadow-sm bg-light">
                <span class="input-group-text bg-transparent border-0 text-muted ps-3"><i data-lucide="image" style="width:18px"></i></span>
                <input type="file" name="foto" class="form-control bg-transparent border-0 shadow-none py-2" accept="image/*">
            </div>
        </div>

        <div>
            <label class="form-label small fw-bold text-secondary text-uppercase mb-2">Nama Aset</label>
            <div class="input-group border rounded-3 overflow-hidden shadow-sm bg-light">
                <span class="input-group-text bg-transparent border-0 text-muted ps-3"><i data-lucide="box" style="width:18px"></i></span>
                <input type="text" name="nama_aset" class="form-control bg-transparent border-0 shadow-none py-2" placeholder="Nama inventaris..." required autocomplete="off">
            </div>
        </div>

        <div>
            <label class="form-label small fw-bold text-secondary text-uppercase mb-2">Kode Aset</label>
            <div class="input-group border rounded-3 overflow-hidden shadow-sm bg-light">
                <span class="input-group-text bg-transparent border-0 text-muted ps-3"><i data-lucide="hash" style="width:18px"></i></span>
                <input type="text" name="kode_aset" class="form-control bg-transparent border-0 shadow-none py-2" placeholder="Masukkan kode unik..." required autocomplete="off">
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label small fw-bold text-secondary text-uppercase mb-2">Kategori</label>
                <select name="kategori" class="form-select bg-light border rounded-3 py-2 shadow-sm" required>
                    <option value="" selected disabled>Pilih Kategori...</option>
                    $kategori_opt
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-bold text-secondary text-uppercase mb-2">Lokasi</label>
                <select name="lokasi" class="form-select bg-light border rounded-3 py-2 shadow-sm" required>
                    <option value="" selected disabled>Pilih Lokasi...</option>
                    $lokasi_opt
                </select>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label small fw-bold text-secondary text-uppercase mb-2">Tanggal Perolehan</label>
                <input type="date" name="tgl_perolehan" class="form-control bg-light border rounded-3 py-2 shadow-sm" required>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-bold text-secondary text-uppercase mb-2">Kondisi</label>
                <select name="kondisi" class="form-select bg-light border rounded-3 py-2 shadow-sm" required>
                    <option value="Baik" selected>Baik</option>
                    <option value="Rusak Ringan">Rusak Ringan</option>
                    <option value="Rusak Berat">Rusak Berat</option>
                </select>
            </div>
        </div>

        <div>
            <label class="form-label small fw-bold text-secondary text-uppercase mb-2">Keterangan</label>
            <textarea name="keterangan" class="form-control bg-light border rounded-3 shadow-sm p-3" rows="3" placeholder="Informasi tambahan terkait aset..."></textarea>
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
            PageHeader("Tambah Aset Baru", "Daftarkan aset inventaris ke dalam sistem database");
            PageContentForm($formContent);
echo '  </div>';
echo '</div>';
?>

<script>
    lucide.createIcons();
</script>
