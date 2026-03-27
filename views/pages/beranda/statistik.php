<?php
$q_aset = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM aset WHERE id_aset NOT IN (SELECT id_aset FROM penghapusan)");
$total_aset = mysqli_fetch_assoc($q_aset)['total'] ?? 0;

$q_baik = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM aset WHERE kondisi='Baik' AND id_aset NOT IN (SELECT id_aset FROM penghapusan)");
$aset_baik = mysqli_fetch_assoc($q_baik)['total'] ?? 0;

$q_hapus = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM penghapusan");
$total_hapus = mysqli_fetch_assoc($q_hapus)['total'] ?? 0;

$q_pegawai = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM pegawai");
$total_pegawai = mysqli_fetch_assoc($q_pegawai)['total'] ?? 0;
?>
<div class="row g-4 mb-5">
        <div class="col-md-6 col-xl-3">
            <div class="card-premium">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="stat-icon-wrapper bg-soft-primary">
                        <i data-lucide="package"></i>
                    </div>
                </div>
                <div>
                    <p class="text-muted small fw-bold mb-1 text-uppercase ls-wide">Total Aset</p>
                    <h3 class="fw-800 mb-0"><?= $total_aset ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card-premium">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="stat-icon-wrapper bg-soft-success">
                        <i data-lucide="check-circle"></i>
                    </div>
                </div>
                <div>
                    <p class="text-muted small fw-bold mb-1 text-uppercase ls-wide">Kondisi Baik</p>
                    <h3 class="fw-800 mb-0"><?= $aset_baik ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card-premium">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="stat-icon-wrapper bg-soft-danger">
                        <i data-lucide="trash-2"></i>
                    </div>
                </div>
                <div>
                    <p class="text-muted small fw-bold mb-1 text-uppercase ls-wide">Aset Dihapus</p>
                    <h3 class="fw-800 mb-0"><?= $total_hapus ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card-premium border-0 position-relative overflow-hidden" style="background: var(--accent);">
                <div class="position-absolute top-0 end-0 bg-white opacity-10 rounded-circle" style="width: 100px; height: 100px; transform: translate(30%, -30%);"></div>
                
                <div class="d-flex align-items-center justify-content-between mb-4 position-relative">
                    <div class="stat-icon-wrapper bg-white bg-opacity-25 text-white">
                        <i data-lucide="users"></i>
                    </div>
                </div>
                <div class="position-relative">
                    <p class="text-white text-opacity-75 small fw-bold mb-1 text-uppercase ls-wide">Total Pegawai</p>
                    <h3 class="fw-800 mb-0 text-white"><?= $total_pegawai ?></h3>
                </div>
            </div>
        </div>
    </div>
