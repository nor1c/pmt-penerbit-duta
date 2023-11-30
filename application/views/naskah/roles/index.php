<div class="container-fluid">
    <h4 class="c-grey-900 mT-10 mB-30">Data Master Role Naskah</h4>
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <table id="naskahTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Key</th>
                            <th>Nama Role</th>
                            <th>Status</th>
                            <th>List Karyawan</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<?=$this->load->view('naskah/roles/mapper')?>

<script>
    let listKaryawan = {}
    
    $(document).ready(function() {
        fetchKaryawan()

        table = $('#naskahTable').DataTable({
            "sDom": "Rlfrtip",
            "scrollX": true,
            // "scrollY": "300px",
            // "scrollCollapse": true,
            "aLengthMenu": [
                [1, 10, 10, 5, 20],
                [1, 10, 10, 5, 20],
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
                            (row[3] != 0 ? '<i class="c-green-500 ti-check"></i> Aktif' : '<i class="c-red-500 ti-close"></i> Tidak Aktif') +
                            '</div>' +
                            '</div>';
                    },
                    "targets": 3,
                },
                {
                    "render": function(data, type, row) {
                        return '<div>' +
                            (row[4] ? '- ' + row[4].replaceAll(',', '<br>- ') : '<i>Belum ada karyawan yang terdaftar ke role ini.</i><br><div class="mT-10"><button onclick="mapKaryawan(\''+ row[1] +'\')" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#employeeMapperModal"><i class="c-white-500 ti-settings"></i>&nbsp; Atur Karyawan</button></div>') +
                            (row[4] ? '<div class="mT-10"><button onclick="mapKaryawan(\''+ row[1] +'\')" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#employeeMapperModal"><i class="c-white-500 ti-settings"></i>&nbsp; Atur Karyawan</button></div>' : '') +
                        '</div>';
                    },
                    "targets": 4,
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

    function refreshTable() {
        console.log('reloading table..');
        table.ajax.reload()
    }

    function mapKaryawan(roleKey) {
        removeAllPicker()

        $('#naskah_key').val(roleKey);

        $.ajax({
            method: 'GET',
            url: "<?=site_url(uriSegment(1).'/'.uriSegment(2).'/getMappedKaryawans?roleKey=')?>" + roleKey
        }).then((data) => {
            const mappedKaryawan = JSON.parse(data)

            mappedKaryawan.map((karyawan) => {
                createNewPICPicker(karyawan.id_karyawan)
            }) 
        })
    }

    function removeAllPicker() {
        $('.picker').remove()
    }

    function fetchKaryawan() {
        $.ajax({
            method: 'GET',
            url: "<?=site_url('karyawan/getPICNaskahJSON')?>",
        }).then((karyawans) => {
            listKaryawan = JSON.parse(karyawans)
        })
    }

    let currentPickerIndex = 0
    function createNewPICPicker(idKaryawan = null) {
        currentPickerIndex += 1

        let picker = '<tr id=picker_'+currentPickerIndex+' class="picker">' +
                        '<td width="98%" class="pR-10">' +
                            '<select class="form-control mT-5 karyawan_mapper">' +
                                '<option selected default>--Pilih Karyawan--</option>'

        listKaryawan.forEach((karyawan) => {
            picker += '<option value="'+ karyawan.id_karyawan + '"' + (idKaryawan && idKaryawan == karyawan.id_karyawan ? " selected" : "") + ' >' + karyawan.nama + '</option>'
        })

        picker += '</select>' +
                '</td>' +
                '<td width="10">' +
                    '<i onclick="removePicker('+currentPickerIndex+')" class="c-red-500 ti-close" style="cursor:pointer"></i>' +
                '</td>' +
            '</tr>'

        $('#addableArea').append(picker)
    }

    function saveMapping() {
        const pickedKaryawans = $('.karyawan_mapper option:selected').map(function() {
            return $(this).val()
        }).get()

        const naskahKey = $('#naskah_key').val()
        let data = []
        pickedKaryawans.map(function(idKaryawan) {
            data.push({
                role_key: naskahKey,
                id_karyawan: idKaryawan
            })
        })

        $.ajax({
            method: 'POST',
            url: "<?=site_url(uriSegment(1).'/'.uriSegment(2).'/saveMapping')?>",
            data: {
                data
            }
        }).then(success => {
            if (success) {
                $("[data-bs-dismiss=modal]").trigger({ type: "click" })
                refreshTable()
            }
        })
    }

    function removePicker(pickerIndex) {
        $('#picker_' + pickerIndex).remove()
    }
</script>