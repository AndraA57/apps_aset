<?php
// ==========================================================
// LOGIKA BACKEND (SIMPAN PERUBAHAN)
// ==========================================================
if (isset($_POST['update'])) {
    $id = $_POST['IdPegawai'];
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    
    $query_update = "UPDATE pegawai SET Nama='$nama', username='$username' WHERE IdPegawai='$id'";
    $update = mysqli_query($koneksi, $query_update);

    if ($update) {
        echo "<script>
                alert('Berhasil! Data pegawai telah diperbarui.');
                window.location='index.php?pg=kpegawai&fl=list';
              </script>";
    } else {
        echo "<script>alert('Gagal memperbarui data: " . mysqli_error($koneksi) . "');</script>";
    }
}

// Ambil ID dari URL
$id = $_GET['id'] ?? '';

// Ambil data pegawai dari database
$query = mysqli_query($koneksi, "SELECT * FROM pegawai WHERE IdPegawai = '$id'");
$d = mysqli_fetch_assoc($query);

if (!$d) {
    echo "<div class='alert alert-danger m-4'>Data pegawai tidak ditemukan!</div>";
    exit;
}

$btnBatal  = buttonhref("index.php?pg=kpegawai&fl=list", "Batal", "light border text-muted px-4", "", "");
$btnSimpan = button("update", "Simpan Perubahan", "primary px-4 shadow", "save", "style='background-color: var(--accent); border:none;'");

$formContent = <<<HTML
<form action="" method="POST">
    <input type="hidden" name="IdPegawai" value="{$d['IdPegawai']}">
    <div class="d-flex flex-column gap-4">
        
        <div>
            <label class="form-label small fw-bold text-secondary text-uppercase ls-wide mb-2">Nama Lengkap</label>
            <div class="input-group border rounded-3 overflow-hidden shadow-sm bg-light">
                <span class="input-group-text bg-transparent border-0 text-muted ps-3"><i data-lucide="user" style="width:18px"></i></span>
                <input type="text" name="nama" class="form-control bg-transparent border-0 shadow-none py-2" value="{$d['Nama']}" placeholder="Nama lengkap pegawai..." required autocomplete="off">
            </div>
        </div>

        <div>
            <label class="form-label small fw-bold text-secondary text-uppercase ls-wide mb-2">Username</label>
            <div class="input-group border rounded-3 overflow-hidden shadow-sm bg-light">
                <span class="input-group-text bg-transparent border-0 text-muted ps-3"><i data-lucide="user" style="width:18px"></i></span>
                <input type="text" name="username" class="form-control bg-transparent border-0 shadow-none py-2" value="{$d['username']}" placeholder="Masukkan username..." required autocomplete="off">
            </div>
        </div>

        <div class="mt-4 pt-3 border-top d-flex flex-column flex-sm-row justify-content-end gap-2">
            $btnBatal
            $btnSimpan
        </div>

    </div>
</form>
HTML;

echo '<div class="row justify-content-center">';
echo '  <div class="col-12 col-md-8 col-lg-6">';
            PageContentForm($formContent);
echo '  </div>';
echo '</div>';
?>

<script>
    lucide.createIcons();
</script>
