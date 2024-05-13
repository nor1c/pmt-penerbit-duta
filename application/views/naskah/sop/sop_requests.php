<div class="container-fluid">
    <h4 class="c-grey-900 mT-10 mB-30">Form SOP</h4>
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <table id="sopRequestsTable" class="table table-bordered table-hover" cellspacing="0" width="100%">
                    <thead class="table-dark">
                        <tr>
                            <th width="10">#</th>
                            <th width="10">ID Naskah</th>
                            <th>No. Job</th>
                            <th>Judul Naskah</th>
                            <th>Editor</th>
                            <th>Tanggal Request</th>
                            <th>SOP</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        table = $('#sopRequestsTable').DataTable({
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
                "url": "<?=site_url($this->uri->segment(1) . '/sop_requests_data')?>",
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
            ],
            "columnDefs": [
                {
                    "targets": 7,
                    "render": function(data, type, row) {
                        return '<div class="peers mR-15">' +
                                '<div class="peer">' +
                                '<a href="<?=site_url('/naskah/sop_')?>'+ row[6].toLowerCase().replaceAll(' ', '_') + '?id_naskah=' + row[1] + '&no_job=' + row[2] +'" class="td-n c-deep-purple-500 cH-blue-500 fsz-md p-5">' +
                                '<i class="c-green-500 ti-eye"></i>' +
                                '</a>' +
                                '</div>' +
                                '</div>';
                    },
                },
            ],
            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {},
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
        
        // hide column(s) from datatable
        $('#sopRequestsTable').DataTable().column(1).visible(false);
    })
</script>