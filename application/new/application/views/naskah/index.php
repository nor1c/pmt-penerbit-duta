<div class="container-fluid">
    <h4 class="c-grey-900 mT-10 mB-30">Naskah</h4>
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <h4 class="c-grey-900 mB-20">Data Naskah</h4>

                <button type="button" class="btn btn-primary btn-color mB-20" data-bs-toggle="modal" data-bs-target="#naskahFormModal">
                    Tambah Naskah Baru
                </button>
                <button type="button" class="btn btn-primary btn-color mB-20" onclick="refreshTable()">
                    Refresh Data
                </button>

                <table id="naskahTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>No. Job</th>
                            <th>Kode Buku</th>
                            <th>Judul Buku</th>
                            <th>Jilid</th>
                            <th>Penulis</th>
                            <th>Aksi</th>
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
        let currentDraw = 1
        let naskahTable = $('#naskahTable').DataTable({
            "sDom": "Rlfrtip",
            "scrollX": true,
            "scrollY": "300px",
            "scrollCollapse": true,
            "aLengthMenu": [
                [5, 10, 10, 100, 50, 100, 10],
                [5, 10, 10, 100, 50, 100, 10],
            ],
            "pageLength": 50,
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?= site_url($this->uri->segment(1) . '/data') ?>",
                'method': 'POST',
                'data': function(d) {
                    d.draw = d.draw || 1
                    return $.extend(d, {});
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
					render: function (data, type, row, meta) {
						return meta.row + meta.settings._iDisplayStart + 1;
					}
				},
                null,
                null,
                null,
                null,
                null,
                null
            ],
            "columnDefs": [
                {
                    "render": function(data, type, row) {
                        return '<div class="peers mR-15">'+
                                    '<div class="peer">'+
                                        '<a href="" class="td-n c-deep-purple-500 cH-blue-500 fsz-md p-5">'+
                                            '<i class="c-blue-500 ti-pencil"></i>'+
                                        '</a>'+
                                    '</div>'+
                                    '<div class="peer">'+
                                        '<a href="" class="td-n c-deep-purple-500 cH-blue-500 fsz-md p-5">'+
                                            '<i class="c-red-500 ti-trash"></i>'+
                                        '</a>'+
                                    '</div>'+
                                '</div>';
                    },
                    "targets": 6,
                }
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

        refreshTable = function() {
            naskahTable.ajax.reload(null, false)
        }

        $('#formNaskah').submit(function (e) {
            e.preventDefault()

            $.ajax({
                url: '<?=site_url($this->uri->segment(1) . '/create')?>',
                type: 'POST',
                data: new FormData($(this)[0]),
                contentType: false,
                processData: false,
                cache: false,
            }).then((res) => {
                if (res) {
                    refreshTable()
                    $('#naskahFormModal').modal('hide')
                }
            }).fail(() => {
                alert('Insert failure!')
            })
        })
    })
</script>