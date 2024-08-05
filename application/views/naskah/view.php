<?php
$uri = uriSegment(1) == 'buku' ? 'buku' : 'naskah';
$menu = uriSegment(1) == 'buku' ? 'Buku' : 'Naskah';
?>

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
        font-size: 16px;
    }

    .clickable-rectangle:hover {
        border: solid 2px #ccc;
    }

    .sop-done {
        background-color: #e3ffe3;
    }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between">
        <div>
            <a href="<?= site_url($uri . '/index') ?>">
                <button class="btn cur-p btn-outline-secondary mB-10"><i class="c-light-blue-500 ti-angle-left mR-5"></i> Kembali ke  Daftar <?=$menu?></button>
            </a>
        </div>

        <div>
            <?php if (
                ($this->session->userdata('id_jabatan') == 1 && $this->session->userdata('id_divisi') == 1) ||
                $this->session->userdata('id_divisi') == 2
            ) { ?>
                <a href="#" onClick="enableEdit()">
                    <button class="btn cur-p btn-warning mB-10">Edit <?=$menu?></button>
                </a>
            <?php } ?>

            <?php if (!$naskah->is_sent_to_ppic && $uri == 'buku' && $this->session->userdata('id_jabatan') == 1 && $this->session->userdata('id_divisi') == 1) { ?>
                <a href="#" onClick="kirimPPIC(<?=$naskah->id?>)">
                    <button class="btn cur-p btn-danger mB-10">Kirim ke PPIC</button>
                </a>
            <?php } ?>
        </div>
    </div>

    <div class="bd bgc-white p-30 r-10">
        <div class="row">
            <div class="col-md-3">
                <form action="" enctype="multipart/form-data">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h4><b>Cover <?=$menu?></b></h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <img src="<?=$naskah->cover != NULL ? base_url('uploads/cover_naskah/' . $naskah->cover) : 'https://marketplace.canva.com/EAFersXpW3g/1/0/1003w/canva-blue-and-white-modern-business-book-cover-cfxNJXYre8I.jpg'?>" width="200">
                            </div>
                        </div>
                        <div class="row">
                            <?php if (
                                ($this->session->userdata('id_jabatan') == 1 && $this->session->userdata('id_divisi') == 1) ||
                                $this->session->userdata('id_divisi') == 2
                            ) { ?>
                                <div class="col-md-12 text-center mT-10">
                                    <input class="d-none" type="file" id="fileInput" name="file" accept="image/*" onchange="uploadImage()">
                                    <button type="button" id="uploadButton" class="btn btn-primary" onclick="chooseFile()">Ubah Cover</button>
                                    <input class="d-none" type="submit" value="Submit">
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </form>
            </div>

            <form id="editNaskahForm" class="row col-md-9">
                <div class="col-md-5">
                    <div class="each-field">
                        <h6><b>No Job</b></h6>
                        <span class="hide-on-edit"><?= $naskah->no_job; ?></span>
                        <input type="text" class="editable form-control" name="no_job" value="<?= $naskah->no_job; ?>" readonly>
                    </div>
                    <div class="each-field">
                        <h6><b>Kode <?=$menu?></b></h6>
                        <span class="hide-on-edit"><?= $naskah->kode; ?></span>
                        <input type="text" class="editable form-control" name="kode" value="<?= $naskah->kode; ?>">
                    </div>
                    <div class="each-field">
                        <h6><b>Judul <?=$menu?></b></h6>
                        <span class="hide-on-edit"><?= $naskah->judul; ?></span>
                        <input type="text" class="editable form-control" name="judul" value="<?= $naskah->judul; ?>">
                    </div>
                    <div class="each-field">
                        <h6><b>Jenjang</b></h6>
                        <span class="hide-on-edit"><?= $naskah->nama_jenjang; ?></span>
                        <select name="id_jenjang" id="jenjang" class="editable form-control" required>
                            <option selected disabled default>--Pilih Jenjang--</option>
                            <?php foreach ($jenjangs as $jenjang) { ?>
                                <option value="<?=$jenjang['id']?>" <?=$naskah->id_jenjang == $jenjang['id'] ? 'selected' : ''?>><?=$jenjang['nama_jenjang']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="each-field">
                        <h6><b>Mapel</b></h6>
                        <span class="hide-on-edit"><?= $naskah->nama_mapel; ?></span>
                        <select name="id_mapel" id="mapel" class="editable form-control" required>
                            <option selected disabled default>--Pilih Mapel--</option>
                            <?php foreach ($mapels as $mapel) { ?>
                                <option value="<?=$mapel['id']?>" <?=$naskah->id_mapel == $mapel['id'] ? 'selected' : ''?>><?=$mapel['nama_mapel']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="each-field">
                        <h6><b>Kategori</b></h6>
                        <span class="hide-on-edit"><?= $naskah->nama_kategori; ?></span>
                        <select name="id_kategori" id="kategori" class="editable form-control" required>
                            <option selected disabled default>--Pilih Kategori--</option>
                            <?php foreach ($kategoris as $kategori) { ?>
                                <option value="<?=$kategori['id']?>" <?=$naskah->id_kategori == $kategori['id'] ? 'selected' : ''?>><?=$kategori['nama_kategori']?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="each-field">
                        <h6><b>Penulis</b></h6>
                        <span class="hide-on-edit"><?= $naskah->penulis; ?></span>
                        <input type="text" class="editable form-control" name="penulis" value="<?= $naskah->penulis; ?>">
                    </div>
                    <div class="each-field">
                        <h6><b>Ukuran</b></h6>
                        <span class="hide-on-edit"><?= $naskah->nama_ukuran; ?></span>
                        <select name="id_ukuran" id="ukuran" class="editable form-control" required>
                            <option selected disabled default>--Pilih Ukuran--</option>
                            <?php foreach ($ukurans as $ukuran) { ?>
                                <option value="<?=$ukuran['id']?>" <?=$naskah->id_ukuran == $ukuran['id'] ? 'selected' : ''?>><?=$ukuran['nama_ukuran']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="each-field">
                        <h6><b>Warna</b></h6>
                        <span class="hide-on-edit"><?= $naskah->nama_warna; ?></span>
                        <select name="id_warna" id="warna" class="editable form-control" required>
                            <option selected disabled default>--Pilih Warna--</option>
                            <?php foreach ($warnas as $warna) { ?>
                                <option value="<?=$warna['id']?>" <?=$naskah->id_warna == $warna['id'] ? 'selected' : ''?>><?=$warna['nama_warna']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="each-field">
                        <h6><b>Halaman</b></h6>
                        <span class="hide-on-edit"><?= $naskah->halaman; ?></span>
                        <input type="text" class="editable form-control" name="halaman" value="<?= $naskah->halaman; ?>">
                    </div>
                    <div class="each-field">
                        <h6><b>ISBN Jil. Lengkap</b></h6>
                        <span class="hide-on-edit"><?= $naskah->isbn_jil_lengkap; ?></span>
                        <input type="text" class="editable form-control" name="isbn_jil_lengkap" value="<?= $naskah->isbn_jil_lengkap; ?>">
                    </div>
                    <div class="each-field">
                        <h6><b>ISBN</b></h6>
                        <span class="hide-on-edit"><?= $naskah->isbn; ?></span>
                        <input type="text" class="editable form-control" name="isbn" value="<?= $naskah->isbn; ?>">
                    </div>
                    <div class="each-field">
                        <button id="save-button" type="submit" class="editable btn btn-success text-white">Save</button>
                        <button type="button" onClick="disableEdit()" class="editable btn btn-primary">Cancel</button>
                    </div>
                </div>

                <?php if (($this->session->userdata('id_jabatan') == 1 && $this->session->userdata('id_divisi') == 1) || $this->session->userdata('id_divisi') == 2) { ?>
                <div class="col-md-2">
                    <div class="btn-group" role="group">
                        <i class="ti-more-alt no-after dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="float:right;transform:rotate(90deg);cursor:pointer;"></i>

                        <ul class="dropdown-menu fsz-sm" aria-labelledby="btnGroupDrop1" style="">
                            <?php if (
                                ($this->session->userdata('id_jabatan') == 1 && $this->session->userdata('id_divisi') == 1) ||
                                $this->session->userdata('id_divisi') == 2
                            ) { ?>
                            <li>
                                <a id="edit-naskah-button" href="#" class="d-b td-n pY-5 pX-10 bgcH-grey-100 c-grey-700" onclick="enableEdit()">
                                    <i class="c-yellow-700 ti-pencil mR-10"></i>
                                    <span>Edit <?=$menu?></span>
                                </a>
                            </li>
                            <?php } ?>
                            <?php if (!$naskah->is_sent_to_ppic && $uri == 'buku' && $this->session->userdata('id_jabatan') == 1 && $this->session->userdata('id_divisi') == 1) { ?>
                                <li>
                                    <a href="#" class="d-b td-n pY-5 pX-10 bgcH-grey-100 c-grey-700" onClick="kirimPPIC(<?=$naskah->id?>)">
                                        <i class="c-red-500 ti-alert mR-10"></i>
                                        <span>Kirim ke PPIC</span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <?php } ?>
            </form>
        </div>
    </div>

    <div class="mT-30">
        <h5><b>Standar Operasional Prosedur (SOP) Editor</b></h5>

        <div class="container-bawah">

            <a class="clickable-rectangle <?=$sop_progress->editing_done ? 'sop-done' : ''?>" href="<?=site_url('naskah/sop_editing') . '?id_naskah=' . $naskah->id . '&no_job=' . $naskah->no_job?>"><div>EDITING</div></a>
            <a class="clickable-rectangle <?=$sop_progress->koreksi_1_done ? 'sop-done' : ''?>" href="<?=site_url('naskah/sop_koreksi_1') . '?id_naskah=' . $naskah->id . '&no_job=' . $naskah->no_job?>"><div>KOREKSI 1</div></a>
            <a class="clickable-rectangle <?=$sop_progress->koreksi_2_done ? 'sop-done' : ''?>" href="<?=site_url('naskah/sop_koreksi_2') . '?id_naskah=' . $naskah->id . '&no_job=' . $naskah->no_job?>"><div>KOREKSI 2</div></a>
            <a class="clickable-rectangle <?=$sop_progress->koreksi_3_done ? 'sop-done' : ''?>" href="<?=site_url('naskah/sop_koreksi_3') . '?id_naskah=' . $naskah->id . '&no_job=' . $naskah->no_job?>"><div>KOREKSI 3</div></a>
            <a class="clickable-rectangle <?=$sop_progress->pdf_done ? 'sop-done' : ''?>" href="<?=site_url('naskah/sop_pdf') . '?id_naskah=' . $naskah->id . '&no_job=' . $naskah->no_job?>"><div>PDF</div></a>
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
    function disableEdit() {
        $('.editable').hide()
        $('.hide-on-edit').show()
        $('#save-button').hide()
    }

    $(document).ready(function() {
        $('.editable').hide()
        $('#save-button').hide()

        $('#editNaskahForm').submit(function (e) {
            e.preventDefault()

            $.ajax({
                url: "<?=site_url('naskah/update')?>",
                type: 'POST',
                data: new FormData($(this)[0]),
                contentType: false,
                processData: false,
                cache: false,
            }).then((res) => {
                res = JSON.parse(res)

                if (res.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal menyimpan perubahan',
                        text: res.message,
                    })
                } else {
                    Swal.fire(
                        'Berhasil disimpan!',
                        'Data naskah berhasil disimpan.',
                        'success'
                    ).then(function() {
                        location.reload()
                    })
                }
            })

            $('.editable').hide()
            $('.hide-on-edit').show()
        })

        kirimPPIC = (idNaskah) => {
            $.ajax({
                url: '<?=site_url('naskah/kirimPPIC')?>?id_naskah=' + idNaskah,
                type: 'POST',
            }).then((res) => {
                res = JSON.parse(res)

                if (res.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal mengirim ke PPIC!',
                        text: res.message,
                    })
                } else {
                    window.location.href = "<?=site_url('ppic/index')?>"
                }
            }).catch(err => {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal mengirim ke PPIC!',
                    text: res.message,
                })
            })
        }
    })

    function chooseFile() {
        document.getElementById('fileInput').click();
    }

    function uploadImage() {
        let fileInput = document.getElementById('fileInput')
        let fileNameDisplay = document.getElementById('fileName')

        let fileExtension = getFileExtension(fileInput.files[0].name)
        let newFileName = "<?=$naskah->id?>" + '.' + fileExtension

        let formData = new FormData();
        formData.append('file', fileInput.files[0], newFileName)

        $.ajax({
            url: "<?=site_url('naskah/changeCover?naskahId=' . $naskah->id) . '&prevFileName=' . $naskah->cover?>",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                res = JSON.parse(res)

                if (res.error != true) {
                    Swal.fire(
                        'Berhasil merubah cover naskah!',
                        'Naskah cover terupdate.',
                        'success'
                    ).then(function() {
                        location.reload()
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops... Gagal merubah cover naskah!',
                        text: res.message,
                    })
                }
            },
            error: function(error) {
                console.error('Upload error:', error)
            }
        });
    }

    function getFileExtension(filename) {
        return filename.slice((filename.lastIndexOf(".") - 1 >>> 0) + 2);
    }
</script>