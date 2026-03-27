<?php
include_once 'cores/component.php'; 

$id_pegawai = $_SESSION['id'] ?? '';
if(!$id_pegawai) {
    echo "<div class='alert alert-danger'>Data profil tidak ditemukan.</div>";
    exit;
}

$koneksi = mysqli_connect("localhost", "root", "", "db_asset");

// Ensure foto column exists
$check_col = mysqli_query($koneksi, "SHOW COLUMNS FROM pegawai LIKE 'foto'");
if(mysqli_num_rows($check_col) == 0) {
    mysqli_query($koneksi, "ALTER TABLE pegawai ADD COLUMN foto VARCHAR(255) DEFAULT ''");
}

if(isset($_POST['update_profil'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $role = mysqli_real_escape_string($koneksi, $_POST['role']);
    
    $foto_update = "";
    if(!empty($_FILES['foto']['name'])) {
        $foto = time() . '_' . str_replace(" ", "_", $_FILES['foto']['name']);
        if (!is_dir("assets/img/pegawai")) {
            mkdir("assets/img/pegawai", 0777, true);
        }
        if(move_uploaded_file($_FILES['foto']['tmp_name'], "assets/img/pegawai/$foto")) {
            $foto_update = ", foto='$foto'";
            
            $q_foto_lama = mysqli_query($koneksi, "SELECT foto FROM pegawai WHERE IdPegawai='$id_pegawai'");
            $foto_lama = mysqli_fetch_assoc($q_foto_lama)['foto'] ?? '';
            if(!empty($foto_lama) && file_exists("assets/img/pegawai/$foto_lama")) {
                unlink("assets/img/pegawai/$foto_lama");
            }
            $_SESSION['foto'] = $foto;
        }
    }

    if(!empty($_POST['password'])) {
        $pwd = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $qx = mysqli_query($koneksi, "UPDATE pegawai SET Nama='$nama', username='$username', Sandi='$pwd', role='$role' $foto_update WHERE IdPegawai='$id_pegawai'");
    } else {
        $qx = mysqli_query($koneksi, "UPDATE pegawai SET Nama='$nama', username='$username', role='$role' $foto_update WHERE IdPegawai='$id_pegawai'");
    }

    if($qx) {
        $_SESSION['nama'] = $nama;
        $_SESSION['role'] = $role;
        echo "<script>alert('Profil berhasil diperbarui!'); window.location='index.php?pg=user&fl=profile';</script>";
        exit;
    }
}

$q_prof = mysqli_query($koneksi, "SELECT * FROM pegawai WHERE IdPegawai='$id_pegawai'");
$profil = mysqli_fetch_assoc($q_prof);

$q_role = mysqli_query($koneksi, "SELECT DISTINCT role FROM pegawai WHERE role IS NOT NULL AND role != '' ORDER BY role ASC");
$role_options = "";
while($r = mysqli_fetch_assoc($q_role)) {
    $role_name = $r['role'];
    // Cek jika null maka value string kosong
    if(!$role_name) continue;
    $selected = (isset($profil['role']) && $profil['role'] == $role_name) ? "selected" : "";
    
    // Opsional: label lebih rapi misal 'Administrator' jadi 'Admin' jika user inginkan
    $lbl = $role_name == 'Administrator' ? 'Admin' : $role_name;
    
    $role_options .= "<option value=\"".htmlspecialchars($role_name)."\" {$selected}>".htmlspecialchars($lbl)."</option>";
}

$img_src = (!empty($profil['foto']) && file_exists('assets/img/pegawai/' . $profil['foto'])) 
    ? 'assets/img/pegawai/' . $profil['foto'] 
    : 'https://ui-avatars.com/api/?name=' . urlencode($profil['Nama']) . '&background=4f46e5&color=fff&size=150';

$btnKembali = buttonhref("index.php", "Kembali", "light border text-muted px-4", "arrow-left", "");

$formContent = <<<HTML
<form action="" method="POST" enctype="multipart/form-data">
    <div class="row g-4">
        <div class="col-12 col-md-4 text-center">
            <div class="mb-3 d-flex justify-content-center">
                <img src="{$img_src}" style="width: 150px; height: 150px; object-fit: cover;" class="rounded-circle border border-4 shadow-sm" alt="Profile">
            </div>
            
            <div class="mb-3 px-4">
                <label for="foto_profil" class="btn btn-sm btn-outline-primary w-100 rounded-pill fw-bold">Ganti Foto</label>
                <input type="file" name="foto" id="foto_profil" class="d-none" accept="image/*">
            </div>

            <h5 class="fw-bold mb-1">{$profil['Nama']}</h5>
            <p class="text-muted small text-uppercase fw-bold ls-wide">{$profil['role']}</p>
        </div>
        <div class="col-12 col-md-8 border-start-md">
            <h6 class="fw-bold mb-3 text-secondary border-bottom pb-2">Informasi Akun</h6>
            
            <div class="mb-3">
                <label class="form-label small fw-bold text-muted">Nama Lengkap</label>
                <div class="input-group text-muted">
                    <span class="input-group-text bg-light border text-muted"><i data-lucide="user" style="width: 18px;"></i></span>
                    <input type="text" name="nama" class="form-control" value="{$profil['Nama']}" required>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-6 mb-3">
                    <label class="form-label small fw-bold text-muted">Username</label>
                    <div class="input-group text-muted">
                        <span class="input-group-text bg-light border text-muted"><i data-lucide="at-sign" style="width: 18px;"></i></span>
                        <input type="text" name="username" class="form-control" value="{$profil['username']}" required>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label small fw-bold text-muted">Role</label>
                    <select name="role" class="form-select bg-light text-muted" required>
                        {$role_options}
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label small fw-bold text-muted">Password Baru</label>
                <div class="input-group text-muted">
                    <span class="input-group-text bg-light border text-muted"><i data-lucide="lock" style="width: 18px;"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah password">
                </div>
                <small class="text-muted" style="font-size: 0.70rem;">Masukkan sandi baru untuk mengganti persandian saat ini.</small>
            </div>
            
            <div class="mt-4 pt-3 border-top d-flex flex-column flex-sm-row justify-content-end gap-2">
                {$btnKembali}
                <button type="submit" name="update_profil" class="btn btn-primary px-4 fw-bold shadow-sm d-inline-flex align-items-center gap-2">
                    <i data-lucide="save" style="width: 18px;"></i> Simpan Perubahan
                </button>
            </div>
        </div>
    </div>
</form>
HTML;

echo '<div class="row justify-content-center">';
echo '  <div class="col-12 col-xl-10">';
PageHeader("Profil Pengguna", "Kelola informasi preferensi akun Anda di sini");
PageContentForm($formContent);
echo '  </div>';
echo '</div>';
?>
