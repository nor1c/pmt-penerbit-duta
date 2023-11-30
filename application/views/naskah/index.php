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
                        <i class="ti-plus"></i> Naskah Baru
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
                                <select name="id_jenjang" id="jenjang" class="form-control" required>
                                    <option selected disabled>--Pilih Jenjang--</option>
                                    <?php foreach ($jenjangs as $jenjang) { ?>
                                        <option value="<?=$jenjang['id']?>"><?=$jenjang['nama_jenjang']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Mapel</label>
                                <select name="id_mapel" id="mapel" class="form-control" required>
                                    <option selected disabled>--Pilih Mapel--</option>
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
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-color" style="float:right">Filter</button>
                            </div>
                        </div>
                    </form>
                </div>

                <table id="naskahTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>No. Job</th>
                            <th>Kode Buku</th>
                            <th>Judul Buku</th>
                            <th>Jilid</th>
                            <th>Penulis</th>
                            <th>Rencana Produksi</th>
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
            "scrollX": true,
            "scrollY": "300px",
            "scrollCollapse": true,
            "aLengthMenu": [
                [5, 10, 10, 150, 50, 100, 5],
                [5, 10, 10, 150, 50, 100, 5],
            ],
            "pageLength": 50,
            "processing": true,
            "serverSide": true,
            "searching": false,
            "ajax": {
                "url": "<?= site_url($this->uri->segment(1) . '/data') ?>",
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
                null,
                null,
                // null,
                // null
            ],
            "columnDefs": [
                {
                    "render": function(data, type, row) {
                        return '<div class="peers mR-15">' +
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
                            '<i class="c-red-500 ti-trash"></i>' +
                            '</a>' +
                            '</div>' +
                            '</div>';
                    },
                    "targets": 6,
                },
                // {
                //     "render": function(data, type, row) {
                //         return '<div class="peers mR-15">' +
                //             '<div class="peer">' +
                //             '<a href="#" onclick="editNaskah(' + row[1] + ')" class="td-n c-deep-purple-500 cH-blue-500 fsz-md p-5" data-bs-toggle="modal" data-bs-target="#naskahFormModal">' +
                //             '<i class="c-orange-600 ti-eye"></i>' +
                //             '</a>' +
                //             '</div>' +
                //             '</div>';
                //     },
                //     "targets": 7,
                // },
                // {
                //     "render": function(data, type, row) {
                //         return '<div class="peers mR-15">' +
                //             '<div class="peer">' +
                //             '<a href="#" onclick="editNaskah(' + row[1] + ')" class="td-n c-deep-purple-500 cH-blue-500 fsz-md p-5" data-bs-toggle="modal" data-bs-target="#naskahFormModal">' +
                //             '<i class="c-blue-500 ti-eye"></i>' +
                //             '</a>' +
                //             '</div>' +
                //             '<div class="peer">' +
                //             '<a href="#" onclick="deleteNaskah(' + row[1] + ')" class="td-n c-deep-purple-500 cH-blue-500 fsz-md p-5">' +
                //             '<i class="c-black-500 ti-settings"></i>' +
                //             '</a>' +
                //             '</div>' +
                //             '</div>';
                //     },
                //     "targets": 8,
                // },
            ],
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

            $.ajax({
                url: '<?=site_url($this->uri->segment(1))?>/next_new_no_job',
                type: 'GET',
            }).then((res) => {
                console.log(res)
                $('#formNaskah input[name=no_job]').val(res)
            })
        })

        $('#formNaskah').submit(function(e) {
            e.preventDefault()

            $.ajax({
                url: '<?= site_url($this->uri->segment(1)) ?>/' + (isEdit ? 'update' : 'create'),
                type: 'POST',
                data: new FormData($(this)[0]),
                contentType: false,
                processData: false,
                cache: false,
            }).then((res) => {
                if (res) {
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
        })

        function resetNaskahForm() {
            $('#formNaskah')[0].reset()
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

                for (let column in data) {
                    if (data.hasOwnProperty(column)) {
                        if (column === 'id_jenjang' || column === 'id_mapel' || column === 'id_kategori' || column === 'ukuran') {
                            $('#formNaskah select[name='+column+'] option[value="'+data[column]+'"]').attr('selected', 'selected')
                            $('#formNaskah select[name='+column+']').prop('disabled', true)
                        } else {
                            $('#formNaskah input[name='+column+']').val(data[column])
                            $('#formNaskah input[name='+column+']').prop('disabled', true)
                        }
                    }
                }
            })
        }

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
                    }).then((success) => {
                        success = JSON.parse(success)
                        if (success === true) {
                            refreshTable()
                            Swal.fire(
                                'Berhasil dihapus!',
                                'Naskah telah dihapus.',
                                'success'
                            )
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Gagal menghapus naskah!',
                            })
                        }
                    })
                }
            })
        }
    })
</script>