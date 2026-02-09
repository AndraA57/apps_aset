<?php 
// --- 1. LOGIKA SIMPAN DATA (INSERT) ---
if (isset($_POST['simpan_data'])) {
    $nama   = htmlspecialchars($_POST['nama']);
    $sandi  = $_POST['sandi']; // Sebaiknya di-hash (password_hash) nanti
    $role   = $_POST['role'];
    $gender = $_POST['gender'];

    // Query Insert ke tabel pegawai
    $insert = mysqli_query($koneksi, "INSERT INTO pegawai (Nama, Sandi, ROLE, Gender) VALUES ('$nama', '$sandi', '$role', '$gender')");

    if ($insert) {
        echo "<script>
                alert('Berhasil! Pengelola baru ditambahkan.');
                window.location='index.php?pengelola';
              </script>";
    } else {
        echo "<script>alert('Gagal: " . mysqli_error($koneksi) . "');</script>";
    }
}

// --- 2. LOGIKA AMBIL DATA (SELECT) ---
$judul = "Kelola Pegawai"; 
$query = mysqli_query($koneksi, "SELECT * FROM pegawai ORDER BY IdPegawai DESC");
?>

<style>
    .highlight-anim {
        background-color: #fff3cd;      /* Kuning muda */
        color: #000000;                 /* Pink/Ungu */
        font-weight: 800 !important;    /* Tebal */
        text-shadow: 0 0 10px rgb(255, 255, 255); /* Efek Bersinar */
        padding: 0 2px;
        border-radius: 3px;
        transition: all 0.3s ease;
    }
    .fs-small { font-size: 0.85rem; }
    .form-control:focus, .form-select:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 0.25rem rgba(var(--accent-rgb), 0.1);
    }
</style>

<div class="content-wrapper p-4">
    <div class="row g-4">
        
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-header bg-white border-bottom p-4">
                    <div class="d-flex align-items-center gap-2 text-primary" style="color: var(--accent) !important;">
                        <i data-lucide="user-plus" size="20"></i>
                        <h6 class="fw-bold mb-0 text-dark">Tambah Pengelola</h6>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <form action="" method="POST">
                        <div class="d-flex flex-column gap-3">
                            <div>
                                <label class="form-label small fw-bold text-muted">Nama Pegawai</label>
                                <div class="input-group border rounded-3 overflow-hidden bg-light">
                                    <span class="input-group-text bg-transparent border-0 text-muted ps-3"><i data-lucide="user" size="16"></i></span>
                                    <input type="text" name="nama" class="form-control bg-transparent border-0 shadow-none" placeholder="Nama lengkap..." required>
                                </div>
                            </div>

                            <div>
                                <label class="form-label small fw-bold text-muted">Status Akses</label>
                                <div class="input-group border rounded-3 overflow-hidden bg-light">
                                    <span class="input-group-text bg-transparent border-0 text-muted ps-3"><i data-lucide="shield" size="16"></i></span>
                                    <select name="role" class="form-select bg-transparent border-0 shadow-none cursor-pointer" required>
                                        <option value="" selected disabled>Pilih Akses...</option>
                                        <option value="Admin">Administrator</option>
                                        <option value="Staff">Staff</option>
                                    </select>
                                </div>
                            </div>

                            <button type="submit" name="simpan_data" class="btn btn-primary w-100 rounded-3 fw-bold mt-2 shadow-sm" style="background-color: var(--accent); border: none;">
                                <i data-lucide="save" size="16" class="me-1"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100 overflow-hidden">
                
                <div class="p-4 border-bottom d-flex flex-wrap gap-3 justify-content-between align-items-center bg-white">
                    <div>
                        <h5 class="fw-bold text-dark mb-1">Daftar Pengelola Aset</h5>
                        <p class="text-muted small mb-0">Total <?php echo mysqli_num_rows($query); ?> pengelola terdaftar</p>
                    </div>
                    
                    <div class="input-group input-group-sm border rounded-3 overflow-hidden bg-light" style="width: 200px;">
                        <span class="input-group-text bg-transparent border-0 text-muted ps-3">
                            <i data-lucide="search" size="14"></i>
                        </span>
                        <input type="text" id="searchInput" class="form-control bg-transparent border-0 shadow-none ps-2" placeholder="Cari...">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-muted small fw-bold border-0">ID</th>
                                <th class="py-3 text-muted small fw-bold border-0">NAMA PEGAWAI</th>
                                <th class="py-3 text-muted small fw-bold border-0 text-center">STATUS</th>
                                <th class="pe-4 py-3 text-muted small fw-bold border-0 text-center">OPSI</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody"> 
                            <?php 
                            if(mysqli_num_rows($query) > 0) {
                                while($row = mysqli_fetch_assoc($query)) { 
                                    $id = $row['IdPegawai'];
                                    $labelRole = $row['ROLE'] ?? 'Staff'; 
                                    
                                    $badgeColor = ($labelRole == 'Admin') ? 'text-primary bg-primary' : 'text-success bg-success';
                            ?>
                            <tr>
                                <td class="ps-4">
                                    <span class="text-muted small">#<?php echo $id; ?></span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-sm bg-light text-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                            <i data-lucide="user" size="16"></i>
                                        </div>
                                        <span class="fw-semibold text-dark nama-pegawai" data-original="<?php echo htmlspecialchars($row['Nama']); ?>">
                                            <?php echo $row['Nama']; ?>
                                        </span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="role-text badge <?php echo $badgeColor; ?> bg-opacity-10 rounded-pill px-3 py-2" style="font-size: 11px;">
                                        <?php echo strtoupper($labelRole); ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-white border-0 text-muted" type="button" data-bs-toggle="dropdown">
                                            <i data-lucide="more-horizontal" size="18"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm">
                                            <li>
                                                <a class="dropdown-item py-2 small" href="index.php?edit_pegawai&id=<?php echo $id; ?>">
                                                    <i data-lucide="edit-3" size="14" class="me-2"></i> Edit
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a class="dropdown-item py-2 small text-danger" 
                                                   href="views/pages/adm_instansi/hapuspegawai.php?id=<?php echo $id; ?>" 
                                                   onclick="return confirm('Hapus pengelola ini?')">
                                                    <i data-lucide="trash-2" size="14" class="me-2"></i> Hapus
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <?php 
                                }
                            } else {
                                echo "<tr><td colspan='4' class='text-center py-5 text-muted'>Data kosong.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
    </div>
</div>

<script>
    // 1. Aktifkan Icon Lucide
    lucide.createIcons();

    // 2. LOGIKA PENCARIAN DENGAN EFEK GLOW/HIGHLIGHT
    const searchInput = document.getElementById('searchInput');
    const tableRows = document.querySelectorAll('#tableBody tr');

    searchInput.addEventListener('input', function() {
        const term = this.value.toLowerCase(); // Kata kunci pencarian
        
        tableRows.forEach(row => {
            // Lewati jika baris "Data Kosong"
            if(row.cells.length < 2) return;

            // Ambil elemen
            const namaEl = row.querySelector('.nama-pegawai');
            const roleEl = row.querySelector('.role-text');
            
            // Ambil teks asli
            const originalNama = namaEl.getAttribute('data-original');
            // Jika role tidak punya class, ambil dari textContent biasa
            const textRole = roleEl ? roleEl.textContent.toLowerCase() : row.cells[2].textContent.toLowerCase();

            // Cek kecocokan
            if (originalNama.toLowerCase().includes(term) || textRole.includes(term)) {
                row.style.display = ''; // Tampilkan

                // --- HIGHLIGHT LOGIC ---
                if (term.length > 0) {
                    // Buat Regex (Case Insensitive)
                    const regex = new RegExp(`(${term})`, 'gi');
                    
                    // Replace teks yang cocok dengan span highlight
                    namaEl.innerHTML = originalNama.replace(regex, `<span class="highlight-anim">$1</span>`);
                } else {
                    // Jika input kosong, kembalikan ke semula
                    namaEl.innerHTML = originalNama;
                }
            } else {
                row.style.display = 'none'; // Sembunyikan
            }
        });
    });
</script>