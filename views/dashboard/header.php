<?php
$pg = $_GET['pg'] ?? '';
$fl = $_GET['fl'] ?? '';

// Daftar judul yang sama agar konsisten
$daftar_judul = [
    'beranda'        => 'Nexus Core',
    'kpegawai'       => 'Kelola Pegawai',
    'kpengelola'     => 'Pengelola Aset',
    'kaset'          => 'Kelola Aset',
    'kserte'         => 'Serah Terima Aset',
    'kpeminjaman'    => 'Peminjaman',
    'khapus'         => 'Penghapusan Aset',
    'kpengembalian'  => 'Pengembalian',
    'maintenance'    => 'Pemeliharaan',
    'perbaikan'      => 'Perbaikan',
    'kkategori'      => 'Kelola Kategori',
    'klokasi'        => 'Lokasi'
];

// Tentukan judul untuk header berdasarkan pg (atau fl jika staf/teknisi)
$judul_key = ($pg == 'staf_aset' || $pg == 'teknisi') ? $fl : $pg;
if ($judul_key == '') $judul_key = 'beranda';

$judul_header = $daftar_judul[$judul_key] ?? "Dashboard";
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
        
        <div class="dropdown">
            <div class="d-flex align-items-center gap-3 cursor-pointer" data-bs-toggle="dropdown">
                <div class="text-end d-none d-sm-block">
                    <p class="mb-0 fw-bold small">
                        <?php echo isset($_SESSION['nama']) ? $_SESSION['nama'] : 'Guest'; ?>
                    </p>
                    <p class="mb-0 text-muted text-uppercase fw-bold" style="font-size: 0.6rem; letter-spacing: 0.5px;">
                        <?php echo isset($_SESSION['role']) ? $_SESSION['role'] : 'User'; ?>
                    </p>
                </div>
                <?php
                if (!empty($_SESSION['foto']) && file_exists('assets/img/pegawai/' . $_SESSION['foto'])) {
                    $img_src = 'assets/img/pegawai/' . $_SESSION['foto'];
                } else {
                    $img_src = 'https://ui-avatars.com/api/?name=' . urlencode($_SESSION['nama'] ?? 'User') . '&background=4f46e5&color=fff';
                }
                ?>
                <img src="<?php echo $img_src; ?>" 
                     width="40" height="40" class="rounded-circle border border-2 border-white shadow-sm" style="object-fit: cover;">
                </div>

            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                <li><a class="dropdown-item py-2" href="index.php?pg=user&fl=profile"><i data-lucide="user" style="width: 16px;" class="me-2 text-muted"></i>Profil Saya</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item py-2 text-danger" href="index.php?pg=logout"><i data-lucide="log-out" style="width: 16px;" class="me-2"></i> Logout</a></li>
            </ul>
        </div>
    </div>
</header>