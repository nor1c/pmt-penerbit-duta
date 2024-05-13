<!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/custom.css"> -->

<style>
    html {
        scroll-behavior: smooth;
    }

    .ignielToTop {
        width: 50px;
        height: 50px;
        position: fixed;
        bottom: 50px;
        right: 50px;
        z-index: 99;
        cursor: pointer;
        border-radius: 100px;
        transition: all .5s;
        background: #008c5f url("data:image/svg+xml,%3Csvg viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M7.41,15.41L12,10.83L16.59,15.41L18,14L12,8L6,14L7.41,15.41Z' fill='%23fff'/%3E%3C/svg%3E") no-repeat center center;
    }

    .ignielToTop:hover {
        background: #1d2129 url("data:image/svg+xml,%3Csvg viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M7.41,15.41L12,10.83L16.59,15.41L18,14L12,8L6,14L7.41,15.41Z' fill='%23fff'/%3E%3C/svg%3E") no-repeat center center;
    }

    .loader {
        margin: 0 auto;
        margin-bottom: 50px;
        border: 16px solid #f3f3f3;
        /* Light grey */
        border-top: 16px solid #3498db;
        /* Blue */
        border-radius: 50%;
        width: 120px;
        height: 120px;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>

<div class="loader"></div>

<div id="input" style="display:none">
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <div id="lateMessage" class="col-md-12">
                    <center>
                        <h5>
                            Anda melewati batas waktu absensi yakni pukul <b>08:30 WIB</b>, silahkan menghubungi admin untuk mengurus
                            surat keterlambatan. Terima kasih!
                            </h4>
                    </center>
                </div>
                <div id="workTimeTracker" class="col-md-12">
                    <center>
                        <h3>
                            Anda telah bekerja selama <div style="height:50px;" id="txtWorkTime"></div>
                        </h3>
                    </center>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <center>
                            <h4>
                                <div style="height:50px;" id="txtDatang"></div>
                                <button id="buttonDatang" class="btn btn-primary" onclick="clockIn()">Datang</button>
                            </h4>
                        </center>
                    </div>

                    <div class="col-md-6">
                        <center>
                            <h3>
                                <div style="height:50px;" id="txtPulang"></div>
                                <button id="buttonPulang" class="btn btn-warning" onclick="clockOut()">Pulang</button>
                            </h3>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <fieldset>
                    <legend>Progress Naskah</legend>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="content-box">
                                <div class="row" style="margin:0 auto;">
                                    <div class="col-sm">
                                        <div style="margin-top:30%">
                                            <div class="mb-4">
                                                <div class="row">
                                                    <div class="col-sm-2">
                                                        <div style="width:15px;height:15px;background:#24b2f9;border-radius:100%;margin-top:4px">&nbsp;</div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <h5 class="font-weight-bold">Halaman</h5>
                                                    </div>
                                                </div>
                                                <div style="margin-left:28px"><span id="total_halaman_terkerjakan">0</span>/<span id="total_halaman">0</span> halaman</div>
                                            </div>
                                            <div>
                                                <div class="row">
                                                    <div class="col-sm-2">
                                                        <div style="width:15px;height:15px;background:#5155c0;border-radius:100%;margin-top:4px">&nbsp;</div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <h5 class="font-weight-bold">Hari</h5>
                                                    </div>
                                                </div>
                                                <div style="margin-left:28px"><span id="hari_pengerjaan">0</span>/<span id="total_hari_perencanaan">0</span> hari</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- doughtnut charts -->
                                    <div class="col-sm">
                                        <figure class="highcharts-figure">
                                            <div id="progressChart"></div>
                                        </figure>
                                    </div>

                                    <!-- buttons -->
                                    <div class="col-sm">
                                        <div style="margin-top:40%;">
                                            <button id="start-naskah-button" onclick="startJob()" class="mb-2 form-control btn btn-info">Mulai</button>
                                            <button id="pause-naskah-button" type="button" class="form-control btn btn-danger" data-bs-toggle="modal" data-bs-target="#stopJobModal">Selesai</button>
                                        </div>
                                    </div>
                                </div>
                                <div id="activeTrack" class="col-sm">
                                    <table class="table table-md">
                                        <tbody>
                                            <tr>
                                                <td><b>START TIME</b></td>
                                                <td id="activeStartTime">2020-01-01</td>
                                            </tr>
                                            <tr>
                                                <td><b>ELAPSED TIME</b></td>
                                                <td><div id="activeTimer"></div></td>
                                            </tr>
                                            <tr>
                                                <td><b>STATUS</b></td>
                                                <td id="activeStatus"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="content-box">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div>
                                            <img id="activeNaskahCover" style="border-radius:5px" width="100%">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="content-box">
                                            <h8 id="activeNaskahKode">10-000-0000-0</h8>
                                            <h6 class="mT-5"><b id="activeNaskahJudul">Judul Buku</b></h6>
                                            <table class="mT-10 table table-sm">
                                                <tbody>
                                                    <tr>
                                                        <td>Penulis</td>
                                                        <td>:</td>
                                                        <td id="activeNaskahPenulis"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Warna</td>
                                                        <td>:</td>
                                                        <td id="activeNaskahWarna">...</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Ukuran</td>
                                                        <td>:</td>
                                                        <td id="activeNaskahUkuran">...</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Halaman</td>
                                                        <td>:</td>
                                                        <td id="activeNaskahHalaman">...</td>
                                                    </tr>
                                                    <tr>
                                                        <td>ISBN</td>
                                                        <td>:</td>
                                                        <td id="activeNaskahISBN">...</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <br>
                                            <center>
                                                <a id="activeNaskahDetailButton" href="#" target="_blank" class="btn btn-primary" style="margin:0 auto;">Detail</a>
                                            </center>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="content-box">
                                <table class="table table-sm">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">LEVEL</th>
                                            <th scope="col">PIC</th>
                                            <th scope="col">STATUS</th>
                                            <th scope="col">PROGRESS</th>
                                        </tr>
                                    </thead>
                                    <tbody id="activeNaskahLevelKerjaList"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <br><br><br>

                    <!-- table -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="content-box">
                                <table id="jobTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Kode Buku</th>
                                            <th>No. Job</th>
                                            <th>Judul Buku</th>
                                            <th>Hal</th>
                                            <th>Level</th>
                                            <th>Rencana Mulai</th>
                                            <th>Rencana Selesai</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>

                    <br><br><br>

                    <!-- table -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="content-box">
                                <table id="dailyReportTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Tanggal</th>
                                            <th>Nama</th>
                                            <th>Level Kerja</th>
                                            <th>Judul</th>
                                            <th>Catatan</th>
                                            <th>Kode Buku</th>
                                            <th>No. Job</th>
                                            <th>Realisasi</th>
                                            <th>Accuracy Meter</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
</div>

<!-- modal untuk stop job hari ini -->
<div class="modal fade bd-example-modal-md" id="stopJobModal" role="dialog" aria-labelledby="formModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form id="formJobReport">
                <div class="modal-header bg-light">
                    <h5 class="modal-title">Form Laporan Pekerjaan Harian</h5>
                    <span type="button" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i>
                    </span>
                </div>

                <div class="modal-body">
                    <div id="formJobReportError" class="alert alert-danger"></div>

                    <div class="mb-3">
                        <label class="form-label" for="holidayDateInput">Tanggal</label>
                        <input type="text" name="tanggal" class="form-control" readonly disabled value="<?=date('d/m/Y', time())?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Halaman</label>
                        <input type="number" min="0" max="999" value="0" name="halaman" class="form-control" placeholder="Progress Jumlah Halaman Hari Ini" required>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="submit" class="btn btn-info waves-effect waves-light">Simpan</button>
                    <button type="reset" class="btn btn-secondary waves-effect waves-light">Clear</button>
                    <button type="button" class="btn btn-dark waves-effect waves-light" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- modal untuk kirim level kerja -->
<div class="modal fade bd-example-modal-md" id="kirimJobModal" role="dialog" aria-labelledby="formModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form id="formKirimJob">
                <div class="modal-header bg-light">
                    <h5 class="modal-title">Form Catatan Kirim Job</h5>
                    <span type="button" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i>
                    </span>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" for="kirimDateInput">Tanggal</label>
                        <input type="text" name="tanggal" class="form-control" readonly disabled value="<?=date('d/m/Y', time())?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea type="text" name="catatan_cicil" class="form-control" rows="8" placeholder="Catatan" required></textarea>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="submit" class="btn btn-info waves-effect waves-light">Kirim</button>
                    <button type="reset" class="btn btn-secondary waves-effect waves-light">Clear</button>
                    <button type="button" class="btn btn-dark waves-effect waves-light" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- modal untuk finish level kerja -->
<div class="modal fade bd-example-modal-md" id="finishJobModal" role="dialog" aria-labelledby="formModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form id="formFinishJob">
                <div class="modal-header bg-light">
                    <h5 class="modal-title">Form Catatan Finish Level Kerja</h5>
                    <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i>
                    </span>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" for="finishDateInput">Tanggal</label>
                        <input type="text" name="tanggal" class="form-control" readonly disabled value="<?=date('d/m/Y', time())?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Halaman</label>
                        <input id="finishJobRealisasi" type="text" name="realisasi" class="form-control" readonly disabled value="" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea type="text" name="catatan_selesai" class="form-control" rows="8" placeholder="Catatan" required></textarea>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="submit" class="btn btn-danger waves-effect waves-light">Kirim</button>
                    <button type="button" class="btn btn-secondary waves-effect waves-light" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/solid-gauge.js"></script>
<script type="text/javascript">
    const pekerjaanOpt = $('select[name=pekerjaan]')
    const judulBukuOpt = $('select[name=id_buku]')
    const kodeBukuInput = $('input[id=kode_buku]')
    const noJobInput = $('input[id=no_job]')
    const catatanInput = $('input[name=catatan]')
    const targetInput = $('input[name=target]')
    const statusOpt = $('select[name=status]')

    let clockIn
    let clockOut
    let attendTime
    let stopWorkTimer = false

    let getActiveJob

    let activeKirimJobNoJob = null
    let activeKirimJobLevelKerja = null

    let activeFinishJobNoJob = null
    let activeFinishJobLevelKerja = null

    const levelKerjaMap = {
        'penulisan': 'Penulisan',
        'editing': 'Editing',
        'setting_1': 'Setting 1',
        'setting_2': 'Setting 2',
        'setting_3': 'Setting 3',
        'koreksi_1': 'Koreksi 1',
        'koreksi_2': 'Koreksi 2',
        'koreksi_3': 'Koreksi 3',
        'pdf': 'PDF',
    }
    const statusMap = {
        open: {
            text: 'Open',
            bgColor: '#cccccc'
        },
        on_progress: {
            text: 'On Progress',
            bgColor: '#7de5ff'
        },
        paused: {
            text: 'Sedang Ditunda',
            bgColor: '#e3db94'
        },
        cicil: {
            text: 'Dicicil',
            bgColor: '#e3b094'
        },
        finished: {
            text: 'Selesai',
            bgColor: '#8de0a5'
        },
    }

    $(document).ready(function() {
        // jobs
        getActiveJob = function() {
            $.ajax({
                url: "<?=site_url('jobs/checkActiveJob')?>",
                method: "GET"
            }).then(res => {
                res = JSON.parse(res)
                if (res.noJob) {
                    viewJob(true, res.noJob, res.levelKerja)
                    $('#activeStartTime').text(new Date(res.waktuMulai).toLocaleDateString() + ' ' + new Date(res.waktuMulai).toLocaleTimeString('id-ID'))
                    
                    $('#activeTrack').show()
                    var targetDate = new Date(res.waktuMulai).getTime();
                    var elapsedTimeInterval = setInterval(function() {
                        var currentDate = new Date().getTime();
                        var timeDifference = currentDate - targetDate;
                        var elapsedHours = Math.floor(timeDifference / (1000 * 60 * 60));
                        var elapsedMinutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
                        var elapsedTimeText = elapsedHours + " jam " + elapsedMinutes + " menit";
                        $("#activeTimer").text(elapsedTimeText);

                        if (elapsedHours > 16) {
                            $('#activeStatus').html('<span style="color:red"><i class="ti-alert"></i> <b>BAD (Melebihi batas hari)</b></span>')
                        } else {
                            $('#activeStatus').html('<span style="color:green"><i class="ti-check"></i> <b>GOOD</b></span>')
                        }
                    }, 1000);
                } else {
                    $('#activeTrack').hide()
                }
            })
        }
        getActiveJob()

        table = $('#jobTable').DataTable({
            "sDom": "Rlfrtip",
            "scrollCollapse": true,
            "aLengthMenu": [
                [5, 10, 15, 20],
                [5, 10, 15, 20],
            ],
            "pageLength": 5,
            "processing": true,
            "serverSide": true,
            "searching": true,
            "orderable": false,
            "ajax": {
                "url": "<?= site_url('jobs/my_job') ?>",
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
            ],
            "columnDefs": [
                {
                    "targets": 5,
                    "render": function(data, type, row) {
                        return levelKerjaMap[row[5]]
                    }
                },
                {
                    "targets": 6,
                    "render": function(data, type, row) {
                        return '<div style="'+(new Date() > new Date(row[6]) ? 'color:red;font-weight:bold;' : '')+'">'+(new Date() > new Date(row[6]) ? '<i class="ti-alert"></i>' : '')+' '+new Date(row[6]).toLocaleDateString('id-ID')+'</div>'
                    }
                },
                {
                    "targets": 7,
                    "render": function(data, type, row) {
                        return '<div style="'+(new Date() > new Date(row[7]) ? 'color:red;font-weight:bold;' : '')+'">'+(new Date() > new Date(row[7]) ? '<i class="ti-alert"></i>' : '')+' '+new Date(row[7]).toLocaleDateString('id-ID')+'</div>'
                    }
                },
                {
                    "targets": 8,
                    "render": function(data, type, row) {
                        return '<div><button class="btn" style="border:none;cursor:default;'+(row[8]=='on_progress'?'font-weight:bold;':'')+';background-color:'+statusMap[row[8]].bgColor+'">'+statusMap[row[8]].text+'</button></div>'
                    }
                },
                {
                    "targets": 9,
                    "render": function(data, type, row) {
                        return '<div class="peers mR-15">' +
                            '<div class="peer mR-5">' +
                                '<button onclick="viewJob('+false+', \''+row[2]+'\', \''+row[5]+'\')" class="btn btn-info">View</button>' +
                            '</div>' +
                            ((row[8] == 'open' || row[8] == 'paused') ? 
                                '<div class="peer mR-5">' +
                                '<button onclick="mulaiJob(\''+row[2]+'\', \''+row[5]+'\')" class="btn btn-success" '+(row[8]=='on_progress' || row[8]=='cicil'?'disabled':'')+'>'+(row[8] == 'paused' ? 'Lanjut' : 'Mulai')+'</button>' +
                                '</div>' 
                                :
                                '<div class="peer mR-5">' +
                                '<button onclick="tundaJob(\''+row[2]+'\', \''+row[5]+'\')" class="btn btn-warning '+(row[8]!='on_progress' || row[8]=='cicil'?'disabled':'')+'">Tunda</button>' +
                                '</div>'
                            ) +
                            '<div class="peer mR-5">' +
                                // '<button onclick="kirimJob(\''+row[2]+'\', \''+row[5]+'\')" class="btn btn-primary"'+(row[8]=='on_progress'?'disabled':'')+'>Kirim</button>' +
                                '<button id="kirim-job-button" onClick="kirimJobTrigger(\''+row[2]+'\', \''+row[5]+'\')" type="button" class="form-control btn btn-primary" data-bs-toggle="modal" data-bs-target="#kirimJobModal" class="btn btn-primary"'+((row[8]=='finished' || row[8]=='open' || row[9] != null)?'disabled':'')+'>Kirim</button>' +
                            '</div>' +
                            '<div class="peer mR-5">' +
                                '<button id="finish-job-button" onClick="finishJobTrigger(\''+row[2]+'\', \''+row[5]+'\', \''+row[4]+'\')" type="button" class="form-control btn btn-danger" data-bs-toggle="modal" data-bs-target="#finishJobModal" class="btn btn-danger" '+(row[8]=='finished' || row[8]=='open' ?'disabled':'')+'>Selesai</button>' +
                            '</div>' +
                            '<div class="peer mR-5">' +
                                '<a href="<?=site_url('naskah/detail')?>/'+row[2]+'" class="btn btn-primary">Detail</a>' +
                            '</div>' +
                            '</div>';
                    },
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

        // table laporan pekerjaan
        const dailyJobReportTable = $('#dailyReportTable').DataTable({
            "sDom": "Rlfrtip",
            "scrollCollapse": true,
            "aLengthMenu": [
                [5, 30, 30, 30, 50, 50, 30, 10, 10, 30],
                [5, 30, 30, 30, 50, 50, 30, 10, 10, 30],
            ],
            "pageLength": 10,
            "processing": true,
            "serverSide": true,
            "searching": false,
            "orderable": false,
            "ajax": {
                "url": "<?= site_url('jobs/dailyJobReport') ?>",
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
            ],
            "columnDefs": [
                {
                    "targets": 1,
                    "render": function(data, type, row) {
                        const splittedDate = (row[1].split(' ')[0]).split('-')
                        return splittedDate[2] + '-' + splittedDate[1] + '-' + splittedDate[0]
                    }
                },
                {
                    "targets": 8,
                    "render": function(data, type, row) {
                        return row[8] ? row[8] + ' halaman' : '<i>~On Progress~</i>'
                    }
                },
                {
                    "targets": 9,
                    "render": function(data, type, row) {
                        const fromDate = new Date(row[9])
                        const toDate = new Date(row[1].split(' ')[0])
                        const difference = Math.abs(toDate - fromDate);
                        const daysDifference = Math.ceil(difference / (1000 * 60 * 60 * 24));
                        const dayDiffWithoutHolidays = Math.abs(daysDifference - row[12])

                        let barColor = 'd94141'
                        const barPercentage = ((dayDiffWithoutHolidays ?? 0)*100/row[11])
                        if (barPercentage <= 33) {
                            barColor = '58a85e'
                        } else if (barPercentage > 33 && barPercentage <= 66) {
                            barColor = 'd1a847'
                        }

                        return '<div class="peers mR-15" style="width:100%">' +
                            '<div class="peer mR-5" style="width:100%;'+ (dayDiffWithoutHolidays > row[11] ? 'color:red;font-weight:bold' : '') +'">' +
                            '<div style="height:20px;width:100%;border:solid 1px #ddd;border-radius:5px;">'+
                            '<div style="height:18px;width100%;background:#'+barColor+';border-radius:5px;text-align:center;color:#fff"></div>' +
                            '</div>' +
                            '<div style="text-align:center">' + dayDiffWithoutHolidays + ' dari ' + row[11] + ' hari' + '</div>' +
                            '</div>' +
                            '</div>';
                    },
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

        // fitur absensi (new) May 3rd, 2023
        // on load check for attendance status

        // special users that don't follow the new attendance rule
        const specialUsers = JSON.parse("<?= json_encode($special_users) ?>");
        const loggedInUserId = "<?= $this->session->userdata('user_id') ?>"
        const isCurrentUserSpecial = specialUsers.includes(parseInt(loggedInUserId))

        checkAttendance()

        function startTimer() {
            $('#buttonPulang').attr('disabled', true)
            $('#buttonPulang').css('cursor', 'not-allowed')

            const today = new Date();
            let h = today.getHours();
            let m = today.getMinutes();
            let s = today.getSeconds();
            m = checkTime(m);
            s = checkTime(s);
            document.getElementById('txtDatang').innerHTML = h + ":" + m + ":" + s;
            timerTimeout = setTimeout(startTimer, 1000);
        }

        function startTimerPulang() {
            const today = new Date();
            let h = today.getHours();
            let m = today.getMinutes();
            let s = today.getSeconds();
            m = checkTime(m);
            s = checkTime(s);
            document.getElementById('txtPulang').innerHTML = h + ":" + m + ":" + s;
            timerTimeoutPulang = setTimeout(startTimerPulang, 1000);
        }

        function startTimerDiffWorkTime() {
            if (!stopWorkTimer) {
                const now = new Date()

                const explodedAttendTime = attendTime.split(':')
                const loggedInTime = new Date()
                loggedInTime.setHours(explodedAttendTime[0])
                loggedInTime.setMinutes(explodedAttendTime[1])
                loggedInTime.setSeconds(explodedAttendTime[2])

                const elapsedTimeMs = now - loggedInTime;
                const h = Math.floor(elapsedTimeMs / (1000 * 60 * 60));
                const m = Math.floor((elapsedTimeMs / (1000 * 60)) % 60);
                const s = Math.floor((elapsedTimeMs / 1000) % 60);

                document.getElementById('txtWorkTime').innerHTML = h + " jam " + m + " menit " + s + " detik";

                if (!isCurrentUserSpecial) {
                    if (now.getHours() <= 16 && (now.getHours() == 16 && now.getMinutes() < 30)) {
                        $('#buttonPulang').attr('disabled', true)
                        $('#buttonPulang').css('cursor', 'not-allowed')
                    } else {
                        if (h < 9) {
                            $('#buttonPulang').attr('disabled', true)
                            $('#buttonPulang').css('cursor', 'not-allowed')
                        } else {
                            $('#buttonPulang').attr('disabled', false)
                            $('#buttonPulang').css('cursor', 'pointer')
                        }
                    }
                }

                workTimeDiff = setTimeout(startTimerDiffWorkTime, 1000)
            }
        }

        function checkTime(i) {
            if (i < 10) {
                i = "0" + i
            }; // add zero in front of numbers < 10
            return i;
        }

        // check for attendance status
        function checkAttendance() {
            const [h, m] = "<?= date('H:i', time()); ?>".split(':')
            const isLate = isCurrentUserSpecial ? false : (h > 8 || (h == 8 && m > 30))

            $('#filter-tanggal-mulai').val('<?= date('d/m/Y', time()) ?>')
            $('#filter-tanggal-sampai').val('<?= date('d/m/Y', time()) ?>')

            const attendanceStatus = $.ajax({
                url: '<?= base_url('presences/check'); ?>',
                type: 'POST',
                success: function(data) {
                    if (data == 'null') {
                        if (!isLate) {
                            $('#workTimeTracker').hide()
                            startTimer()

                            $('#buttonPulang').attr('disabled', true)
                            $('#buttonPulang').css('cursor', 'not-allowed')

                            const currentTime = "<?= date('H:i', time()); ?>".split(':')
                            const h = currentTime[0]
                            const m = currentTime[1]

                            // disable "datang" button if it's past 8:30 o'clock
                            if (!isCurrentUserSpecial && (h > 8 || (h == 8 && m > 30))) {
                                $('#lateMessage').show()
                                $('#buttonDatang').attr('disabled', true)
                                $('#buttonDatang').css('cursor', 'not-allowed')
                            } else {
                                $('#lateMessage').hide()
                                $('#buttonDatang').attr('disabled', false)
                                $('#buttonDatang').css('cursor', 'pointer')
                            }
                        } else {
                            $('#buttonDatang').attr('disabled', true)
                            $('#buttonDatang').css('cursor', 'not-allowed')

                            $('#buttonPulang').attr('disabled', true)
                            $('#buttonPulang').css('cursor', 'not-allowed')

                            $('#workTimeTracker').hide()
                        }
                    } else {
                        const parsedData = JSON.parse(data)

                        attendTime = parsedData.jam_masuk
                        const attendPulang = parsedData.jam_keluar

                        document.getElementById('txtDatang').innerHTML = attendTime

                        if (attendPulang == null && attendTime != null) {
                            $('#buttonDatang').attr('disabled', true)
                            $('#buttonDatang').css('cursor', 'not-allowed')

                            startTimerPulang()

                            if (h > 7 || (h == 7 && m > 30)) {
                                startTimerDiffWorkTime()
                            } else {
                                $('#workTimeTracker').hide()
                            }
                        } else {
                            $('#buttonDatang').attr('disabled', true)
                            $('#buttonDatang').css('cursor', 'not-allowed')

                            $('#buttonPulang').attr('disabled', true)
                            $('#buttonPulang').css('cursor', 'not-allowed')

                            document.getElementById('txtPulang').innerHTML = attendPulang

                            $('#workTimeTracker').hide()
                        }

                        $('#lateMessage').hide()
                    }
                }
            })
        }

        // absen datang & pulang
        clockIn = function() {
            $.ajax({
                url: '<?= base_url('presences/attend'); ?>',
                type: 'POST',
                success: function(success) {
                    if (success == 'true') {
                        clearTimeout(timerTimeout)

                        $('#buttonDatang').attr('disabled', true)
                        $('#buttonDatang').css('cursor', 'not-allowed')
                        startTimerPulang()

                        const now = new Date();
                        const hours = now.getHours().toString().padStart(2, '0');
                        const minutes = now.getMinutes().toString().padStart(2, '0');
                        const seconds = now.getSeconds().toString().padStart(2, '0');

                        // const minClockIn = now.getHours() > 7 || (now.getHours() == 7 && now.getMinutes() < 30) ? true : false;
                        let minClockIn = false
                        if (now.getHours() < 7 || (now.getHours() == 7 && now.getMinutes() < 30)) {
                            minClockIn = true
                        }

                        attendTime = `${minClockIn ? 07 : hours}:${minClockIn ? 30 : minutes}:${minClockIn ? 00 : seconds}`;

                        if (minClockIn) {
                            document.getElementById('txtDatang').innerHTML = '07:30:00'
                        } else {
                            startTimerDiffWorkTime()
                        }
                    } else {
                        alert('Gagal absen masuk, harap refresh halaman lalu coba lagi.')
                    }
                }
            })
        }

        clockOut = function() {
            $.ajax({
                url: '<?= base_url('presences/out') ?>',
                type: 'POST',
                success: function(success) {
                    if (success == 'true') {
                        clearTimeout(timerTimeoutPulang)

                        $('#buttonPulang').attr('disabled', true)
                        $('#buttonPulang').css('cursor', 'not-allowed')

                        stopWorkTimer = true

                        const now = new Date()
                        const h = now.getHours()
                        const m = now.getMinutes()

                        let clockOutTime = h + ':' + m + ':' + now.getSeconds()
                        if (!isCurrentUserSpecial && (h > 17 || (h > 17 && m == 30))) {
                            clockOutTime = '17:30:00'
                        }

                        document.getElementById('txtPulang').innerHTML = clockOutTime
                    } else {
                        alert('Gagal absen pulang, harap refresh halaman lalu coba lagi.')
                    }
                }
            })
        }

        //
        setTimeout(() => {
            $('#input').css('display', 'block')
            $('.loader').css('display', 'none')
        }, 200);
    })

    // chart
    function renderIcons() {}
    
    const trackColors = Highcharts.getOptions().colors.map(color =>
        new Highcharts.Color(color).setOpacity(0.3).get()
    );

    let progressHalaman = 0
    let progressHari = 0
    let progressChart = Highcharts.chart('progressChart', {
        credits: {
            enabled: false
        },

        exporting: {
            enabled: false
        },

        chart: {
            type: 'solidgauge',
            height: '130%',
            events: {
                render: renderIcons
            }
        },

        title: {
            text: 'Chart',
            style: {
                fontSize: '20px'
            }
        },

        tooltip: {
            borderWidth: 0,
            backgroundColor: 'none',
            shadow: false,
            style: {
                fontSize: '12px'
            },
            valueSuffix: '%',
            pointFormat: '{series.name}<br>' +
                '<span style="font-size: 2em; color: {point.color}; ' +
                'font-weight: bold">{point.y}</span>',
            positioner: function (labelWidth) {
                return {
                    x: (this.chart.chartWidth - labelWidth) / 2,
                    y: (this.chart.plotHeight / 2) + 15
                };
            }
        },

        pane: {
            startAngle: 0,
            endAngle: 360,
            background: [{ // Track for Conversion
                outerRadius: '112%',
                innerRadius: '88%',
                backgroundColor: trackColors[0],
                borderWidth: 0
            }, { // Track for Engagement
                outerRadius: '87%',
                innerRadius: '63%',
                backgroundColor: trackColors[1],
                borderWidth: 0
            }]
        },

        yAxis: {
            min: 0,
            max: 100,
            lineWidth: 0,
            tickPositions: []
        },

        plotOptions: {
            solidgauge: {
                dataLabels: {
                    enabled: false
                },
                linecap: 'round',
                stickyTracking: false,
                rounded: true
            }
        },

        series: [{
            name: 'Halaman',
            data: [{
                color: Highcharts.getOptions().colors[0],
                radius: '112%',
                innerRadius: '88%',
                y: 0
            }],
            custom: {
                icon: 'filter',
                iconColor: '#303030'
            }
        }, {
            name: 'Hari',
            data: [{
                color: Highcharts.getOptions().colors[1],
                radius: '87%',
                innerRadius: '63%',
                y: 0
            }],
            custom: {
                icon: 'comments-o',
                iconColor: '#ffffff'
            }
        }]
    });

    function mulaiJob(noJob, levelKerja) {
        $.ajax({
            url: "<?=site_url('jobs/startLevelKerja')?>?noJob=" + noJob + "&levelKerja=" + levelKerja,
            method: "POST",
            data: {
                noJob,
                levelKerja,
            }
        }).success(res => {
            res = JSON.parse(res)

            if (res.success) {
                refreshTable()
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal memulai level kerja!',
                    text: res.message,
                })
            }
        })
    }

    function tundaJob(noJob, levelKerja) {
        $.ajax({
            url: "<?=site_url('jobs/tundaLevelKerja')?>?noJob=" + noJob + "&levelKerja=" + levelKerja,
            method: "POST",
            data: {
                noJob,
                levelKerja
            }
        }).success(res => {
            res = JSON.parse(res)

            if (res.success) {
                refreshTable()
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal menunda level kerja!',
                    text: res.message
                })
            }
        })
    }

    // kirim job
    function kirimJobTrigger(noJob, levelKerja) {
        activeKirimJobNoJob = noJob
        activeKirimJobLevelKerja = levelKerja
    }

    function kirimJob(noJob, levelKerja) {
        $.ajax({
            url: "<?=site_url('jobs/kirim')?>?noJob=" + noJob + "&levelKerja=" + levelKerja,
            method: "POST",
            data: {
                noJob,
                levelKerja
            }
        }).then(res => {
            res = JSON.parse(res)

            if (res.success) {
                refreshTable()
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal mengirim level kerja!',
                    text: res.message
                })
            }
        })
    }

    // finish job
    function finishJobTrigger(noJob, levelKerja, hal) {
        activeFinishJobNoJob = noJob
        activeFinishJobLevelKerja = levelKerja
        $('#finishJobRealisasi').val(hal)
    }

    $('#formFinishJob').submit(function(e) {
        e.preventDefault()

        const formData = $('form').serializeObject()

        $.ajax({
            url: "<?=site_url('jobs/finishJob')?>",
            method: "POST",
            data: {
                data: {
                    noJob: activeFinishJobNoJob,
                    levelKerja: activeFinishJobLevelKerja,
                    ...formData
                }
            },
        }).then(res => {
            res = JSON.parse(res)
            refreshTable();

            if (res.success != true) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal menyimpan status pekerjaan!',
                    text: res.message,
                })
            } else {
                Swal.fire(
                    'Pekerjaan telah dinyatakan selesai dan diteruskan ke Administrator.',
                    '',
                    'success'
                ).then(function() {
                    $("#finishJobModal .close").click();
                })
            }
        })
    })

    let runningJob = {}
    function viewJob(isRunningJob = false, noJob, levelKerja) {
        $.ajax({
            url: "<?=site_url('jobs/viewJob')?>?noJob=" + noJob + "&levelKerja=" + levelKerja,
            method: "GET"
        }).success(res => {
            res = JSON.parse(res)

            if (res.chart.status != 'on_progress' && res.chart.status != 'cicil') {
                $('#start-naskah-button').attr('disabled', true)
                $('#pause-naskah-button').attr('disabled', true)
            } else {
                $('#start-naskah-button').attr('disabled', false)
                $('#pause-naskah-button').attr('disabled', false)

                activeJob = {
                    noJob: res.naskah.no_job,
                    naskahId: res.naskah.id,
                    levelKerja,
                }

                if (!isRunningJob) {
                    $('#activeTrack').hide()
                }

                if (isRunningJob) {
                    runningJob = activeJob
                }

                if (runningJob.naskahId) {
                    $('#start-naskah-button').attr('disabled', true)

                    if (runningJob.naskahId != activeJob.naskahId) {
                        $('#pause-naskah-button').attr('disabled', true)
                        $('#activeTrack').hide()
                    } else {
                        $('#pause-naskah-button').attr('disabled', false)
                        if (!isRunningJob) {
                            $('#activeTrack').show()
                        }
                    }
                }
            }

            $('#activeNaskahCover').attr('src', "<?=base_url('uploads/cover_naskah')?>/" + res.naskah.cover)
            $('#activeNaskahKode').text(res.naskah.kode)
            $('#activeNaskahJudul').text(res.naskah.judul)
            $('#activeNaskahPenulis').text(res.naskah.penulis)
            $('#activeNaskahWarna').text(res.naskah.warna)
            $('#activeNaskahUkuran').text(res.naskah.nama_ukuran)
            $('#activeNaskahHalaman').text(res.naskah.halaman)
            $('#activeNaskahISBN').text(res.naskah.isbn != '' ? res.naskah.isbn : '-')
            $('#activeNaskahDetailButton').attr('href', "<?=site_url('naskah/view')?>/" + res.naskah.no_job)

            let naskahLevelKerjaListHtml = ''
            res.level_kerja.forEach((lk) => {
                let barColor = '58a85e'
                const barPercentage = (lk.total_hari ?? 0)*100/lk.durasi
                if (barPercentage <= 33) {
                    barColor = 'd94141'
                } else if (barPercentage > 33 && barPercentage <= 66) {
                    barColor = 'd1a847'
                }

                naskahLevelKerjaListHtml += '<tr>'+
                    '<td style="vertical-align:middle">'+levelKerjaMap[lk.key]+'</td>'+
                    '<td style="vertical-align:middle">'+(lk.nama == null ? '<i style="color:red">Tentatif</i>' : lk.nama)+'</td>'+
                    '<td style="vertical-align:middle;"><button class="btn" style="border:none;cursor:default;'+(lk.status=='on_progress'?'font-weight:bold;':'')+';background-color:'+statusMap[lk.status].bgColor+'">'+statusMap[lk.status].text+'</button></td>'+
                    '<td style="vertical-align:middle">'+('<div style="height:20px;width:100%;border:solid 1px #ddd;border-radius:5px;"><div style="height:18px;width:'+((lk.total_hari ?? 0)*100/lk.durasi)+'%;background:#'+barColor+';border-radius:5px;text-align:center;color:#fff">'+(lk.durasi == 0 ? '100' : ((lk.total_hari ?? 0)*100/lk.durasi).toFixed(0))+'%</div></div><div>'+(lk.total_hari ?? 0)+' dari ' + lk.durasi + ' hari</div>')+'</td>'+
                '</tr>'
            })
            $('#activeNaskahLevelKerjaList').html(naskahLevelKerjaListHtml)

            // update progress halaman dan hari
            const progressHalaman = res.progress.halaman ?? 0
            const totalHalaman = parseInt(res.naskah.halaman)
            const progressHari = res.days.days ?? 0
            const totalHari = res.chart.durasi

            $('#total_halaman_terkerjakan').html(progressHalaman)
            $('#total_halaman').html(totalHalaman)
            $('#hari_pengerjaan').html(progressHari)
            $('#total_hari_perencanaan').html(totalHari)
            
            progressChart.series[0].data[0].update(Math.round(progressHalaman*100/totalHalaman), false)
            progressChart.series[1].data[0].update(Math.round(progressHari*100/totalHari), false)
            progressChart.redraw()
        })
    }

    let activeJob = {}
    function startJob() {
        $.ajax({
            url: "<?=site_url('jobs/startJob')?>",
            method: "POST",
            data: activeJob,
        }).then(res => {
            res = JSON.parse(res)

            if (res.error != false) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal memulai pekerjaan!',
                    text: res.message,
                })
            } else {
                refreshTable()
                getActiveJob()

                Swal.fire(
                    'Berhasil memulai pekerjaan!',
                    'Selamat bekerja 😀',
                    'success'
                )
            }
        })
    }

    $(document).ready(function() {
        $('#formJobReportError').hide()
    });

    // report pekerjaan harian
    $('#formJobReport').submit(function(e) {
        e.preventDefault()

        const formData = $('form').serializeObject()

        $.ajax({
            url: "<?=site_url('jobs/reportDailyProgress')?>",
            method: "POST",
            data: {
                data: {
                    naskahId: runningJob.naskahId,
                    levelKerja: runningJob.levelKerja,
                    ...formData
                }
            },
        }).then(res => {
            res = JSON.parse(res)

            if (res.error != false) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal menyimpan progress pekerjaan!',
                    text: res.message,
                })
            } else {
                Swal.fire(
                    'Progress pekerjaan telah tersimpan!',
                    'Terima kasih atas kerja kerasnya 😀',
                    'success'
                )
            }
        })
    })

    // kirim pekerjaan ke level berikutnya
    $('#formKirimJob').submit(function(e) {
        e.preventDefault()

        const formData = $('form').serializeObject()

        $.ajax({
            url: "<?=site_url('jobs/kirimJob')?>",
            method: "POST",
            data: {
                data: {
                    noJob: activeKirimJobNoJob,
                    levelKerja: activeKirimJobLevelKerja,
                    ...formData
                }
            },
        }).then(res => {
            res = JSON.parse(res)
            refreshTable()

            if (res.success != true) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal mengirim pekerjaan!',
                    text: res.message,
                })
            } else {
                Swal.fire(
                    'Pekerjaan telah terkirim dan diteruskan ke level kerja selanjutnya jika ada.',
                    '',
                    'success'
                ).then(function() {
                    $("#kirimJobModal .close").click();
                })
            }
        })
    })
</script>