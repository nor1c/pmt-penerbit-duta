<div class="modal fade bd-example-modal-xl" id="naskahFormModal" role="dialog" aria-labelledby="formModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form id="formNaskah">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="formModalTitle"></h5>
                    <span type="button" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label class="form-label">No Job</label>
                            <input type="text" name="nojob" id="" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Kode Buku</label>
                            <input type="text" name="kode_buku" id="" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Judul Buku</label>
                            <input type="text" name="judul_buku" id="" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Penulis</label>
                            <input type="text" name="penulis" id="" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label class="form-label">Jenjang</label>
                            <input type="text" name="jenjang" id="" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Mapel</label>
                            <input type="text" name="mapel" id="" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Kategori</label>
                            <input type="text" name="kategori" id="" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Warna</label>
                            <input type="text" name="warna" id="" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Ukuran</label>
                            <input type="text" name="ukuran" id="" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Halaman</label>
                            <input type="number" name="halaman" id="" class="form-control" minlength="0" min="0">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">ISBN Jil. Lengkap</label>
                            <input type="text" name="isbn_jil_lengkap" id="" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">ISBN</label>
                            <input type="text" name="isbn" id="" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="submit" class="btn btn-info waves-effect waves-light">Simpan</button>
                    <button type="reset" class="btn btn-secondary waves-effect waves-light">Clear</button>
                    <button type="button" class="btn btn-dark waves-effect waves-light" onclick="closeModal()">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function closeModal() {
        $('#formNaskahModal').modal('hide')
    }
</script>