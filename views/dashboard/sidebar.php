<?php
$pg = $_GET['pg'] ?? '';
$fl = $_GET['fl'] ?? '';

// Tentukan judul yang tampil di Sidebar Brand
$judul_tampil = isset($AppNameShort) ? $AppNameShort : "Management Aset";
?>

<aside id="sidebar">
    <div class="sidebar-header">
       <div>
            <img src="assets/img/logo.png" alt="Logo" width="42" height="42">
        </div>
        <span class="brand-text fw-bold"><?php echo $judul_tampil; ?></span>
    </div>

    <div class="d-flex flex-column flex-grow-1 overflow-auto custom-scrollbar">
        
        <a href="index.php?pg=&fl=" class="nav-link-custom <?php echo ($pg == '' || $pg == 'beranda') ? 'active' : ''; ?>">
            <i data-lucide="house"></i> Beranda
        </a>

        <?php include('menu/adm_instansi.php') ?>
        <?php include('menu/adm_aset.php') ?>
        <?php include('menu/staf_aset.php') ?>
        <?php include('menu/teknisi.php') ?>
        
    </div>
</aside>