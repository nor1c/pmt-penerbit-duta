<div class="container-fluid">
    <h4 class="c-grey-900 mT-10 mB-30">Warna</h4>
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <div class="mB-20">
                    <button type="button" class="btn cur-p btn-outline-secondary" onclick="refreshTable()">
                        <i class="ti-reload"></i>
                    </button>
                    <button id="addNewWarna" type="button" class="btn btn-primary btn-color" data-bs-toggle="modal" data-bs-target="#warnaFormModal">
                        <i class="ti-plus"></i> Tambah
                    </button>
                </div>

                <table id="warnaTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead class="table-dark">
                        <tr>
                            <th width="10">#</th>
                            <th width="10">ID</th>
                            <th>Warna</th>
                            <th width="150">Status</th>
                            <th width="100">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->load->view('master/warna/form') ?>

<script>
    $(document).ready(function() {
        const warnaError = $('#warnaError')

        table = $('#warnaTable').DataTable({
            "sDom": "Rlfrtip",
            "scrollX": true,
            "aLengthMenu": [
                [10, 15, 20, 25, 50],
                [10, 15, 20, 25, 50],
            ],
            "pageLength": 10,
            "processing": true,
            "serverSide": true,
            "searching": false,
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
                    "className": 'datatables-number',
                    "data": null,
                    "orderable": true,
                    "searchable": false,
                    "defaultContent": '',
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                null,
                null,
                null,
                null,
            ],
            "columnDefs": [
                {
                    "targets": 3,
                    "render": function(data, type, row) {
                        return '<div class="peers mR-15">' +
                            '<div class="peer">' +
                            (row[3] != 0 ? '<i class="c-green-500 ti-check"></i> Aktif' : '<i class="c-red-500 ti-close"></i> Tidak Aktif') +
                            '</div>' +
                            '</div>';
                    },
                },
                {
                    "targets": 4,
                    "render": function(data, type, row) {
                        return '<div class="peers mR-15">' +
                                '<div class="peer">' +
                                '<a href="#" onclick="editWarna(' + row[1] + ')" class="td-n c-deep-purple-500 cH-blue-500 fsz-md p-5" data-bs-toggle="modal" data-bs-target="#warnaFormModal">' +
                                '<i class="c-blue-500 ti-pencil"></i>' +
                                '</a>' +
                                '</div>' +
                                '<div class="peer">' +
                                '<a href="#" onclick="deleteWarna(' + row[1] + ')" class="td-n c-deep-purple-500 cH-blue-500 fsz-md p-5">' +
                                '<i class="c-red-500 ti-trash"></i>' +
                                '</a>' +
                                '</div>' +
                                '</div>';
                    },
                },
            ],
            "order": [
                [0, 'asc']
            ],
            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                if (aData[3] == 0) {
                    $('td', nRow).css('background-color', '#ffedef');
                }
            },
            "oLanguage": {
                "sSearch": "Pencarian",
                "sProcessing": '<image style="width:150px" src="http://superstorefinder.net/support/wp-content/uploads/2018/01/blue_loading.gif">',
            }
        });

        // hide column(s) from datatable
        $('#warnaTable').DataTable().column(1).visible(false);

        let isEdit = false
        let selectedIdWarna = 0
        $('#addNewWarna').click(function() {
            resetWarnaForm()
            isEdit = false
            selectedIdWarna = 0
            warnaError.hide()
        })

        $('#formWarna').submit(function(e) {
            e.preventDefault()
            warnaError.hide()

            const values = $(this).serialize()

            $.ajax({
                method: 'POST',
                url: "<?=site_url(uriSegment(1).'/'.uriSegment(2))?>/" + (isEdit ? 'update?id=' + selectedIdWarna : 'create'),
                data: values
            }).then((result) => {
                result = JSON.parse(result)
                
                if (result.error) {
                    warnaError.show()
                    $('#warnaError').text(result.message);
                } else {
                    warnaError.hide()
                    $("[data-bs-dismiss=modal]").trigger({ type: "click" })
                    $(this).trigger('reset')
                    refreshTable()

                    if (isEdit) {
                        Swal.fire(
                            'Berhasil mengupdate warna!',
                            'Data warna berhasil diupdate.',
                            'success'
                        ).then(function() {
                            refreshTable()
                        })
                    }
                }
            })
        })

        function resetWarnaForm() {
            $('#formWarna')[0].reset()
            $('#warnaError').hide()
        }

        editWarna = function(id) {
            $.ajax({
                url: "<?=site_url('master/warna/warnaDetail')?>?id=" + id,
                method: 'GET',
            }).then((res) => {
                resetWarnaForm()

                const data = JSON.parse(res)

                isEdit = true
                selectedIdWarna = data['id']

                $('#warnaFormTitle').html('Edit Warna ' + data['nama'])
                $('#isEdit').html(true)

                for (let column in data) {
                    if (data.hasOwnProperty(column)) {
                        if (column === 'is_active') {
                            $('#formWarna select[name='+column+'] option[value="'+data[column]+'"]').attr('selected', 'selected')
                        } else {
                            $('#formWarna input[name='+column+']').val(data[column])
                        }
                    }
                }
            })
        }

        deleteWarna = function(id) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Anda tidak dapat mengembalikan warna yang telah dihapus dan akan ada kemungkinan gagal dihapus jika sedang digunakan oleh naskah.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?=site_url('master/warna/deleteWarna')?>",
                        method: 'POST',
                        data: {
                            id: id
                        }
                    }).then((res) => {
                        res = JSON.parse(res)
                        
                        if (res.error != true) {
                            refreshTable()
                            Swal.fire(
                                'Berhasil menghapus warna!',
                                'Data warna telah terhapus.',
                                'success'
                            ).then(function() {
                                refreshTable()
                            })
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops... Gagal menghapus warna!',
                                text: res.message,
                            })
                        }
                    })
                }
            })
        }
    })
</script>