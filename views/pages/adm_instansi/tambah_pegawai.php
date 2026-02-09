<?php
// --- LOGIKA PROSES SIMPAN DATA ---
if (isset($_POST['simpan_data'])) {
// 1. Ambil data dari form
$nama   = htmlspecialchars($_POST['nama']);
$sandi  = $_POST['sandi']; // Sesuai kolom 'Sandi'
$role   = $_POST['role'];  // Sesuai kolom 'ROLE'
$gender = $_POST['gender']; // Sesuai kolom 'Gender'

// 2. Eksekusi Query Insert
// Kolom IdPegawai, Create_at, Update_at biasanya otomatis (Auto Increment / Current Timestamp)
// Jadi kita hanya memasukkan: Nama, Sandi, ROLE, Gender
$query_sql = "INSERT INTO pegawai (Nama, Sandi, ROLE, Gender) 
                VALUES ('$nama', '$sandi', '$role', '$gender')";

$insert = mysqli_query($koneksi, $query_sql);

// 3. Cek Keberhasilan
if ($insert) {
    echo "<script>
            alert('Berhasil! Pegawai baru telah ditambahkan.');
            window.location='index.php?pegawai';
            </script>";
} else {
    echo "<script>
            alert('Gagal! Terjadi kesalahan: " . mysqli_error($koneksi) . "');
            </script>";
}
}
?>

<div class="content-wrapper p-4">
<div class="d-flex justify-content-start mb-4" style="margin-top: -10px;">
    <a href="index.php?pegawai" class="btn btn-white btn-sm border-0 bg-white shadow-sm px-3 rounded-pill d-inline-flex align-items-center gap-2 text-secondary hover-scale">
        <i data-lucide="arrow-left" size="16"></i> 
        <span class="fw-bold small">Kembali</span>
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-lg-10 col-xl-9">
        <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
            
            <div class="p-4 px-md-5 border-bottom">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-primary bg-opacity-10 p-2 rounded-3 text-primary" style="color: var(--accent) !important; background-color: rgba(var(--accent-rgb), 0.1) !important;">
                        <i data-lucide="user-plus" size="24"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1 text-dark">Tambah Pegawai Baru</h5>
                        <p class="text-muted small mb-0">Lengkapi formulir di bawah ini.</p>
                    </div>
                </div>
            </div>

            <div class="card-body p-4 p-md-5">
                <form action="" method="POST"> 
                    <div class="d-flex flex-column gap-4">
                        
                        <div>
                            <label class="form-label small fw-bold text-secondary text-uppercase ls-wide mb-2">Nama Lengkap</label>
                            <div class="input-group border rounded-3 overflow-hidden shadow-sm bg-light group-hover-border">
                                <span class="input-group-text bg-transparent border-0 text-muted ps-3">
                                    <i data-lucide="user" size="18"></i>
                                </span>
                                <input type="text" name="nama" class="form-control bg-transparent border-0 shadow-none py-2" placeholder="Masukkan nama lengkap..." required>
                            </div>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-secondary text-uppercase ls-wide mb-2">Jenis Kelamin</label>
                                <div class="input-group border rounded-3 overflow-hidden shadow-sm bg-light group-hover-border">
                                    <span class="input-group-text bg-transparent border-0 text-muted ps-3">
                                        <i data-lucide="users" size="18"></i>
                                    </span>
                                    <select name="gender" class="form-select bg-transparent border-0 shadow-none py-2 cursor-pointer" required>
                                        <option value="" selected disabled>Pilih Gender...</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-secondary text-uppercase ls-wide mb-2">Kata Sandi</label>
                                <div class="input-group border rounded-3 overflow-hidden shadow-sm bg-light group-hover-border">
                                    <span class="input-group-text bg-transparent border-0 text-muted ps-3">
                                        <i data-lucide="lock" size="18"></i>
                                    </span>
                                    <input type="password" name="sandi" class="form-control bg-transparent border-0 shadow-none py-2" placeholder="••••••••" required>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="form-label small fw-bold text-secondary text-uppercase ls-wide mb-2">Role / Hak Akses</label>
                            <div class="input-group border rounded-3 overflow-hidden shadow-sm bg-light group-hover-border">
                                <span class="input-group-text bg-transparent border-0 text-muted ps-3">
                                    <i data-lucide="shield-check" size="18"></i>
                                </span>
                                <select name="role" class="form-select bg-transparent border-0 shadow-none py-2 cursor-pointer" required>
                                    <option value="" selected disabled>Pilih Level Akses...</option>
                                    <option value="Admin">Administrator</option>
                                    <option value="Staff">Staff</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top d-flex flex-column flex-sm-row justify-content-end gap-2">
                            <a href="index.php?pegawai" class="btn btn-light px-4 rounded-3 fw-semibold text-muted border">
                                Batal
                            </a>
                            <button type="submit" name="simpan_data" class="btn btn-primary px-4 rounded-3 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2" style="background-color: var(--accent); border: none;">
                                <i data-lucide="save" size="18"></i> Simpan Data
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<script>lucide.createIcons();</script>