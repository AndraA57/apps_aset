<?php
// ==========================================================
// LOGIKA BACKEND (SIMPAN DATA)
// ==========================================================
if (isset($_POST['simpan_data'])) {
    // 1. Ambil & Sanitasi data
    $nama     = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $sandi    = mysqli_real_escape_string($koneksi, $_POST['sandi']); 
    $sandi_hash = password_hash($sandi, PASSWORD_DEFAULT);
    
    // 2. SET ROLE DEFAULT (Kunci role jadi 'user')
    $role     = 'user'; 

    // 3. Eksekusi Query Insert
    $query_sql = "INSERT INTO pegawai (Nama, username, Sandi, ROLE) VALUES ('$nama', '$username', '$sandi_hash', '$role')";
    $insert = mysqli_query($koneksi, $query_sql);

    // 4. Cek Keberhasilan
    if ($insert) {
        echo "<script>
                alert('Berhasil! Pegawai baru ($nama) ditambahkan.');
                window.location='index.php?pg=kpegawai&fl=list';
              </script>";
    } else {
        echo "<script>alert('Gagal! Terjadi kesalahan: " . mysqli_error($koneksi) . "');</script>";
    }
}

// ==========================================================
// TAMPILAN (FRONTEND)
// ==========================================================

// 1. SETUP TOMBOL KEMBALI & HEADER
// Pastikan tidak ada parameter pencarian di PageHeader

// 2. SETUP ISI FORM
$btnBatal  = buttonhref("index.php?pg=kpegawai&fl=list", "Batal", "light border text-muted px-4", "", "");
$btnSimpan = button("simpan_data", "Simpan Pegawai", "primary px-4 shadow", "save", "style='background-color: var(--accent); border:none;'");

// B. Susun HTML Form
$formContent = <<<HTML
<form action="" method="POST">
    <div class="d-flex flex-column gap-4">
        
        <div>
            <label class="form-label small fw-bold text-secondary text-uppercase ls-wide mb-2">Nama Lengkap</label>
            <div class="input-group border rounded-3 overflow-hidden shadow-sm bg-light">
                <span class="input-group-text bg-transparent border-0 text-muted ps-3"><i data-lucide="user" style="width:18px"></i></span>
                <input type="text" name="nama" class="form-control bg-transparent border-0 shadow-none py-2" placeholder="Nama lengkap pegawai..." required autocomplete="off">
            </div>
        </div>

        <div>
            <label class="form-label small fw-bold text-secondary text-uppercase ls-wide mb-2">Username</label>
            <div class="input-group border rounded-3 overflow-hidden shadow-sm bg-light">
                <span class="input-group-text bg-transparent border-0 text-muted ps-3"><i data-lucide="user" style="width:18px"></i></span>
                <input type="text" name="username" class="form-control bg-transparent border-0 shadow-none py-2" placeholder="Masukkan username..." required autocomplete="off">
            </div>
        </div>

        <div>
            <label class="form-label small fw-bold text-secondary text-uppercase ls-wide mb-2">Buat Kata Sandi</label>
            <div class="input-group border rounded-3 overflow-hidden shadow-sm bg-light">
                <span class="input-group-text bg-transparent border-0 text-muted ps-3"><i data-lucide="lock" style="width:18px"></i></span>
                <input type="text" name="sandi" class="form-control bg-transparent border-0 shadow-none py-2" placeholder="Masukkan kata sandi..." required>
            </div>
            <div class="form-text small mt-2 text-muted">
                <i data-lucide="info" style="width:12px" class="me-1"></i>
                Untuk mengubah menjadi Admin, gunakan menu <i>Kelola Pengelola</i> setelah data disimpan.
            </div>
        </div>

        <div class="mt-4 pt-3 border-top d-flex flex-column flex-sm-row justify-content-end gap-2">
            $btnBatal
            $btnSimpan
        </div>

    </div>
</form>
HTML;

// 3. TAMPILKAN FORM
echo '<div class="row justify-content-center">';
echo '  <div class="col-12 col-md-8 col-lg-6">';
            PageContentForm($formContent);
echo '  </div>';
echo '</div>';
?>

<script>
    // Hanya memuat icon, tanpa script search
    lucide.createIcons();
</script>
