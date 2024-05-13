<div class="container-fluid">
    <h4 class="c-grey-900 mT-10 mB-30">Detail Proses Job</h4>
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <div class="mB-20">
                    <button type="button" class="btn cur-p btn-outline-secondary" onclick="refreshTable()">
                        <i class="ti-reload"></i>
                    </button>
                </div>

                <table id="prosesJobTable" class="table table-bordered" cellspacing="0" width="100%">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>No. Job</th>
                            <th>Kode Buku</th>
                            <th>Judul</th>
                            <th>Level Kerja</th>
                            <th>Status</th>
                            <th>PIC</th>
                            <th>Rencana Mulai</th>
                            <th>Rencana Selesai</th>
                            <th>Catatan</th>
                            <th>Progress</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $startNumber = (inputGet('page') == 0 ? 1 : (inputGet('page')+1)*$perPagePagination) - 1;
                            foreach ($jobs['jobs'] as $job_idx => $job) {
                                $number = $startNumber+=1;
                        ?>
                            <tr>
                                <td rowspan="<?=$job['total']?>"><?=$number?></td>
                                <td rowspan="<?=$job['total']?>"><?=$job['no_job']?></td>
                                <td rowspan="<?=$job['total']?>"><?=$job['kode']?></td>
                                <td rowspan="<?=$job['total']?>"><?=$job['judul']?></td>
                                <?php 
                                    $lk_data = json_decode($job['lk_data']);
                                    foreach ($lk_data as $lk_idx => $lk) {
                                        $barColor = '58a85e';
                                        $barPercentage = ($lk->progress_hari ? $lk->progress_hari : 0)*100/$lk->durasi;
                                        if ($barPercentage >= 50 && $barPercentage <= 100) {
                                            $barColor = 'd1a847';
                                        } else if ($barPercentage > 100) {
                                            $barColor = 'd94141';
                                        }

                                        // previous level kerja status
                                        $previousLvlStatus = $lk_idx != 0 ? $lk_data[$lk_idx-1]->status : null;
                                        $currentLvlStatus = $lk_data[$lk_idx]->status;
                                ?>
                                    <?php if ($lk_idx != 0) { echo '<tr>'; } ?>
                                        <td style="width:100px;background-color:<?=$lk_idx == 0 ? '#ccffc7' : ($lk_idx+1 == $job['total'] ? '#fffec7' : '#ffffff')?>"><?=$levelKerjaMap[$lk->level]['text']?></td>
                                        <td style="background-color:<?=$statusMap[$lk->status]['bgColor']?>"><?=$statusMap[$lk->status]['text']?></td>
                                        <td><?=$lk->nama ? $lk->nama : '<i style="color:red">Tentatif</i>'?></td>
                                        <td style="width:100px;text-align:center;"><?=date('d-m-Y', strtotime($lk->tgl_rencana_mulai))?></td>
                                        <td style="width:100px;text-align:center;background-color:<?=(date('Y-m-d', time()) > $lk->tgl_rencana_selesai && ($lk->status != 'finished' && $lk->status != 'cicil')) ? '#ffd7cf' : '#ffffff'?>;"><?=date('d-m-Y', strtotime($lk->tgl_rencana_selesai))?></td>
                                        <td style="max-width:150px;"><?=$lk->tgl_cicil != '' ? '('.date('d-m-Y', strtotime($lk->tgl_cicil)).')' : ''?><br><?=$lk->catatan?></td>
                                        <td style="width:150px;text-align:center"><div style="height:20px;width:100%;border:solid 1px #ddd;border-radius:5px;"><div style="height:18px;width:<?=(($lk->progress_hari ? $lk->progress_hari : 0)*100/$lk->durasi)?>%;background:#<?=$barColor?>;border-radius:5px;text-align:center;color:#fff"><?=($lk->durasi == 0 ? '100' : (($lk->progress_hari ? $lk->progress_hari : 0)*100/$lk->durasi))?>%</div></div><div><?=($lk->progress_hari ? $lk->progress_hari : 0)?> dari <?=$lk->durasi?> hari</div></td>
                                        <td style="max-width:110px;text-align:center;">
                                            <?php if ($lk->status != 'finished' && $lk->status != 'cicil' && $lk->status != 'on_progress') { ?>
                                                <div class="bootstrap">
                                                    <button class="btn btn-<?=($lk_idx != 0 ? ($previousLvlStatus == 'open' || $previousLvlStatus == 'on_progress' || $previousLvlStatus == 'paused' || $currentLvlStatus == 'paused') ? 'warning' : ($previousLvlStatus == 'finished' ? 'warning' : 'info') : 'info') ?>  <?=($lk_idx != 0 ? ($previousLvlStatus == 'open' || $previousLvlStatus == 'on_progress' || $previousLvlStatus == 'paused' || $currentLvlStatus == 'paused') ? 'disabled' : ($previousLvlStatus == 'finished' ? '' : '') : '') ?>  dropdown-toggle <?=$lk->status == 'on_progress' ? 'disabled' : ''?>" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <?=($lk_idx != 0 ? ($previousLvlStatus == 'open' || $previousLvlStatus == 'on_progress' || $previousLvlStatus == 'paused' || $currentLvlStatus == 'paused') ? 'Kirim' : ($previousLvlStatus == 'finished' ? 'Kirim' : 'Bagi') : 'Bagi') ?> 
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        
                                                    <?php
                                                        foreach ($roles_karyawan as $naskah_pic) {
                                                            if ($naskah_pic['role_key'] == $level_kerja_key_map[$lk->level]['pic']) {
                                                                foreach (json_decode($naskah_pic['karyawan']) as $pic) {
                                                                    echo '<a class="dropdown-item" href="#" onclick="assignTaskTo('.$lk->id_naskah.', \''.$lk->level.'\', '.$pic->id.')">'.$pic->nama.'</a>';
                                                                }
                                                            }
                                                        }
                                                    ?>
                                                </div>
                                            <?php } ?>
                                            <button class="btn btn-success">Detail</button>
                                        </td>
                                    <?php if ($lk_idx != 0) { echo '</tr>'; } ?>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div style="text-align:center">
                    <a href="?page=<?=inputGet('page')-1;?>" class="btn btn-primary <?=inputGet('page') == '' || inputGet('page') == 0 ? 'disabled' : ''?>">Prev</a>
                    <a href="?page=<?=inputGet('page')+1;?>" class="btn btn-primary <?=(inputGet('page')+1)*$perPagePagination >= $jobs['foundRows'] ? 'disabled' : ''?>">Next</a>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    function assignTaskTo(naskahId, levelKerja, picId) {
        $.ajax({
            url: "<?=site_url(uriSegment(1))?>/assignTaskTo",
            method: 'POST',
            data: {
                naskahId,
                levelKerja,
                picId
            }
        }).then(res => {
            res = JSON.parse(res)

            if (res.success == true) {
                
                Swal.fire(
                    'Berhasil!',
                    'Berhasil membagi dan meneruskan ke level selanjutnya',
                    'success'
                ).then(function() {
                    location.reload()
                })
            }
        })
    }
</script>