<style>
    .td-color-1-head {
        background-color: #bcaffa !important;
    }
    .td-color-1 {
        background-color: #ece8ff !important;
    }
    .td-color-2-head {
        background-color: #f7db9e !important;
    }
    .td-color-2 {
        background-color: #fff8e8 !important;
    }
</style>

<div class="container-fluid">
    <a href="<?= site_url('/dashboard') ?>">
        <button class="btn cur-p btn-outline-secondary mB-10"><i class="c-light-blue-500 ti-angle-left mR-5"></i> Kembali ke Dashboard</button>
    </a>

    <div class="bd bgc-white p-30 r-10">
        <h5><b>Detail Pengerjaan Naskah</b></h5>

        <table class="table table-bordered" style="width: 50%;">
            <tr>
                <td><b>No. Job</b></td>
                <td class="td-color-1"><?=$naskah->no_job?></td>
            </tr>
            <tr>
                <td><b>Kode</b></td>
                <td class="td-color-1"><?=$naskah->kode?></td>
            </tr>
            <tr>
                <td><b>Judul</b></td>
                <td class="td-color-1"><?=$naskah->judul?></td>
            </tr>
            <tr>
                <td><b>Jilid</b></td>
                <td class="td-color-1"><?=$naskah->jilid?></td>
            </tr>
            <tr>
                <td><b>Pengarang</b></td>
                <td class="td-color-1"><?=$naskah->penulis?></td>
            </tr>
            <tr>
                <td><b>Posisi</b></td>
                <td class="td-color-1"></td>
            </tr>
        </table>

        <table class="table table-bordered">
            <tr style="font-weight:bold">
                <td style="background-color: #2196f3;color:#fff;">Status</td>
                <td class="td-color-1-head">PIC</td>
                <td class="td-color-1-head">Rencana Start</td>
                <td class="td-color-2-head">Rencana Finish</td>
                <td class="td-color-1-head">Realisasi Start</td>
                <td class="td-color-2-head">Realisasi Finish</td>
                <td style="background-color: #2196f3;color:#fff;" width="120">Catatan Cicil</td>
                <td style="background-color: #2196f3;color:#fff;" width="120">Catatan Finish</td>
            </tr>
            <?php
                foreach ($progress as $p) {
            ?>
                <tr>
                    <td><?=$level_kerja_key_map[$p['key']]['text']?></td>
                    <td class="td-color-1"><?=$p['pic']?></td>
                    <td class="td-color-1"><?=getIndoDateWithDay($p['tgl_rencana_mulai'])?></td>
                    <td class="td-color-2"><?=getIndoDateWithDay($p['tgl_rencana_selesai'])?></td>
                    <td class="td-color-1"><?=getIndoDateWithDay($p['waktu_mulai'])?></td>
                    <td class="td-color-2"><?=getIndoDateWithDay($p['waktu_selesai'])?></td>
                    <td style="text-align:center;"><?=$p['catatan_cicil'] != '' ? '<i onClick="loadCatatan(\''.$p['catatan_cicil'].'\')" id="catatan-button" type="button" data-bs-toggle="modal" data-bs-target="#catatanModal" class="ti-notepad pR-10"></i>' : '' ?></td>
                    <td style="text-align:center;"><?=$p['catatan'] != '' ? '<i onClick="loadCatatan(\''.$p['catatan'].'\')" id="catatan-button" type="button" data-bs-toggle="modal" data-bs-target="#catatanModal" class="ti-notepad pR-10"></i>' : '' ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>

<div class="modal fade bd-example-modal-md" id="catatanModal" role="dialog" aria-labelledby="formModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <p id="catatan-content">-</p>
            </div>
        </div>
    </div>
</div>

<script>
    function loadCatatan(content) {
        console.log(content);
        document.getElementById('catatan-content').innerHTML = content
    }
</script>