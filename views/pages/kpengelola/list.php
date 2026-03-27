<?php
// ==========================================================
// 1. LOGIKA BACKEND (SIMPAN & UPDATE)
// ==========================================================

// A. SIMPAN DATA (ANGKAT JADI PENGELOLA)
if (isset($_POST['simpan_data'])) {
    $id_pegawai = $_POST['id_pegawai']; 
    $role       = $_POST['role'];       

    // 1. Update role di tabel pegawai
    $query_update = "UPDATE pegawai SET role='$role' WHERE IdPegawai='$id_pegawai'";
    $update = mysqli_query($koneksi, $query_update);

    if ($update) {
        // 2. Insert ke tabel pengelola_aset agar tercatat
        $query_insert = "INSERT INTO pengelola_aset (IdPegawai) VALUES ('$id_pegawai')";
        $insert = mysqli_query($koneksi, $query_insert);

        if ($insert) {
            echo "<script>
                    alert('Berhasil! Pegawai telah diangkat menjadi Pengelola.');
                    window.location='index.php?pg=kpengelola&fl=list';
                  </script>";
        } else {
            // Jika gagal insert ke pengelola_aset
            echo "<script>alert('Berhasil ubah role, tapi gagal menyimpan ke tabel pengelola_aset: " . mysqli_error($koneksi) . "');</script>";
        }
    } else {
        echo "<script>alert('Gagal mengubah role pegawai: " . mysqli_error($koneksi) . "');</script>";
    }
}

// B. CABUT AKSES (TURUN JADI BIASA)
if (isset($_GET['hapus_akses'])) {
    $id_hapus = $_GET['hapus_akses'];
    
    // 1. Reset role kembali ke 'user'
    $reset = mysqli_query($koneksi, "UPDATE pegawai SET role='user' WHERE IdPegawai='$id_hapus'");
    
    if($reset){
        // 2. Hapus data dari pengelola_aset karena sudah bukan pengelola lagi
        mysqli_query($koneksi, "DELETE FROM pengelola_aset WHERE IdPegawai='$id_hapus'");
        
        echo "<script>
                alert('Akses dicabut. Kembali menjadi pegawai biasa.');
                window.location='index.php?pg=kpengelola&fl=list';
              </script>";
    }
}

// ==========================================================
// 2. PERSIAPAN DATA (PREPARE VIEW)
// ==========================================================

// A. QUERY DATA
$query_pengelola = mysqli_query($koneksi, "SELECT * FROM pegawai WHERE role != 'user' AND role != '' AND role IS NOT NULL ORDER BY IdPegawai DESC");
$query_calon     = mysqli_query($koneksi, "SELECT IdPegawai, Nama FROM pegawai WHERE role = 'user' OR role = '' OR role IS NULL ORDER BY Nama ASC");

// B. GENERATE OPSI DROPDOWN PEGAWAI (UNTUK FORM KIRI)
$opsi_pegawai = "";
if(mysqli_num_rows($query_calon) > 0){
    while($p = mysqli_fetch_assoc($query_calon)) {
        $opsi_pegawai .= "<option value='{$p['IdPegawai']}'>{$p['Nama']}</option>";
    }
} else {
    $opsi_pegawai = "<option disabled>Semua pegawai sudah jadi pengelola</option>";
}

// C. GENERATE BARIS TABEL (UNTUK TABEL KANAN)
$tr_data = "";
if(mysqli_num_rows($query_pengelola) > 0) {
    while($row = mysqli_fetch_assoc($query_pengelola)) { 
        $id   = $row['IdPegawai'];
        $nama = $row['Nama'];
        $role = $row['role'];

        // Styling Badge Role
        $roleClass = 'bg-secondary';
        if($role == 'admin') $roleClass = 'bg-danger';
        elseif($role == 'admin_intansi') $roleClass = 'bg-primary';
        elseif($role == 'staff') $roleClass = 'bg-success';
        elseif($role == 'teknisi') $roleClass = 'bg-warning text-dark';
        
        $roleLabel = ($role == 'admin_intansi') ? "ADMIN ASET" : strtoupper($role);
        $textClass = (strpos($roleClass, 'text-dark') !== false) ? 'text-dark' : 'text-' . explode('-', $roleClass)[1];

        // COMPONENT BUTTON UNTUK AKSI (Sejajar & Konsisten)
        // Tombol Edit Akses
        $btnEdit = "
            <a href='index.php?pg=kpengelola&fl=edit&id=$id' class='btn btn-sm btn-light text-primary border shadow-sm' title='Edit Akses'>
                <i data-lucide='edit-3' style='width: 16px;'></i>
            </a>";

        // Tombol Cabut Akses (Hapus)
        $btnHapus = "
            <a href='index.php?pg=kpengelola&fl=list&hapus_akses=$id' class='btn btn-sm btn-light text-danger border shadow-sm' 
                onclick=\"return confirm('Cabut akses pengelola? Dia akan kembali menjadi pegawai biasa.');\" title='Cabut Akses'>
                <i data-lucide='user-minus' style='width: 16px;'></i>
            </a>";

        // Susun HTML Baris
        $tr_data .= <<<HTML
        <tr>
            <td class="ps-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar-sm bg-light text-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                        <i data-lucide="user-check" style="width:16px"></i>
                    </div>
                    <div>
                        <span class="fw-semibold text-dark nama-pegawai" data-original="$nama">$nama</span>
                        <div class="small text-muted" style="font-size: 10px;">ID: #$id</div>
                    </div>
                </div>
            </td>
            <td class="text-center">
                <span class="role-text badge $roleClass bg-opacity-10 $textClass rounded-pill px-3 py-2" style="font-size: 11px;">
                    $roleLabel
                </span>
            </td>
            <td class="text-center">
                <div class="d-flex gap-1 justify-content-center">
                    $btnEdit
                    $btnHapus
                </div>
            </td>
        </tr>
HTML;
    }
} else {
    $tr_data = "<tr><td colspan='3' class='text-center py-5 text-muted'>Belum ada pengelola.</td></tr>";
}

// ==========================================================
// 3. TAMPILAN HALAMAN
// ==========================================================

PageHeader("Kelola Pengelola", "Manajemen hak akses dan role administrator sistem.");

// B. KONTEN UTAMA (GRID SYSTEM)
echo '<div class="row g-4">';

    // --- KOLOM KIRI: FORM TAMBAH ---
    echo '<div class="col-lg-4">';
        
        $btnSimpan = button("simpan_data", "Simpan & Beri Akses", "primary w-100 mt-2 shadow-sm fw-bold", "save", "style='background-color: var(--accent); border:none;'");
        
        $formContent = <<<HTML
            <div class="d-flex align-items-center gap-2 mb-4 pb-3 border-bottom text-primary" style="color: var(--accent) !important;">
                <i data-lucide="user-plus" style="width:20px"></i>
                <h6 class="fw-bold mb-0 text-dark">Tambah Pengelola</h6>
            </div>

            <form action="" method="POST">
                <div class="d-flex flex-column gap-3">
                    <div>
                        <label class="form-label small fw-bold text-muted">Pilih Pengelola</label>
                        <div class="input-group border rounded-3 overflow-hidden bg-light">
                            <span class="input-group-text bg-transparent border-0 text-muted ps-3"><i data-lucide="user" style="width:16px"></i></span>
                            <select name="id_pegawai" class="form-select bg-transparent border-0 shadow-none cursor-pointer" required>
                                <option value="" selected disabled> Pilih Pegawai </option>
                                $opsi_pegawai
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="form-label small fw-bold text-muted">Berikan Hak Akses</label>
                        <div class="input-group border rounded-3 overflow-hidden bg-light">
                            <span class="input-group-text bg-transparent border-0 text-muted ps-3"><i data-lucide="shield" style="width:16px"></i></span>
                            <select name="role" class="form-select bg-transparent border-0 shadow-none cursor-pointer" required>
                                <option value="" selected disabled>Pilih Akses...</option>
                                <option value="admin_intansi">Admin Intansi</option>
                                <option value="staff">Staff</option>
                                <option value="teknisi">Teknisi</option>
                            </select>
                        </div>
                    </div>

                    $btnSimpan
                </div>
            </form>
HTML;
        PageContentForm($formContent);
    echo '</div>'; // End Col-4

    // --- KOLOM KANAN: TABEL PENGELOLA ---
    echo '<div class="col-lg-8">';
        
        $th = <<<HTML
            <th class="ps-4 py-3 text-muted small fw-bold border-0">NAMA PEGAWAI</th>
            <th class="py-3 text-muted small fw-bold border-0 text-center">ROLE</th>
            <th class="py-3 text-muted small fw-bold border-0 text-center" style="width: 120px;">AKSI</th>
HTML;
        
        // Slot footer tabel (ketnum) kita pakai untuk info jumlah
        $jumlah = mysqli_num_rows($query_pengelola);
        $ketnum = "<span class='small text-muted'>Total <b>$jumlah</b> pengguna khusus aktif.</span>";

        PageContentTabel($th, $tr_data, $ketnum, ""); // Parameter terakhir kosong karena belum ada pagination
    echo '</div>'; // End Col-8

echo '</div>'; // End Row
?>

<script>
    lucide.createIcons();
</script>