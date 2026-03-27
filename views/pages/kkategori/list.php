<?php
include_once 'cores/component.php'; 

$koneksi = mysqli_connect("localhost", "root", "", "db_asset");

if (isset($_POST['BtnSimpan'])) {
    $nama_kategori = mysqli_real_escape_string($koneksi, $_POST['nama_kategori']);
    $deskripsi   = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);

    if (!empty($_POST['id_kategori'])) {
        $id = $_POST['id_kategori'];
        $query = mysqli_query($koneksi, "UPDATE kategori SET nama_kategori='$nama_kategori', deskripsi='$deskripsi' WHERE id_kategori='$id'");
        $msg = "Kategori diperbarui!";
    } else {
        $query = mysqli_query($koneksi, "INSERT INTO kategori (nama_kategori, deskripsi) VALUES ('$nama_kategori', '$deskripsi')");
        $msg = "Kategori ditambahkan!";
    }
    
    if ($query) {
        echo "<script>alert('$msg'); window.location='index.php?pg=kkategori&fl=list';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal: " . mysqli_error($koneksi) . "');</script>";
    }
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM kategori WHERE id_kategori='$id'");
    echo "<script>alert('Kategori dihapus!'); window.location='index.php?pg=kkategori&fl=list';</script>";
    exit;
}

PageHeader("Manajemen Kategori", "Pengelolaan kategori aset untuk memudahkan identifikasi dan grouping");

?>
<div class="row g-4">
    <div class="col-lg-4">
        <?php
            $BtnSimpan = button("BtnSimpan","Simpan Kategori","primary","save","class='w-100'");
            $formHTML = <<<HTML
                <div class="d-flex align-items-center gap-2 mb-4 pb-3 border-bottom text-primary">
                    <i data-lucide="layers" style="width:20px"></i>
                    <h6 class="fw-bold mb-0 text-dark" id="formTitle">Tambah Kategori Baru</h6>
                </div>
                <form method="POST" autocomplete="off">
                    <input type="hidden" name="id_kategori" id="id_kategori">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Nama Kategori</label>
                        <div class="input-group border bg-light overflow-hidden rounded-3">
                            <span class="input-group-text bg-transparent border-0 text-muted ps-3"><i data-lucide="tag" style="width:18px"></i></span>
                            <input type="text" name="nama_kategori" id="nama_kategori" class="form-control bg-transparent border-0 ps-2 shadow-none" placeholder="Contoh: Elektronik" required>
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
            $th_data = '<th class="ps-4 py-3 fw-bold">Nama Kategori</th><th class="py-3 fw-bold">Deskripsi</th><th class="pe-4 py-3 text-center fw-bold" style="width:100px;">Aksi</th>';
            
            $tr_data = "";
            $q = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY id_kategori DESC");
            if (mysqli_num_rows($q) > 0) {
                while ($row = mysqli_fetch_assoc($q)) {
                    $id = $row['id_kategori'];
                    $nama = $row['nama_kategori'];
                    $deskripsi = $row['deskripsi'];

                    $BtnAksi = AksiDropdown([
                        ["", "javascript:editKategori('$id', '$nama', '$deskripsi')", "edit-3", "Edit"],
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
                $tr_data = "<tr><td colspan='3' class='text-center py-5 text-muted small'>Belum ada data kategori.</td></tr>";
            }

            PageContentTabel($th_data, $tr_data, "", "");
        ?>
    </div>
</div>

<?php modalHapus(); ?>

<script>
    lucide.createIcons();

    function editKategori(id, nama, desc) {
        document.getElementById('formTitle').innerText = "Edit Kategori";
        document.getElementById('id_kategori').value = id;
        document.getElementById('nama_kategori').value = nama;
        document.getElementById('deskripsi').value = desc;
        document.getElementById('btnBatalEdit').classList.remove('d-none');
        document.querySelector('button[name="BtnSimpan"]').innerHTML = '<i data-lucide="check" style="width:18px" class="me-1"></i> Update Kategori';
        lucide.createIcons();
    }

    function resetForm() {
        document.getElementById('formTitle').innerText = "Tambah Kategori Baru";
        document.getElementById('id_kategori').value = "";
        document.getElementById('nama_kategori').value = "";
        document.getElementById('deskripsi').value = "";
        document.getElementById('btnBatalEdit').classList.add('d-none');
        document.querySelector('button[name="BtnSimpan"]').innerHTML = '<i data-lucide="save" style="width:18px" class="me-1"></i> Simpan Kategori';
        lucide.createIcons();
    }

    function setHapus(id) {
        document.getElementById('btnLinkHapus').href = 'index.php?pg=kkategori&fl=list&hapus=' + id;
    }
</script>
