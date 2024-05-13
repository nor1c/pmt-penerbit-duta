<style>
    #naskahReportTable tbody tr:hover {
        cursor: pointer;
    }
</style>

<div class="container-fluid">
    <h4 class="c-grey-900 mT-10 mB-30">Naskah</h4>
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <div class="mB-20">
                    <div class="alert alert-warning" role="alert">
                        <b><i class="ti-info-alt"></i>&nbsp;&nbsp; Klik row Naskah untuk melihat detail report pekerjaannya.</b>
                    </div>
                    <button type="button" class="btn cur-p btn-outline-secondary" onclick="refreshTable()">
                        <i class="ti-reload"></i>
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

                <table id="naskahReportTable" class="table table-bordered table-hover" cellspacing="0" width="100%">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>No. Job</th>
                            <th>Kode Buku</th>
                            <th>Judul Buku</th>
                            <th>Jilid</th>
                            <th>Penulis</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        table = $('#naskahReportTable').DataTable({
            "sDom": "Rlfrtip",
            "scrollCollapse": true,
            "aLengthMenu": [
                [5, 10, 10, 150, 50, 100, 5],
                [5, 10, 10, 150, 50, 100, 5],
            ],
            "pageLength": 10,
            "processing": true,
            "serverSide": true,
            "searching": true,
            "ajax": {
                "url": "<?=site_url($this->uri->segment(1)) . '/naskahData'?>",
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
                // {
                //     "targets": 6,
                //     "render": function(data, type, row) {
                //         const withButtons = '<div class="peers mR-15">' +
                //                                 '<div class="peer">' +
                //                                     '<a href="#" onclick="deleteNaskah(' + row[1] + ')" class="td-n c-deep-purple-500 cH-blue-500 fsz-md p-5">' +
                //                                         '<i class="c-orange-500 ti-agenda"></i>' +
                //                                     '</a>' +
                //                                 '</div>' +
                //                             '</div>';

                //         return withButtons
                //     },
                // },
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

        
        $('#naskahReportTable tbody').on('click', 'tr', function() {
            const data = table.row(this).data();
            const noJob = data[1]
            const url = "<?=site_url('report/naskah')?>/" + noJob;
            window.location.href = url;
        });
    })
</script>