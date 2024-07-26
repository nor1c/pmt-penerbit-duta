<div class="modal fade bd-example-modal-sm" id="warnaFormModal" role="dialog" aria-labelledby="formModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <form id="formWarna">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="warnaFormTitle">Tambah Warna</h5>
                    <span id="closeWarnaFormModalButton" type="button" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <div id="warnaError" class="alert alert-danger"></div>

                    <div class="mb-3">
                        <label class="form-label">Nama Warna</label>
                        <input type="text" name="nama_warna" class="form-control" placeholder="Nama Warna" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="is_active" class="form-control" required>
                            <option value="" disabled readonly>--Pilih Status--</option>
                            <option value="1" selected>Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
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