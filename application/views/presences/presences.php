<div class="container-fluid">
    <h4 class="c-grey-900 mT-10 mB-30">Rekap Kehadiran</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <div class="mB-10">
                    <form id="filter">
                        <div class="row mB-10">
                        <div class="col-md-2">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="text" name="attendance_history_filter_start_date" class="form-control date" required="required" placeholder="dd/mm/yyyy" id="attendance_history_filter_start_date" data-provide="datepicker" value="<?= date('m/d/Y') ?>">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Tanggal Akhir</label>
                            <input type="text" name="attendance_history_filter_finish_date" class="form-control date" required="required" placeholder="dd/mm/yyyy" id="attendance_history_filter_finish_date" data-provide="datepicker" value="<?= date('m/d/Y') ?>">
                        </div>
                        <?php if ($this->session->userdata('id_jabatan') == 1) { ?>
                            <div class="col-md-2">
                                <label class="form-label">Nama Karyawan</label>
                                <select class="form-control" id="attendance_history_filter_karyawan" name="attendance_history_filter_karyawan">
                                <option selected disabled>--Pilih Karyawan--</option>
                                <?php
                                    $this->db->order_by('nama', 'ASC');
                                    foreach ($this->db->get('t_karyawan')->result() as $kar) {
                                        if ($kar->id_karyawan == $this->session->userdata('id_karyawan')) {
                                            $selected = 'selected';
                                        } else {
                                            $selected = '';
                                        }
                                        echo "<option value='" . $kar->id_karyawan . "' " . $selected . ">" . $kar->nama . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        <?php } ?>
                        <div class="col-md-1">
                            <label class="form-label">&nbsp;</label>
                            <input type="submit" class="form-control btn btn-primary btn-color" value="Filter" />
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">&nbsp;</label>
                            <input type="button" class="form-control btn btn-success btn-color" value="Rekap (PDF)" onclick="attendanceHistoryRekap()" />
                        </div>
                        </div>
                    </form>
                </div>

                <table id="attendanceHistoryTable" class="table table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Hari, Tanggal</th>
                            <th>Waktu Datang</th>
                            <th>Datang Melalui</th>
                            <th>Waktu Pulang</th>
                            <th>Pulang Melalui</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    const pekerjaanOpt = $('select[name=pekerjaan]')
    const judulBukuOpt = $('select[name=id_buku]')
    const kodeBukuInput = $('input[id=kode_buku]')
    const noJobInput = $('input[id=no_job]')
    const catatanInput = $('input[name=catatan]')
    const targetInput = $('input[name=target]')
    const statusOpt = $('select[name=status]')

    let attendanceHistoryRekap

    $(document).ready(function() {
        table = $('#attendanceHistoryTable').DataTable({
            "sDom": "Rlfrtip",
            "aLengthMenu": [
                [5, 10, 15, 20],
                [5, 10, 15, 20]
            ],
            "pageLength": 30,
            "processing": true,
            "serverSide": true,
            "searching": false,
            "ajax": {
                "url": "<?= site_url($this->uri->segment(1) . '/histories') ?>",
                'method': 'POST',
                'data': function(d) {
                    d.draw = d.draw || 1
                    return $.extend(d, filters);
                },
            },
            "deferRender": true,
            "columns": [
                null, null, null, null, null, null, null, null
            ],
            "columnDefs": [],
            "order": [],
            "oLanguage": {
                "sSearch": "Pencarian",
                "sProcessing": '<image style="width:150px" src="http://superstorefinder.net/support/wp-content/uploads/2018/01/blue_loading.gif">',
            }
        });

        attendanceHistoryRekap = function() {
            var presences_date_start = $("#attendance_history_filter_start_date").val();
            var presences_date_end = $("#attendance_history_filter_finish_date").val();
            var id_karyawan;

            if ($("#attendance_history_filter_karyawan").val() != "" || $("#attendance_history_filter_karyawan").val() != null) {
                id_karyawan = '&id_karyawan=' + $("#attendance_history_filter_karyawan").val();
            } else {
                id_karyawan = "";
            }
            var url = '<?php echo base_url(); ?>presences/report_pdf/?startdate=' + presences_date_start + '&enddate=' + presences_date_end + id_karyawan;
            console.log(url)

            window.location.href = url;
        }

        // $("#attendance_history_filter_start_date").datetimepicker({
        //     pickTime: false
        // });
        // $("#attendance_history_filter_finish_date").datetimepicker({
        //     pickTime: false
        // });
    })
</script>