<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serah Terima Aset (BAST) - Dashboard</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* --- Custom CSS (Style yang sama dengan Penghapusan, beda warna aksen) --- */
        :root {
            --bs-font-sans-serif: 'Inter', sans-serif;
            --primary-green: #198754; /* Warna HIJAU untuk BAST */
            --bg-light-gray: #f8f9fa;
        }

        body {
            background-color: var(--bg-light-gray);
        }

        /* Navbar Styling */
        .top-navbar {
            background-color: #fff;
            border-bottom: 1px solid #eaeaea;
            padding-top: 1rem;
            padding-bottom: 1rem;
        }
        .breadcrumb-item {
            font-size: 0.85rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .page-title-head {
            font-weight: 700;
            font-size: 1.25rem;
            margin-bottom: 0;
        }
        .nav-icon-btn {
            color: #6c757d;
            font-size: 1.2rem;
            position: relative;
        }
        .notification-dot {
            position: absolute;
            top: 0;
            right: 2px;
            width: 8px;
            height: 8px;
            background-color: var(--primary-green);
            border-radius: 50%;
            border: 1px solid #fff;
        }
        .user-avatar {
            width: 40px;
            height: 40px;
            background-color: #4e54c8;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-weight: 600;
        }
        .user-info .role {
            font-size: 0.75rem;
            color: #adb5bd;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        /* Main Content Styling */
        .main-content-header h2 {
            font-weight: 700;
            color: #212529;
        }
        
        /* Summary Card Styling (Aksen Hijau) */
        .card-summary {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.03);
            border-left: 4px solid var(--primary-green); /* Garis Hijau */
        }
        .icon-box-green {
            width: 48px;
            height: 48px;
            background-color: #d1e7dd; /* Hijau muda pudar */
            color: var(--primary-green);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-size: 1.5rem;
        }
        .summary-count {
            font-size: 1.75rem;
            font-weight: 700;
            line-height: 1.2;
        }
        
        /* Table Styling */
        .table-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.03);
            overflow: hidden;
        }
        .table thead th {
            background-color: #f8f9fa;
            font-weight: 600;
            font-size: 0.9rem;
            color: #495057;
            border-bottom: 2px solid #eaeaea;
            padding-top: 1rem;
            padding-bottom: 1rem;
        }
        .table tbody td {
            vertical-align: middle;
            padding-top: 1rem;
            padding-bottom: 1rem;
            font-size: 0.95rem;
        }
        
        /* Custom Badges */
        .badge-success-subtle {
            background-color: #d1e7dd;
            color: #0f5132;
            font-weight: 500;
            padding: 0.5em 1em;
        }
        .badge-warning-subtle {
            background-color: #fff3cd;
            color: #856404;
            font-weight: 500;
            padding: 0.5em 1em;
        }

        /* Action Buttons */
        .btn-icon-outline {
            width: 32px;
            height: 32px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            border: 1px solid #dee2e6;
            background: #fff;
            color: #6c757d;
            transition: all 0.2s;
        }
        /* Hover Effect Hijau untuk Tombol Edit/Print */
        .btn-icon-outline.action:hover {
            border-color: var(--primary-green);
            color: var(--primary-green);
            background-color: #f0fdf4;
        }
        .btn-icon-outline.danger:hover {
            border-color: #dc3545;
            color: #dc3545;
            background-color: #fde8e8;
        }

    </style>
</head>
<body>

 
    <div class="container-fluid px-4 py-4">
        
        <div class="d-flex justify-content-between align-items-start mb-5 main-content-header">
            <div>
                <h2>Berita Acara Serah Terima</h2>
                <p class="text-muted mb-0">Manajemen perpindahan hak tanggung jawab dan fisik aset.</p>
            </div>
            <div>
                <button class="btn btn-success d-flex align-items-center gap-2 px-3 py-2 fw-medium shadow-sm">
                    <i class="bi bi-file-earmark-plus"></i>
                    Buat BAST Baru
                </button>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-md-4 col-lg-3">
                <div class="card card-summary p-3 bg-white">
                    <div class="d-flex align-items-center">
                        <div class="icon-box-green me-3">
                            <i class="bi bi-file-earmark-check"></i> </div>
                        <div>
                            <div class="summary-count">28</div>
                            <div class="text-muted small">BAST Terbit Bulan Ini</div>
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
                                <th class="ps-4">No. BAST</th>
                                <th>Tanggal</th>
                                <th>Pihak Penerima</th>
                                <th>Jml Aset</th>
                                <th>Lokasi</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ps-4 fw-medium">BAST-2026/001</td>
                                <td>06 Feb 2026</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle bg-light border d-flex align-items-center justify-content-center" style="width:24px;height:24px;font-size:10px;">SA</div>
                                        <span>Siti Aminah</span>
                                    </div>
                                </td>
                                <td>3 Unit</td>
                                <td>Lantai 2 - HRD</td>
                                <td>
                                    <span class="badge badge-success-subtle rounded-pill">
                                        <i class="bi bi-check-circle-fill me-1"></i> Selesai
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <button class="btn btn-icon-outline action" data-bs-toggle="tooltip" title="Cetak BAST">
                                            <i class="bi bi-printer"></i>
                                        </button>
                                        <button class="btn btn-icon-outline action" data-bs-toggle="tooltip" title="Edit Data">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            
                            <tr>
                                <td class="ps-4 fw-medium">BAST-2026/002</td>
                                <td>05 Feb 2026</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle bg-light border d-flex align-items-center justify-content-center" style="width:24px;height:24px;font-size:10px;">BS</div>
                                        <span>Budi Santoso</span>
                                    </div>
                                </td>
                                <td>1 Unit</td>
                                <td>Gedung Server</td>
                                <td>
                                    <span class="badge badge-warning-subtle rounded-pill">
                                        Menunggu TTD
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <button class="btn btn-icon-outline action" title="Cetak Draft">
                                            <i class="bi bi-printer"></i>
                                        </button>
                                        <button class="btn btn-icon-outline action" title="Edit Data">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-icon-outline danger" title="Hapus Draft">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                             <tr>
                                <td class="ps-4 fw-medium">BAST-2026/003</td>
                                <td>01 Feb 2026</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle bg-light border d-flex align-items-center justify-content-center" style="width:24px;height:24px;font-size:10px;">RZ</div>
                                        <span>Riza Pratama</span>
                                    </div>
                                </td>
                                <td>5 Unit</td>
                                <td>Gudang Logistik</td>
                                <td>
                                    <span class="badge badge-success-subtle rounded-pill">
                                        <i class="bi bi-check-circle-fill me-1"></i> Selesai
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <button class="btn btn-icon-outline action" title="Cetak BAST">
                                            <i class="bi bi-printer"></i>
                                        </button>
                                        <button class="btn btn-icon-outline action" title="Detail">
                                            <i class="bi bi-info-circle"></i>
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