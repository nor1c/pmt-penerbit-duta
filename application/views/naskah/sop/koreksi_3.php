<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

$allowed_to_save = !$data->pic_signed_by || ($data->pic_signed_by == sessionData('user_id') || $data->approver_id == sessionData('user_id'));
?>

<style>
    ul, li {
        padding: 0;
        list-style-type: none;
    }

    .iptCheck, .iptLabel {
        width: 10px !important;
    }
    
    canvas, .disabled-canvas {
        border: 1px solid #ccc;
        border-radius: 0.5rem;
        width: 100%;
        height: 200px;
    }

    .strike-option {
        cursor:pointer;
        color:red;
        border: solid 1px #ccc;
        padding: 0px 3.3px;
        font-size: 9px;
        font-weight: bold;
        border-radius: 8px;
    }

    table {
        input {
            margin-top: 7px;
        }
    }
</style>

<div class="container-fluid">
    <a href="<?= site_url('naskah/view/' . inputGet('no_job')) ?>">
        <button class="btn cur-p btn-outline-secondary mB-10"><i class="c-light-blue-500 ti-angle-left mR-5"></i> Back to Naskah Detail</button>
    </a>

    <div class="bd bgc-white p-30 r-10">
        <h5><b>SOP KOREKSI 3</b></h5>

        <div class="">
            <form action="#" id="sop-form">
                <table id="checklist-table" class="table" style="<?=$data->approver_id == sessionData('user_id') ? 'pointer-events:none' : ''?>"></table>
                <div class="col-md-12 row">
                    <div class="col-md-6">
                        <label class="form-label">Catatan</label>
                        <textarea id="catatan" name="catatan" cols="30" rows="10" class="form-control" placeholder="Catatan" <?=$data->approver_id == sessionData('user_id') ? 'readonly disabled' : ''?>><?=$data->catatan ? $data->catatan : ''?></textarea>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanda tangan Editor</label>

                        <div id="pic-signature" style="<?=$data->pic_signature ? 'display:none' : ''?>">
                            <canvas id="pic-signature-pad" class="signature-pad"></canvas>
                            <button type="button" class="btn btn-info" id="clear-pic-sign">Clear Signature</button>
                        </div>

                        <?php 
                        if ($data->pic_signature) { ?>
                            <div id="pic-signature-jpg">
                                <img src="<?=base_url('signatures/sop/'.$data->pic_signature).'?'.time()?>" cache-control="no-cache" style="border: solid 1px #bbb;border-radius:10px;" />

                                <?php if ($data->approver_id != sessionData('user_id') && !$data->approver_signature) { ?>
                                    <button type="button" onClick="showPICSignature()" class="btn btn-info mT-5" id="clear-pic-sign">Tanda-tangani Ulang</button>
                                <?php } else {
                                    echo 'Ditanda-tangani oleh <b> ' . $data->nama_pic . '('.date('d/m/Y', strtotime($data->pic_signed_date)).')</b>';
                                } ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanda tangan Koor. Editor</label>
                            <div style="<?=$data->approver_signature ? '' : 'display:none'?>">
                                <img src="<?=base_url('signatures/sop/'.$data->approver_signature).'?'.time()?>" cache-control="no-cache" style="border: solid 1px #bbb;border-radius:10px;" />
                                Ditanda-tangani oleh <b><?=$data->nama_approver . ' ('.date('d/m/Y', strtotime($data->pic_signed_date)).')';?></b>
                            </div>
                            
                            <div>
                                <div style="<?=$data->approver_id == sessionData('user_id') && !$data->approver_signature ? '' : 'display:none'?>">
                                    <canvas id="approver-signature-pad" class="signature-pad"></canvas>
                                    <button type="button" class="btn btn-info" id="clear-approver-sign">Clear Signature</button>
                                </div>
                                <div class="signature-pad disabled-canvas" style="background-color:#eee;margin-bottom:5px;<?=($data->approver_signature != '' || $data->approver_id == sessionData('user_id')) ? 'display:none' : ''?>"></div>
                            </div>
                    </div>
                </div>
                <?php if (!$data->approver_signature) { ?>
                    <div class="mT-20 d-flex">
                        <button onClick="saveOrSend(false); return false;" class="btn btn-primary mR-50 <?=$allowed_to_save ? '' : 'disabled'?>">Simpan</button>
                        <?php if ($data->approver_id != sessionData('user_id')) { ?>
                            <select id="approver_id" name="approver_id" class="form-control mR-10" style="width:300px;" required>
                                <option disabled readonly selected>Pilih Koor. Editor</option>
                                <?php foreach ($pics as $pic) { ?>
                                    <?php if ($pic['id_karyawan'] != sessionData('user_id')) { ?>
                                        <option value="<?=$pic['id_karyawan']?>" <?=$pic['id_karyawan'] == $data->approver_id ? 'selected' : ''?>>
                                            <?=$pic['nama']?>
                                        </option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                            <button onClick="saveOrSend(true); return false;" class="btn btn-danger">Kirim</button>
                        <?php } ?>
                    </div>
                <?php } ?>
            </form>
        </div>
    </div>
</div>
</div>

<script src="<?=base_url('assets/js/signature-pad.min.js')?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
<script>
    let options
    let baseOptions = [
        {
            "label": 1,
            "title": "Cek ulang materi sesuai kurikulum dengan cermat dan sedetil-detilnya",
            "checked": false,
            "striked": false,
        },
        {
            "label": 2,
            "title": "Konsep dan isi",
            "checked": false,
            "striked": false,
            "child": [
                {
                    "label": "a.",
                    "title": "Materi sesuai teori",
                    "checked": false,
                    "striked": false,
                },
                {
                    "label": "b.",
                    "title": "Ejaan dan efektivitas bahasa",
                    "checked": false,
                    "striked": false,
                },
                {
                    "label": "c.",
                    "title": "Persamaan/formulasi/ayat/hadis benar dan tepat",
                    "checked": false,
                    "striked": false,
                },
                {
                    "label": "d.",
                    "title": "Tata nama dan istilah seragam, baku, dan konsisten",
                    "checked": false,
                    "striked": false,
                },
                {
                    "label": "e.",
                    "title": "Evaluasi",
                    "checked": false,
                    "striked": false,
                    "child": [
                        {
                            "label": "1)",
                            "title": "Keseragaman perintah soal",
                            "checked": false,
                            "striked": false,
                        },
                        {
                            "label": "2)",
                            "title": "Keseragaman tipe soal",
                            "checked": false,
                            "striked": false,
                        },
                        {
                            "label": "3)",
                            "title": "Banyaknya soal (kelipatan 5)",
                            "checked": false,
                            "striked": false,
                        },
                        {
                            "label": "4)",
                            "title": "Evaluasi semester 1 dan 2",
                            "checked": false,
                            "striked": false,
                        },
                        {
                            "label": "5)",
                            "title": "Kunci jawaban",
                            "checked": false,
                            "striked": false,
                        },
                    ]
                },
                {
                    "label": "f.",
                    "title": "Kegiatan (aktivitas siswa)/glosarium/daftar pustaka",
                    "checked": false,
                    "striked": false,
                },
                {
                    "label": "g.",
                    "title": "Gambar dan tabel",
                    "checked": false,
                    "striked": false,
                    "child": [
                        {
                            "label": "1)",
                            "title": "Nomor gambar dan tabel",
                            "checked": false,
                            "striked": false,
                        },
                        {
                            "label": "2)",
                            "title": "Judul gambar dan tabel",
                            "checked": false,
                            "striked": false,
                        },
                        {
                            "label": "3)",
                            "title": "Sumber gambar dan tabel (jika ada)",
                            "checked": false,
                            "striked": false,
                        },
                    ]
                },
                {
                    "label": "h.",
                    "title": "Fitur-fitur buku ada dan konsisten",
                    "checked": false,
                    "striked": false,
                },
                {
                    "label": "i.",
                    "title": "Halaman i lengkap",
                    "checked": false,
                    "striked": false,
                },
            ]
        },
        {
            "label": "3.",
            "title": "Naskah telah di-proofread (bahasa Asing, bahasa daerah)",
            "checked": false,
            "striked": false,
        },
        {
            "label": "4.",
            "title": "Form pemesanan gambar",
            "checked": false,
            "striked": false,
        },
    ]


    let picSignCanvas = document.getElementById('pic-signature-pad');
    let approverSignCanvas = document.getElementById('approver-signature-pad');

    // signature pad initialization
    let picSignaturePad = new SignaturePad(picSignCanvas, {
        backgroundColor: 'rgb(255, 255, 255)'
    });
    let approverSignaturePad = new SignaturePad(approverSignCanvas, {
        backgroundColor: 'rgb(255, 255, 255)'
    });

    
    document.addEventListener('DOMContentLoaded', function () {
        resizeCanvas();
    })

    function resizeCanvas() {
        let ratio = Math.max(window.devicePixelRatio || 1, 1);

        picSignCanvas.width = picSignCanvas.offsetWidth * ratio;
        picSignCanvas.height = picSignCanvas.offsetHeight * ratio;
        picSignCanvas.getContext("2d").scale(ratio, ratio);

        approverSignCanvas.width = approverSignCanvas.offsetWidth * ratio;
        approverSignCanvas.height = approverSignCanvas.offsetHeight * ratio;
        approverSignCanvas.getContext("2d").scale(ratio, ratio);
    }

    let checkedOptions = []

    let strike
    let generateOptions
    let showPICSignature
    let saveOrSend
    $(document).ready(function() {
        // clear signature
        $('#clear-pic-sign').click(function () {
            picSignaturePad.clear();
        });
        $('#clear-approver-sign').click(function () {
            approverSignaturePad.clear();
        });

        showPICSignature = () => {
            $('#pic-signature').show()
            $('#pic-signature-jpg').hide()
        }

        setTimeout(() => {
            $('#pic-signature').hide()
            $('#pic-signature-jpg').hide()
            const existingSignature = "<?=$data->pic_signature ? 'true' : 'false'?>"
            if (existingSignature == 'true') {
                $('#pic-signature').hide()
                $('#pic-signature-jpg').show()
            } else {
                showPICSignature()
            }
        }, 0)

        const existingChecklist = "<?=$data->checklist ? 'true' : 'false'?>"
        if (existingChecklist == "true") {
            const dbChecklist = existingChecklist == "true" ? JSON.parse(JSON.stringify(<?=$data->checklist ?? null?>)) : []
            options = dbChecklist
        } else {
            options = baseOptions
        }
        
        generateOptions = () => {
            tableContentHtml = ''
            options.forEach((option, optionIdx) => {
                tableContentHtml += '<tr><td onClick="strike('+optionIdx+')" width="10">'+(option.child ? '' : '<span class="strike-option">-</span>')+'</td><td class="iptCheck">'+(option.child ? '' : '<input type="checkbox" onClick="check('+optionIdx+')" onClick="setToCheck('+optionIdx+')" '+(option.checked ? 'checked' : '')+' '+(option.striked ? 'disabled' : '')+' />')+'</td><td class="iptLabel">'+ option.label+'</td><td colspan="3" style="'+(option.striked ? 'text-decoration:line-through' : '')+'">'+option.title+'</td></tr>'

                const child = option.child

                if (child) {
                    child.forEach((childOpt, childIdx) => {
                        tableContentHtml += '<tr><td></td><td onClick="strike('+optionIdx+', '+childIdx+')">'+(childOpt.child ? '' : '<span class="strike-option">-</span>')+'</td><td class="iptCheck">'+ (childOpt.child ? '' : '<input type="checkbox" onClick="check('+optionIdx+', '+childIdx+')" '+(childOpt.checked ? 'checked' : '')+' '+(childOpt.striked ? 'disabled' : '')+' />') +'</td><td class="iptLabel">'+childOpt.label+'</td><td colspan="2" style="'+(childOpt.striked ? 'text-decoration:line-through' : '')+'">'+childOpt.title+'</td></tr>'

                        const subChild = childOpt.child

                        if (subChild) {
                            subChild.forEach((subChildOpt, subChildIdx) => {
                                tableContentHtml += '<tr><td></td><td></td><td onClick="strike('+optionIdx+', '+childIdx+', '+subChildIdx+')">'+(subChildOpt.child ? '' : '<span class="strike-option">-</span>')+'</td><td class="iptCheck"><input type="checkbox" onClick="check('+optionIdx+', '+childIdx+', '+subChildIdx+')" '+(subChildOpt.checked ? 'checked' : '')+' '+(subChildOpt.striked ? 'disabled' : '')+' /></td><td class="iptLabel">'+subChildOpt.label+'</td><td style="'+(subChildOpt.striked ? 'text-decoration:line-through' : '')+'">'+subChildOpt.title+'</td></tr>'
                            })
                        }
                    })
                }
            })

            $('#checklist-table').html(tableContentHtml);
        }

        generateOptions()

        strike = (optionIdx, childIdx = null, subChildIdx = null) => {
            if (childIdx == null && subChildIdx == null) {
                options[optionIdx].striked = !options[optionIdx].striked
            }

            if (childIdx != null && subChildIdx == null) {
                options[optionIdx].child[childIdx].striked = !options[optionIdx].child[childIdx].striked
            }

            if (subChildIdx != null) {
                options[optionIdx].child[childIdx].child[subChildIdx].striked = !options[optionIdx].child[childIdx].child[subChildIdx].striked
            }

            generateOptions()
        }

        check = (optionIdx, childIdx = null, subChildIdx = null) => {
            if (childIdx == null && subChildIdx == null) {
                options[optionIdx].checked = !options[optionIdx].checked
            }

            if (childIdx != null && subChildIdx == null) {
                options[optionIdx].child[childIdx].checked = !options[optionIdx].child[childIdx].checked
            }

            if (subChildIdx != null) {
                options[optionIdx].child[childIdx].child[subChildIdx].checked = !options[optionIdx].child[childIdx].child[subChildIdx].checked
            }

            generateOptions()
        }

        saveOrSend = (isSend = false) => {
            <?php if ($data->approver_id != sessionData('user_id')) { ?>
                if ($('#approver_id').val() == null) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops... Gagal menyimpan!',
                        text: 'Harap memilih Koor. Editor',
                    })
                    return
                }
            <?php } ?>

            const catatan = $('#catatan').val()

            const picSignature = picSignaturePad.toDataURL();
            const isPicDrawed = picSignaturePad.points.length;
            const approverSignature = approverSignaturePad.toDataURL();
            const isApproverDrawed = approverSignaturePad.points.length;

            let data = {
                naskahId: "<?=inputGet('id_naskah')?>",
                catatan,
                checklist: JSON.stringify(options),
                approverId: $('#approver_id').val(),
                isSend: isSend ? '1' : '0',
            }

            <?php if ($data->approver_id != sessionData('user_id')) { ?>
                if (isPicDrawed) {
                    data.picSignature = picSignature
                }
            <?php } ?>

            <?php if ($data->approver_id == sessionData('user_id')) { ?>
                if (isApproverDrawed) {
                    data.approverSignature = approverSignature
                }
            <?php } ?>

            $.ajax({
                url: "<?=site_url('naskah/save_sop_koreksi_3')?>",
                data: data,
                method: "POST",
                success: function () {
                    Swal.fire(
                        'Berhasil menyimpan!',
                        'SOP Koreksi 3 berhasil disimpan..',
                        'success'
                    ).then(function() {
                        window.location.reload()
                    })
                },
            })
        }
    })
</script>