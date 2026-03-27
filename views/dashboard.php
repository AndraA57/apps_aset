<?php 
    $pg = $_GET['pg'] ?? '';
    $fl = $_GET['fl'] ?? '';
    $ak = $_GET['ak'] ?? '';

    // Logika Logout
    if($pg == 'logout'){
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
    <link rel="icon" href="assets/img/logo.png" type="image/png">
    <title><?= isset($AppName) ? $AppName : "Management Aset" ?></title>
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
                if ($pg == '' && $fl == '') {
                    include('pages/beranda.php');
                } else if ($pg == '' && $fl != '') {
                    include('pages/'.$fl.'.php');
                } else {
                    $file_path = 'pages/' . $pg . '/' . $fl . '.php';
                    if (file_exists('views/' . $file_path)) {
                        include($file_path);
                    } else {
                        echo "<div class='alert alert-danger'>Halaman tidak ditemukan.</div>";
                    }
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