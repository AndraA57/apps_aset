<?php
// Ambil ID dari URL
$id = $_GET['id'] ?? '';

// Ambil data pegawai dari database
$query = mysqli_query($koneksi, "SELECT * FROM pegawai WHERE IdPegawai = '$id'");
$d = mysqli_fetch_assoc($query);

if (!$d) {
    echo "<div class='alert alert-danger m-4'>Data pegawai tidak ditemukan!</div>";
    exit;
}
?>

<div class="content-wrapper p-4">
    <div class="d-flex justify-content-start mb-3" style="margin-top: -15px;">
        <a href="index.php?pegawai" class="btn btn-white btn-sm border rounded-3 shadow-sm px-3 d-inline-flex align-items-center gap-2">
            <i data-lucide="arrow-left" size="14"></i> 
            <span style="font-size: 13px;" class="fw-bold">Kembali ke Daftar</span>
        </a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-premium overflow-hidden shadow-sm border-0 rounded-4 bg-white">
                <div class="p-4 border-bottom bg-light bg-opacity-50">
                    <h6 class="fw-800 mb-1 text-dark">Form Edit Data Pegawai</h6>
                    <p class="text-muted small mb-0">Perbarui informasi detail pegawai pada formulir di bawah ini.</p>
                </div>

                <div class="card-body p-4 p-md-5">
                    <div class="mx-auto" style="max-width: 800px;">
                        <form action="pages/adm_instansi/proses_edit.php" method="POST">
                            <input type="hidden" name="IdPegawai" value="<?= $d['IdPegawai']; ?>">

                            <div class="d-flex flex-column gap-4">
                                
                                <div>
                                    <label class="form-label small fw-bold text-muted text-uppercase ls-wide">Nama Lengkap</label>
                                    <div class="input-group border rounded-3 overflow-hidden bg-light focus-ring">
                                        <span class="input-group-text bg-transparent border-0 text-muted ps-3">
                                            <i data-lucide="user" size="18"></i>
                                        </span>
                                        <input type="text" name="nama" class="form-control bg-transparent border-0 shadow-none py-2" 
                                               value="<?= $d['Nama']; ?>" placeholder="Masukkan nama lengkap..." required>
                                    </div>
                                </div>

                                <div>
                                    <label class="form-label small fw-bold text-muted text-uppercase ls-wide">role / Role</label>
                                    <div class="input-group border rounded-3 overflow-hidden bg-light">
                                        <span class="input-group-text bg-transparent border-0 text-muted ps-3">
                                            <i data-lucide="shield-check" size="18"></i>
                                        </span>
                                        <select name="role" class="form-select bg-transparent border-0 shadow-none py-2" required>
                                            <option value="" disabled>Pilih role...</option>
                                            <option value="Admin" <?= ($d['role'] == 'Admin') ? 'selected' : ''; ?>>Administrator</option>
                                            <option value="Staff" <?= ($d['role'] == 'Staff') ? 'selected' : ''; ?>>Staff Instansi</option>
                                            <option value="Teknisi" <?= ($d['role'] == 'Teknisi') ? 'selected' : ''; ?>>Teknisi</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mt-4 pt-4 border-top d-flex flex-column flex-sm-row justify-content-end gap-3">
                                    <a href="index.php?pegawai" class="btn btn-light px-4 rounded-3 fw-bold text-muted border py-2">Batal</a>
                                    <button type="submit" name="update" class="btn btn-primary px-5 rounded-3 fw-bold d-flex align-items-center justify-content-center gap-2 py-2" style="background-color: #0d6efd; border: none;">
                                        <i data-lucide="save" size="18"></i> Simpan Perubahan
                                    </button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>lucide.createIcons();</script>