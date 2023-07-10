<div class="modal fade bd-example-modal-xl" id="naskahFormModal" role="dialog" aria-labelledby="formModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form id="formNaskah">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="naskahFormTitle">Buat Naskah Baru</h5>
                    <span id="closeNaskahFormModalButton" type="button" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label class="form-label">No Job</label>
                            <input type="text" name="no_job" id="" class="form-control" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Kode Buku</label>
                            <input type="text" name="kode" id="" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Judul Buku</label>
                            <input type="text" name="judul" id="" class="form-control" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Penulis</label>
                            <input type="text" name="penulis" id="" class="form-control" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Jilid</label>
                            <input type="text" name="jilid" id="" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label class="form-label">Jenjang</label>
                            <select name="jenjang_id" id="jenjang" class="form-control" required>
                                <option selected disabled>--Pilih Jenjang--</option>
                                <?php foreach ($jenjangs as $jenjang) { ?>
                                    <option value="<?=$jenjang['id']?>"><?=$jenjang['nama_jenjang']?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Mapel</label>
                            <select name="mapel_id" id="mapel" class="form-control" required>
                                <option selected disabled>--Pilih Mapel--</option>
                                <?php foreach ($mapels as $mapel) { ?>
                                    <option value="<?=$mapel['id']?>"><?=$mapel['nama_mapel']?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Kategori</label>
                            <select name="kategori_id" id="mapel" class="form-control" required>
                                <option selected disabled>--Pilih Kategori--</option>
                                <?php foreach ($kategoris as $kategori) { ?>
                                    <option value="<?=$kategori['id']?>"><?=$kategori['nama_kategori']?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Warna</label>
                            <input type="text" name="warna" id="" class="form-control" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Ukuran</label>
                            <input type="text" name="ukuran" id="" class="form-control" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Halaman</label>
                            <input type="number" name="halaman" id="" class="form-control" minlength="0" min="0" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">ISBN Jil. Lengkap</label>
                            <input type="text" name="isbn_jil_lengkap" id="" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">ISBN</label>
                            <input type="text" name="isbn" id="" class="form-control" required>
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