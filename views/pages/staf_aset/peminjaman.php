<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman Aset - Dashboard</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* --- Custom CSS (Konsisten dengan halaman sebelumnya) --- */
        :root {
            --bs-font-sans-serif: 'Inter', sans-serif;
            --primary-blue: #0d6efd; /* Warna BIRU untuk Peminjaman */
            --bg-light-gray: #f8f9fa;
        }

        body { background-color: var(--bg-light-gray); }

        /* Navbar & Header */
        .top-navbar {
            background-color: #fff;
            border-bottom: 1px solid #eaeaea;
            padding: 1rem 0;
        }
        .page-title-head {
            font-weight: 700;
            font-size: 1.25rem;
            margin-bottom: 0;
            color: #212529;
        }
        .breadcrumb-item {
            font-size: 0.85rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;
        }
        
        /* User Profile & Icons */
        .nav-icon-btn { color: #6c757d; font-size: 1.2rem; position: relative; }
        .notification-dot {
            position: absolute; top: 0; right: 2px; width: 8px; height: 8px;
            background-color: var(--primary-blue); border-radius: 50%; border: 1px solid #fff;
        }
        .user-avatar {
            width: 40px; height: 40px; background-color: #4e54c8; color: white;
            display: flex; align-items: center; justify-content: center;
            border-radius: 50%; font-weight: 600;
        }
        .user-info .role { font-size: 0.75rem; color: #adb5bd; font-weight: 600; }

        /* Summary Card (Aksen Biru) */
        .card-summary {
            border: none; border-radius: 12px; box-shadow: 0 2px 15px rgba(0,0,0,0.03);
            border-left: 4px solid var(--primary-blue);
        }
        .icon-box-blue {
            width: 48px; height: 48px; background-color: #cfe2ff; color: var(--primary-blue);
            display: flex; align-items: center; justify-content: center;
            border-radius: 8px; font-size: 1.5rem;
        }
        .summary-count { font-size: 1.75rem; font-weight: 700; line-height: 1.2; }
        
        /* Table Styling */
        .table-card { border: none; border-radius: 12px; box-shadow: 0 2px 15px rgba(0,0,0,0.03); overflow: hidden; }
        .table thead th {
            background-color: #f8f9fa; font-weight: 600; font-size: 0.9rem; color: #495057;
            border-bottom: 2px solid #eaeaea; padding: 1rem;
        }
        .table tbody td { vertical-align: middle; padding: 1rem; font-size: 0.95rem; }
        
        /* Badges */
        .badge-info-subtle { background-color: #cff4fc; color: #055160; font-weight: 500; padding: 0.5em 1em; }
        .badge-danger-subtle { background-color: #f8d7da; color: #842029; font-weight: 500; padding: 0.5em 1em; }
        .badge-success-subtle { background-color: #d1e7dd; color: #0f5132; font-weight: 500; padding: 0.5em 1em; }

        /* Action Buttons */
        .btn-icon-outline {
            width: 32px; height: 32px; padding: 0; display: inline-flex;
            align-items: center; justify-content: center; border-radius: 6px;
            border: 1px solid #dee2e6; background: #fff; color: #6c757d; transition: all 0.2s;
        }
        .btn-icon-outline.action:hover { border-color: var(--primary-blue); color: var(--primary-blue); background-color: #f0f7ff; }
        .btn-icon-outline.return:hover { border-color: #198754; color: #198754; background-color: #f0fdf4; }
    </style>
</head>
<body>


    <div class="container-fluid px-4 py-4">
        
        <div class="d-flex justify-content-between align-items-start mb-5">
            <div>
                <h2 class="fw-bold text-dark">Kelola Peminjaman</h2>
                <p class="text-muted mb-0">Monitor sirkulasi aset, peminjaman, dan proses pengembalian.</p>
            </div>
            <div>
                <button class="btn btn-primary d-flex align-items-center gap-2 px-3 py-2 fw-medium shadow-sm">
                    <i class="bi bi-plus-circle"></i> Buat Peminjaman
                </button>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-md-4 col-lg-3">
                <div class="card card-summary p-3 bg-white">
                    <div class="d-flex align-items-center">
                        <div class="icon-box-blue me-3">
                            <i class="bi bi-box-arrow-right"></i>
                        </div>
                        <div>
                            <div class="summary-count">12</div>
                            <div class="text-muted small">Sedang Dipinjam</div>
                        </div>
                    </div>
                </div>
            </div>
             <div class="col-md-4 col-lg-3">
                <div class="card card-summary p-3 bg-white" style="border-left-color: #dc3545;">
                    <div class="d-flex align-items-center">
                        <div class="icon-box-blue me-3" style="background-color: #f8d7da; color: #dc3545;">
                            <i class="bi bi-exclamation-circle"></i>
                        </div>
                        <div>
                            <div class="summary-count text-danger">2</div>
                            <div class="text-muted small">Terlambat Kembali</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card table-card bg-white">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">No. Pinjam</th>
                                <th>Peminjam</th>
                                <th>Item Aset</th>
                                <th>Tgl Pinjam</th>
                                <th>Tenggat Kembali</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <tr>
                                <td class="ps-4 fw-medium text-primary">PJ-2026/088</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle bg-light border d-flex align-items-center justify-content-center" style="width:24px;height:24px;font-size:10px;">DY</div>
                                        <span>Dimas Yudha</span>
                                    </div>
                                </td>
                                <td>Proyektor Epson EB-X</td>
                                <td>05 Feb 2026</td>
                                <td>07 Feb 2026</td>
                                <td>
                                    <span class="badge badge-info-subtle rounded-pill">Sedang Dipinjam</span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <button class="btn btn-icon-outline return" data-bs-toggle="tooltip" title="Proses Pengembalian">
                                            <i class="bi bi-box-arrow-in-left"></i>
                                        </button>
                                        <button class="btn btn-icon-outline action" title="Cetak Surat Jalan">
                                            <i class="bi bi-printer"></i>
                                        </button>
                                        <button class="btn btn-icon-outline action" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="ps-4 fw-medium text-primary">PJ-2026/085</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle bg-light border d-flex align-items-center justify-content-center" style="width:24px;height:24px;font-size:10px;">AN</div>
                                        <span>Anita Sari</span>
                                    </div>
                                </td>
                                <td>Kamera DSLR Canon</td>
                                <td>01 Feb 2026</td>
                                <td class="text-danger fw-bold">03 Feb 2026</td>
                                <td>
                                    <span class="badge badge-danger-subtle rounded-pill">Terlambat</span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <button class="btn btn-icon-outline return" title="Proses Pengembalian">
                                            <i class="bi bi-box-arrow-in-left"></i>
                                        </button>
                                        <button class="btn btn-icon-outline action" title="Hubungi Peminjam">
                                            <i class="bi bi-chat-text"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="ps-4 fw-medium text-muted">PJ-2026/080</td>
                                <td class="text-muted">
                                    <div class="d-
