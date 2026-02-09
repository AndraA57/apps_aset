<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penghapusan Aset - Dashboard</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* --- Custom CSS untuk menyesuaikan dengan desain referensi --- */
        :root {
            --bs-font-sans-serif: 'Inter', sans-serif;
            --primary-red: #dc3545; /* Warna merah aksen */
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
            background-color: var(--primary-red);
            border-radius: 50%;
            border: 1px solid #fff;
        }
        .user-avatar {
            width: 40px;
            height: 40px;
            background-color: #4e54c8; /* Warna biru avatar */
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
        
        /* Summary Card Styling (Kartu Statistik) */
        .card-summary {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.03);
            /* Aksen garis merah di kiri */
            border-left: 4px solid var(--primary-red); 
        }
        .icon-box-red {
            width: 48px;
            height: 48px;
            background-color: #fde8e8; /* Merah sangat muda */
            color: var(--primary-red);
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
            overflow: hidden; /* Agar sudut tabel mengikuti border-radius card */
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
        
        /* Status Badge Custom */
        .badge-pending-custom {
            background-color: #fff3cd;
            color: #856404;
            font-weight: 500;
            padding: 0.5em 1em;
        }

        /* Action Buttons Custom */
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
        .btn-icon-outline.info:hover {
            border-color: #0d6efd;
            color: #0d6efd;
            background-color: #f0f7ff;
        }
        .btn-icon-outline.danger:hover {
            border-color: var(--primary-red);
            color: var(--primary-red);
            background-color: #fde8e8;
        }

    </style>
</head>
<body>

    <nav class="navbar top-navbar sticky-top px-4">
        <div class="container-fluid px-0">
            <div class="d-flex flex-column">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                      <li class="breadcrumb-item text-muted">PAGES</li>
                      <li class="breadcrumb-item active text-muted" aria-current="page">PENGHAPUSAN ASET</li>
                    </ol>
 
    <div class="container-fluid px-4 py-4">
        
        <div class="d-flex justify-content-between align-items-start mb-5 main-content-header">
            <div>
                <h2>Penghapusan Aset</h2>
                <p class="text-muted mb-0">Manajemen penghentian penggunaan dan pemusnahan aset.</p>
            </div>
            <div>
                <button class="btn btn-danger d-flex align-items-center gap-2 px-3 py-2 fw-medium">
                    <i class="bi bi-trash3"></i>
                    Ajukan Penghapusan
                </button>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-md-4 col-lg-3">
                <div class="card card-summary p-3 bg-white">
                    <div class="d-flex align-items-center">
                        <div class="icon-box-red me-3">
                            <i class="bi bi-archive"></i> </div>
                        <div>
                            <div class="summary-count">14</div>
                            <div class="text-muted small">Aset Dihapuskan Thn Ini</div>
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
                                <th class="ps-4">No. Berita Acara</th>
                                <th>Aset</th>
                                <th>Tgl Hapus</th>
                                <th>Alasan</th>
                                <th>Metode</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ps-4 fw-medium">SKP-09221</td>
                                <td>Printer Epson L3110</td>
                                <td>01 Feb 2026</td>
                                <td>Rusak Berat</td>
                                <td>Lelang/Jual</td>
                                <td>
                                    <span class="badge badge-pending-custom rounded-pill">
                                        Menunggu Persetujuan
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <button class="btn btn-icon-outline info" data-bs-toggle="tooltip" title="Detail">
                                            <i class="bi bi-info-circle"></i>
                                        </button>
                                        <button class="btn btn-icon-outline danger" data-bs-toggle="tooltip" title="Batalkan">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            
                            <tr>
                                <td class="ps-4 fw-medium">SKP-09222</td>
                                <td>Laptop Dell Latitude 7490</td>
                                <td>28 Jan 2026</td>
                                <td>Hilang</td>
                                <td>Pemusnahan</td>
                                <td>
                                    <span class="badge badge-pending-custom rounded-pill">
                                        Menunggu Persetujuan
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <button class="btn btn-icon-outline info" title="Detail">
                                            <i class="bi bi-info-circle"></i>
                                        </button>
                                        <button class="btn btn-icon-outline danger" title="Batalkan">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                             <tr>
                                <td class="ps-4 fw-medium">SKP-09220</td>
                                <td>Kursi Kantor Staff (5 Unit)</td>
                                <td>15 Jan 2026</td>
                                <td>Rusak Berat</td>
                                <td>Pemusnahan</td>
                                <td>
                                    <span class="badge bg-success-subtle text-success-emphasis rounded-pill px-3">
                                        Selesai
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <button class="btn btn-icon-outline info" title="Detail">
                                            <i class="bi bi-info-circle"></i>
                                        </button>
                                        <button class="btn btn-icon-outline danger" title="Batalkan" disabled>
                                            <i class="bi bi-x-circle"></i>
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
        // Mengaktifkan Bootstrap tooltips (opsional)
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
</body>
</html>