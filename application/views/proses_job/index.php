<div class="container-fluid">
    <h4 class="c-grey-900 mT-10 mB-30">Detail Proses Job</h4>
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <!-- filters -->
                <div id="filter" class="mB-20">
                    <form id="nonDtFilter">
                        <div class="row mB-10">
                            <div class="col-md-2">
                                <label class="form-label">No Job</label>
                                <input type="text" name="no_job" value="<?=$this->input->get('no_job')?>" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Judul</label>
                                <input type="text" name="judul" value="<?=$this->input->get('judul')?>" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Jenjang</label>
                                <select name="id_jenjang" id="jenjang" class="form-control">
                                    <option value="" selected>--Semua Jenjang--</option>
                                    <?php foreach ($jenjangs as $jenjang) { ?>
                                        <option value="<?=$jenjang['id']?>" <?=$jenjang['id'] == $this->input->get('id_jenjang') ? 'selected' : ''?>><?=$jenjang['nama_jenjang']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Mapel</label>
                                <select name="id_mapel" id="mapel" class="form-control">
                                    <option value="" selected>--Semua Mapel--</option>
                                    <?php foreach ($mapels as $mapel) { ?>
                                        <option value="<?=$mapel['id']?>" <?=$mapel['id'] == $this->input->get('id_mapel') ? 'selected' : ''?>><?=$mapel['nama_mapel']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Kategori</label>
                                <select name="id_kategori" id="kategori" class="form-control">
                                    <option value="" selected>--Semua Kategori--</option>
                                    <?php foreach ($kategoris as $kategori) { ?>
                                        <option value="<?=$kategori['id']?>" <?=$kategori['id'] == $this->input->get('id_kategori') ? 'selected' : ''?>><?=$kategori['nama_kategori']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-color" style="float:right">Filter</button>
                                <a href="<?=site_url($this->uri->segment(1))?>" class="btn cur-p btn-outline-primary mR-10" style="float:right;color:black;">Clear</a>
                            </div>
                        </div>
                    </form>
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
                            <th width="130">Rencana Mulai</th>
                            <th width="130">Rencana Selesai</th>
                            <!-- <th width="130">Realisasi Mulai</th>
                            <th width="130">Realisasi Finish</th> -->
                            <th>Catatan</th>
                            <th>Progress</th>
                            <th width="180">Aksi</th>
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
                                        <td style="width:100px;text-align:center;">
                                            <?php if (date('Y-m-d', time()) > $lk->tgl_rencana_mulai && ($lk->status == 'open')) { ?>
                                                <span style="color:red" data-toggle="tooltip" data-placement="bottom" title="Telah melewati tanggal Rencana Mulai dan belum dikerjakan (telat dimulai)"><i class="ti-alert"></i></span>&nbsp;
                                            <?php } ?>
                                            <?=date('d-m-Y', strtotime($lk->tgl_rencana_mulai))?>
                                        </td>
                                        <td style="width:100px;text-align:center;background-color:<?=(date('Y-m-d', time()) > $lk->tgl_rencana_selesai && ($lk->status != 'finished' && $lk->status != 'cicil')) ? '#ffffff' : '#ffffff'?>;">
                                            <?php if (date('Y-m-d', time()) > $lk->tgl_rencana_selesai && ($lk->status != 'finished' && $lk->status != 'cicil')) { ?>
                                                <span style="color:red" data-toggle="tooltip" data-placement="bottom" title="Melewati tanggal Rencana Selesai (tidak tepat waktu)"><i class="ti-alert"></i></span>&nbsp;
                                            <?php } ?>
                                            <?=date('d-m-Y', strtotime($lk->tgl_rencana_selesai))?>
                                        </td>
                                        <!-- <td><?=date('d-m-Y', strtotime($lk->tgl_rencana_selesai))?></td> -->
                                        <!-- <td><?=date('d-m-Y', strtotime($lk->tgl_rencana_selesai))?></td> -->
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
                                            <a href="<?=site_url('naskah/detail') .'/'. $job['no_job']?>" class="btn btn-success">Detail</a>
                                        </td>
                                    <?php if ($lk_idx != 0) { echo '</tr>'; } ?>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div style="text-align:center">
                    <?php if (!(inputGet('page') == '' || inputGet('page') == 0) && ((inputGet('page')+1)*$perPagePagination >= $jobs['foundRows'])) { ?>
                        <a href="?page=<?=inputGet('page')-1;?>" class="btn btn-primary <?=inputGet('page') == '' || inputGet('page') == 0 ? 'disabled' : ''?>">Prev</a>
                        <a href="?page=<?=inputGet('page')+1;?>" class="btn btn-primary <?=(inputGet('page')+1)*$perPagePagination >= $jobs['foundRows'] ? 'disabled' : ''?>">Next</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();

		let nonDtFilter = []
		$('#nonDtFilter').submit(function (e) {
			e.preventDefault()

			nonDtFilter.filters = $('#nonDtFilter :input').serialize().replace(/\+/g, '%20');
			
            window.location.href = "<?=site_url('proses_job')?>?" + nonDtFilter.filters
		})
    })

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