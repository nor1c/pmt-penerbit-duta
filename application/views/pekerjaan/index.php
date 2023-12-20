<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <b>Drive untuk Share File saja</b>
                            <br>
                            <b><a href="https://drive.google.com/drive/u/0/my-drive" target="_blank" rel="nofollow">Link Login</a>
                                / Salin Link:</b> https://drive.google.com/drive/u/0/my-drive
                            <br>
                            <b>Email:</b> garasicrew123@qmail.id<p>
                                <b>Password:</b> pastiduta123 <br><br>
                        </div>
                        <div class="col-md-6">
                            <b>Drive untuk Save Data Penting (kapasitas 200GB)</b>
                            <br>
                            <b><a href="https://drive.google.com/drive/u/0/my-drive" target="_blank" rel="nofollow">Link Login</a>
                                / Salin Link:</b> https://drive.google.com/drive/u/0/my-drive
                            <br>
                            <b>Email:</b> drivedutadepok@gmail.com<p>
                                <b>Password:</b> pastidutadepok
                        </div>
                    </div>

                    <center>
                        <b> Disarankan Login menggunakan browser chrome incognito, ketik CTRL + SHIFT + N di Halaman Google chrome</b>
                    </center>
                </div>
            </div>
        </div>
    </div>

    <!-- START OF:: Input pekerjaan -->
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <fieldset>
                    <legend>Input pekerjaan</legend>
                    <form id="input-pekerjaan-form" action="<?= site_url('pekerjaan/report_pekerjaan') ?>" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <select class="form-control" id="pekerjaan-opt" name="pekerjaan" required>
                                        <option disabled selected value="">Pekerjaan</option>

                                        <optgroup label="Editor">
                                            <option disable-realisasi="true" value="Menulis Naskah">Menulis Naskah</option>
                                            <option disable-realisasi="true" value="Editing">Editing</option>
                                            <option disable-realisasi="true" value="K1">K1</option>
                                            <option disable-realisasi="true" value="K2">K2</option>
                                            <option disable-realisasi="true" value="K3">K3</option>
                                            <option disable-realisasi="true" value="Koreksi Artwork Final">Koreksi Artwork Final</option>
                                            <option disable-realisasi="true" value="Koreksi Silang (Bedah Naskah)">Koreksi Silang (Bedah Naskah)
                                            </option>

                                        <optgroup label="Picture Archivist">
                                            <option disable-realisasi="true" value="Foto dan ilustrasi">Foto dan ilustrasi</option>
                                            <option disable-realisasi="true" value="Update bank gambar">Update bank gambar</option>

                                        <optgroup label="Desainer">
                                            <option disable-realisasi="true" value="S1">S1</option>
                                            <option disable-realisasi="true" value="S2">S2</option>
                                            <option disable-realisasi="true" value="S3">S3</option>
                                            <option disable-realisasi="true" value="Proses PDF">Proses PDF</option>
                                            <option disable-realisasi="false" value="Membuat cover"> Membuat cover</option>
                                            <option disable-realisasi="true" value="Cek PDF akhir/Artwork">Cek PDF akhir/Artwork</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <select name="id_buku" class="form-control buku" placeholder="Judul Buku" required>
                                        <option disabled selected value="">Judul Buku (Jika tidak ada, ketik manual dikolom catatan)</option>
                                        <?php foreach ($this->db->get('buku_dikerjakan')->result() as $buku) : ?>
                                            <option value="<?php echo $buku->id; ?>"><?php echo $buku->judul_buku; ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <input type="text" class="form-control" placeholder="Kode Buku (Otomatis)" id="kode_buku" disabled>
                                </div>
                                <div class="form-group mb-3">
                                    <input type="text" class="form-control" name="no_job" placeholder="No. Job (Otomatis)" id="no_job" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <input name="catatan" type="text" class="form-control" placeholder="Catatan: Subtema / Bab / Pembelajaran, dll" required />
                                </div>
                                <div class="form-group mb-3">
                                    <input id="target" name="target" type="number" min="1" class="form-control" placeholder="Target (Jumlah halaman / Objek)" required />
                                </div>
                                <div class="form-group mb-3">
                                    <input name="realisasi_target" type="number" class="form-control" placeholder="Realisasi Target">
                                </div>
                                <div class="form-group mb-3">
                                    <select class="form-control" required="" name="status">
                                        <option>Status Hasil Kerja</option>
                                        <option value="Target Tercapai">Target Tercapai</option>
                                        <option value="Target Tidak Tercapai">Target Tidak Tercapai</option>
                                        <option value="Melebihi Target">Melebihi Target</option>
                                    </select>
                                </div>
                                <div class="form-group mT-10">
                                    <button id="kirim-button" type="submit" value="Kirim" class="btn btn-warning">Kirim</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </fieldset>
            </div>
        </div>
    </div>

    <!-- END OF:: Input pekerjaan -->

    <!-- START OF:: FILTER LAPORAN PEKERJAAN -->
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <fieldset>
                    <form id="filter">
                        <legend style>Filter laporan pekerjaan</legend>
                        <div class="row mB-10">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                <label class="form-label" for="presences_date_start">Tanggal Mulai</label>
                                    <input type="text" name="startdate" class="form-control date" required="required" placeholder="dd/mm/yyyy" id="date_start" data-provide="datepicker" value="<?php echo (!$this->session->flashdata('startdate')) ? date('m/d/Y') : date("m/d/Y", strtotime($this->session->flashdata('startdate'))); ?>">
                                </div>
                                <div class="form-group mb-3">
                                <label class="form-label" for="presences_date_start">Tanggal Akhir</label>
                                    <input type="text" name="enddate" class="form-control date" required="required" placeholder="dd/mm/yyyy" id="date_end" data-provide="datepicker" value="<?php echo (!$this->session->flashdata('enddate')) ? date('m/d/Y') : date("m/d/Y", strtotime($this->session->flashdata('enddate'))); ?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="karyawan">Nama Karyawan</label>
                                    <select class="form-control" id="id_karyawan" name="id_karyawan">
                                        <option width="50px" value="">Semua Karyawan</option>
                                        <?php
                                        $this->db->order_by('nama', 'ASC');
                                        foreach ($this->db->get('t_karyawan')->result() as $kar) {
                                            if ($kar->id_karyawan == $this->session->flashdata('id_karyawan')) {
                                                $selected = 'selected';
                                            } else {
                                                if ($kar->id_karyawan == $this->session->userdata('user_id')) {
                                                    $selected = 'selected';
                                                } else {
                                                    $selected = '';
                                                }
                                            }

                                            echo "<option value='" . $kar->id_karyawan . "'>" . $kar->nama . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label" for="karyawan">Judul Buku</label>
                                    <select class="form-control" id="judul_buku_filter" name="id_judul_buku">
                                        <option value="">Semua Buku</option>
                                        <?php foreach ($this->db->get('buku_dikerjakan')->result() as $buku) : ?>
                                            <option <?= ($this->session->flashdata('id_judul_buku') == $buku->id ? 'selected' : '') ?> value="<?php echo $buku->id; ?>"><?php echo $buku->judul_buku; ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3" style="float:right">
                                    <button type="submit" class="btn btn-primary">Tampilkan Data Laporan</button>
                                    <!-- <input type="submit" name="submit" id="report_pdf" value="Report PDF" class="btn btn-warning"> -->
                                </div>
                            </div>
                        </div>
                    </form>
                </fieldset>

                <br><br><br>

                <center>
                    <h3>Table Laporan Harian</h3>
                </center>
                <hr>
                <div class="row">
                    <div class="col-md-13">
                        <table id="laporanHarianTable" class="table table-striped" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Nama Karyawan</th>
                                    <th>Pekerjaan</th>
                                    <th>Judul Buku</th>
                                    <th>Catatan</th>
                                    <th>Kode Buku</th>
                                    <th>No. Job</th>
                                    <th>Target (Hal/Objek)</th>
                                    <th>Realisasi Target</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        table = $('#laporanHarianTable').DataTable({
            "sDom": "Rlfrtip",
            "aLengthMenu": [
                [5, 10, 15, 20],
                [5, 10, 15, 20]
            ],
            "pageLength": 5,
            "processing": true,
            "serverSide": true,
            "searching": false,
            "ajax": {
                "url": "<?= site_url($this->uri->segment(1) . '/laporan') ?>",
                'method': 'POST',
                'data': function(d) {
                    d.draw = d.draw || 1
                    return $.extend(d, filters);
                },
            },
            "deferRender": true,
            "columns": [
                null, null, null, null, null, null, null, null, null, null, null
            ],
            "columnDefs": [],
            "order": [
                // [0, 'asc']
            ],
            "oLanguage": {
                "sSearch": "Pencarian",
                "sProcessing": '<image style="width:150px" src="http://superstorefinder.net/support/wp-content/uploads/2018/01/blue_loading.gif">',
            }
        });

        let currentHour = new Date().getHours()

        if (currentHour < 15) {
            $('.update-work-button').addClass('disabled')
        }

        $("#report_pdf").click(function() {
            var presences_date_start = $("#date_start").val();
            var presences_date_end = $("#date_end").val();
            var id_karyawan;

            if ($("#sel1").val() != "" || $("#sel1").val() != null) {
                id_karyawan = '&id_karyawan=' + $("#sel1").val();
            } else {
                id_karyawan = "";
            }

            if ($("#judul_buku_filter").val() != "" || $("#judul_buku_filter").val() != null) {
                id_judul_buku = '&id_judul_buku=' + $("#judul_buku_filter").val();
            } else {
                id_judul_buku = "";
            }

            var url = '<?php echo base_url(); ?>presences/input_report_pdf/?startdate=' + presences_date_start +
                '&enddate=' + presences_date_end + id_karyawan + id_judul_buku;

            window.location.href = url;
        });

        // $("#date_start").datetimepicker({
        //     pickTime: false
        // });
        // $("#date_end").datetimepicker({
        //     pickTime: false
        // });

        // stupid force submit code
        // $('#kirim-button').click(function(e) {
        //   $(this).closest("form")[0].submit();
        //   $(this).attr('disabled', true);
        // })

        /* Change either related realisasi inputs is disabled or enabled for certain condition. */
        function toggleRealisasiInput(isDisable) {
            isDisable = (isDisable === 'true')
            if (isDisable) {
                if (currentHour >= 15) {
                    isDisable = false
                }
            }

            $('input[name=realisasi_target]').attr('disabled', isDisable)
            $('select[name=status]').attr('disabled', isDisable)

            if (!isDisable) {
                judulBukuOpt.attr('required', false)
                catatanInput.attr('required', false)
                targetInput.attr('required', false)
                $('input[name=realisasi_target]').attr('required', false)
                $('select[name=status]').attr('required', false)
            }
        }
        $('#pekerjaan-opt').change(function() {
            let isDisableRealisasi = $('option:selected', this).attr('disable-realisasi')
            toggleRealisasiInput(isDisableRealisasi)

            if ($(this).val() === 'Update bank gambar') {
                judulBukuOpt.attr('required', false)
            }
        })

        $('input[name=realisasi_target]').keyup(function() {
            if ($(this).val() > 0) {
                $('#kirim-button').attr('disabled', false)
            } else {
                $('#kirim-button').attr('disabled', true)
            }

            let realizedTarget = Number($(this).val())
            const target = Number(targetInput.val())

            if (realizedTarget >= target) {
                statusOpt.val('Target Tercapai')
            } else if (realizedTarget > target) {
                statusOpt.val('Melebihi Target')
            } else {
                statusOpt.val('Target Tidak Tercapai')
            }
        })

        $(".buku").change(function() {
            var id = $(this).val();
            $.ajax({
                    url: '<?php echo site_url('presences/buku_dikerjakan') ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id: id
                    },
                })
                .done(function(data) {
                    let sisa_halaman = data.standar_halaman - data.halaman_selesai

                    $("#kode_buku").val(data.kode_buku);
                    $("#no_job").val(data.no_job);
                    $("#standar_halaman").val(data.standar_halaman);
                    $("#sisa_halaman").val(sisa_halaman);
                    $("#target").attr('max', sisa_halaman)
                })
                .fail(function() {
                    console.log("error");
                })
                .always(function() {
                    console.log("complete");
                });
        });
    });

    /** Update progress of running job */
    function updateWork(pekerjaan, workId, idBuku, kodeBuku, noJob, catatan, target, standarHalaman) {
        console.log([
            kodeBuku,
            noJob
        ]);
        pekerjaanOpt.attr('disabled', true)
        pekerjaanOpt.val(pekerjaan)
        judulBukuOpt.attr('disabled', true)
        judulBukuOpt.val(idBuku)
        kodeBukuInput.attr('disabled', true)
        kodeBukuInput.val(kodeBuku)
        noJobInput.attr('disabled', true)
        noJobInput.val(noJob)
        catatanInput.attr('disabled', true)
        catatanInput.val(catatan)
        targetInput.attr('disabled', true)
        targetInput.val(target)
        $('#standar_halaman').val(standarHalaman)
        $('input[name=realisasi_target]').attr('max', target)

        $('select[name=status]').attr('readonly', true)

        $('#kirim-button').text('Update')
        $('#kirim-button').attr('disabled', true)

        $('#input-pekerjaan-form').attr('action', "<?= site_url('presences/update_report_pekerjaan?work-id=') ?>" + workId)
    }
</script>