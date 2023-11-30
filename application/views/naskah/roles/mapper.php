<div class="modal fade bd-example-modal-sm" id="employeeMapperModal" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <input id="naskah_key" type="hidden">

            <div class="modal-header bg-light">
                <h5 class="modal-title" id="naskahFormTitle">Map Naskah Role</h5>
                <span id="closeNaskahFormModalButton" type="button" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti-close"></i>
                </span>
            </div>

            <div class="modal-body">
                <table id="addableArea"></table>
                <table style="width:100%;">
                    <tr style="width:100%">
                        <td>
                            <button onclick="createNewPICPicker()" class="btn btn-primary mT-10" style="width:100%">
                                <i class="c-white-500 ti-plus"></i>
                                Tambah PIC
                            </button>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="modal-footer bg-light">
                <button type="submit" onclick="saveMapping()" class="btn btn-info waves-effect waves-light">Simpan</button>
                <button type="button" class="btn btn-dark waves-effect waves-light" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>