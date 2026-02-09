<?php
// --- 0. KONEKSI DATABASE ---
// Pastikan file koneksi Anda sudah di-include di sini
// include 'koneksi.php'; 
// SEMENTARA: Kita buat koneksi dummy agar kode tidak error saat dicoba tanpa DB
$koneksi = mysqli_connect("localhost", "root", "", "db_kantor"); // Sesuaikan DB Anda

$judul = "Kelola Aset";

// --- 1. LOGIKA TAMBAH ASET (CREATE) ---
if (isset($_POST['simpan_aset'])) {
    $nama      = $_POST['nama_aset'];
    $kode      = $_POST['kode_aset'];
    $kategori  = $_POST['kategori'];
    $tgl       = $_POST['tgl_perolehan'];
    $harga     = $_POST['harga'];
    $kondisi   = $_POST['kondisi'];
    $ket       = $_POST['keterangan'];

    $query = mysqli_query($koneksi, "INSERT INTO aset (nama_aset, kode_aset, kategori, tgl_perolehan, harga, kondisi, keterangan) VALUES ('$nama', '$kode', '$kategori', '$tgl', '$harga', '$kondisi', '$ket')");
    
    if($query) echo "<script>alert('Aset berhasil ditambahkan!'); window.location='?';</script>";
}

// --- 2. LOGIKA HAPUS ASET (DELETE) ---
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $query = mysqli_query($koneksi, "DELETE FROM aset WHERE id_aset = '$id'");
    if($query) echo "<script>alert('Aset dihapus!'); window.location='aset.php';</script>"; // Ganti nama file jika perlu
}

// --- 3. LOGIKA UPDATE ASET (UPDATE) ---
if (isset($_POST['update_aset'])) {
    $id        = $_POST['id_aset'];
    $nama      = $_POST['nama_aset'];
    $kode      = $_POST['kode_aset'];
    $kategori  = $_POST['kategori'];
    $tgl       = $_POST['tgl_perolehan'];
    $harga     = $_POST['harga'];
    $kondisi   = $_POST['kondisi'];
    $ket       = $_POST['keterangan'];

    $query = mysqli_query($koneksi, "UPDATE aset SET nama_aset='$nama', kode_aset='$kode', kategori='$kategori', tgl_perolehan='$tgl', harga='$harga', kondisi='$kondisi', keterangan='$ket' WHERE id_aset='$id'");

    if($query) echo "<script>alert('Data aset diperbarui!'); window.location='?';</script>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Aset Inventaris</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <style>
        body { background-color: #f4f6f9; font-family: 'Inter', sans-serif; }
        .card-stat { transition: transform 0.2s; }
        .card-stat:hover { transform: translateY(-3px); }
        .table > :not(caption) > * > * { padding: 1rem 0.75rem; }
        
        /* Style khusus Cetak */
        @media print {
            .no-print { display: none !important; }
            .card { border: none !important; box-shadow: none !important; }
            .table th:last-child, .table td:last-child { display: none; } /* Sembunyikan kolom aksi */
        }
    </style>
</head>
<body>

<div class="container-fluid p-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Manajemen Aset</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-0 small">
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Aset</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2 no-print">
            <button onclick="window.print()" class="btn btn-white bg-white border shadow-sm text-dark d-flex align-items-center gap-2">
                <i data-lucide="printer" size="16"></i> Cetak Laporan
            </button>
            <button class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalTambahAset">
                <i data-lucide="plus-circle" size="16"></i> Tambah Aset
            </button>
        </div>
    </div>

    <div class="row g-3 mb-4 no-print">
        <div class="col-md-3">
            <div class="card card-stat border-0 shadow-sm p-3 h-100 border-start border-4 border-primary rounded-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div><p class="text-muted small mb-1 fw-bold text-uppercase">Total Aset</p><h4 class="fw-bold mb-0">1,240</h4></div>
                    <div class="bg-primary bg-opacity-10 p-2 rounded text-primary"><i data-lucide="box" size="24"></i></div>
                </div>
            </div>
        </div>
        </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white p-4 border-bottom no-print">
            <div class="row g-3 align-items-center">
                <div class="col-md-4">
                    <form method="GET">
                        <div class="input-group border rounded-3 overflow-hidden bg-light">
                            <span class="input-group-text bg-transparent border-0 text-muted ps-3"><i data-lucide="search" size="16"></i></span>
                            <input type="text" name="cari" class="form-control bg-transparent border-0 shadow-none" placeholder="Cari nama aset, kode..." value="<?php echo isset($_GET['cari']) ? $_GET['cari'] : ''; ?>">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small text-uppercase">
                    <tr>
                        <th class="ps-4">Info Aset</th>
                        <th>Kategori</th>
                        <th>Tgl Perolehan</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th class="text-end pe-4 no-print">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // LOGIKA TAMPIL DATA (READ)
                    $where = "";
                    if(isset($_GET['cari'])){
                        $cari = $_GET['cari'];
                        $where = "WHERE nama_aset LIKE '%$cari%' OR kode_aset LIKE '%$cari%'";
                    }
                    $tampil = mysqli_query($koneksi, "SELECT * FROM aset $where ORDER BY id_aset DESC");
                    
                    if(mysqli_num_rows($tampil) > 0) {
                        while ($data = mysqli_fetch_array($tampil)) {
                            // Warna badge kondisi
                            $badgeClass = 'bg-secondary';
                            if($data['kondisi'] == 'Baik') $badgeClass = 'bg-success text-success bg-opacity-10';
                            if($data['kondisi'] == 'Rusak Ringan') $badgeClass = 'bg-warning text-warning bg-opacity-10';
                            if($data['kondisi'] == 'Rusak Berat') $badgeClass = 'bg-danger text-danger bg-opacity-10';
                    ?>
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-3">
                                <div>
                                    <h6 class="mb-0 fw-bold text-dark"><?php echo $data['nama_aset']; ?></h6>
                                    <span class="text-muted small">ID: <?php echo $data['kode_aset']; ?></span>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge bg-light text-dark border"><?php echo $data['kategori']; ?></span></td>
                        <td class="text-muted small"><?php echo date('d M Y', strtotime($data['tgl_perolehan'])); ?></td>
                        <td class="fw-semibold">Rp <?php echo number_format($data['harga'],0,',','.'); ?></td>
                        <td><span class="badge <?php echo $badgeClass; ?> rounded-pill px-3"><?php echo $data['kondisi']; ?></span></td>
                        <td class="text-center no-print">
                            <div class="btn-group">
                                <button class="btn btn-sm btn-outline-secondary btn-edit" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalEditAset"
                                    data-id="<?php echo $data['id_aset']; ?>"
                                    data-nama="<?php echo $data['nama_aset']; ?>"
                                    data-kode="<?php echo $data['kode_aset']; ?>"
                                    data-kategori="<?php echo $data['kategori']; ?>"
                                    data-tgl="<?php echo $data['tgl_perolehan']; ?>"
                                    data-harga="<?php echo $data['harga']; ?>"
                                    data-kondisi="<?php echo $data['kondisi']; ?>"
                                    data-ket="<?php echo $data['keterangan']; ?>">
                                    <i data-lucide="edit-3" style="width: 14px;"></i>
                                </button>
                                
                                <button class="btn btn-sm btn-outline-secondary btn-qr" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalQR" 
                                    data-kode="<?php echo $data['kode_aset']; ?>"
                                    data-nama="<?php echo $data['nama_aset']; ?>">
                                    <i data-lucide="qr-code" style="width: 14px;"></i>
                                </button>
                                
                                <a href="?hapus=<?php echo $data['id_aset']; ?>" onclick="return confirm('Yakin ingin menghapus aset <?php echo $data['nama_aset']; ?>?')" class="btn btn-sm btn-outline-danger">
                                    <i data-lucide="trash-2" style="width: 14px;"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php 
                        } 
                    } else {
                        echo "<tr><td colspan='6' class='text-center py-4 text-muted'>Belum ada data aset.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahAset" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Tambah Aset Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="" method="POST">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Nama Aset</label>
                            <input type="text" name="nama_aset" class="form-control" required placeholder="Contoh: Laptop Dell">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Kode Inventaris</label>
                            <input type="text" name="kode_aset" class="form-control" required placeholder="Contoh: AST-001">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Kategori</label>
                            <select name="kategori" class="form-select" required>
                                <option value="" selected disabled>Pilih...</option>
                                <option value="Elektronik">Elektronik</option>
                                <option value="Furniture">Furniture</option>
                                <option value="Kendaraan">Kendaraan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Tanggal Perolehan</label>
                            <input type="date" name="tgl_perolehan" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Harga Perolehan</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="harga" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Kondisi Awal</label>
                            <select name="kondisi" class="form-select" required>
                                <option value="Baik">Baik</option>
                                <option value="Rusak Ringan">Rusak Ringan</option>
                                <option value="Rusak Berat">Rusak Berat</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold text-muted">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="mt-4 d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="simpan_aset" class="btn btn-primary">Simpan Aset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditAset" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold text-primary">Edit Aset</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="" method="POST">
                    <input type="hidden" name="id_aset" id="edit_id"> <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Nama Aset</label>
                            <input type="text" name="nama_aset" id="edit_nama" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Kode Inventaris</label>
                            <input type="text" name="kode_aset" id="edit_kode" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Kategori</label>
                            <select name="kategori" id="edit_kategori" class="form-select" required>
                                <option value="Elektronik">Elektronik</option>
                                <option value="Furniture">Furniture</option>
                                <option value="Kendaraan">Kendaraan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Tanggal Perolehan</label>
                            <input type="date" name="tgl_perolehan" id="edit_tgl" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Harga Perolehan</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="harga" id="edit_harga" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Kondisi</label>
                            <select name="kondisi" id="edit_kondisi" class="form-select" required>
                                <option value="Baik">Baik</option>
                                <option value="Rusak Ringan">Rusak Ringan</option>
                                <option value="Rusak Berat">Rusak Berat</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold text-muted">Keterangan</label>
                            <textarea name="keterangan" id="edit_ket" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="mt-4 d-flex justify-content-end gap-2">
                        <button type="submit" name="update_aset" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalQR" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow rounded-4 text-center">
            <div class="modal-body p-4">
                <h6 class="fw-bold mb-3" id="qr_title">QR Code Aset</h6>
                <div class="bg-light p-3 rounded mb-3">
                    <img id="qr_image" src="" class="img-fluid" alt="QR Code">
                </div>
                <p class="text-muted small mb-3" id="qr_code_text">AST-001</p>
                <button class="btn btn-outline-primary btn-sm w-100" onclick="window.print()">
                    <i data-lucide="printer" size="14" class="me-1"></i> Cetak QR
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // 1. Aktifkan Icon Lucide
    lucide.createIcons();

    // 2. Logic Mengisi Modal Edit (Tanpa AJAX, pakai Data Attribute)
    const modalEdit = document.getElementById('modalEditAset');
    modalEdit.addEventListener('show.bs.modal', function (event) {
        // Tombol yang diklik
        const button = event.relatedTarget;
        
        // Ambil data dari atribut data-*
        const id = button.getAttribute('data-id');
        const nama = button.getAttribute('data-nama');
        const kode = button.getAttribute('data-kode');
        const kategori = button.getAttribute('data-kategori');
        const tgl = button.getAttribute('data-tgl');
        const harga = button.getAttribute('data-harga');
        const kondisi = button.getAttribute('data-kondisi');
        const ket = button.getAttribute('data-ket');

        // Isi form
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_nama').value = nama;
        document.getElementById('edit_kode').value = kode;
        document.getElementById('edit_kategori').value = kategori;
        document.getElementById('edit_tgl').value = tgl;
        document.getElementById('edit_harga').value = harga;
        document.getElementById('edit_kondisi').value = kondisi;
        document.getElementById('edit_ket').value = ket;
    });

    // 3. Logic QR Code Generator (API Publik)
    const modalQR = document.getElementById('modalQR');
    modalQR.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const kode = button.getAttribute('data-kode');
        const nama = button.getAttribute('data-nama');

        // Set Title
        document.getElementById('qr_title').innerText = nama;
        document.getElementById('qr_code_text').innerText = kode;
        
        // Generate QR pakai API (QRServer)
        const apiUrl = `https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=${kode}`;
        document.getElementById('qr_image').src = apiUrl;
    });
</script>

</body>
</html>