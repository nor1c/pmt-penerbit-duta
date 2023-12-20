<div class="modal fade bd-example-modal-sm" id="holidayFormModal" role="dialog" aria-labelledby="formModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <form id="formHoliday">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="holidayFormTitle">Tambah Hari Libur</h5>
                    <span id="closeHolidayFormModalButton" type="button" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <div id="holidayError" class="alert alert-danger"></div>

                    <div class="mb-3">
                        <label class="form-label" for="holidayDateInput">Tanggal</label>
                        <input id="holidayDateInput" type="text" name="date" class="form-control holiday-picker" onchange="holidayPickerChanged()" placeholder="Tanggal Hari Libur" data-date-format="dd/mm/yyyy" data-provide="datepicker" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" placeholder="Judul Hari Libur" required>
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