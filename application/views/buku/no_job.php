<div id="no-job" class="mb-30 row">
  <div>
    <fieldset>
      <legend for="">Input No. Job</legend>
      <form id="no-job-form">
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Pilih Judul Buku</label>
            <select id="judul_buku_select" name="id_buku" class="form-control" placeholder="Judul Buku" required>
              <option disabled selected value="">Judul Buku</option>
              <?php foreach ($books as $buku) : ?>
                <option value="<?php echo $buku->id; ?>"><?php echo $buku->judul_buku; ?></option>
              <?php endforeach ?>
            </select>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="">No Job</label>
            <input type="text" name="no_job" class="form-control" placeholder="No. Job"  />
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="">Standar Halaman</label>
            <input type="text" name="standar_halaman" class="form-control" placeholder="Jumlah Standar Halaman" />
          </div>
          <div class="form-group" style="float:right">
            <input type="submit" class="btn btn-warning" value="Simpan">
          </div>
        </div>
      </form>
    </fieldset>

    <hr>

    <fieldset style="background-color: #7ede96">
      <legend style="background-color: #ffffff">Daftar Buku dan No Job</legend>
      <fieldset style="background-color: white">
        <legend style="background-color: white">Daftar Judul Buku</legend>
        <table id="books" class="hover stripe" style="width: 100%">
          <thead>
            <tr>
              <th>No.</th>
              <th>Judul Buku</th>
              <th>Jumlah No. Jobs</th>
            </tr>
          </thead>
        </table>
      </fieldset>
      <fieldset style="background-color: white">
        <legend style="background-color: white">Daftar No. Job</legend>
        <table id="no_jobs" class="hover stripe" style="width: 100%">
          <thead>
            <tr>
              <th>No.</th>
              <th>No Job</th>
              <th>Jumlah Standar Halaman</th>
            </tr>
          </thead>
        </table>
      </fieldset>
    </fieldset>
  </div>
</div>

<script>
  $(document).ready(function () {
    /* input no job form */
    $('#no-job-form').submit(function (e) {
      e.preventDefault()

      $.ajax({
        type: 'post',
        url: "<?=site_url('buku/save_no_job')?>",
        data: $(this).serialize(),
        success: function (res) {
          res = JSON.parse(res)
          
          if (res.error) {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: res.message
            })
          } else {
            Swal.fire({
              icon: 'success',
              title: 'Success',
              text: res.message
            })

            $('#no-job-form')[0].reset()

            bookTable.ajax.reload()
            no_jobsTable.ajax.reload()
          }
        }
      })
    })

    /* book list table */
    let bookTable = $('#books').DataTable({
      dom: "Bfrtip",
      pageLength: 5,
      ajax: "<?=site_url('buku/get_books')?>",
      columns: [
        {
          data: null,
          render: function (data, type, row, meta) {
            return meta.row+1
          }
        },
        { data: 'judul_buku' },
        { data: 'num_no_jobs' }
      ],
      select: {
        style: 'single'
      }
    });
 
    // /* no jobs table */
    let no_jobsTable = $('#no_jobs').DataTable({
      dom: 'Bfrtip',
      ajax: {
        url: "<?=site_url('buku/get_no_jobs')?>",
        type: 'post',
        data: function (d) {
          let selected = bookTable.row({ selected: true });
          if (selected.any()) {
            d.book_id = selected.data().id;
          }
        }
      },
      columns: [
        {
          data: null,
          render: function (data, type, row, meta) {
            return meta.row+1
          }
        },
        { data: 'no_job' },
        { data: 'standar_halaman' }
      ],
      select: true
    });

    /* events */
    bookTable.on('select', function (e) {
      no_jobsTable.ajax.reload();
    });
 
    bookTable.on('deselect', function () {
      no_jobsTable.ajax.reload();
    });

    $('#judul_buku_select').select2()
  })
</script>