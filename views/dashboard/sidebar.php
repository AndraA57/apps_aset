<?php
// Mengambil kunci pertama dari URL (seperti 'pegawai' dari ?pegawai)
$keys = array_keys($_GET);
$page_aktif = $keys[0] ?? 'beranda';

// Tentukan judul yang tampil di Sidebar Brand
$judul_tampil = isset($judul) ? $judul : "Pasundan Aset";
?>

<aside id="sidebar">
    <div class="sidebar-header">
        <div class="brand-logo">
            <img src="assets/img/pass.svg" alt="Logo" width="32" height="32">
        </div>
        <span class="brand-text fw-bold"><?php echo $judul_tampil; ?></span>
    </div>

    <div class="d-flex flex-column flex-grow-1 overflow-auto custom-scrollbar">
        
        <a href="index.php?beranda" class="nav-link-custom <?php echo ($page_aktif == 'beranda') ? 'active' : ''; ?>">
            <i data-lucide="house"></i> Beranda
        </a>

        <?php include('menu/adm_instansi.php') ?>
        <?php include('menu/adm_aset.php') ?>
        <?php include('menu/staf_aset.php') ?>
        <?php include('menu/teknisi.php') ?>
        
    </div>

    <div class="sidebar-footer border-top p-3">
        <a href="index.php?logout" class="nav-link-custom text-danger border-0">
            <i data-lucide="log-out"></i> Keluar
        </a>
    </div>
</aside>