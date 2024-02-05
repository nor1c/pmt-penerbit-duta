<div class="container-fluid">
    <h4 class="c-grey-900 mT-10 mB-30">Hari Libur (Holidays)</h4>
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <div class="mB-20">
                    <button type="button" class="btn cur-p btn-outline-secondary" onclick="refreshTable()">
                        <i class="ti-reload"></i>
                    </button>
                    <button id="addNewHoliday" type="button" class="btn btn-primary btn-color" data-bs-toggle="modal" data-bs-target="#holidayFormModal">
                        <i class="ti-plus"></i> Tambah
                    </button>
                    <button id="importCSVButton" type="button" class="btn btn-success btn-color" data-bs-toggle="modal" data-bs-target="#importHolidayFormModal">
                        <i class="ti-import"></i> Import .CSV
                    </button>
                </div>

                <table id="holidaysTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->load->view('holidays/form') ?>

<script>
    $(document).ready(function() {
        const holidayError = $('#holidayError')

        table = $('#holidaysTable').DataTable({
            "sDom": "Rlfrtip",
            "scrollX": true,
            "aLengthMenu": [
                [1, 10, 30],
                [1, 10, 30],
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
                    "width": "25%",
                    "orderable": false
                },
                {
                    "width": "70%",
                    "orderable": false
                },
            ],
            "columnDefs": [],
            "order": [
                [0, 'asc']
            ],
            "oLanguage": {
                "sSearch": "Pencarian",
                "sProcessing": '<image style="width:150px" src="http://superstorefinder.net/support/wp-content/uploads/2018/01/blue_loading.gif">',
            }
        });

        $('#addNewHoliday').click(function() {
            holidayError.hide()
        })

        $('#formHoliday').submit(function(e) {
            e.preventDefault()
            holidayError.hide()

            const values = $(this).serialize()

            $.ajax({
                method: 'POST',
                url: "<?=site_url(uriSegment(1).'/create')?>",
                data: values
            }).then((result) => {
                result = JSON.parse(result)
                
                if (result.error) {
                    holidayError.show()
                    $('#holidayError').text(result.message);
                } else {
                    holidayError.hide()
                    $("[data-bs-dismiss=modal]").trigger({ type: "click" })
                    $(this).trigger('reset')
                    refreshTable()
                }
            })
        })
    })

    function holidayPickerChanged() {
        const pickedDate = $('.holiday-picker').val()

        $.ajax({
            method: 'GET',
            url: "<?=site_url(uriSegment(1).'/checkDate?date=')?>" + pickedDate
        }).then((pickedDate) => {
            if (pickedDate.length) {
                alert('date picked')
            } else {
                alert('OK!')
            }
        })
    }

    function refreshTable() {
        table.ajax.reload()
    }
</script>