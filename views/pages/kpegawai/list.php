<?php 
// ==========================================================
// LOGIKA BACKEND (PHP UTAMA)
// ==========================================================

// --- 1. LOGIKA HAPUS PEGAWAI ---
if(isset($_GET['hapus'])){
    $id_hapus = $_GET['hapus'];
    if(!empty($id_hapus)){
        $query_hapus = "DELETE FROM pegawai WHERE IdPegawai='$id_hapus'";
        $hapus = mysqli_query($koneksi, $query_hapus);
        if($hapus){
            echo "<script>alert('Data pegawai berhasil dihapus.'); window.location='index.php?pg=kpegawai&fl=list';</script>";
            exit();
        } else {
            echo "<script>alert('Gagal menghapus: ".mysqli_error($koneksi)."');</script>";
        }
    }
}

// 2. SETUP TABEL HEADER ($th)
$th = '
    <th class="ps-4 py-3 text-muted small fw-bold text-uppercase border-0">ID</th>
    <th class="py-3 text-muted small fw-bold text-uppercase border-0">Nama Lengkap</th>
    <th class="py-3 text-muted small fw-bold text-uppercase border-0 text-center">Username</th>
    <th class="py-3 text-muted small fw-bold text-uppercase border-0 text-center">Role</th>
    <th class="py-3 text-muted small fw-bold text-uppercase border-0 text-center sticky-col">Aksi</th>
';

// 3. SETUP TABEL ROW ($tr)
$tr = "";
$query = mysqli_query($koneksi, "SELECT * FROM pegawai ORDER BY IdPegawai DESC");

if(mysqli_num_rows($query) > 0) {
    while($row = mysqli_fetch_assoc($query)) { 
        $id       = $row['IdPegawai'];
        $nama     = $row['Nama'];
        $role     = $row['role']; 
        $username = $row['username'];
        
        // Badge Role Logic
        $roleClass = 'bg-secondary';
        if($role == 'admin') $roleClass = 'bg-danger';
        elseif($role == 'adm_aset') $roleClass = 'bg-primary';
        elseif($role == 'staff') $roleClass = 'bg-success';
        elseif($role == 'teknisi') $roleClass = 'bg-warning text-dark';
        
        $roleBadge = "<span class='badge $roleClass bg-opacity-10 ".(strpos($roleClass, 'text-dark') ? 'text-dark' : 'text-'.explode('-',$roleClass)[1])." rounded-pill px-3 py-2'>".strtoupper($role == 'adm_aset' ? 'ADMIN ASET' : $role)."</span>";
        $usernameBadge = "<span class='badge bg-light text-dark border px-2 py-1'>$username</span>";

        // COMPONENT BUTTON UNTUK AKSI
        $btnEdit = "
            <a href='index.php?pg=kpegawai&fl=edit&id=$id' class='btn btn-sm btn-light text-primary border shadow-sm' title='Edit Data'>
                <i data-lucide='edit-3' style='width: 16px;'></i>
            </a>";

        $btnReset = "
            <a href='index.php?pg=kpegawai&fl=reset&id=$id' class='btn btn-sm btn-light text-warning border shadow-sm' title='Reset Password'>
                <i data-lucide='key' style='width: 16px;'></i>
            </a>";

        $btnHapus = "
            <a href='index.php?pg=kpegawai&fl=list&hapus=$id' class='btn btn-sm btn-light text-danger border shadow-sm' 
                onclick=\"return confirm('Yakin ingin menghapus pegawai ini?');\" title='Hapus'>
                <i data-lucide='trash-2' style='width: 16px;'></i>
            </a>";

        // Susun Baris
        $tr .= "
        <tr>
            <td class='ps-4'><span class='badge bg-light text-dark border fw-bold'>#$id</span></td>
            <td>
                <div class='d-flex align-items-center gap-3'>
                    <div class='bg-light rounded-circle d-flex align-items-center justify-content-center text-secondary' style='width: 32px; height:32px;'>
                        <i data-lucide='user' style='width:16px'></i>
                    </div>
                    <span class='fw-semibold text-dark nama-pegawai'>$nama</span>
                </div>
            </td>
            <td class='text-center'>$usernameBadge</td>
            <td class='text-center'>$roleBadge</td>
            <td class='text-center sticky-col'>
                <div class='d-flex gap-1 justify-content-center'>
                    $btnEdit
                    $btnReset
                    $btnHapus
                </div>
            </td>
        </tr>";
    }
} else {
    $tr = "<tr><td colspan='5' class='text-center py-5 text-muted small'>Belum ada data pegawai.</td></tr>";
}

// 4. SIAPKAN TOMBOL TAMBAH
$tombolTambah = buttonhref("index.php?pg=kpegawai&fl=form", "Tambah Pegawai", "primary", "plus", "style='background-color: var(--accent); border:none;'");

// 5. PANGGIL KOMPONEN PAGE HEADER 
// Tombol ditempatkan di sini agar muncul di atas/header
PageHeader("Manajemen Pegawai", "Kelola data pegawai perusahaan", $tombolTambah);

// 6. PANGGIL CONTENT TABEL
// Parameter ke-3 dikosongkan karena tombol sudah pindah ke header
PageContentTabel($th, $tr, "", "");
?>

<script>
    lucide.createIcons();
</script>
