

<!DOCTYPE html>
<html>
<head>
    <title>Cetak Surat</title>
    <style>
        body { font-family: 'Times New Roman', serif; padding: 30px; }
        .kop { text-align: center; border-bottom: 3px double #000; pb: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; }
    </style>
</head>
<body onload="window.print();">
    <?php
        // Ambil data dari database berdasarkan ID yang dikirim
        $id = $_GET['id'];
        // Contoh data dummy (Ganti dengan query database Anda)
        $no_surat = "001/SR/2026";
    ?>
    <div class="kop">
        <h2>PT. TEKNOLOGI INDONESIA</h2>
        <p>Jl. Jenderal Sudirman No. 45, Jakarta</p>
    </div>

    <h3 style="text-align:center">BERITA ACARA SERAH TERIMA</h3>
    <p>Nomor: <?= $no_surat ?></p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Qty</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Laptop Asus (Contoh dari Database)</td>
                <td>1 Unit</td>
            </tr>
        </tbody>
    </table>

    <?php
        error_reporting(0);
        $id=$_GET['id'];
        $jenis=$_GET['jenis'];
        
        echo "
            $id - $jenis
        "
    ?>
</body>
</html>