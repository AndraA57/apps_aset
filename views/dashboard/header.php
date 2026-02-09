<?php
// Samakan logika dengan sidebar.php
$keys = array_keys($_GET);
$page_aktif = $keys[0] ?? 'beranda';

// Daftar judul yang sama agar konsisten
$daftar_judul = [
    'beranda'        => 'Nexus Core',
    'pegawai'        => 'Kelola Pegawai',
    'tambah_pegawai' => 'Tambah Pegawai',
    'editpegawai'    => 'Edit Data Pegawai',
    'pengelola'      => 'Pengelola Aset',
    'aset'           => 'Kelola Aset',
    'serah_terima'   => 'Serah Terima Aset',
    'peminjaman'     => 'Peminjaman',
    'penghapusan'    => 'Penghapusan Aset',
    'pengembalian'   => 'Pengembalian',
    'maintenance'    => 'Pemeliharaan',
    'perbaikan'      => 'Perbaikan'
];

// Tentukan judul untuk header
$judul_header = $daftar_judul[$page_aktif] ?? "Nexus Core";
?>

<header class="d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center gap-3">
        <button class="btn btn-light border d-lg-none" id="mobileToggle">
            <i data-lucide="menu"></i>
        </button>
        <div class="d-none d-md-block">
            <div class="text-muted small fw-bold text-uppercase ls-wide" style="font-size: 10px; letter-spacing: 1px;">
                Pages / <?php echo $judul_header; ?>
            </div>
            <div class="fw-bold text-dark fs-5">
                <?php echo $judul_header; ?>
            </div>
        </div>
    </div>

    <div class="d-flex align-items-center gap-4">
        <div class="d-none d-md-block text-muted cursor-pointer hover-dark">
            <i data-lucide="search" size="20"></i>
        </div>
        
        <div class="position-relative cursor-pointer">
            <i data-lucide="bell" size="20" class="text-muted"></i>
            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
        </div>

        <div class="dropdown">
            <div class="d-flex align-items-center gap-3 cursor-pointer" data-bs-toggle="dropdown">
                <div class="text-end d-none d-sm-block">
                    <p class="mb-0 fw-bold small"><?php echo $_SESSION['nama'] ?? 'Alex Morgan'; ?></p>
                    <p class="mb-0 text-muted text-uppercase fw-bold" style="font-size: 0.6rem; letter-spacing: 0.5px;">
                        <?php echo $_SESSION['role'] ?? 'Super Admin'; ?>
                    </p>
                </div>
                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['nama'] ?? 'User'); ?>&background=4f46e5&color=fff" 
                     width="40" height="40" class="rounded-circle border border-2 border-white shadow-sm">
            </div>

            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                <li><a class="dropdown-item" href="index.php?logout"><i data-lucide="log-out" size="16"></i> Logout</a></li>
            </ul>
        </div>
    </div>
</header>