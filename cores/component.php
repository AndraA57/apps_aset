<?php
    function button($var="",$val="",$warna="",$icon="",$attbr="")
    {
        return <<<button
            <button type="submit" name="$var" value="$val" class="btn btn-$warna fw-bold shadow-sm" style="border:none; white-space: nowrap;" $attbr>
                <i data-lucide="$icon" style="width:18px" class="me-1"></i> $val
            </button>
        button;
    }

    function buttonhref($link="",$val="",$warna="",$icon="",$attbr="")
    {
        return <<<buttonhref
            <a href="$link" class="btn btn-$warna fw-bold py-2 shadow-sm" style="border:none;" $attbr>
                <i data-lucide="$icon" style="width:18px" class="me-1"></i> $val
            </a>
        buttonhref;
    }


    function AksiDropdown($li=[])
    {
        //0=jenis, 1=link, 2=icon, 3=Judul, 4=warna, 5=onclick
        $hasil = '<div class="d-flex gap-1 justify-content-end">';
        
        foreach($li as $Arli)
        {
            // Lewati pembatas (hr) karena kita menggunakan tampilan sejajar
            if(!isset($Arli[0]) || $Arli[0] == 'hr') continue; 
            
            // Default warna jika kosong
            $warna = (isset($Arli[4]) && $Arli[4] != "") ? $Arli[4] : "primary";
            
            switch($Arli[0])
            {
                case "hapus":
                    $hasil .= <<<btn
                        <button type="button" class="btn btn-sm btn-light text-$warna border shadow-sm" data-bs-toggle="modal" data-bs-target="#modalHapus" onclick="{$Arli[5]}" data-bs-toggle="tooltip" title="{$Arli[3]}">
                            <i data-lucide="{$Arli[2]}" style="width: 16px;"></i>
                        </button>
                    btn;
                break;
                case "qr":
                    $hasil .= <<<btn
                        <button type="button" class="btn btn-sm btn-light text-$warna border shadow-sm" data-bs-toggle="modal" data-bs-target="#modalCetakQR" onclick="{$Arli[5]}" data-bs-toggle="tooltip" title="{$Arli[3]}">
                            <i data-lucide="{$Arli[2]}" style="width: 16px;"></i>
                        </button>
                    btn;
                break;
                case "print":
                    $hasil .= <<<btn
                        <button type="button" class="btn btn-sm btn-light text-$warna border shadow-sm" onclick="{$Arli[5]}" data-bs-toggle="tooltip" title="{$Arli[3]}">
                            <i data-lucide="{$Arli[2]}" style="width: 16px;"></i>
                        </button>
                    btn;
                break;
                default:
                    $attr = isset($Arli[5]) ? $Arli[5] : "";
                    $hasil .= <<<btn
                        <a href="{$Arli[1]}" class="btn btn-sm btn-light text-$warna border shadow-sm" {$attr} data-bs-toggle="tooltip" title="{$Arli[3]}">
                            <i data-lucide="{$Arli[2]}" style="width: 16px;"></i>
                        </a>
                    btn;
                break;
            }
        }
        
        $hasil .= '</div>';
        return $hasil;
        
        return <<<aksi
            <div class="dropdown">
                <button class="btn btn-sm btn-light border shadow-sm" type="button" data-bs-toggle="dropdown" data-bs-popper-config='{"strategy":"fixed"}'>
                    <i data-lucide="more-horizontal" style="width:16px"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0" style="z-index: 9999;">
                    $hasil
                </ul>
            </div>
        aksi;
    }

    // --- FITUR PENCARIAN DITAMBAHKAN DI SINI ---
    // Saya menambahkan parameter ke-4 ($tampilCari) untuk on/off fitur pencarian jika dibutuhkan
    function PageHeader($Judul="", $JudulDeskripsi="", $Tambahan=""){
        
        

        echo <<<PageHeader
            <div class="row align-items-center mb-4 g-3">
                <div class="col-md-6">
                    <h4 class="fw-bold text-dark mb-0" style="letter-spacing: -0.5px;">$Judul</h4>
                    <p class="text-secondary small mb-0 mt-1">$JudulDeskripsi</p>
                </div>
                <div class="col-md-6">
                    <div class="d-flex gap-2 justify-content-md-end align-items-center">
                        $Tambahan
                    </div>
                </div>
            </div>
        PageHeader;
    }

    function PageContentTabel($th="",$tr="",$ketnum="",$li="")
    {
        echo <<<PageContent
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden" style="background: #ffffffff;">
                <div class="card-body p-0">
                    <div class="table-responsive" style="overflow-x: auto; overflow-y: hidden;">
                        <table class="table table-hover align-middle mb-0" style="border-collapse: collapse; white-space: nowrap;">
                
                            <thead class="bg-white border-bottom sticky-top" style="z-index: 10;">
                                <tr>
                                    $th
                                </tr>
                            </thead>

                            <tbody class="border-top-0">
                                
                                    $tr
                                    
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white border-top py-3 px-4">
                     <div class="d-flex justify-content-between align-items-center">
                        $ketnum
                        <nav>
                            <ul class="pagination pagination-sm mb-0 gap-1">
                                $li
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        PageContent;
    }

    function PageContentForm($Konten)
    {
        echo <<<PageContent
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden" style="background: #fff;">
                <div class="card-body p-4">
                    $Konten
                </div>
            </div>
        PageContent;
    }


    function modalHapus()
    {
        echo <<<m
            <div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
                <div class="modal-dialog modal-dialog-centered modal-sm">
                    <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
                        
                        <div class="modal-body text-center p-4">
                            <div class="mb-3">
                                <div class="d-inline-flex align-items-center justify-content-center bg-danger bg-opacity-10 text-danger rounded-circle" style="width: 64px; height: 64px;">
                                    <i data-lucide="alert-triangle" style="width: 32px; height: 32px;"></i>
                                </div>
                            </div>

                            <h6 class="fw-bold text-dark mb-1">Yakin Data dihapus?</h6>
                            <p class="text-muted small mb-4">
                                Tindakan ini tidak dapat dibatalkan. Data akan hilang permanen dari sistem
                            </p>

                            <div class="d-grid gap-2">
                                <a href="#" id="btnLinkHapus" class="btn btn-danger fw-bold py-2 rounded-3 shadow-sm">
                                    Ya
                                </a>
                                
                                <button type="button" class="btn btn-light text-secondary fw-bold py-2 rounded-3" data-bs-dismiss="modal">
                                    Batal
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        m;
    }

    function modalQRCode()
    {
        echo <<<qr
            <div class="modal fade" id="modalCetakQR" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
                <div class="modal-dialog modal-dialog-centered modal-sm">
                    <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
                        <div class="modal-header border-0 pb-0">
                            <h6 class="modal-title fw-bold">Cetak QR Code</h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        
                        <div class="modal-body text-center" id="areaCetak">
                            <div class="p-4 border border-2 rounded-3 mb-2 d-inline-block bg-white" style="border-style: dashed !important; border-color: #ccc;">
                                <div class="fw-bold text-uppercase small mb-3" style="letter-spacing: 1px;">INVENTARIS ASET</div>
                                
                                <div class="d-flex justify-content-center mb-2">
                                    <div id="qrcode"></div>
                                </div>
                                
                                <div class="mt-2">
                                    <span id="labelKode" class="d-block text-muted small" style="font-size: 0.75rem;"></span>
                                    <span id="labelNamaAset" class="d-block fw-bold text-dark" style="font-size: 0.85rem;"></span>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer border-0 pt-0">
                            <button type="button" class="btn btn-primary w-100 rounded-3 fw-bold" onclick="printLabel()">
                                <i data-lucide="printer" class="me-1" style="width: 16px;"></i> Print
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        qr;
    }

    function dialogPrint()
    {
        echo <<<d
            <iframe id="frameCetak" name="frameCetak" style="display:none;"></iframe>
        d;
    }
?>