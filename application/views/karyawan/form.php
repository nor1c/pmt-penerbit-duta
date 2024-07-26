<div class="modal fade bd-example-modal-md" id="karyawanFormModal" role="dialog" aria-labelledby="formModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form id="formKaryawan">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="karyawanFormTitle">Tambah Karyawan Baru</h5>
                    <span id="closeKaryawanFormModalButton" type="button" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <div id="karyawanError" class="alert alert-danger"></div>

                    <div class="mb-3">
                        <label class="form-label"><span style="color:red">*</span>Username</label>
                        <input type="text" name="nik" class="form-control" placeholder="Username" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">NIK</label>
                        <input type="text" name="nikaryawan" class="form-control" placeholder="Contoh: 20.101.10.0.01">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><span style="color:red">*</span>Nama Karyawan</label>
                        <input type="text" name="nama" class="form-control" placeholder="Nama Karyawan" required>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-6">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control" placeholder="Tempat Lahir">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="text" name="tanggal_lahir" class="form-control" placeholder="Tanggal Hari Libur" data-date-format="dd/mm/yyyy" data-provide="datepicker" autocomplete="off">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><span style="color:red">*</span>Jenis Kelamin</label>

                        <div class="col-sm-6">	
                            <label class="radio-inline" style="margin-right:10px">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" value="1" required> Pria 
                            </label>
                            <label class="radio-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" value="2" required> Wanita
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control"></textarea>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-6">
                            <label class="form-label">No Telepon</label>
                            <input type="text" name="no_telp" class="form-control" placeholder="No Telepon">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No Handphone</label>
                            <input type="text" name="no_handphone" class="form-control" placeholder="No Handphone">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="mail@example.com">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status Perkawinan</label>
                        <select name="status_perkawinan" class="form-control" required>
                            <option selected disabled>--Pilih Status Perkawinan--</option>
                            <option value="1">Lajang</option>
                            <option value="2">Menikah</option>
                            <option value="3">Cerai</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><span style="color:red">*</span>Jabatan</label>
                        <select name="id_jabatan" class="form-control" required>
                            <option selected disabled>--Pilih Jabatan--</option>
                            <?php
                            foreach ($jabatan as $jbt) {
                                echo "<option value='".$jbt['id_jabatan']."'>".$jbt['nama_jabatan']."</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><span style="color:red">*</span>Divisi</label>
                        <select name="id_divisi" class="form-control" required>
                            <option selected disabled>--Pilih Divisi--</option>
                            <?php
                            foreach ($divisi as $dvs) {
                                echo "<option value='".$dvs['id_divisi']."'>".$dvs['nama_divisi']."</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><span style="color:red">*</span>Golongan</label>
                        <select name="id_golongan" class="form-control" required>
                            <option selected disabled>--Pilih Golongan--</option>
                            <?php
                            foreach ($golongan as $gol) {
                                echo "<option value='".$gol['id_golongan']."'>".$gol['nama_golongan']."</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><span style="color:red">*</span>Jam Kerja</label>
                        <select name="id_jam_kerja" class="form-control" required>
                            <option selected disabled>--Pilih Jam Kerja--</option>
                            <?php
                            foreach ($jam_kerja as $jk) {
                                echo "<option value='".$jk['id_jam_kerja']."'>".$jk['keterangan']."</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><span style="color:red">*</span>Tanggal Masuk</label>
                        <input type="text" name="tanggal_masuk" class="form-control" placeholder="Tanggal Masuk" data-date-format="dd/mm/yyyy" data-provide="datepicker" required autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><span style="color:red">*</span>Status</label>

                        <div class="col-sm-6">	
                            <label class="radio-inline" style="margin-right:10px">
                                <input class="form-check-input" type="radio" name="active" value="1" required> Aktif
                            </label>
                            <label class="radio-inline">
                                <input class="form-check-input" type="radio" name="active" value="0" required> Nonaktif
                            </label>
                        </div>
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