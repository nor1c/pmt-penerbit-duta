<div class="container-fluid">
    <h4 class="c-grey-900 mT-10 mB-30">Jenjang</h4>
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <table id="naskahTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead class="table-dark">
                        <tr>
                            <th width="10">#</th>
                            <th>Jenjang</th>
                            <th width="150">Status</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        table = $('#naskahTable').DataTable({
            "sDom": "Rlfrtip",
            "scrollX": true,
            // "scrollY": "300px",
            // "scrollCollapse": true,
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
            ],
            "columnDefs": [
                {
                    "render": function(data, type, row) {
                        return '<div class="peers mR-15">' +
                            '<div class="peer">' +
                            (row[2] != 0 ? '<i class="c-green-500 ti-check"></i> Aktif' : '<i class="c-red-500 ti-close"></i> Tidak Aktif') +
                            '</div>' +
                            '</div>';
                    },
                    "targets": 2,
                },
            ],
            "order": [
                [0, 'asc']
            ],
            "oLanguage": {
                "sSearch": "Pencarian",
                "sProcessing": '<image style="width:150px" src="http://superstorefinder.net/support/wp-content/uploads/2018/01/blue_loading.gif">',
            }
        });
    })
</script>