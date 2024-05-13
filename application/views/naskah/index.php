<div class="container-fluid">
    <h4 class="c-grey-900 mT-10 mB-30">Naskah</h4>
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <div class="mB-20">
                    <button type="button" class="btn cur-p btn-outline-secondary" onclick="refreshTable()">
                        <i class="ti-reload"></i>
                    </button>
                    <button id="addNaskahButton" type="button" class="btn btn-primary btn-color" data-bs-toggle="modal" data-bs-target="#naskahFormModal">
                        <i class="ti-plus"></i> &nbsp; <?=uriSegment(2) == 'pengajuan' ? 'Ajukan' : ''?> Naskah Baru
                    </button>
                </div>

                <!-- filters -->
                <div id="filter" class="mB-20">
                    <form id="filter">
                        <div class="row mB-10">
                            <div class="col-md-2">
                                <label class="form-label">No Job</label>
                                <input type="text" name="no_job" id="" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Judul</label>
                                <input type="text" name="judul" id="" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Jenjang</label>
                                <select name="id_jenjang" id="jenjang" class="form-control">
                                    <option value="" selected>--Semua Jenjang--</option>
                                    <?php foreach ($jenjangs as $jenjang) { ?>
                                        <option value="<?=$jenjang['id']?>"><?=$jenjang['nama_jenjang']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Mapel</label>
                                <select name="id_mapel" id="mapel" class="form-control">
                                    <option value="" selected>--Semua Mapel--</option>
                                    <?php foreach ($mapels as $mapel) { ?>
                                        <option value="<?=$mapel['id']?>"><?=$mapel['nama_mapel']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Kategori</label>
                                <select name="id_kategori" id="kategori" class="form-control">
                                    <option value="" selected>--Semua Kategori--</option>
                                    <?php foreach ($kategoris as $kategori) { ?>
                                        <option value="<?=$kategori['id']?>"><?=$kategori['nama_kategori']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-color" style="float:right">Filter</button>
                            </div>
                        </div>
                    </form>
                </div>

                <table id="naskahTable" class="table table-bordered table-hover" cellspacing="0" width="100%">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>No. Job</th>
                            <th>Kode Buku</th>
                            <th>Judul Buku</th>
                            <?php if (uriSegment(2) == 'pengajuan') { ?>
                                <th>Pengaju</th>
                                <th>Tgl Pengajuan</th>
                            <?php } ?>
                            <th>Jilid</th>
                            <th>Penulis</th>
                            <th><?=uriSegment(2) == 'pengajuan' ? 'Status' : 'Aksi'?></th>
                            <!-- <th>Spek</th>
                            <th>Rencana Produksi</th> -->
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->load->view('naskah/form') ?>

<script>
    $(document).ready(function() {
        table = $('#naskahTable').DataTable({
            "sDom": "Rlfrtip",
            "scrollCollapse": true,
            "aLengthMenu": [
                [5, 10, 10, 150, <?=uriSegment(2) == 'pengajuan' ? '50, 50,' : ''?> 50, 100, 5],
                [5, 10, 10, 150, <?=uriSegment(2) == 'pengajuan' ? '50, 50,' : ''?> 50, 100, 5],
            ],
            "pageLength": 10,
            "processing": true,
            "serverSide": true,
            "searching": true,
            "ajax": {
                "url": "<?=site_url($this->uri->segment(1) . '/data?isPengajuan=' . (uriSegment(2) == 'pengajuan' ? 'true' : 'false')) ?>",
                'method': 'POST',
                'data': function(d) {
                    d.draw = d.draw || 1
                    return $.extend(d, filters);
                },
            },
            "deferRender": true,
            "columns": [
                {
                    "className": 'datatables-number',
                    "data": null,
                    "orderable": false,
                    "searchable": false,
                    "defaultContent": '',
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    "orderable": false,
                    "searchable": true,
                },
                {
                    "orderable": false,
                    "searchable": true,
                },
                {
                    "orderable": false,
                    "searchable": false,
                },
                {
                    "orderable": false,
                    "searchable": true,
                },
                {
                    "orderable": false,
                    "searchable": false,
                },
            ],
            "columnDefs": [
                {
                    "targets": <?=uriSegment(2) == 'pengajuan' ? '8' : '6'?>,
                    "render": function(data, type, row) {
                        const withButtons = '<div class="peers mR-15">' +
                                '<div class="peer">' +
                                '<a href="<?=site_url('/naskah/view')?>/'+ row[1] +'" class="td-n c-deep-purple-500 cH-blue-500 fsz-md p-5">' +
                                '<i class="c-green-500 ti-eye"></i>' +
                                '</a>' +
                                '</div>' +
                                '<div class="peer">' +
                                '<a href="#" onclick="editNaskah(' + row[1] + ')" class="td-n c-deep-purple-500 cH-blue-500 fsz-md p-5" data-bs-toggle="modal" data-bs-target="#naskahFormModal">' +
                                '<i class="c-blue-500 ti-pencil"></i>' +
                                '</a>' +
                                '</div>' +
                                '<div class="peer">' +
                                '<a href="#" onclick="deleteNaskah(' + row[1] + ')" class="td-n c-deep-purple-500 cH-blue-500 fsz-md p-5">' +
                                '<i class="c-orange-500 ti-agenda"></i>' +
                                '</a>' +
                                '</div>' +
                                '<div class="peer">' +
                                '<a href="#" onclick="deleteNaskah(' + row[1] + ')" class="td-n c-deep-purple-500 cH-blue-500 fsz-md p-5">' +
                                '<i class="c-red-500 ti-trash"></i>' +
                                '</a>' +
                                '</div>' +
                                '</div>';

                        <?php if (uriSegment(2) == 'pengajuan') { ?>
                            <?php if (sessionData('id_jabatan') != 1) { ?>
                                return '<div>' +
                                        (row[9] == true ? '<span style="color:green"><i class="c-green-500 ti-clip"></i> Sudah diproses</span>' : '<span style="color:red"><i class="c-red-500 ti-clip"></i> Belum diproses</span>') +
                                    '</div>';
                            <?php } else { ?>
                                return withButtons
                            <?php } ?>
                        <?php } else { ?>
                            return withButtons
                        <?php } ?>
                    },
                },
            ],
            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                if (aData[6] == null) {
                    $('td', nRow).css('background-color', '#ffd5d1');
                }
            },
            'select': {
                'style': 'multi'
            },
            "order": [
                [0, 'asc']
            ],
            "oLanguage": {
                "sSearch": "Pencarian",
                "sProcessing": '<image style="width:150px" src="http://superstorefinder.net/support/wp-content/uploads/2018/01/blue_loading.gif">',
            }
        });

        let isEdit = false
        $('#addNaskahButton').click(function () {
            resetNaskahForm()
            $('#perencanaanProduksiDiv').hide()
            isEdit = false

            // disable all level kerja inputs
            if (isEdit == false) {
                const levelKerjaInputs = document.getElementById('perencanaanProduksiTbody').getElementsByTagName('input')
                for (var i = 0; i < levelKerjaInputs.length; i++) {
                    levelKerjaInputs[i].disabled = true;
                }
                const levelKerjaSelects = document.getElementById('perencanaanProduksiTbody').getElementsByTagName('select')
                for (var i = 0; i < levelKerjaSelects.length; i++) {
                    var options = levelKerjaSelects[i].getElementsByTagName('option');
                    for (var j = 0; j < options.length; j++) {
                        options[j].disabled = true;
                    }
                }
            }

            $.ajax({
                url: '<?=site_url($this->uri->segment(1))?>/next_new_no_job',
                type: 'GET',
            }).then((res) => {
                $('#formNaskah input[name=no_job]').val(res)
            })
        })

        function resetNaskahForm() {
            $('#formNaskah')[0].reset()
            $('#naskahError').hide()
        }

        editNaskah = function(noJob) {
            $('#perencanaanProduksiDiv').show()

            $.ajax({
                url: "<?=site_url('naskah/naskahDetail')?>?no_job=" + noJob,
                method: 'GET',
            }).then((res) => {
                resetNaskahForm()

                const data = JSON.parse(res)

                isEdit = true

                $('#naskahFormTitle').html('Edit Naskah ' + data['no_job'])
                $('#naskahId').html(data['id'])
                $('#isEdit').html(true)

                for (let column in data) {
                    if (data.hasOwnProperty(column)) {
                        if (column === 'id_jenjang' || column === 'id_mapel' || column === 'id_kategori' || column === 'id_ukuran') {
                            $('#formNaskah select[name='+column+'] option[value="'+data[column]+'"]').attr('selected', 'selected')
                            $('#formNaskah select[name='+column+']').prop('disabled', true)
                        } else {
                            $('#formNaskah input[name='+column+']').val(data[column])
                            $('#formNaskah input[name='+column+']').prop('disabled', true)
                        }
                    }
                }

                getNaskahLevelKerja(data['id'])
            })
        }

        $('#formNaskah').submit(function(e) {
            e.preventDefault()

            if (isEdit) {
                var data = $(this).serializeArray();

                const idNaskah = $('#naskahId').text()

                const transformedData = [];

                for (let i = 0; i < data.length / 8; i++) {
                    const startIndex = i * 8;
                    const newObj = {};

                    for (let j = startIndex; j < startIndex + 8; j++) {
                        const key = data[j].name.replace(/\[\d+\]/, '');
                        newObj[key] = data[j].value;
                    }

                    transformedData.push(newObj);
                }

                const dataWithKey = {};
                for (const key in transformedData) {
                    if (transformedData.hasOwnProperty(key)) {
                        const entry = transformedData[key];
                        dataWithKey[entry.key] = entry;
                    }
                }

                const totalLevelKerja = parseInt("<?=count($default_level_kerja)?>")

                // get level kerja mapping
                $.ajax({
                    method: 'GET',
                    url: "<?=site_url(uriSegment(1) . '/getLevelKerjaKeyMapJson')?>",
                }).then((levelKerjaMap) => {
                    const levelKerja = JSON.parse(levelKerjaMap)

                    // transform all data as final data
                    let finalData = []
                    for (const key in levelKerja) {
                        if (dataWithKey[key] !== undefined) {
                            finalData.push({
                                order: levelKerja[key].order,
                                key: levelKerja[key].key,
                                id_naskah: idNaskah,
                                durasi: dataWithKey[key]['duration'],
                                kecepatan: dataWithKey[key]['kecepatanInput'],
                                tgl_rencana_mulai: dataWithKey[key]['tgl_rencana_mulai'],
                                libur: dataWithKey[key]['total_libur'],
                                tgl_rencana_selesai: dataWithKey[key]['tgl_rencana_selesai'],
                                total_libur: dataWithKey[key]['libur'],
                                is_disabled: 0,
                                id_pic_aktif: dataWithKey[key]['pic_aktif'] == 'tentatif' ? 0 : dataWithKey[key]['pic_aktif'],
                            })
                        } else {
                            finalData.push({
                                order: levelKerja[key].order,
                                key: levelKerja[key].key,
                                id_naskah: idNaskah,
                            })
                        }
                    }

                    // save personalized level kerja to database
                    $.ajax({
                        method: 'POST',
                        url: "<?=site_url(uriSegment(1) . '/saveLevelKerja')?>?id_naskah=" + idNaskah,
                        data: {
                            data: finalData
                        }
                    }).then((res) => {
                        res = JSON.parse(res)

                        if (res == true) {
                            Swal.fire(
                                'Berhasil mengatur level naskah!',
                                'Data Level Naskah telah tersimpan.',
                                'success'
                            ).then(function() {
                                $("[data-bs-dismiss=modal]").trigger({ type: "click" })
                                refreshTable()
                            })
                        }
                    })
                })
            } else {
                $('#naskahError').hide()

                $.ajax({
                    url: '<?= site_url($this->uri->segment(1)) ?>/' + (isEdit ? 'update' : 'create?isPengajuan=' + (<?=uriSegment(2) == 'pengajuan' ? 'true' : 'false'?>)),
                    type: 'POST',
                    data: new FormData($(this)[0]),
                    contentType: false,
                    processData: false,
                    cache: false,
                }).then((res) => {
                    res = JSON.parse(res)

                    if (res.error) {
                        $('#naskahError').show()
                        $('#naskahError').text(res.message)
                    } else {
                        refreshTable()
                        $('#closeNaskahFormModalButton').trigger('click')
                        Swal.fire(
                            'Berhasil disimpan!',
                            'Data naskah berhasil disimpan.',
                            'success'
                        )
                    }
                }).fail(() => {
                    alert('Something went wrong, please try again!')
                })
            }
        })

        deleteNaskah = function(noJob) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Anda tidak dapat mengembalikan naskah yang telah dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?=site_url('naskah/deleteNaskah')?>",
                        method: 'POST',
                        data: {
                            no_job: noJob
                        }
                    }).then((res) => {
                        res = JSON.parse(res)
                        
                        if (res.error != true) {
                            refreshTable()
                            Swal.fire(
                                'Berhasil menghapus naskah!',
                                'Naskah telah terhapus.',
                                'success'
                            ).then(function() {
                                refreshTable()
                            })
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops... Gagal menghapus naskah!',
                                text: res.message,
                            })
                        }
                    })
                }
            })
        }
    })
</script>