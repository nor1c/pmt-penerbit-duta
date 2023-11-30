<style>
    .each-field {
        margin-bottom: 10px;
    }

    .each-field h6 {
        color: #5db5e8;
    }

    .container-bawah {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        /* Optional padding */
    }

    /* Custom styling for the clickable rectangles */
    .clickable-rectangle {
        flex-grow: 1;
        background-color: #fff;
        padding: 40px 10px;
        cursor: pointer;
        text-align: center;
        border: solid 2px #eee;
        border-radius: 5px;
        margin-right: 10px;
        font-weight: bold;
    }

    .clickable-rectangle:hover {
        border: solid 2px #ccc;
    }
</style>

<div class="container-fluid">
    <a href="<?= site_url('naskah') ?>">
        <button class="btn cur-p btn-outline-secondary mB-10"><i class="c-light-blue-500 ti-angle-left mR-5"></i> Back to Naskah</button>
    </a>

    <div class="bd bgc-white p-30 r-10">
        <h5><b>Data Buku</b></h5>

        <div class="">
            <form id="editNaskahForm" class="row">
                <div class="col-md-4">
                    <div class="each-field">
                        <h6><b>No Job</b></h6>
                        <span class="hide-on-edit"><?= $naskah['no_job']; ?></span>
                        <input type="text" class="editable form-control" name="no_job" value="<?= $naskah['no_job']; ?>">
                    </div>
                    <div class="each-field">
                        <h6><b>Kode Buku</b></h6>
                        <span class="hide-on-edit"><?= $naskah['kode']; ?></span>
                        <input type="text" class="editable form-control" name="kode" value="<?= $naskah['kode']; ?>">
                    </div>
                    <div class="each-field">
                        <h6><b>Judul Buku</b></h6>
                        <span class="hide-on-edit"><?= $naskah['judul']; ?></span>
                        <input type="text" class="editable form-control" name="judul" value="<?= $naskah['judul']; ?>">
                    </div>
                    <div class="each-field">
                        <h6><b>Jenjang</b></h6>
                        <span class="hide-on-edit"><?= $naskah['id_jenjang']; ?></span>
                        <input type="text" class="editable form-control" name="id_jenjang" value="<?= $naskah['id_jenjang']; ?>">
                    </div>
                    <div class="each-field">
                        <h6><b>Mapel</b></h6>
                        <span class="hide-on-edit"><?= $naskah['id_mapel']; ?></span>
                        <input type="text" class="editable form-control" name="id_mapel" value="<?= $naskah['id_mapel']; ?>">
                    </div>
                    <div class="each-field">
                        <h6><b>Kategori</b></h6>
                        <span class="hide-on-edit"><?= $naskah['id_kategori']; ?></span>
                        <input type="text" class="editable form-control" name="id_kategori" value="<?= $naskah['id_kategori']; ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="each-field">
                        <h6><b>Penulis</b></h6>
                        <span class="hide-on-edit"><?= $naskah['penulis']; ?></span>
                        <input type="text" class="editable form-control" name="penulis" value="<?= $naskah['penulis']; ?>">
                    </div>
                    <div class="each-field">
                        <h6><b>Ukuran</b></h6>
                        <span class="hide-on-edit"><?= $naskah['ukuran']; ?></span>
                        <input type="text" class="editable form-control" name="ukuran" value="<?= $naskah['ukuran']; ?>">
                    </div>
                    <div class="each-field">
                        <h6><b>Warna</b></h6>
                        <span class="hide-on-edit"><?= $naskah['warna']; ?></span>
                        <input type="text" class="editable form-control" name="warna" value="<?= $naskah['warna']; ?>">
                    </div>
                    <div class="each-field">
                        <h6><b>Halaman</b></h6>
                        <span class="hide-on-edit"><?= $naskah['halaman']; ?></span>
                        <input type="text" class="editable form-control" name="halaman" value="<?= $naskah['halaman']; ?>">
                    </div>
                    <div class="each-field">
                        <h6><b>ISBN Jil. Lengkap</b></h6>
                        <span class="hide-on-edit"><?= $naskah['isbn_jil_lengkap']; ?></span>
                        <input type="text" class="editable form-control" name="isbn_jil_lengkap" value="<?= $naskah['isbn_jil_lengkap']; ?>">
                    </div>
                    <div class="each-field">
                        <h6><b>ISBN</b></h6>
                        <span class="hide-on-edit"><?= $naskah['isbn']; ?></span>
                        <input type="text" class="editable form-control" name="isbn" value="<?= $naskah['isbn']; ?>">
                    </div>
                    <div class="each-field">
                        <button id="save-button" type="submit" class="btn btn-success text-white">Save</button>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h4><b>Cover Buku</b></h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <img src="https://marketplace.canva.com/EAFersXpW3g/1/0/1003w/canva-blue-and-white-modern-business-book-cover-cfxNJXYre8I.jpg" width="200">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center mT-10">
                                <button class="btn btn-primary">Upload</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="btn-group" role="group">
                        <i class="ti-more-alt no-after dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="float:right;transform:rotate(90deg);cursor:pointer;"></i>

                        <ul class="dropdown-menu fsz-sm" aria-labelledby="btnGroupDrop1" style="">
                            <li>
                                <a id="edit-naskah-button" href="#" class="d-b td-n pY-5 pX-10 bgcH-grey-100 c-grey-700" onclick="enableEdit()">
                                    <i class="ti-trash mR-10"></i>
                                    <span>Edit Naskah</span>
                                </a>
                            </li>
                            <li>
                                <a href="" class="d-b td-n pY-5 pX-10 bgcH-grey-100 c-grey-700">
                                    <i class="ti-alert mR-10"></i>
                                    <span>Kirim ke PPIO</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="mT-30">
        <h5><b>Standar Operasional Prosedur (SOP) Editor</b></h5>

        <div class="container-bawah">
            <div class="clickable-rectangle">EDITING</div>
            <div class="clickable-rectangle">KOREKSI 1</div>
            <div class="clickable-rectangle">KOREKSI 2</div>
            <div class="clickable-rectangle">KOREKSI 3</div>
            <div class="clickable-rectangle">PDF</div>
        </div>
    </div>
</div>
</div>

<script>
    function enableEdit() {
        $('.editable').show()
        $('.hide-on-edit').hide()
        $('#save-button').show()
    }

    $(document).ready(function() {
        $('.editable').hide()
        $('#save-button').hide()

        $('#editNaskahForm').submit(function (e) {
            e.preventDefault()

            $.ajax({
                url: '<?= site_url($this->uri->segment(1)) ?>/' + 'update',
                type: 'POST',
                data: new FormData($(this)[0]),
                contentType: false,
                processData: false,
                cache: false,
            }).then((res) => {
                Swal.fire(
                    'Berhasil disimpan!',
                    'Data naskah berhasil disimpan.',
                    'success'
                )
            })

            $('.editable').hide()
            $('.hide-on-edit').show()
        })
    })
</script>