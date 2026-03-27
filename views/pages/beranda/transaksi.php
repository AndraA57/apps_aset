<?php
// Ambil data aset terbaru
$q_log = mysqli_query($koneksi, "SELECT * FROM aset ORDER BY id_aset DESC LIMIT 5");
error_reporting(E_ALL);
?>
<div class="card-premium p-0 overflow-hidden shadow-sm">
        <div class="p-4 border-bottom d-flex flex-wrap gap-3 justify-content-between align-items-center bg-white">
            <h6 class="fw-bold mb-0">Log Penambahan Aset</h6>
        </div>
        <div class="table-responsive">
            <table class="table table-premium mb-0 align-middle">
                <thead>
                    <tr>
                        <th class="ps-4">Kode Aset</th>
                        <th>Nama Aset</th>
                        <th>Kategori</th>
                        <th>Kondisi</th>
                        <th>Tgl Perolehan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($q_log) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($q_log)): ?>
                        <tr>
                            <td class="ps-4"><span class="fw-bold small text-dark"><?= htmlspecialchars($row['kode_aset']) ?></span></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center text-muted fw-bold" style="width:32px; height:32px; font-size: 0.7rem;"><i data-lucide="package" style="width: 14px;"></i></div>
                                    <div class="small fw-semibold"><?= htmlspecialchars($row['nama_aset']) ?></div>
                                </div>
                            </td>
                            <td><span class="badge-soft bg-soft-primary"><?= htmlspecialchars($row['kategori']) ?></span></td>
                            <td>
                                <?php
                                $badgeClass = 'bg-soft-success';
                                if($row['kondisi'] == 'Rusak Ringan') $badgeClass = 'bg-soft-warning';
                                if($row['kondisi'] == 'Rusak Berat') $badgeClass = 'bg-soft-danger';
                                ?>
                                <span class="badge-soft <?= $badgeClass ?>"><?= htmlspecialchars($row['kondisi']) ?></span>
                            </td>
                            <td><span class="text-muted small"><?= date('d M Y', strtotime($row['tgl_perolehan'])) ?></span></td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted small">Belum ada aset ditambahkan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="p-3 border-top text-center bg-light">
            <a href="index.php?pg=kaset&fl=list" class="text-decoration-none small fw-bold" style="color: var(--accent);">Lihat Semua Aset</a>
        </div>
    </div>
