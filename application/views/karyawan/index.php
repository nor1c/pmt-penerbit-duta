<div class="container-fluid">
    <h4 class="c-grey-900 mT-10 mB-30">Data Master Karyawan</h4>
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <div class="mB-20">
                    <button type="button" class="btn cur-p btn-outline-secondary" onclick="refreshTable()">
                        <i class="ti-reload"></i>
                    </button>
                    <button id="addNewKaryawan" type="button" class="btn btn-primary btn-color" data-bs-toggle="modal" data-bs-target="#karyawanFormModal">
                        <i class="ti-plus"></i> Tambah
                    </button>
                </div>

                <table id="karyawanTable" class="table table-hover table-bordered" cellspacing="0" width="100%">
                    <thead class="table-dark">
                        <tr>
                        <th width="10">#</th>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Nama Lengkap</th>
                        <th>Jabatan</th>
                        <th>Divisi</th>
                        <th>Golongan</th>
                        <th>No. HP</th>
                        <th>Email</th>
                        <th>Jam Kerja</th>
                        <th>Status</th>
                        <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->load->view('karyawan/form') ?>

<script>
    $(document).ready(function() {
        const karyawanError = $('#karyawanError')

        table = $('#karyawanTable').DataTable({
            "sDom": "Rlfrtip",
            "scrollX": true,
            "aLengthMenu": [
                [10, 15, 20, 25, 50],
                [10, 15, 20, 25, 50],
            ],
            "pageLength": 10,
            "processing": true,
            "serverSide": true,
            "searching": true,
            "orderable": false,
            "ajax": {
                "url": "<?= site_url(uriSegment(1).'/'.uriSegment(2).'/getAll') ?>",
                'method': 'POST',
                'data': function(d) {
                    d.draw = d.draw || 1
                    return $.extend(d, filters);
                },
            },
            "deferRender": true,
            "columns": [
                {
                    "width": "5%",
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
                    "searchable": false,
                },
                {
                    "orderable": false,
                    "searchable": false,
                },
                {
                    "orderable": false,
                    "searchable": false,
                },
                {
                    "orderable": false,
                    "searchable": false,
                },
                {
                    "orderable": false,
                    "searchable": false,
                },
                {
                    "orderable": false,
                    "searchable": false,
                },
                {
                    "orderable": false,
                    "searchable": false,
                },
                {
                    "orderable": false,
                    "searchable": false,
                },
                {
                    "orderable": false,
                    "searchable": false,
                },
                {
                    "orderable": false,
                    "searchable": false,
                },
                {
                    "orderable": false,
                    "searchable": false,
                },
            ],
            "columnDefs": [
                {
                    "targets": 10,
                    "render": function(data, type, row) {
                        return '<div class="peers mR-15">' +
                            '<div class="peer">' +
                            (row[10] != 0 ? '<i class="c-green-500 ti-check"></i> Aktif' : '<i class="c-red-500 ti-close"></i> Nonaktif') +
                            '</div>' +
                            '</div>';
                    },
                },
                {
                    "targets": 11,
                    "render": function(data, type, row) {
                        return '<div class="peers mR-15">' +
                            '<div class="peer peer-text mR-5">' +
                            '<a href="#" onclick="editKaryawan(' + row[1] + ')" class="td-n c-gray-500 p-2" data-bs-toggle="modal" data-bs-target="#karyawanFormModal">' +
                            'Edit' +
                            '</a>' +
                            '</div>' +
                            '<div class="peer peer-text">' +
                            '<a href="#" onclick="'+(row[10] != 0 ? 'deleteKaryawan('+row[1]+')' : 'activateKaryawan('+row[1]+')')+'" class="td-n c-gray-500 p-2">' +
                            (row[10] != 0 ? 'Nonaktifkan' : 'Aktifkan') +
                            '</a>' +
                            '</div>' +
                        '</div>';
                    }
                }
            ],
            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                if (aData[10] == 0) {
                    $('td', nRow).css('background-color', '#ffedef');
                }
            },
            "order": [
                [0, 'asc']
            ],
            "oLanguage": {
                "sSearch": "Pencarian",
                "sProcessing": '<image style="width:150px" src="http://superstorefinder.net/support/wp-content/uploads/2018/01/blue_loading.gif">',
            }
        });

        // hide column(s) from datatable
        $('#karyawanTable').DataTable().column(1).visible(false);

        let isEdit = false
        let selectedIdKaryawan = 0
        $('#addNewKaryawan').click(function() {
            resetKaryawanForm()
            isEdit = false
            selectedIdKaryawan = 0
            karyawanError.hide()
        })

        $('#formKaryawan').submit(function(e) {
            e.preventDefault()
            karyawanError.hide()

            const values = $(this).serialize()

            $.ajax({
                method: 'POST',
                url: "<?=site_url(uriSegment(1))?>/" + (isEdit ? 'update?id_karyawan=' + selectedIdKaryawan : 'create'),
                data: values
            }).then((result) => {
                result = JSON.parse(result)
                
                if (result.error) {
                    karyawanError.show()
                    if (result.message.includes('Duplicate')) {
                        $('#karyawanError').text('Karyawan sudah terdaftar!');
                    } else {
                        $('#karyawanError').text(result.message);
                    }
                } else {
                    karyawanError.hide()
                    $("[data-bs-dismiss=modal]").trigger({ type: "click" })
                    $(this).trigger('reset')

                    Swal.fire(
                        'Berhasil ' + (isEdit ? 'mengupdate' : 'menambah') + ' karyawan!',
                        'Data Karyawan telah ' + (isEdit ? 'diperbarui' : 'didaftarkan') + '.',
                        'success'
                    ).then(function() {
                        refreshTable()
                    })
                }
            })
        })

        function resetKaryawanForm() {
            $('#formKaryawan')[0].reset()
            $('#karyawanError').hide()
        }

        editKaryawan = function(idKaryawan) {
            $.ajax({
                url: "<?=site_url('karyawan/karyawanDetail')?>?id_karyawan=" + idKaryawan,
                method: 'GET',
            }).then((res) => {
                resetKaryawanForm()

                const data = JSON.parse(res)

                isEdit = true
                selectedIdKaryawan = data['id_karyawan']

                $('#karyawanFormTitle').html('Edit Karyawan ' + data['nama'])
                $('#isEdit').html(true)

                for (let column in data) {
                    if (data.hasOwnProperty(column)) {
                        if (column === 'id_jabatan' || column === 'id_golongan' || column === 'id_divisi' || column === 'id_jam_kerja' || column == 'status_perkawinan') {
                            $('#formKaryawan select[name='+column+'] option[value="'+data[column]+'"]').attr('selected', 'selected')
                        } else if (column == 'jenis_kelamin' || column == 'active') {
                            $('#formKaryawan input[name='+column+'][value="'+data[column]+'"]').prop('checked', true)
                        } else if (column == 'alamat') {
                            $('#formKaryawan textarea[name='+column+']').val(data[column])
                        } else {
                            if (column == 'tanggal_masuk' || column == 'tanggal_lahir') {
                                if (data[column] != null) {
                                    let tglParts = data[column].split('-')
                                    data[column] = `${tglParts[2]}/${tglParts[1]}/${tglParts[0]}`;
                                }
                            }
                            $('#formKaryawan input[name='+column+']').val(data[column])
                        }
                    }
                }
            })
        }

        deleteKaryawan = function(idKaryawan) {
            $.ajax({
                url: "<?=site_url('karyawan/deleteKaryawan')?>",
                method: 'POST',
                data: {
                    id_karyawan: idKaryawan
                }
            }).then((res) => {
                res = JSON.parse(res)
                
                if (res.error != true) {
                    refreshTable()
                    Swal.fire(
                        'Berhasil menonaktifkan karyawan!',
                        'Karyawan telah dinonaktifkan.',
                        'success'
                    ).then(function() {
                        refreshTable()
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops... Gagal menonaktifkan karyawan!',
                        text: res.message,
                    })
                }
            })
        }

        activateKaryawan = function(idKaryawan) {
            $.ajax({
                url: "<?=site_url('karyawan/activateKaryawan')?>",
                method: 'POST',
                data: {
                    id_karyawan: idKaryawan
                }
            }).then((res) => {
                res = JSON.parse(res)
                
                if (res.error != true) {
                    refreshTable()
                    Swal.fire(
                        'Berhasil mengaktifkan karyawan!',
                        'Karyawan telah diaktifkan kembali.',
                        'success'
                    ).then(function() {
                        refreshTable()
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops... Gagal mengaktifkan karyawan!',
                        text: res.message,
                    })
                }
            })
        }
    })

    function refreshTable() {
        table.ajax.reload()
    }
</script>