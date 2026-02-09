<div class="card-premium p-0 overflow-hidden shadow-sm">
        <div class="p-4 border-bottom d-flex flex-wrap gap-3 justify-content-between align-items-center bg-white">
            <h6 class="fw-bold mb-0">Log Transaksi</h6>
            <div class="d-flex gap-2">
                <div class="input-group input-group-sm border rounded-2 overflow-hidden" style="width: 250px;">
                    <span class="input-group-text bg-white border-0 text-muted"><i data-lucide="search" size="14"></i></span>
                    <input type="text" class="form-control border-0 shadow-none" placeholder="Cari ID, Nama...">
                </div>
                <button class="btn btn-light btn-sm border"><i data-lucide="filter" size="14"></i> Filter</button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-premium mb-0 align-middle">
                <thead>
                    <tr>
                        <th class="ps-4">Invoice ID</th>
                        <th>Pelanggan</th>
                        <th>Tipe</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th class="text-end pe-4">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="ps-4"><span class="fw-bold small text-dark">#INV-9921</span></td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center text-muted fw-bold" style="width:32px; height:32px; font-size: 0.7rem;">SN</div>
                                <div class="small fw-semibold">Odih</div>
                            </div>
                        </td>
                        <td><span class="badge-soft bg-soft-primary">Subscription</span></td>
                        <td><span class="badge-soft bg-soft-success">Paid</span></td>
                        <td><span class="text-muted small">28 Jan, 10:20</span></td>
                        <td class="text-end pe-4 fw-bold text-dark">$120.00</td>
                    </tr>
                    <tr>
                        <td class="ps-4"><span class="fw-bold small text-dark">#INV-9922</span></td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center text-muted fw-bold" style="width:32px; height:32px; font-size: 0.7rem;">BW</div>
                                <div class="small fw-semibold">Warso</div>
                            </div>
                        </td>
                        <td><span class="badge-soft bg-soft-warning">Refund</span></td>
                        <td><span class="badge-soft bg-soft-warning">Pending</span></td>
                        <td><span class="text-muted small">27 Jan, 14:30</span></td>
                        <td class="text-end pe-4 fw-bold text-dark">-$45.00</td>
                    </tr>
                    <tr>
                        <td class="ps-4"><span class="fw-bold small text-dark">#INV-9923</span></td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <img src="https://ui-avatars.com/api/?name=Ahmad+R&background=random" class="rounded-circle" width="32">
                                <div class="small fw-semibold">Encep</div>
                            </div>
                        </td>
                        <td><span class="badge-soft bg-soft-primary">Purchase</span></td>
                        <td><span class="badge-soft bg-soft-danger">Failed</span></td>
                        <td><span class="text-muted small">27 Jan, 09:15</span></td>
                        <td class="text-end pe-4 fw-bold text-dark">$299.00</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="p-3 border-top text-center bg-light">
            <a href="#" class="text-decoration-none small fw-bold" style="color: var(--accent);">Lihat Semua Transaksi</a>
        </div>
    </div>