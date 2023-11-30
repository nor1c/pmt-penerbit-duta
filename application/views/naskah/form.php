<style>
    tbody td {
        vertical-align: middle; /* This centers the text vertically */
    }
</style>

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
                            <select name="id_jenjang" id="jenjang" class="form-control" required>
                                <option selected disabled default>--Pilih Jenjang--</option>
                                <?php foreach ($jenjangs as $jenjang) { ?>
                                    <option value="<?=$jenjang['id']?>"><?=$jenjang['nama_jenjang']?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Mapel</label>
                            <select name="id_mapel" id="mapel" class="form-control" required>
                                <option selected disabled default>--Pilih Mapel--</option>
                                <?php foreach ($mapels as $mapel) { ?>
                                    <option value="<?=$mapel['id']?>"><?=$mapel['nama_mapel']?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Kategori</label>
                            <select name="id_kategori" id="kategori" class="form-control" required>
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
                            <select name="ukuran" id="ukuran" class="form-control" required>
                                <option selected disabled default>--Pilih Ukuran--</option>
                                <option value="148mm x 210mm">148mm x 210mm</option>
                                <option value="176mm x 250mm">176mm x 250mm</option>
                                <option value="195mm x 255mm">195mm x 255mm</option>
                                <option value="210mm x 260mm">210mm x 260mm</option>
                                <option value="210mm x 297mm">210mm x 297mm</option>
                            </select>
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

                <div id="perencanaanProduksiDiv">
                    <hr>

                    <div class="modal-body">
                        <h5><b>Perencanaan Produksi</b></h5>

                        <div>
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <th width="10">Urutan</th>
                                    <th>Level Kerja</th>
                                    <th width="70">Durasi</th>
                                    <th>Kecepatan (Hal/Hari)</th>
                                    <th width="100">Mulai</th>
                                    <th width="10">Libur</th>
                                    <th width="100">Selesai</th>
                                    <th>PIC</th>
                                    <!-- <th></th> -->
                                </thead>
                                <tbody>
                                    <?php
                                        for ($i=1; $i <= 10; $i++) {
                                    ?>
                                        <tr>
                                            <td><?=$i?></td>
                                            <td>Penulisan</td>
                                            <td>
                                                <input type="text" name="" id="" class="form-control">
                                            </td>
                                            <td>Otomatis</td>
                                            <td>15-03-2023</td>
                                            <td>1</td>
                                            <td>19-05-2023</td>
                                            <td>
                                                <select name="" id="" class="form-control">
                                                    <option value="tentatif">Tentatif</option>
                                                    <option value="editor">Editor</option>
                                                    <option value="setter">Setter</option>
                                                </select>
                                            </td>
                                            <!-- <td>edit | delete</td> -->
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
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