<?php 
    // Mengambil kunci pertama dari URL (misal: 'pegawai' dari index.php?pegawai)
    $keys = array_keys($_GET);
    $page = $keys[0] ?? 'beranda';

    // Logika Logout
    if($page == 'logout'){
        session_destroy();
        header('Location:index.php');
        exit;
    }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/img/pass.svg" type="image/png">
    <title>Pasundan Aset</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <?php include('dashboard/sidebar.php') ?>

    <div class="main-content">
        
        <?php include('dashboard/header.php') ?>

        <div class="p-4 p-lg-5">
            <?php 
                // Routing berdasarkan parameter key (?halaman)
                switch($page) {
                    // --- ADMIN INSTANSI ---
                    case 'pegawai':
                        $judul = "Daftar Pegawai";
                        include('pages/adm_instansi/kpegawai.php');
                        break;
                    case 'tambah_pegawai':
                        $judul = "Tambah Pegawai Baru";
                        include('pages/adm_instansi/tambah_pegawai.php');
                        break;
                    case 'pengelola':
                        $judul = "Daftar Pengelola Aset";
                        include('pages/adm_instansi/pengelola.php');
                        break;
                    case 'tambah_pengelola':
                        $judul = "Daftar Pengelola Aset";
                        include('pages/adm_instansi/tambah_pengelola.php');
                        break;
                    case 'edit_pegawai':
                        $judul = "Edit Data Pegawai";
                        include('pages/adm_instansi/edit_pegawai.php'); // Pastikan file ini ada
                        break;

                    // --- ADMIN ASET ---
                    case 'aset':
                        $judul = "Kelola Aset";
                        include('pages/adm_aset/aset.php');
                        break;
                    case 'serah_terima':
                        $judul = "Berita Acara Serah Terima";
                        include('pages/adm_aset/serah_terima.php');
                        break;
                    case 'penghapusan':
                        $judul = "Penghapusan Aset";
                        include('pages/adm_aset/penghapusan.php');
                        break;

                    // --- STAF ASET ---
                    case 'peminjaman':
                        $judul = "Peminjaman Aset";
                        include('pages/staf_aset/peminjaman.php');
                        break;
                    case 'pengembalian':
                        $judul = "Pengembalian Aset";
                        include('pages/staf_aset/pengembalian.php');
                        break;

                    // --- TEKNISI ---
                    case 'maintenance':
                        $judul = "Pemeliharaan Rutin";
                        include('pages/teknisi/maintenance.php');
                        break;
                    case 'perbaikan':
                        $judul = "Perbaikan Aset";
                        include('pages/teknisi/perbaikan.php');
                        break;

                    // --- DEFAULT / BERANDA ---
                    case 'beranda':
                    default:
                        $judul = "Dashboard Utama";
                        include('pages/beranda.php');
                        break;
                }
            ?>
        </div>
    </div> 

    <script src="assets/js/dashboard.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>