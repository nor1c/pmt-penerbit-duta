<!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/custom.css"> -->

<style>
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
          <h3>
            <div style="height:50px;" id="txtDatang"></div>
            <button id="buttonDatang" class="btn btn-primary" onclick="clockIn()">Datang</button>
          </h3>
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

  <br>
  <br>
  <br>

  <div>
    <div class="form-group row">
      <div class="col-md-6">
        <b>Drive untuk Share File saja</b>
        <br>
        <a href="https://drive.google.com/drive/u/0/my-drive" target="_blank" rel="nofollow">Link Login</a>
        / Salin Link: https://drive.google.com/drive/u/0/my-drive
        <br>
        Email : garasicrew123@qmail.id<p>
          Password: pastiduta123 <br><br>
      </div>
      <div class="col-md-6">
        <b>Drive untuk Save Data Penting (kapasitas 200GB)</b>
        <br>
        <a href="https://drive.google.com/drive/u/0/my-drive" target="_blank" rel="nofollow">Link Login</a>
        / Salin Link: https://drive.google.com/drive/u/0/my-drive
        <br>
        Email : drivedutadepok@gmail.com<p>
          Password: pastidutadepok
      </div>
    </div>

    <center>
      <b> Disarankan Login menggunakan browser chrome incognito, ketik CTRL + SHIFT + N di Halaman Google chrome</b>
    </center>
  </div>

  <br><br>

  <!-- START OF:: Input pekerjaan -->
  <div class="row">
    <fieldset>
      <legend>Input pekerjaan</legend>
      <form id="input-pekerjaan-form" action="<?= site_url('presences/report_pekerjaan') ?>" method="post">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
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

                  <!--<optgroup label="Non Rutin">
                  <option disable-realisasi="false" value="Pengembangan produk">Pengembangan produk</option>
                  <option disable-realisasi="false" value="Sharing knowledge">Sharing knowledge</option>
                  <option disable-realisasi="false" value="Perbaikan proyek penilaian">Perbaikan proyek penilaian</option>

                <optgroup label="Pekerjaan Lain">
                  <option disable-realisasi="false" value="Administrasi File">Administrasi File</option>
                  <option disable-realisasi="false" value="Dinas Keluar">Dinas Keluar</option>
                  <option disable-realisasi="false" value="Meeting">Meeting</option>
                  <option disable-realisasi="false" value="Build & Maintenance Web Duta">Build & Maintenance Web Duta</option>
                  <option disable-realisasi="false" value="Youtube Duta">Youtube Duta</option> -->
              </select>
            </div>
            <div class="form-group">
              <select name="id_buku" class="form-control buku" placeholder="Judul Buku" required>
                <option disabled selected value="">Judul Buku (Jika tidak ada, ketik manual dikolom catatan)</option>
                <?php foreach ($this->db->get('buku_dikerjakan')->result() as $buku) : ?>
                  <option value="<?php echo $buku->id; ?>"><?php echo $buku->judul_buku; ?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Kode Buku (Otomatis)" id="kode_buku" disabled>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="no_job" placeholder="No. Job (Otomatis)" id="no_job" readonly>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <input name="catatan" type="text" class="form-control" placeholder="Catatan: Subtema / Bab / Pembelajaran, dll" required />
            </div>
            <div class="form-group">
              <input id="target" name="target" type="number" min="1" class="form-control" placeholder="Target (Jumlah halaman / Objek)" required />
            </div>
            <div class="form-group">
              <input name="realisasi_target" type="number" class="form-control" placeholder="Realisasi Target">
            </div>
            <div class="form-group">
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
  <!-- END OF:: Input pekerjaan -->

  <br>

  <!-- START OF:: FILTER LAPORAN PEKERJAAN -->
  <div class="row">
    <fieldset>
      <form action="<?php echo site_url('presences/laporan_filter') ?>" method="post">
        <legend style>Filter laporan pekerjaan</legend>
          <div class="row mB-10">
            <div class="col-md-6">
              <div class="form-group">
                <label for="presences_date_start">Tanggal Mulai</label>
                <input type="text" name="startdate" class="form-control date" required="required" placeholder="dd/mm/yyyy" id="date_start" value="<?php echo (!$this->session->flashdata('startdate')) ? date('m/d/Y') : date("m/d/Y", strtotime($this->session->flashdata('startdate'))); ?>">
              </div>
              <div class="form-group">
                <label for="presences_date_start">Tanggal Akhir</label>
                <input type="text" name="enddate" class="form-control date" required="required" placeholder="dd/mm/yyyy" id="date_end" value="<?php echo (!$this->session->flashdata('enddate')) ? date('m/d/Y') : date("m/d/Y", strtotime($this->session->flashdata('enddate'))); ?>">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="karyawan">Nama Karyawan</label>
                <select class="form-control" id="sel1" name="id_karyawan">
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

              <div class="form-group">
                <label for="karyawan">Judul Buku</label>
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
            <div class="form-group" style="float:right">
              <button type="submit" class="btn btn-primary">Tampilkan Data Laporan</button>
              <input type="submit" name="submit" id="report_pdf" value="Report PDF" class="btn btn-warning">
            </div>
          </div>
        </div>
      </form>
    </fieldset>
  </div>
  <!-- END OF:: FILTER LAPORAN PEKERJAAN -->

  <div style="margin-top:60px;">
    <center>
      <h3>Table Laporan Harian</h3>
    </center>
    <hr>
    <div class="row">
      <div class="col-md-13">
        <table class="table table-bordered">
          <thead class="text-white alert-info">
            <tr>
              <th>No</th>
              <th>Tanggal</th>
              <th>Nama Karyawan</th>
              <th>
                <center>Pekerjaan</center>
              </th>
              <th>Judul buku</th>
              <th>
                <center>Catatan</center>
              </th>
              <th>Kode buku</th>
              <th>No.Job</th>
              <th>Target (Hal/Objek)</th>

              <th>
                <center>Realisasi Target</center>
              </th>
              <th width="160px">
                <center>Status<center>
              </th>
              <th></th>
            </tr>
          </thead>
          <tbody>

            <?php

            $no = 1;
            if ($this->session->flashdata('startdate') && $this->session->flashdata('enddate')) {
              if (!empty($this->session->flashdata('id_karyawan'))) {
                $id_karyawan = " and report_pekerjaan.id_karyawan=" . $this->session->flashdata('id_karyawan') . "";
              } else {
                $id_karyawan = "";
              }

              if (!empty($this->session->flashdata('id_judul_buku'))) {
                $id_judul_buku = " and report_pekerjaan.id_buku_dikerjakan=" . $this->session->flashdata('id_judul_buku') . "";
              } else {
                $id_judul_buku = "";
              }

              $lh_sql = "	SELECT report_pekerjaan.*, t_karyawan.nama, buku_dikerjakan.judul_buku, buku_dikerjakan.kode_buku
                          FROM (`report_pekerjaan`)
                          LEFT JOIN `t_karyawan` ON `t_karyawan`.`id_karyawan` = `report_pekerjaan`.`id_karyawan`
                          LEFT JOIN `buku_dikerjakan` ON `report_pekerjaan`.`id_buku_dikerjakan` = `buku_dikerjakan`.`id`
                          WHERE date BETWEEN '" . date("Y-m-d", strtotime($this->session->flashdata('startdate'))) . "'
                          and '" . date("Y-m-d", strtotime($this->session->flashdata('enddate'))) . "' " . $id_karyawan . $id_judul_buku . "
                          ORDER BY nama ASC";

              $data = $this->db->query($lh_sql);
              foreach ($data->result() as $key => $value) { ?>
                <tr>
                  <td><?php echo $no++; ?></td>
                  <td><?php echo $value->date; ?></td>
                  <td><?php echo $value->nama; ?></td>
                  <td><?php echo $value->pekerjaan; ?></td>
                  <td><?php echo $value->judul_buku; ?></td>
                  <td><?php echo $value->catatan; ?></td>
                  <td><?php echo $value->kode_buku; ?></td>
                  <td><?php echo $value->no_job; ?></td>
                  <td><?php echo $value->target; ?></td>

                  <td><?php echo $value->realisasi_target; ?></td>
                  <td><?php echo $value->status; ?></td>
                  <td>
                    <button type="button" class="btn btn-primary disabled">Update</button>
                  </td>
                </tr>
              <?php } ?>
              <?php } else {
              $data = $this->db->query("
                SELECT
                  report_pekerjaan.*,
                  t_karyawan.*,
                  buku_dikerjakan.*,
                  report_pekerjaan.no_job,
                  buku_no_jobs.standar_halaman
                FROM (`report_pekerjaan`)
                LEFT JOIN `t_karyawan` ON `t_karyawan`.`id_karyawan` = `report_pekerjaan`.`id_karyawan`
                LEFT JOIN `buku_dikerjakan` ON `report_pekerjaan`.`id_buku_dikerjakan` = `buku_dikerjakan`.`id`
                LEFT JOIN buku_no_jobs ON report_pekerjaan.id_buku_dikerjakan=buku_no_jobs.id_buku AND report_pekerjaan.no_job=buku_no_jobs.no_job
                WHERE DAY(date) = DAY(CURRENT_DATE()) ORDER BY nama ASC");
              foreach ($data->result() as $key => $value) { ?>
                <?php if (date("Y-m-d") == $value->date) : ?>
                  <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $value->date; ?></td>
                    <td><?php echo $value->nama; ?></td>
                    <td><?php echo $value->pekerjaan; ?></td>
                    <td><?php echo $value->judul_buku; ?></td>
                    <td><?php echo $value->catatan; ?></td>
                    <td><?php echo $value->kode_buku; ?></td>
                    <td><?php echo $value->no_job; ?></td>
                    <td><?php echo $value->target; ?></td>

                    <td><?php echo $value->realisasi_target; ?></td>
                    <td><?php echo $value->status; ?></td>
                    <td>
                      <button type="button" class="update-work-button btn <?= $value->status != '0' || $value->id_karyawan != $this->session->userdata('user_id') ? 'disabled btn-secondary' : 'btn-primary' ?>" onclick="updateWork('<?= $value->pekerjaan ?>', <?= $value->id_report_pekerjaan ?>, <?= $value->id_buku_dikerjakan == null ? '0' : $value->id_buku_dikerjakan ?>, '<?= $value->kode_buku ?>', '<?= $value->no_job ?>', '<?= $value->catatan ?>', <?= $value->target ?>, <?= $value->standar_halaman ?>)"><b>Update</b></button>
                    </td>
                  </tr>
                <?php endif ?>
            <?php }
            } ?>


            <a href="#" class="ignielToTop"></a>


          </tbody>
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

  let clockIn
  let clockOut
  let attendTime
  let stopWorkTimer = false

  $(document).ready(function() {
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
    }, 2000);

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
    $("#date_start").datetimepicker({
      pickTime: false
    });
    $("#date_end").datetimepicker({
      pickTime: false
    });
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






<style>
  /* Back to Top Pure CSS by igniel.com */
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
</style>