<?php
include_once 'cores/component.php'; 

$id_serte = isset($_GET['id']) ? mysqli_real_escape_string($koneksi, $_GET['id']) : 0;

$q = mysqli_query($koneksi, "
    SELECT s.*, a.nama_aset, a.kode_aset, a.kategori, a.lokasi, a.kondisi, a.foto 
    FROM serah_terima s 
    JOIN aset a ON s.id_aset = a.id_aset 
    WHERE s.id_serte = '$id_serte'
");

if(!$q || mysqli_num_rows($q) == 0) {
    echo "<script>alert('Data cetak tidak ditemukan!'); window.location='index.php?pg=kserte&fl=list';</script>";
    exit;
}

$data = mysqli_fetch_assoc($q);
$tgl = date('d F Y', strtotime($data['tgl_serte']));
$fotoUrl = !empty($data['foto']) ? "assets/img/aset/".$data['foto'] : "https://via.placeholder.com/300";

$kembaliBtn = buttonhref("index.php?pg=kserte&fl=list", "Kembali", "outline-secondary btn-sm d-print-none", "arrow-left", "");
$cetakBtn = '<button onclick="window.print()" class="btn btn-primary btn-sm d-print-none"><i data-lucide="printer" style="width:16px;"></i> Cetak BAST</button>';

$headerAksi = "<div class='d-flex align-items-center gap-2 d-print-none'>{$kembaliBtn} {$cetakBtn}</div>";
PageHeader("Detail Serah Terima", "Informasi lengkap mengenai aset yang diserahterimakan.", $headerAksi);
?>

<style>
    @media print {
        body { background: #fff !important; }
        #sidebar, .sidebar, .sidebar-overlay, header, .header, .navbar, .no-print, .d-print-none { display: none !important; }
        .main-content { margin: 0 !important; width: 100% !important; padding: 0 !important; }
        .p-4.p-lg-5 { padding: 0 !important; }
        .printable-surat { display: block !important; }
    }
    .printable-surat {
        display: none;
        max-width: 800px;
        margin: 0 auto;
        padding: 40px;
        background: #fff;
        font-family: 'Times New Roman', Times, serif;
        color: #000;
    }
    .kop-surat { display: flex; align-items: center; border-bottom: 3px solid #000; padding-bottom: 15px; margin-bottom: 30px; }
    .kop-logo { width: 80px; height: 80px; object-fit: contain; }
    .kop-teks { flex: 1; text-align: center; }
    .kop-teks h2 { margin: 0; font-size: 24px; font-weight: bold; text-transform: uppercase; }
    .kop-teks p { margin: 5px 0 0; font-size: 14px; }
    
    .judul-surat { text-align: center; margin-bottom: 30px; }
    .judul-surat h4 { margin: 0; font-weight: bold; text-decoration: underline; font-size: 18px; }
    .judul-surat p { margin: 5px 0 0; font-size: 14px; }

    .isi-surat { font-size: 15px; line-height: 1.6; text-align: justify; }
    .tabel-detail { width: 100%; border-collapse: collapse; margin: 20px 0; }
    .tabel-detail th, .tabel-detail td { border: 1px solid #000; padding: 10px; text-align: left; }
    .tanda-tangan { margin-top: 50px; display: flex; justify-content: space-between; text-align: center; }
    .ttd-box { width: 45%; }
    .ttd-nama { margin-top: 80px; font-weight: bold; text-decoration: underline; }
</style>

<div class="row g-4 mt-2 d-print-none">
    <!-- Gambar Aset -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <img src="<?= $fotoUrl ?>" class="card-img-top object-fit-cover" style="height: 250px;" alt="Aset">
            <div class="card-body text-center bg-light">
                <span class="badge bg-secondary mb-2"><?= $data['kode_aset'] ?></span>
                <h5 class="fw-bold mb-0"><?= $data['nama_aset'] ?></h5>
                <p class="text-muted small mb-0"><?= $data['kategori'] ?></p>
            </div>
        </div>
    </div>

    <!-- Informasi BAST -->
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-4">
            <h5 class="fw-bold border-bottom pb-3 mb-4"><i data-lucide="file-text" class="me-2 text-primary"></i> Data Serah Terima</h5>
            
            <div class="row mb-3">
                <div class="col-sm-4 text-muted small text-uppercase fw-semibold">Pihak Penerima</div>
                <div class="col-sm-8 fw-medium">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle bg-light border text-secondary fw-bold d-flex align-items-center justify-content-center" style="width:28px;height:28px;font-size:11px;"><?= strtoupper(substr($data['penerima'], 0, 2)) ?></div>
                        <?= $data['penerima'] ?>
                    </div>
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-sm-4 text-muted small text-uppercase fw-semibold">Pihak Penyetuju</div>
                <div class="col-sm-8 fw-medium">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle bg-light border text-secondary fw-bold d-flex align-items-center justify-content-center" style="width:28px;height:28px;font-size:11px;"><?= strtoupper(substr($data['penyetuju'], 0, 2)) ?></div>
                        <?= $data['penyetuju'] ?>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-4 text-muted small text-uppercase fw-semibold">Tanggal Serah Terima</div>
                <div class="col-sm-8 fw-medium"><?= $tgl ?></div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-4 text-muted small text-uppercase fw-semibold">Kondisi Aset Saat Diserahkan</div>
                <div class="col-sm-8">
                    <?php 
                        $badgeClass = 'bg-secondary';
                        if($data['kondisi'] == 'Baik') $badgeClass = 'bg-success text-success bg-opacity-10';
                        if($data['kondisi'] == 'Rusak Ringan') $badgeClass = 'bg-warning text-warning bg-opacity-10';
                        if($data['kondisi'] == 'Rusak Berat') $badgeClass = 'bg-danger text-danger bg-opacity-10';
                    ?>
                    <span class="badge <?= $badgeClass ?> rounded-pill border px-3"><?= $data['kondisi'] ?></span>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-4 text-muted small text-uppercase fw-semibold">Lokasi Penempatan</div>
                <div class="col-sm-8 fw-medium"><?= !empty($data['lokasi']) ? $data['lokasi'] : '-' ?></div>
            </div>

            <div class="row">
                <div class="col-sm-4 text-muted small text-uppercase fw-semibold">Catatan Keterangan</div>
                <div class="col-sm-8 text-secondary">
                    <div class="p-3 bg-light rounded border">
                        <?= !empty($data['keterangan']) ? nl2br($data['keterangan']) : '<i>Tidak ada catatan tambahan.</i>' ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php 
$no_surat = "BAST/".date('Y', strtotime($data['tgl_serte']))."/".str_pad($data['id_serte'], 3, '0', STR_PAD_LEFT);
$tgl_cetak = date('d F Y', strtotime($data['tgl_serte']));
$hari_array = array('Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu');
$hari = $hari_array[date('l', strtotime($data['tgl_serte']))];
?>

<!-- Bagian Cetak Surat Tersembunyi -->
<div class="printable-surat">
    <div class="kop-surat">
        <img src="assets/img/logo.png" alt="Logo Instansi" class="kop-logo" onerror="this.src='https://via.placeholder.com/80'">
        <div class="kop-teks">
            <h2>SISTEM MANAJEMEN ASET</h2>
            <p>Berita Acara Serah Terima Aset & Inventaris Perusahaan</p>
        </div>
    </div>

    <div class="judul-surat">
        <h4>BERITA ACARA SERAH TERIMA ASET</h4>
        <p>Nomor: <?= $no_surat ?></p>
    </div>

    <div class="isi-surat">
        <p>Pada hari ini, <strong><?= $hari ?></strong>, tanggal <strong><?= $tgl_cetak ?></strong>, telah dilakukan serah terima aset dengan rincian sebagai berikut:</p>
        
        <table class="tabel-detail">
            <thead style="background-color: #f2f2f2;">
                <tr><th width="30%">Atribut</th><th>Detail Aset</th></tr>
            </thead>
            <tbody>
                <tr><td>Nama Barang</td><td><strong><?= $data['nama_aset'] ?></strong></td></tr>
                <tr><td>Kode/Label Aset</td><td><?= $data['kode_aset'] ?></td></tr>
                <tr><td>Kategori</td><td><?= $data['kategori'] ?></td></tr>
                <tr><td>Kondisi Saat Ini</td><td><?= $data['kondisi'] ?></td></tr>
                <tr><td>Keterangan Tambahan</td><td><?= !empty($data['keterangan']) ? $data['keterangan'] : '-' ?></td></tr>
            </tbody>
        </table>

        <p>Dengan diserahkannya aset tersebut, maka pihak Penerima bertanggung jawab penuh atas penggunaan, pemeliharaan, dan keamanan aset sesuai dengan ketentuan yang berlaku.</p>
    </div>

    <div class="tanda-tangan">
        <div class="ttd-box">
            <p>Pihak Menyetujui/Menyerahkan,</p>
            <div class="ttd-nama"><?= $data['penyetuju'] ?></div>
        </div>
        <div class="ttd-box">
            <p>Yang Menerima,</p>
            <div class="ttd-nama"><?= $data['penerima'] ?></div>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();
    <?php if(isset($_GET['print'])) echo "setTimeout(() => { window.print(); }, 500);"; ?>
</script>
