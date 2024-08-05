<style>
    tbody td {
        vertical-align: middle; /* This centers the text vertically */
    }
</style>

<div class="modal fade bd-example-modal-xl" id="naskahFormModal" role="dialog" aria-labelledby="formModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form id="formNaskah">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="naskahFormTitle"><?=uriSegment(2) == 'pengajuan' ? 'Ajukan' : 'Buat'?> Naskah Baru</h5>
                    <span id="closeNaskahFormModalButton" type="button" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <div id="naskahError" class="alert alert-danger"></div>

                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label class="form-label">No Job</label>
                            <input type="text" name="no_job" id="" class="form-control" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Kode Buku</label>
                            <input type="text" name="kode" id="" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Judul Buku</label>
                            <input type="text" name="judul" id="" class="form-control" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Penulis</label>
                            <input type="text" name="penulis" id="" class="form-control" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Jilid</label>
                            <input type="text" name="jilid" id="" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label class="form-label">Jenjang</label>
                            <select name="id_jenjang" id="jenjang" class="form-control" required>
                                <option selected disabled default>--Pilih Jenjang--</option>
                                <?php foreach ($jenjangs as $jenjang) { ?>
                                    <option value="<?=$jenjang['id']?>"><?=$jenjang['nama_jenjang']?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Mapel</label>
                            <select name="id_mapel" id="mapel" class="form-control" required>
                                <option selected disabled default>--Pilih Mapel--</option>
                                <?php foreach ($mapels as $mapel) { ?>
                                    <option value="<?=$mapel['id']?>"><?=$mapel['nama_mapel']?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Kategori</label>
                            <select name="id_kategori" id="kategori" class="form-control" required>
                                <option selected disabled>--Pilih Kategori--</option>
                                <?php foreach ($kategoris as $kategori) { ?>
                                    <option value="<?=$kategori['id']?>"><?=$kategori['nama_kategori']?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Warna</label>
                            <select name="id_warna" id="warna" class="form-control" required>
                                <option selected disabled default>--Pilih Warna--</option>
                                <?php foreach ($warnas as $warna) { ?>
                                    <option value="<?=$warna['id']?>"><?=$warna['nama_warna']?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Ukuran</label>
                            <select name="id_ukuran" id="ukuran" class="form-control" required>
                                <option selected disabled default>--Pilih Ukuran--</option>
                                <?php foreach ($ukurans as $ukuran) { ?>
                                    <option value="<?=$ukuran['id']?>"><?=$ukuran['nama_ukuran']?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Halaman</label>
                            <input type="number" name="halaman" id="" class="form-control" minlength="0" min="0" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">ISBN Jil. Lengkap</label>
                            <input type="text" name="isbn_jil_lengkap" id="" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">ISBN</label>
                            <input type="text" name="isbn" id="" class="form-control">
                        </div>
                    </div>
                </div>

                <div id="perencanaanProduksiDiv">
                    <hr>

                    <div id="naskahId" class="d-none"></div>
                    <div id="isEdit" class="d-none"></div>

                    <div class="modal-body">
                        <div>
                            <div class="mB-10" style="float:left">
                                <h5><b>Perencanaan Produksi</b></h5>
                            </div>
                            
                            <div class="mB-10" style="float:right">
                                Auto-sync Tanggal Mulai <input id="autoSync" type="checkbox" checked data-toggle="toggle">
                            </div>
                        </div>

                        <div>
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <th width="10">Status</th>
                                    <th>Level Kerja</th>
                                    <th width="70">Durasi</th>
                                    <th>Kecepatan (Hal/Hari)</th>
                                    <th width="150">Mulai</th>
                                    <th width="10">Libur</th>
                                    <th width="150">Selesai</th>
                                    <th>PIC</th>
                                    <!-- <th></th> -->
                                </thead>
                                <tbody id="perencanaanProduksiTbody">
                                    <?php 
                                        $no = 1;
                                        foreach ($default_level_kerja as $lk_index => $lk) { 
                                        $no++;
                                    ?>
                                        <tr>
                                            <span id="nextLevel_<?=$lk['key']?>" class="d-none"><?=$level_kerja_key_map[$lk['key']]['next_level']?></span>

                                            <td>
                                                <input id="key_<?=$lk['key']?>" type="text" name="key[<?=$lk_index?>]" value="<?=$level_kerja_key_map[$lk['key']]['key']?>" class="d-none">
                                                <input id="switch_<?=$lk['key']?>" class="switch" type="checkbox" name="is_disabled[<?=$lk_index?>]" checked data-toggle="toggle" onchange="switchLevelToOff('<?=$lk['key']?>', '<?=$level_kerja_key_map[$lk['key']]['next_level']?>')">
                                            </td>
                                            <td><?=$level_kerja_key_map[$lk['key']]['text']?></td>
                                            <td>
                                                <input id="duration_<?=$lk['key']?>" type="text" name="duration[<?=$lk_index?>]" class="form-control" onchange="generateKecepatan('<?=$lk['key']?>')" autocomplete="off">
                                            </td>
                                            <td>
                                                <span id="kecepatan_<?=$lk['key']?>" class="kecepatan"></span>
                                                <input id="kecepatanInput_<?=$lk['key']?>" type="text" name="kecepatanInput[<?=$lk_index?>]" value="" class="d-none">
                                            </td>
                                            <td>
                                                <input id="startDate_<?=$lk['key']?>" type="text" name="tgl_rencana_mulai[<?=$lk_index?>]" class="form-control" onchange="startDateChanged('<?=$lk['key']?>')" autocomplete="off" data-date-format="dd/mm/yyyy" data-provide="datepicker" required>
                                            </td>
                                            <td>
                                                <span id="offDays_<?=$lk['key']?>" class="offDays"></span>
                                                <input id="libur_<?=$lk['key']?>" type="text" name="libur[<?=$lk_index?>]" value="" class="d-none">
                                            </td>
                                            <td>
                                                <span id="endDate_<?=$lk['key']?>" class="endDate"></span>
                                                <input id="tgl_rencana_selesai_<?=$lk['key']?>" type="text" name="tgl_rencana_selesai[<?=$lk_index?>]" value="" class="d-none">
                                            </td>
                                            <td>
                                                <select id="pic_<?=$lk['key']?>" name="pic_aktif[<?=$lk_index?>]" class="form-control">
                                                    <option value="tentatif">Tentatif</option>
                                                    <?php
                                                        foreach ($roles_karyawan as $naskah_pic) {
                                                            if ($naskah_pic['role_key'] == $level_kerja_key_map[$lk['key']]['pic']) {
                                                                foreach (json_decode($naskah_pic['karyawan']) as $pic) {
                                                                    echo "<option value='$pic->id'>$pic->nama</option>";
                                                                }
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </td>
                                            <!-- <td>edit | delete</td> -->
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="submit" class="btn btn-info waves-effect waves-light">Simpan</button>
                    <button type="reset" class="btn btn-secondary waves-effect waves-light" onclick="clearForm()">Clear</button>
                    <button type="button" class="btn btn-dark waves-effect waves-light" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const isEdit = $('#isEdit').text() == 'true' ? true : false
    let autoSync = true;

    $('#autoSync').change(function() {
        if ($(this).is(':checked')) {
            autoSync = true
        } else {
            autoSync = false
        }
    })

    function clearForm() {
        // $('.switch').prop('checked', true).trigger('change')
        $('.kecepatan').text('')
        $('.offDays').text('')
        $('.endDate').text('')
    }

    function getNaskahLevelKerja(idNaskah) {
        $.ajax({
            method: 'GET',
            url: "<?=site_url(uriSegment(1) . '/getNaskahLevelKerja')?>?id_naskah=" + idNaskah
        }).then((res) => {
            clearForm()
            
            res = JSON.parse(res)
            
            if (res.length) {
                $('#autoSync').prop('checked', false).trigger('change')

                res.forEach(lk => {
                    if (lk.is_disabled == '1') {
                        $('#switch_' + lk.key).prop('checked', false).trigger('change')
                        // switchLevelToOff(lk.key)
                    } else {
                        $('#duration_' + lk.key).val(lk.durasi)
                        $('#kecepatan_' + lk.key).text(lk.kecepatan)
                        $('#kecepatanInput_' + lk.key).val(lk.kecepatan)
                        $('#offDays_' + lk.key).text(lk.total_libur)
                        $('#libur_' + lk.key).val(lk.total_libur)

                        const startDate = new Date(lk.tgl_rencana_mulai)
                        const startDay = startDate.getDate().toString().padStart(2, '0')
                        const startMonth = (startDate.getMonth() + 1).toString().padStart(2, '0')
                        const startYear = startDate.getFullYear();
                        const tglRencanaMulai = `${startDay}/${startMonth}/${startYear}`;
                        $('#startDate_' + lk.key).val(tglRencanaMulai)

                        const endDate = new Date(lk.tgl_rencana_selesai)
                        const endDay = endDate.getDate().toString().padStart(2, '0')
                        const endMonth = (endDate.getMonth() + 1).toString().padStart(2, '0')
                        const endYear = endDate.getFullYear();
                        const tglRencanaSelesai = `${endDay}/${endMonth}/${endYear}`;
                        $('#endDate_' + lk.key).text(tglRencanaSelesai)
                        $('#tgl_rencana_selesai_' + lk.key).val(lk.tgl_rencana_selesai)

                        if (lk.id_pic_aktif != null) {
                            $('#pic_' + lk.key).val(lk.id_pic_aktif)
                        }
                    }
                })
            } else {
                $('#autoSync').prop('checked', true).trigger('change')
                $('.switch').prop('checked', true).trigger('change')
            }
        })
    }

    function generateKecepatan(key) {
        const naskahPage = $('input[name=halaman]').val()
        const duration = $('#duration_' + key).val()
        const kecepatan = (naskahPage/parseInt(duration)).toFixed(2).replace('.00', '')

        $('#kecepatan_' + key).text(Math.round(kecepatan));
        $('#kecepatanInput_' + key).val(Math.round(kecepatan));

        if ($('#startDate_' + key).val() != '') {
            startDateChanged(key)
        }
    }

    let disabledLevels = []
    let disabledLevelsDetail = {}
    function switchLevelToOff(key, nextLevelKerja) {
        const checked = $('#switch_' + key).prop('checked')

        if (checked) {
            const index = disabledLevels.indexOf(key);
            if (index !== -1) {
                disabledLevels.splice(index, 1);
            }

            if (disabledLevelsDetail.hasOwnProperty(key)) {
                delete disabledLevelsDetail[key];
            }
            
            $('#key_' + key).prop('disabled', false)
            $('#libur_' + key).prop('disabled', false)
            $('#kecepatanInput_' + key).prop('disabled', false)
            $('#duration_' + key).prop('disabled', false)
            $('#startDate_' + key).prop('disabled', false)
            $('#tgl_rencana_selesai_' + key).prop('disabled', false)
            $('#pic_' + key).prop('disabled', false)
        } else {
            if (!disabledLevels.includes(key)) {
                disabledLevels.push(key)
            }
            disabledLevelsDetail[key] = nextLevelKerja
            
            $('#key_' + key).prop('disabled', true)
            $('#libur_' + key).prop('disabled', true)
            $('#kecepatanInput_' + key).prop('disabled', true)
            $('#duration_' + key).prop('disabled', true)
            $('#startDate_' + key).prop('disabled', true)
            $('#tgl_rencana_selesai_' + key).prop('disabled', true)
            $('#pic_' + key).prop('disabled', true)
        }

        startDateChanged('penulisan')
    }

    function startDateChanged(key) {
        const pickedDate = $('#startDate_' + key).val()
        const duration = $('#duration_' + key).val()

        // get total libur
        // rumus: rentang tgl terpilih+durasi
        $.ajax({
            url: "<?=site_url(uriSegment(1).'/getOffDaysTotal')?>?duration=" + duration + "&startDate=" + pickedDate,
            method: 'GET',
        }).then((res) => {
            if (res != []) {
                res = JSON.parse(res)

                $('#offDays_' + key).text(res.offDays)
                $('#libur_' + key).val(res.offDays)
                
                let nextLevelKerja = $('#nextLevel_' + key).text()
                const endDate = new Date(res.endDate)
                const day = endDate.getDate().toString().padStart(2, '0')
                const month = (endDate.getMonth() + 1).toString().padStart(2, '0')
                const year = endDate.getFullYear();
                const tglRencanaSelesai = `${day}/${month}/${year}`;
                if (tglRencanaSelesai != 'NaN/NaN/NaN') {
                    $('#endDate_' + key).text(tglRencanaSelesai)
                }
                $('#tgl_rencana_selesai_' + key).val(res.endDate)
                
                if (autoSync) {
                    if (nextLevelKerja && nextLevelKerja != 'null' && nextLevelKerja != null) {
                        if (disabledLevels.includes(nextLevelKerja)) {
                            nextLevelKerja = disabledLevelsDetail[nextLevelKerja]
                        }

                        const nextDay = addOneDay(res.endDate)
                        if (nextDay != 'NaN/NaN/NaN') {
                            $('#startDate_' + nextLevelKerja).val(nextDay)
                            if (nextLevelKerja == 'setting_1') {
                                console.log(nextDay);
                            }
                        }

                        if (nextLevelKerja != null) {
                            startDateChanged(nextLevelKerja)
                        }
                    }
                }
            }
        })
    }

    // $('#formNaskah').submit(function(e) {
    //     e.preventDefault()// Serialize the form data
        
    // })
</script>