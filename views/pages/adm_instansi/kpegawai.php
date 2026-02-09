<?php 
// Variabel judul halaman
$judul = "Data Pegawai"; 

// Query mengambil data pegawai
$query = mysqli_query($koneksi, "SELECT * FROM pegawai ORDER BY IdPegawai DESC");
?>

<style>
    .highlight-anim {
        background-color: #fff3cd;      /* Latar kuning muda */
        color: #020202;                 /* Teks Pink/Ungu */
        font-weight: 800 !important;    /* Bold */
        text-shadow: 0 0 10px rgb(255, 250, 252); /* Efek Glow */
        padding: 0 2px;
        border-radius: 3px;
        transition: all 0.3s ease;
    }
</style>

<div class="content-wrapper p-4">
    <div class="card-premium p-0 overflow-hidden shadow-sm border-0 rounded-4 bg-white">
        
        <div class="p-4 border-bottom d-flex flex-wrap gap-3 justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold text-dark mb-1">Daftar Akses Pengguna Terdaftar</h5>
            </div>

            <div class="d-flex gap-2">
                <div class="input-group input-group-sm border rounded-3 overflow-hidden bg-light" style="width: 250px;">
                    <span class="input-group-text bg-transparent border-0 text-muted ps-3">
                        <i data-lucide="search" size="14"></i>
                    </span>
                    <input type="text" id="searchInput" class="form-control bg-transparent border-0 shadow-none ps-2" placeholder="Cari nama pegawai...">
                </div>
                <a href="index.php?tambah_pegawai" class="btn btn-primary btn-sm px-3 rounded-3 d-flex align-items-center gap-2" style="background-color: var(--accent); border: none;">
                    <i data-lucide="plus" size="16"></i> <span class="fw-bold">Tambah</span>
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle" style="min-height: 200px;">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-muted small fw-bold border-0" style="width: 100px;">ID</th>
                        <th class="py-3 text-muted small fw-bold border-0">NAMA LENGKAP</th>
                        <th class="py-3 text-muted small fw-bold border-0 text-center">ROLE / AKSES</th>
                        <th class="py-3 text-muted small fw-bold border-0 text-center" style="width: 100px;">OPSI</th>
                    </tr>
                </thead>
                <tbody id="tableBody"> 
                    <?php 
                    if(mysqli_num_rows($query) > 0) {
                        while($row = mysqli_fetch_assoc($query)) { 
                            $id = $row['IdPegawai'];
                            
                            // Logika warna badge role
                            $roleClass = 'bg-secondary';
                            if($row['role'] == 'admin') $roleClass = 'bg-danger';
                            elseif($row['role'] == 'adm_aset') $roleClass = 'bg-primary';
                            elseif($row['role'] == 'teknisi') $roleClass = 'bg-warning text-dark';
                    ?>
                    <tr>
                        <td class="ps-4">
                            <span class="badge bg-light text-dark border fw-bold">#<?php echo $id; ?></span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center text-secondary" style="width: 32px; height:32px;">
                                   <i data-lucide="user" size="16"></i>
                                </div>

                                <span class="fw-semibold text-dark nama-pegawai" data-original="<?php echo htmlspecialchars($row['Nama']); ?>">
                                    <?php echo $row['Nama']; ?>
                                </span>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="role-text badge <?php echo $roleClass; ?> bg-opacity-10 <?php echo (strpos($roleClass, 'text-dark') !== false) ? 'text-dark' : 'text-' . explode('-', $roleClass)[1]; ?> rounded-pill px-3 py-2" style="font-size: 11px;">
                                <?php echo strtoupper($row['role']); ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="dropdown">
                                <button class="btn btn-link text-decoration-none text-muted p-0" 
                                        type="button" 
                                        data-bs-toggle="dropdown" 
                                        aria-expanded="false"> 
                                        <i data-lucide="more-vertical" width="18" height="18"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                    <li>
                                        <a class="dropdown-item py-2 d-flex align-items-center gap-2" 
                                           href="index.php?edit_pegawai&id=<?php echo $id; ?>">
                                            <i data-lucide="edit-3" width="14" height="14"></i>
                                            <span>Edit</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item py-2 d-flex align-items-center gap-2 text-danger" 
                                           href="views/pages/adm_instansi/hapuspegawai.php?id=<?php echo $id; ?>" 
                                           onclick="return confirm('Yakin ingin menghapus data pegawai ini?')">
                                            <i data-lucide="trash-2" width="14" height="14"></i>
                                            <span>Hapus</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <?php 
                        }
                    } else {
                        echo "<tr><td colspan='4' class='text-center py-5 text-muted small'>Belum ada data pegawai di database.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // 1. Aktifkan Icon Lucide
    lucide.createIcons();

    // 2. LOGIKA PENCARIAN DENGAN EFEK GLOW
    const searchInput = document.getElementById('searchInput');
    const tableRows = document.querySelectorAll('#tableBody tr');

    searchInput.addEventListener('input', function() {
        const filter = this.value.toLowerCase(); // Kata kunci (huruf kecil)
        
        tableRows.forEach(row => {
            // Lewati baris "Data Kosong"
            if(row.cells.length < 2) return;

            // Ambil elemen
            const namaEl = row.querySelector('.nama-pegawai');
            const roleEl = row.querySelector('.role-text'); // Pastikan role punya class ini atau gunakan sel index
            
            // Ambil data asli
            const originalNama = namaEl.getAttribute('data-original');
            // Jika roleEl null (karena struktur HTML beda), ambil text content biasa
            const originalRole = roleEl ? roleEl.textContent : row.cells[2].textContent;

            // Cek Pencarian
            if (originalNama.toLowerCase().includes(filter) || originalRole.toLowerCase().includes(filter)) {
                row.style.display = ''; // Tampilkan baris

                // --- EFEK HIGHLIGHT / GLOW ---
                if (filter.length > 0) {
                    // Buat Regex Case Insensitive
                    const regex = new RegExp(`(${filter})`, 'gi');
                    
                    // Ganti teks yang cocok dengan span highlight
                    // $1 artinya teks asli yang ditemukan (tetap menjaga huruf besar/kecilnya)
                    namaEl.innerHTML = originalNama.replace(regex, `<span class="highlight-anim">$1</span>`);
                } else {
                    // Jika kosong, kembalikan normal
                    namaEl.innerHTML = originalNama;
                }

            } else {
                row.style.display = 'none'; // Sembunyikan baris
            }
        });
    });
</script>