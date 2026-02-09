<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemeliharaan Aset - Dashboard</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* --- Custom CSS (Konsisten, Tema Oranye) --- */
        :root {
            --bs-font-sans-serif: 'Inter', sans-serif;
            --primary-orange: #fd7e14; /* Warna ORANYE untuk Maintenance */
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
            background-color: var(--primary-orange); border-radius: 50%; border: 1px solid #fff;
        }
        .user-avatar {
            width: 40px; height: 40px; background-color: #4e54c8; color: white;
            display: flex; align-items: center; justify-content: center;
            border-radius: 50%; font-weight: 600;
        }
        .user-info .role { font-size: 0.75rem; color: #adb5bd; font-weight: 600; }

        /* Summary Card (Aksen Oranye) */
        .card-summary {
            border: none; border-radius: 12px; box-shadow: 0 2px 15px rgba(0,0,0,0.03);
            border-left: 4px solid var(--primary-orange);
        }
        .icon-box-orange {
            width: 48px; height: 48px; background-color: #fff3cd; color: var(--primary-orange);
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
        
        /* Badges Custom */
        .badge-warning-subtle { background-color: #fff3cd; color: #856404; font-weight: 500; padding: 0.5em 1em; } /* Proses */
        .badge-info-subtle { background-color: #cff4fc; color: #055160; font-weight: 500; padding: 0.5em 1em; } /* Terjadwal */
        .badge-success-subtle { background-color: #d1e7dd; color: #0f5132; font-weight: 500; padding: 0.5em 1em; } /* Selesai */

        /* Action Buttons */
        .btn-icon-outline {
            width: 32px; height: 32px; padding: 0; display: inline-flex;
            align-items: center; justify-content: center; border-radius: 6px;
            border: 1px solid #dee2e6; background: #fff; color: #6c757d; transition: all 0.2s;
        }
        .btn-icon-outline.action:hover { border-color: var(--primary-orange); color: var(--primary-orange); background-color: #fff8e1; }
        .btn-icon-outline.finish:hover { border-color: #198754; color: #198754; background-color: #f0fdf4; }
        
        /* Button Primary Custom (Orange) */
        .btn-orange {
            background-color: var(--primary-orange); color: white; border: none;
        }
        .btn-orange:hover { background-color: #e36d0d; color: white; }

    </style>
</head>
<body>

    <div class="container-fluid px-4 py-4">
        
        <div class="d-flex justify-content-between align-items-start mb-5">
            <div>
                <h2 class="fw-bold text-dark">Jadwal & Perbaikan</h2>
                <p class="text-muted mb-0">Kelola perawatan rutin (preventive) dan perbaikan kerusakan (corrective).</p>
            </div>
            <div>
                <button class="btn btn-orange d-flex align-items-center gap-2 px-3 py-2 fw-medium shadow-sm">
                    <i class="bi bi-tools"></i> Catat Perbaikan Baru
                </button>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-md-4 col-lg-3">
                <div class="card card-summary p-3 bg-white">
                    <div class="d-flex align-items-center">
                        <div class="icon-box-orange me-3">
                            <i class="bi bi-wrench-adjustable"></i>
                        </div>
                        <div>
                            <div class="summary-count">4</div>
                            <div class="text-muted small">Sedang Diperbaiki</div>
                        </div>
                    </div>
                </div>
            </div>
             <div class="col-md-4 col-lg-3">
                <div class="card card-summary p-3 bg-white" style="border-left-color: #0dcaf0;">
                    <div class="d-flex align-items-center">
                        <div class="icon-box-orange me-3" style="background-color: #cff4fc; color: #055160;">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                        <div>
                            <div class="summary-count fs-4">2 Jadwal</div>
                            <div class="text-muted small">Maintenance Minggu Ini</div>
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
                                <th>Aset</th>
                                <th>Jenis Layanan</th>
                                <th>Teknisi / Vendor</th>
                                <th>Estimasi Selesai</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <tr>
                                <td class="ps-4 fw-medium text-dark">MTC-2026/012</td>
                                <td>
                                    <span class="d-block fw-medium">AC Server Room</span>
                                    <small class="text-muted">ELE-002</small>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border"><i class="bi bi-exclamation-triangle me-1"></i> Perbaikan</span>
                                </td>
                                <td>CV. Sejuk Abadi (Vendor)</td>
                                <td class="text-danger fw-bold">Hari Ini</td>
                                <td>
                                    <span class="badge badge-warning-subtle rounded-pill">
                                        <i class="bi bi-hourglass-split me-1"></i> Proses
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <button class="btn btn-icon-outline finish" data-bs-toggle="tooltip" title="Tandai Selesai">
                                            <i class="bi bi-check-lg"></i>
                                        </button>
                                        <button class="btn btn-icon-outline action" title="Update Progres">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="ps-4 fw-medium text-dark">MTC-2026/015</td>
                                <td>
                                    <span class="d-block fw-medium">Toyota Avanza (B 1234 CD)</span>
                                    <small class="text-muted">VH-001</small>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">Service Berkala</span>
                                </td>
                                <td>Bengkel Resmi</td>
                                <td>10 Feb 2026</td>
                                <td>
                                    <span class="badge badge-info-subtle rounded-pill">Terjadwal</span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <button class="btn btn-icon-outline action" title="Ubah Jadwal">
                                            <i class="bi bi-calendar-event"></i>
                                        </button>
                                        <button class="btn btn-icon-outline action" title="Detail">
                                            <i class="bi bi-info-circle"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="ps-4 fw-medium text-muted">MTC-2026/010</td>
                                <td>
                                    <span class="d-block text-muted">Printer HRD (Epson L310)</span>
                                </td>
                                <td>
                                    <span class="badge bg-light text-secondary border">Ganti Tinta</span>
                                </td>
                                <td class="text-muted">Internal IT</td>
                                <td class="text-muted">05 Feb 2026</td>
                                <td>
                                    <span class="badge badge-success-subtle rounded-pill">Selesai</span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <button class="btn btn-icon-outline action" title="Lihat Laporan">
                                            <i class="bi bi-file-text"></i>
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