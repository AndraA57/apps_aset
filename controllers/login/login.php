<?php
// Controller Login
// Memproses logika autentikasi pengguna

$error_msg = ""; // Variable penampung error

if(isset($_POST['tombol'])){
    // 1. Ambil input dari form
    $input_user  = mysqli_real_escape_string($koneksi, $_POST['user']);
    $input_sandi = $_POST['pwd'];

    // 2. Cek ke database dengan username
    $query = "SELECT * FROM pegawai WHERE username='$input_user'";
    $hasil = mysqli_query($koneksi, $query);

    // 3. Jika ketemu datanya
    if(mysqli_num_rows($hasil) > 0){
        $data = mysqli_fetch_assoc($hasil);
        
        // Verifikasi password hash
        if(password_verify($input_sandi, $data['Sandi'])) {
            // Simpan sesi login
            $_SESSION['status'] = 'OKE';
            $_SESSION['id']     = $data['IdPegawai'];
            $_SESSION['nama']   = $data['Nama'];
            $_SESSION['role']   = $data['role'];
            $_SESSION['foto']   = isset($data['foto']) ? $data['foto'] : '';

            // Redirect ke halaman utama
            header("Location: index.php");
            exit();
        } else {
            $error_msg = "Nama atau Password yang Anda masukkan salah!";
        }
    } else {
        $error_msg = "Nama atau Password yang Anda masukkan salah!";
    }
}
?>
