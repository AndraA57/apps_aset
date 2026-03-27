<?php
include_once 'cores/component.php'; 

$koneksi = mysqli_connect("localhost", "root", "", "db_asset");

if (isset($_POST['BtnSimpan'])) {
    $nama_lokasi = mysqli_real_escape_string($koneksi, $_POST['nama_lokasi']);
    $deskripsi   = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);

    if (!empty($_POST['id_lokasi'])) {
        $id = $_POST['id_lokasi'];
        $query = mysqli_query($koneksi, "UPDATE lokasi SET nama_lokasi='$nama_lokasi', deskripsi='$deskripsi' WHERE id_lokasi='$id'");
        $msg = "Lokasi diperbarui!";
    } else {
        $query = mysqli_query($koneksi, "INSERT INTO lokasi (nama_lokasi, deskripsi) VALUES ('$nama_lokasi', '$deskripsi')");
        $msg = "Lokasi ditambahkan!";
    }
    
    if ($query) {
        echo "<script>alert('$msg'); window.location='index.php?pg=klokasi&fl=list';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal: " . mysqli_error($koneksi) . "');</script>";
    }
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM lokasi WHERE id_lokasi='$id'");
    echo "<script>alert('Lokasi dihapus!'); window.location='index.php?pg=klokasi&fl=list';</script>";
    exit;
}

PageHeader("Manajemen Lokasi", "Pengelolaan titik penempatan aset (contoh: RPS Atas)");

?>
<div class="row g-4">
    <div class="col-lg-4">
        <?php
            $BtnSimpan = button("BtnSimpan","Simpan Lokasi","primary","save","class='w-100'");
            $formHTML = <<<HTML
                <div class="d-flex align-items-center gap-2 mb-4 pb-3 border-bottom text-primary">
                    <i data-lucide="map-pin" style="width:20px"></i>
                    <h6 class="fw-bold mb-0 text-dark" id="formTitle">Tambah Lokasi Baru</h6>
                </div>
                <form method="POST" autocomplete="off">
                    <input type="hidden" name="id_lokasi" id="id_lokasi">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Nama Lokasi</label>
                        <div class="input-group border bg-light overflow-hidden rounded-3">
                            <span class="input-group-text bg-transparent border-0 text-muted ps-3"><i data-lucide="map" style="width:18px"></i></span>
                            <input type="text" name="nama_lokasi" id="nama_lokasi" class="form-control bg-transparent border-0 ps-2 shadow-none" placeholder="Contoh: RPS Atas" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Deskripsi</label>
                        <div class="input-group border bg-light overflow-hidden rounded-3 align-items-start">
                            <span class="input-group-text bg-transparent border-0 text-muted ps-3 pt-2"><i data-lucide="align-left" style="width:18px"></i></span>
                            <textarea name="deskripsi" id="deskripsi" class="form-control bg-transparent border-0 p-2 shadow-none" rows="3" placeholder="Keterangan..." style="resize: none;"></textarea>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-4">
                        <button type="button" class="btn btn-light text-muted fw-bold shadow-sm d-none" id="btnBatalEdit" onclick="resetForm()" style="width: 50%;">Batal</button>
                        $BtnSimpan
                    </div>
                </form>
HTML;
            PageContentForm($formHTML);
        ?>
    </div>

    <div class="col-lg-8">
        <?php
            $th_data = '<th class="ps-4 py-3 fw-bold">Nama Lokasi</th><th class="py-3 fw-bold">Deskripsi</th><th class="pe-4 py-3 text-center fw-bold" style="width:100px;">Aksi</th>';
            
            $tr_data = "";
            $q = mysqli_query($koneksi, "SELECT * FROM lokasi ORDER BY id_lokasi DESC");
            if (mysqli_num_rows($q) > 0) {
                while ($row = mysqli_fetch_assoc($q)) {
                    $id = $row['id_lokasi'];
                    $nama = $row['nama_lokasi'];
                    $deskripsi = $row['deskripsi'];

                    $BtnAksi = AksiDropdown([
                        ["", "javascript:editLokasi('$id', '$nama', '$deskripsi')", "edit-3", "Edit"],
                        ["hr"],
                        ["hapus", "#", "trash-2", "Hapus", "danger", "setHapus('$id')"]
                    ]);

                    $tr_data .= <<<TR
                    <tr>
                        <td class="ps-4 py-3 fw-bold text-dark">$nama</td>
                        <td class="py-3 text-muted small">$deskripsi</td>
                        <td class="pe-4 py-3 text-center">$BtnAksi</td>
                    </tr>
TR;
                }
            } else {
                $tr_data = "<tr><td colspan='3' class='text-center py-5 text-muted small'>Belum ada data lokasi.</td></tr>";
            }

            PageContentTabel($th_data, $tr_data, "", "");
        ?>
    </div>
</div>

<?php modalHapus(); ?>

<script>
    lucide.createIcons();

    function editLokasi(id, nama, desc) {
        document.getElementById('formTitle').innerText = "Edit Lokasi";
        document.getElementById('id_lokasi').value = id;
        document.getElementById('nama_lokasi').value = nama;
        document.getElementById('deskripsi').value = desc;
        document.getElementById('btnBatalEdit').classList.remove('d-none');
        document.querySelector('button[name="BtnSimpan"]').innerHTML = '<i data-lucide="check" style="width:18px" class="me-1"></i> Update Lokasi';
        lucide.createIcons();
    }

    function resetForm() {
        document.getElementById('formTitle').innerText = "Tambah Lokasi Baru";
        document.getElementById('id_lokasi').value = "";
        document.getElementById('nama_lokasi').value = "";
        document.getElementById('deskripsi').value = "";
        document.getElementById('btnBatalEdit').classList.add('d-none');
        document.querySelector('button[name="BtnSimpan"]').innerHTML = '<i data-lucide="save" style="width:18px" class="me-1"></i> Simpan Lokasi';
        lucide.createIcons();
    }

    function setHapus(id) {
        const urlParams = new URLParams();
        document.getElementById('btnLinkHapus').href = 'index.php?pg=klokasi&fl=list&hapus=' + id;
    }
</script>