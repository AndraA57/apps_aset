<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perbaikan Aset - Dashboard</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* --- Custom CSS (Tema Ungu/Indigo) --- */
        :root {
            --bs-font-sans-serif: 'Inter', sans-serif;
            --primary-purple: #6610f2; /* Warna UNGU untuk Perbaikan */
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
            font-weight: 700; font-size: 1.25rem; margin-bottom: 0; color: #212529;
        }
        .breadcrumb-item {
            font-size: 0.85rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;
        }
        
        /* User Profile & Icons */
        .nav-icon-btn { color: #6c757d; font-size: 1.2rem; position: relative; }
        .notification-dot {
            position: absolute; top: 0; right: 2px; width: 8px; height: 8px;
            background-color: var(--primary-purple); border-radius: 50%; border: 1px solid #fff;
        }
        .user-avatar {
            width: 40px; height: 40px; background-color: #4e54c8; color: white;
            display: flex; align-items: center; justify-content: center;
            border-radius: 50%; font-weight: 600;
        }
        .user-info .role { font-size: 0.75rem; color: #adb5bd; font-weight: 600; }

        /* Summary Card (Aksen Ungu) */
        .card-summary {
            border: none; border-radius: 12px; box-shadow: 0 2px 15px rgba(0,0,0,0.03);
            border-left: 4px solid var(--primary-purple);
        }
        .icon-box-purple {
            width: 48px; height: 48px; background-color: #e0cffc; color: var(--primary-purple);
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
        
        /* Badges Priority */
        .badge-high { background-color: #ffe0e3; color: #c61a09; font-weight: 600; padding: 0.5em 1em; } /* Critical */
        .badge-medium { background-color: #fff3cd; color: #856404; font-weight: 600; padding: 0.5em 1em; } /* Normal */
        
        /* Badges Status */
        .badge-status-open { background-color: #e2e3e5; color: #383d41; }
        .badge-status-progress { background-color: #cff4fc; color: #055160; }
        .badge-status-done { background-color: #d1e7dd; color: #0f5132; }

        /* Action Buttons */
        .btn-icon-outline {
            width: 32px; height: 32px; padding: 0; display: inline-flex;
            align-items: center; justify-content: center; border-radius: 6px;
            border: 1px solid #dee2e6; background: #fff; color: #6c757d; transition: all 0.2s;
        }
        .btn-icon-outline.action:hover { border-color: var(--primary-purple); color: var(--primary-purple); background-color: #f3f0ff; }
        
        /* Button Primary Custom (Purple) */
        .btn-purple {
            background-color: var(--primary-purple); color: white; border: none;
        }
        .btn-purple:hover { background-color: #520dc2; color: white; }

    </style>
</head>
<body>

 
    <div class="container-fluid px-4 py-4">
        
        <div class="d-flex justify-content-between align-items-start mb-5">
            <div>
                <h2 class="fw-bold text-dark">Perbaikan Aset</h2>
                <p class="text-muted mb-0">Manajemen laporan kerusakan (insiden) dan pelacakan status perbaikan.</p>
            </div>
            <div>
                <button class="btn btn-purple d-flex align-items-center gap-2 px-3 py-2 fw-medium shadow-sm">
                    <i class="bi bi-plus-lg"></i> Buat Tiket Baru
                </button>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-md-4 col-lg-3">
                <div class="card card-summary p-3 bg-white">
                    <div class="d-flex align-items-center">
                        <div class="icon-box-purple me-3">
                            <i class="bi bi-ticket-perforated"></i>
                        </div>
                        <div>
                            <div class="summary-count">8</div>
                            <div class="text-muted small">Tiket Menunggu (Open)</div>
                        </div>
                    </div>
                </div>
            </div>
             <div class="col-md-4 col-lg-3">
                <div class="card card-summary p-3 bg-white" style="border-left-color: #dc3545;">
                    <div class="d-flex align-items-center">
                        <div class="icon-box-purple me-3" style="background-color: #f8d7da; color: #dc3545;">
                            <i class="bi bi-gear-wide-connected"></i>
                        </div>
                        <div>
                            <div class="summary-count text-danger">3</div>
                            <div class="text-muted small">Menunggu Sparepart</div>
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
                                <th class="ps-4">No. Tiket</th>
                                <th>Aset / Barang</th>
                                <th>Keluhan / Kerusakan</th>
                                <th>Pelapor</th>
                                <th>Prioritas</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <tr>
                                <td class="ps-4 fw-medium text-purple">REP-0992</td>
                                <td>
                                    <span class="d-block fw-bold">Genset Gedung A</span>
                                    <small class="text-muted">MAC-005</small>
                                </td>
                                <td>Mati total, keluar asap hitam</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-person-circle text-secondary"></i> Security
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-high rounded-1">CRITICAL</span>
                                </td>
                                <td>
                                    <span class="badge badge-status-open rounded-pill px-3">Open</span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <button class="btn btn-icon-outline action" data-bs-toggle="tooltip" title="Tindak Lanjuti (Diagnosa)">
                                            <i class="bi bi-play-fill"></i>
                                        </button>
                                        <button class="btn btn-icon-outline action" title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="ps-4 fw-medium text-purple">REP-0990</td>
                                <td>
                                    <span class="d-block fw-bold">Laptop Direktur</span>
                                    <small class="text-muted">IT-LPT-001</small>
                                </td>
                                <td>Keyboard macet beberapa tombol</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-person-circle text-secondary"></i> Sekretaris
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-medium rounded-1">High</span>
                                </td>
                                <td>
                                    <span class="badge badge-status-progress rounded-pill px-3">
                                        <i class="bi bi-tools me-1"></i> Pengerjaan
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <button class="btn btn-icon-outline action" title="Update Status">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button class="btn btn-icon-outline action" title="Request Sparepart">
                                            <i class="bi bi-cart-plus"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="ps-4 fw-medium text-muted">REP-0988</td>
                                <td>
                                    <span class="d-block text-muted">Kursi Staff (R. Meeting)</span>
                                </td>
                                <td class="text-muted">Roda patah satu</td>
                                <td class="text-muted">GA Staff</td>
                                <td>
                                    <span class="badge bg-light text-secondary border rounded-1">Normal</span>
                                </td>
                                <td>
                                    <span class="badge badge-status-done rounded-pill px-3">Selesai</span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <button class="btn btn-icon-outline action" title="Arsipkan">
                                            <i class="bi bi-archive"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
</body>
</html>