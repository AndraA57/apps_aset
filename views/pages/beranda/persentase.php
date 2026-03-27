<?php
$q_aset_all = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM aset WHERE id_aset NOT IN (SELECT id_aset FROM penghapusan)");
$total_aset_all = mysqli_fetch_assoc($q_aset_all)['total'] ?? 0;
$total_aset_all = $total_aset_all == 0 ? 1 : $total_aset_all; // prevent div by zero

$q_baik = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM aset WHERE kondisi='Baik' AND id_aset NOT IN (SELECT id_aset FROM penghapusan)");
$baik = mysqli_fetch_assoc($q_baik)['total'] ?? 0;
$pct_baik = round(($baik / $total_aset_all) * 100);

$q_rr = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM aset WHERE kondisi='Rusak Ringan' AND id_aset NOT IN (SELECT id_aset FROM penghapusan)");
$rr = mysqli_fetch_assoc($q_rr)['total'] ?? 0;
$pct_rr = round(($rr / $total_aset_all) * 100);

$q_rb = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM aset WHERE kondisi='Rusak Berat' AND id_aset NOT IN (SELECT id_aset FROM penghapusan)");
$rb = mysqli_fetch_assoc($q_rb)['total'] ?? 0;
$pct_rb = round(($rb / $total_aset_all) * 100);

// Event Terakhir (gabungan dari aset baru & penghapusan)
$events = [];
$q_ev1 = mysqli_query($koneksi, "SELECT 'aset_baru' as tipe, nama_aset as objek, tgl_perolehan as tgl FROM aset ORDER BY id_aset DESC LIMIT 2");
while($e = mysqli_fetch_assoc($q_ev1)) $events[] = $e;

$q_ev2 = mysqli_query($koneksi, "SELECT 'hapus' as tipe, id_aset as objek, tgl_hapus as tgl FROM penghapusan ORDER BY id_hapus DESC LIMIT 2");
while($e = mysqli_fetch_assoc($q_ev2)) $events[] = $e;

// Urutkan event terbaru (sementara disederhanakan)
usort($events, function($a, $b) {
    return strtotime($b['tgl']) - strtotime($a['tgl']);
});
$events = array_slice($events, 0, 3);
?>
<div class="row g-4 mb-5">
        <div class="col-lg-7">
            <div class="card-premium p-0 overflow-hidden">
                <div class="p-4 border-bottom d-flex justify-content-between align-items-center bg-white">
                    <h6 class="fw-bold mb-0">Persentase Kondisi Aset</h6>
                    <button class="btn btn-sm btn-light border"><i data-lucide="more-horizontal" size="16"></i></button>
                </div>
                <div class="p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="p-3 bg-light rounded-3 me-3 text-success"><i data-lucide="check-circle" size="24"></i></div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="fw-bold small">Kondisi Baik (<?= $baik ?> aset)</span>
                                <span class="fw-bold small"><?= $pct_baik ?>%</span>
                            </div>
                            <div class="progress" style="height: 8px; border-radius: 10px;">
                                <div class="progress-bar bg-success" style="width: <?= $pct_baik ?>%;"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-center mb-4">
                        <div class="p-3 bg-light rounded-3 me-3 text-warning"><i data-lucide="alert-triangle" size="24"></i></div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="fw-bold small">Rusak Ringan (<?= $rr ?> aset)</span>
                                <span class="fw-bold small"><?= $pct_rr ?>%</span>
                            </div>
                            <div class="progress" style="height: 8px; border-radius: 10px;">
                                <div class="progress-bar bg-warning" style="width: <?= $pct_rr ?>%;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-0">
                        <div class="p-3 bg-light rounded-3 me-3 text-danger"><i data-lucide="x-octagon" size="24"></i></div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="fw-bold small">Rusak Berat (<?= $rb ?> aset)</span>
                                <span class="fw-bold small"><?= $pct_rb ?>%</span>
                            </div>
                            <div class="progress" style="height: 8px; border-radius: 10px;">
                                <div class="progress-bar bg-danger" style="width: <?= $pct_rb ?>%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card-premium p-0 overflow-hidden h-100">
                <div class="p-4 border-bottom bg-white">
                    <h6 class="fw-bold mb-0">Aktivitas Terakhir</h6>
                </div>
                <div class="p-4">
                    <?php if(empty($events)): ?>
                        <div class="text-muted small text-center mt-3">Belum ada aktivitas</div>
                    <?php else: ?>
                        <?php foreach($events as $ev): ?>
                            <?php if($ev['tipe'] == 'aset_baru'): ?>
                            <div class="d-flex gap-3 mb-4">
                                <div class="mt-1"><div class="bg-success bg-opacity-10 text-success p-1 rounded-circle"><i data-lucide="plus-circle" size="18"></i></div></div>
                                <div>
                                    <p class="mb-1 small fw-bold">Aset Baru Ditambahkan</p>
                                    <p class="text-muted small mb-0">Data aset <?= htmlspecialchars($ev['objek']) ?> telah diinput.</p>
                                    <small class="text-muted" style="font-size: 0.7rem;"><?= date('d M Y', strtotime($ev['tgl'])) ?></small>
                                </div>
                            </div>
                            <?php else: ?>
                            <div class="d-flex gap-3 mb-4">
                                <div class="mt-1"><div class="bg-danger bg-opacity-10 text-danger p-1 rounded-circle"><i data-lucide="trash-2" size="18"></i></div></div>
                                <div>
                                    <p class="mb-1 small fw-bold">Penghapusan Aset</p>
                                    <p class="text-muted small mb-0">Aset ID-<?= htmlspecialchars($ev['objek']) ?> diproses untuk penghapusan.</p>
                                    <small class="text-muted" style="font-size: 0.7rem;"><?= date('d M Y', strtotime($ev['tgl'])) ?></small>
                                </div>
                            </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
