<?php 
error_reporting(E_ALL);
session_start();

include("cores/database.php");
include("config.php");

// Cek apakah session 'status' sudah diset DAN tidak kosong
if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
    include('cores/component.php');
    
    // Load controller berdasarkan halaman yang diakses
    $pg = $_GET['pg'] ?? '';
    $controller_path = "controllers/pages/{$pg}.php";
    if ($pg != '' && $pg != 'logout' && file_exists($controller_path)) {
        include($controller_path);
    }
    
    include('views/dashboard.php');
    exit;
} else {
    // Load controller login untuk proses autentikasi
    include("controllers/login/login.php");
    include('views/login.php');
    exit;
}
?>