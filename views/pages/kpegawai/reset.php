<?php
// ==========================================================
// 1. AMBIL DATA PEGAWAI BERDASARKAN ID
// ==========================================================
if (!isset($_GET['id'])) {
    echo "<script>alert('ID Pegawai tidak ditemukan!'); window.location='index.php?pg=kpegawai&fl=list';</script>";
    exit;
}

$id_edit = mysqli_real_escape_string($koneksi, $_GET['id']);
$query_get = mysqli_query($koneksi, "SELECT * FROM pegawai WHERE IdPegawai='$id_edit'");
$data = mysqli_fetch_assoc($query_get);

if (!$data) {
    echo "<script>alert('Data pegawai tidak ditemukan!'); window.location='index.php?pg=kpegawai&fl=list';</script>";
    exit;
}

$nama_pegawai = $data['Nama'];
$role_pegawai = strtoupper($data['role'] == 'adm_aset' ? 'Admin Aset' : $data['role']);

// ==========================================================
// 2. LOGIKA SIMPAN PASSWORD BARU
// ==========================================================
if (isset($_POST['simpan_password'])) {
    $pass_baru = $_POST['password_baru']; 
    
    if (!empty($pass_baru)) {
        // Enkripsi password baru
        $password_hash = password_hash($pass_baru, PASSWORD_DEFAULT); 
        
        $query_update = "UPDATE pegawai SET Sandi='$password_hash' WHERE IdPegawai='$id_edit'";
        
        if (mysqli_query($koneksi, $query_update)) {
            echo "<script>
                    alert('Berhasil! Password untuk $nama_pegawai telah diperbarui.'); 
                    window.location='index.php?pg=kpegawai&fl=list';
                  </script>";
            exit;
        } else {
            echo "<script>alert('Gagal menyimpan password: " . mysqli_error($koneksi) . "');</script>";
        }
    }
}

// ==========================================================
// 3. SETUP TAMPILAN (FRONTEND)
// ==========================================================

// Header Halaman
$btnKembali = buttonhref("index.php?pg=kpegawai&fl=list", "Kembali", "light border shadow-sm text-muted", "arrow-left");
PageHeader("Reset Password", "Buat dan cetak ulang kata sandi baru untuk pegawai.", $btnKembali);

?>

<style>
    #print-area { display: none; }
    
    @media print {
        /* Sembunyikan semua elemen di layar utama saat print */
        body * { visibility: hidden; }
        
        /* Tampilkan HANYA area print */
        #print-area, #print-area * { visibility: visible; }
        #print-area { 
            display: block !important; 
            position: absolute; 
            left: 50%; top: 50%; 
            transform: translate(-50%, -50%); 
            width: 350px; 
            border: 2px dashed #000; 
            padding: 25px; 
            font-family: 'Courier New', Courier, monospace;
            background-color: white;
        }
        /* Sembunyikan navbar/sidebar jika ada class khusus cetak */
        .no-print { display: none !important; }
    }
</style>

<div class="row justify-content-center no-print">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-4 p-md-5">
                
                <div class="d-flex align-items-center gap-3 mb-4 p-3 bg-light rounded-3 border">
                    <div class="bg-white rounded-circle d-flex align-items-center justify-content-center text-primary shadow-sm" style="width: 50px; height:50px;">
                        <i data-lucide="user" style="width:24px"></i>
                    </div>
                    <div>
                        <h5 class="mb-1 fw-bold text-dark"><?php echo htmlspecialchars($nama_pegawai); ?></h5>
                        <span class="badge bg-secondary bg-opacity-10 text-secondary border fw-semibold">
                            Role: <?php echo $role_pegawai; ?>
                        </span>
                    </div>
                </div>

                <hr class="border-dashed opacity-25 my-4">

                <form method="POST">
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark d-flex align-items-center gap-2 mb-3">
                            <i data-lucide="key" class="text-warning" style="width:18px"></i> Reset Password
                        </label>
                        
                        <div class="input-group shadow-sm rounded-3 overflow-hidden">
                            <input type="text" class="form-control form-control-lg bg-light border-warning border-opacity-50 fw-bold text-center" 
                                   id="auto_password" name="password_baru" 
                                   style="letter-spacing: 3px; font-family: monospace; font-size: 1.25rem;">
                            
                            <button class="btn btn-warning text-dark fw-bold px-4" type="button" onclick="generatePassword()" title="Buat Sandi Acak">
                                <i data-lucide="refresh-cw" style="width:18px"></i>
                            </button>
                            
                            <button class="btn btn-dark fw-bold px-4 d-flex align-items-center gap-2" type="button" onclick="printPassword()" title="Cetak Sandi">
                                <i data-lucide="printer" style="width:18px"></i> <span class="d-none d-sm-inline">Cetak</span>
                            </button>
                        </div>
                        <div class="form-text small mt-2 text-muted">
                            <i data-lucide="info" style="width:12px" class="me-1"></i> Klik generate, cetak (opsional), lalu simpan perubahan.
                        </div>
                    </div>

                    <button type="submit" name="simpan_password" class="btn btn-primary w-100 py-3 fw-bold rounded-3 shadow" style="background-color: var(--accent); border:none;">
                        <i data-lucide="save" style="width: 18px;" class="me-2"></i> Simpan Password Baru
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>

<div id="print-area">
    <div style="text-align: center; border-bottom: 2px solid #000; padding-bottom: 15px; margin-bottom: 20px;">
        <h2 style="margin: 0; font-size: 20px; font-weight: bold; text-transform: uppercase;">Akses Sistem</h2>
        <p style="margin: 5px 0 0 0; font-size: 12px;">Simpan informasi ini dengan aman</p>
    </div>
    
    <div style="margin-bottom: 20px; font-size: 14px; line-height: 1.6;">
        <table style="width: 100%;">
            <tr>
                <td style="width: 30%; font-weight: bold;">Nama</td>
                <td style="width: 5%;">:</td>
                <td style="width: 65%;"><?php echo htmlspecialchars($nama_pegawai); ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Role</td>
                <td>:</td>
                <td><?php echo $role_pegawai; ?></td>
            </tr>
        </table>
    </div>
    
    <div style="background: #f8f9fa; padding: 15px; text-align: center; border: 1px dashed #000; border-radius: 5px;">
        <div style="font-size: 12px; margin-bottom: 5px; color: #555;">KATA SANDI BARU:</div>
        <strong style="font-size: 24px; letter-spacing: 4px; color: #000;" id="print_pass_value">XXXXXX</strong>
    </div>
    
    <div style="text-align: center; margin-top: 20px; font-size: 10px; color: #666;">
        Dicetak pada: <?php echo date('d-m-Y H:i'); ?>
    </div>
</div>

<script>
    lucide.createIcons();

    // Fungsi Membuat Password Acak
    function generatePassword() {
        const chars = "ABCDEFGHJKLMNPQRSTUVWXYZ23456789"; // Tanpa O, 0, 1, I agar tidak bingung
        let password = "";
        for (let i = 0; i < 6; i++) {
            password += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        
        // Masukkan ke input form
        document.getElementById('auto_password').value = password;
        
        // Masukkan ke area cetak
        document.getElementById('print_pass_value').innerText = password;
    }

    // Fungsi Cetak
    function printPassword() {
        const passVal = document.getElementById('auto_password').value;
        if (!passVal) {
            alert("Silakan klik tombol Generate terlebih dahulu sebelum mencetak!");
            return;
        }
        // Buka dialog print browser
        window.print();
    }
</script>
