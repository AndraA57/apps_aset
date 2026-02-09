<?php 
session_start();

require_once 'config/koneksi.php';

// Cek apakah session 'status' sudah diset DAN tidak kosong
if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
    include('views/dashboard.php');
    exit;
} else {
    include('views/login.php');
    exit;
}
?>