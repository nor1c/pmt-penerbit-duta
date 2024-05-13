<?php

class Naskah extends DUTA_Controller {
    private $userId;
    private $searchableFields = ['no_job', 'kode', 'judul', 'penulis'];

    public function __construct() {
        parent::__construct();
        
        $this->load->model(array('Naskah_model', 'Naskah_role_model'));
        $this->load->library('template');
        $this->userId = sessionData('user_id');
    }

    public function index() {
        $data['jenjangs'] = $this->Jenjang_model->getDropdown();
        $data['mapels'] = $this->Mapel_model->getDropdown();
        $data['kategoris'] = $this->Kategori_model->getDropdown();
        $data['ukurans'] = $this->Ukuran_model->getDropdown();
        $data['next_naskah_no_job'] = $this->Naskah_model->nextNaskahNoJob();

        $data['default_level_kerja'] = [
            ['key' => 'penulisan', 'id_naskah' => null, 'durasi' => null, 'pic_role' => null, 'tgl_rencana_mulai' => null, 'tgl_rencana_selesai' => null, 'total_libur' => null, 'is_disabled' => 0, 'id_pic_aktif' => null, 'status' => 'open'],
            ['key' => 'editing', 'id_naskah' => null, 'durasi' => null, 'pic_role' => null, 'tgl_rencana_mulai' => null, 'tgl_rencana_selesai' => null, 'total_libur' => null, 'is_disabled' => 0, 'id_pic_aktif' => null, 'status' => 'open'],
            ['key' => 'setting_1', 'id_naskah' => null, 'durasi' => null, 'pic_role' => null, 'tgl_rencana_mulai' => null, 'tgl_rencana_selesai' => null, 'total_libur' => null, 'is_disabled' => 0, 'id_pic_aktif' => null, 'status' => 'open'],
            ['key' => 'koreksi_1', 'id_naskah' => null, 'durasi' => null, 'pic_role' => null, 'tgl_rencana_mulai' => null, 'tgl_rencana_selesai' => null, 'total_libur' => null, 'is_disabled' => 0, 'id_pic_aktif' => null, 'status' => 'open'],
            ['key' => 'setting_2', 'id_naskah' => null, 'durasi' => null, 'pic_role' => null, 'tgl_rencana_mulai' => null, 'tgl_rencana_selesai' => null, 'total_libur' => null, 'is_disabled' => 0, 'id_pic_aktif' => null, 'status' => 'open'],
            ['key' => 'koreksi_2', 'id_naskah' => null, 'durasi' => null, 'pic_role' => null, 'tgl_rencana_mulai' => null, 'tgl_rencana_selesai' => null, 'total_libur' => null, 'is_disabled' => 0, 'id_pic_aktif' => null, 'status' => 'open'],
            ['key' => 'setting_3', 'id_naskah' => null, 'durasi' => null, 'pic_role' => null, 'tgl_rencana_mulai' => null, 'tgl_rencana_selesai' => null, 'total_libur' => null, 'is_disabled' => 0, 'id_pic_aktif' => null, 'status' => 'open'],
            ['key' => 'koreksi_3', 'id_naskah' => null, 'durasi' => null, 'pic_role' => null, 'tgl_rencana_mulai' => null, 'tgl_rencana_selesai' => null, 'total_libur' => null, 'is_disabled' => 0, 'id_pic_aktif' => null, 'status' => 'open'],
            ['key' => 'pdf', 'id_naskah' => null, 'durasi' => null, 'pic_role' => null, 'tgl_rencana_mulai' => null, 'tgl_rencana_selesai' => null, 'total_libur' => null, 'is_disabled' => 0, 'id_pic_aktif' => null, 'status' => 'open'],
        ];
        $data['level_kerja_key_map'] = $this->keyMap;
        $data['level_kerja_key_map_as_json'] = json_encode($this->keyMap);
        $data['roles_karyawan'] = $this->Naskah_role_model->getEveryPICs();

        $this->template->display('naskah/index.php', $data);
    }

    public function data() {
        $pagination = array(
            'start' => $this->input->post('start'),
            'length' => $this->input->post('length')
        );

        $search = inputPost('search')['value'];
        $filters = explode('&', $this->input->post('filters'));

        $isPengajuan = inputGet('isPengajuan');
        $naskah = $this->Naskah_model->getAll($this->searchableFields, $search, $filters, $pagination, $isPengajuan);

        $formattedData = array_map(function ($item) {
            $isPengajuan = inputGet('isPengajuan');
            if ($isPengajuan === 'true') {
                return ['', $item['no_job'], $item['kode'], $item['judul'], $item['id_pengaju'], $item['tgl_pengajuan'], $item['jilid'], $item['penulis'], $item['level_kerja'], ($item['is_pengajuan_processed'] == 1 ? true : false)];
            } else {
                return ['', $item['no_job'], $item['kode'], $item['judul'], $item['jilid'], $item['penulis'], $item['level_kerja']];
            }
        }, $naskah['data']);

        $data = [
            'recordsTotal' => $naskah['recordsTotal'],
            'recordsFiltered' => $naskah['recordsTotal'],
            'data' => $formattedData
        ];

        echo json_encode($data);
    }

    public function getLevelKerjaKeyMapJson() {
        echo json_encode($this->keyMap);
    }

    public function next_new_no_job() {
        echo json_encode((int)$this->Naskah_model->nextNaskahNoJob());
    }

    public function getNaskahLevelKerja() {
        $idNaskah = inputGet('id_naskah');

        $level_kerja = $this->Naskah_model->getNaskahLevelKerja($idNaskah);

        echo json_encode($level_kerja);
    }

    public function create() {
        $post_data = $this->input->post();
        
        $isPengajuan = inputGet('isPengajuan');
        if ($isPengajuan == 'true') {
            $post_data['is_pengajuan'] = '1';
            $post_data['id_pengaju'] = $this->userId;
            $post_data['tgl_pengajuan'] = date('Y-m-d H:i:s', time());
        }
        
        $created = $this->Naskah_model->save($post_data);

        echo json_encode($created);
    }

    public function update() {
        $post_data = $this->input->post();

        $update = $this->Naskah_model->update($post_data);

        echo json_encode($update);
    }

    public function naskahDetail() {
        $no_job = $this->input->get('no_job');

        $naskah = $this->Naskah_model->findByNoJob($no_job);

        echo json_encode($naskah);
    }

    public function deleteNaskah() {
        $no_job = $this->input->post('no_job');

        $deleteResponse = $this->Naskah_model->delete($no_job);

        echo json_encode($deleteResponse);
    }

    public function view() {
        $data['no_job'] = $this->uri->segment(3);

        $data['naskah'] = $this->Naskah_model->findByNoJob($data['no_job']);
        $data['jenjangs'] = $this->Jenjang_model->getDropdown();
        $data['mapels'] = $this->Mapel_model->getDropdown();
        $data['kategoris'] = $this->Kategori_model->getDropdown();
        $data['ukurans'] = $this->Ukuran_model->getDropdown();
        $data['sop_progress'] = $this->Naskah_model->getProgressSOP($data['naskah']->id);

        $this->template->display('naskah/view.php', $data);
    }

    public function detail() {
        $data['no_job'] = $this->uri->segment(3);

        $data['naskah'] = $this->Naskah_model->findByNoJob($data['no_job']);
        $data['progress'] = $this->Naskah_model->getProgressWithRealizationDate($data['naskah']->id);

        $this->template->display('naskah/detail.php', $data);
    }

    public function changeCover() {
        $naskahId = inputGet('naskahId');
        $prevFileName = inputGet('prevFileName');

        $config['upload_path']   = './uploads/cover_naskah';
        $config['allowed_types'] = 'jpg|jpeg|png';

        $this->load->library('upload', $config);

        if (file_exists('./uploads/cover_naskah/' . $prevFileName)) {
            unlink('./uploads/cover_naskah/' . $prevFileName);
        }

        if (!$this->upload->do_upload('file')) {
            $error = array('error' => $this->upload->display_errors());
            echo json_encode(errorResponse('Gagal mengupdate naskah cover'));
        } else {
            $data = $this->upload->data();

            $updateResponse = $this->Naskah_model->updateCover($naskahId, $data['client_name']);
            
            echo json_encode($updateResponse);
        }
    }

    public function getOffDaysTotal() {
        $duration = inputGet('duration');
        $startDateRaw = inputGet('startDate');
        
        if ($duration == "" && ($startDateRaw == "" || $startDateRaw == "NaN/NaN/NaN")) {
            echo json_encode(array());
            die;
        }

        $startDate = convertDateFormat($startDateRaw);

        $endDate = $this->Naskah_model->getEndDate($duration, $startDate);

        echo json_encode($endDate);
    }

    public function saveLevelKerja() {
        $idNaskah = inputGet('id_naskah');
        $data = inputPost('data');

        $this->deleteLevelKerja($idNaskah);
        
        foreach ($data as $index => $lk) {
            foreach ($lk as $i => $key) {
                if ($i == 'tgl_rencana_mulai') {
                    $data[$index][$i] = convertDateFormat($lk[$i]);
                } else if ($i == 'id_pic_aktif') {
                    if ($data[$index][$i] == '0') {
                        unset($data[$index][$i]);
                    }
                }
            } 
        }

        $insertLevelKerja = $this->Naskah_model->saveLevelKerja($data);

        if ($insertLevelKerja) {
            // update status is_processed to 1
            $this->Naskah_model->setAsProcessed($idNaskah);
        }
        
        echo json_encode($insertLevelKerja);
    }

    public function deleteLevelKerja($naskahId) {
        return $this->Naskah_model->deleteLevelKerja($naskahId);
    }

    public function sop_requests() {
        $this->template->display('naskah/sop/sop_requests.php');
    }

    public function sop_requests_data() {
        $pagination = array(
            'start' => $this->input->post('start'),
            'length' => $this->input->post('length')
        );

        $search = inputPost('search')['value'];
        $filters = explode('&', $this->input->post('filters'));

        $sop = $this->Naskah_model->getSOPRequestList($this->searchableFields, $search, $filters, $pagination);

        $formattedData = array_map(function ($item) {
            return ['', $item['id'], $item['no_job'], $item['judul'], $item['nama_editor'], date('d/m/Y H:i', strtotime($item['tanggal_request'])), ucfirst($item['type'])];
        }, $sop['data']);

        $data = [
            'recordsTotal' => $sop['recordsTotal'],
            'recordsFiltered' => $sop['recordsTotal'],
            'data' => $formattedData
        ];

        echo json_encode($data);
    }

    public function sop_editing() {
        $idNaskah = inputGet('id_naskah');
        $data['id_naskah'] = $idNaskah;

        $data['data'] = $this->Naskah_model->sop_editing($idNaskah);
        $data['pics'] = $this->Karyawan_model->getPICNaskahJSON();

        $this->template->display('naskah/sop/editing', $data);
    }

    public function save_sop_editing() {
        $naskahId = inputPost('naskahId');
        $catatan = inputPost('catatan');
        $checkList = inputPost('checklist');
        $picSignature = inputPost('picSignature');
        $approverId = inputPost('approverId');
        $approverSignature = inputPost('approverSignature');
        $isSend = inputPost('isSend');
        
        $picSignFileName = "editing_editor_$naskahId.jpg";
        $approverSignFileName = "editing_koor_editor_$naskahId.jpg";

        if ($picSignature) {
            $savePICSign = $this->save_signature($picSignature, $picSignFileName);
        }
        if ($approverSignature) {
            $saveApproverSign = $this->save_signature($approverSignature, $approverSignFileName);
        }

        // save to database
        $data = array(
            'id_naskah' => $naskahId,
            'catatan' => $catatan,
            'checklist' => $checkList,
            'is_send' => $isSend,
            'send_date' => $isSend ? date('Y-m-d H:i:s', time()) : NULL,
        );

        if ($picSignature) {
            $pic_sign_data = array(
                'approver_id' => $approverId,
                'pic_signature' => $picSignFileName,
                'pic_signed_by' => sessionData('user_id'),
                'pic_signed_date' => date('Y-m-d', time()),
            );

            $data = array_merge($data, $pic_sign_data);
        }

        if ($approverSignature) {
            $approver_sign_data = array(
                'approver_signature' => $approverSignFileName,
                'approver_signed_by' => sessionData('user_id'),
                'approver_signed_date' => date('Y-m-d', time()),
            );

            $data = array_merge($data, $approver_sign_data);
        }

        $result = $this->Naskah_model->save_sop_editing($data);

        echo json_encode($result);
    }

    public function save_signature($signature, $fileName) {
        $encodedSignature = explode(',', $signature)[1];
        $decodedSignature = base64_decode($encodedSignature);

        $rootDir = dirname(dirname(__DIR__));
        
        $uploadDir = $rootDir . '/signatures/sop';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $filePath = $uploadDir . '/' . $fileName;

        if (file_put_contents($filePath, $decodedSignature) !== false) {
            return true;
        } else {
            return false;
        }
    }

    public function sop_koreksi_1() {
        $idNaskah = inputGet('id_naskah');
        $data['id_naskah'] = $idNaskah;

        $data['data'] = $this->Naskah_model->sop_koreksi_1($idNaskah);
        $data['pics'] = $this->Karyawan_model->getPICNaskahJSON();

        $this->template->display('naskah/sop/koreksi_1', $data);
    }

    public function save_sop_koreksi_1() {
        $naskahId = inputPost('naskahId');
        $catatan = inputPost('catatan');
        $checkList = inputPost('checklist');
        $picSignature = inputPost('picSignature');
        $approverId = inputPost('approverId');
        $approverSignature = inputPost('approverSignature');
        $isSend = inputPost('isSend');
        
        $picSignFileName = "koreksi_1_editor_$naskahId.jpg";
        $approverSignFileName = "koreksi_1_koor_editor_$naskahId.jpg";

        if ($picSignature) {
            $savePICSign = $this->save_signature($picSignature, $picSignFileName);
        }
        if ($approverSignature) {
            $saveApproverSign = $this->save_signature($approverSignature, $approverSignFileName);
        }

        // save to database
        $data = array(
            'id_naskah' => $naskahId,
            'catatan' => $catatan,
            'checklist' => $checkList,
            'is_send' => $isSend,
            'send_date' => $isSend ? date('Y-m-d H:i:s', time()) : NULL,
        );

        if ($picSignature) {
            $pic_sign_data = array(
                'approver_id' => $approverId,
                'pic_signature' => $picSignFileName,
                'pic_signed_by' => sessionData('user_id'),
                'pic_signed_date' => date('Y-m-d', time()),
            );

            $data = array_merge($data, $pic_sign_data);
        }

        if ($approverSignature) {
            $approver_sign_data = array(
                'approver_signature' => $approverSignFileName,
                'approver_signed_by' => sessionData('user_id'),
                'approver_signed_date' => date('Y-m-d', time()),
            );

            $data = array_merge($data, $approver_sign_data);
        }

        $result = $this->Naskah_model->save_sop_koreksi_1($data);

        echo json_encode($result);
    }

    public function sop_koreksi_2() {
        $idNaskah = inputGet('id_naskah');
        $data['id_naskah'] = $idNaskah;

        $data['data'] = $this->Naskah_model->sop_koreksi_2($idNaskah);
        $data['pics'] = $this->Karyawan_model->getPICNaskahJSON();

        $this->template->display('naskah/sop/koreksi_2', $data);
    }

    public function save_sop_koreksi_2() {
        $naskahId = inputPost('naskahId');
        $catatan = inputPost('catatan');
        $checkList = inputPost('checklist');
        $picSignature = inputPost('picSignature');
        $approverId = inputPost('approverId');
        $approverSignature = inputPost('approverSignature');
        $isSend = inputPost('isSend');
        
        $picSignFileName = "koreksi_2_editor_$naskahId.jpg";
        $approverSignFileName = "koreksi_2_koor_editor_$naskahId.jpg";

        if ($picSignature) {
            $savePICSign = $this->save_signature($picSignature, $picSignFileName);
        }
        if ($approverSignature) {
            $saveApproverSign = $this->save_signature($approverSignature, $approverSignFileName);
        }

        // save to database
        $data = array(
            'id_naskah' => $naskahId,
            'catatan' => $catatan,
            'checklist' => $checkList,
            'is_send' => $isSend,
            'send_date' => $isSend ? date('Y-m-d H:i:s', time()) : NULL,
        );

        if ($picSignature) {
            $pic_sign_data = array(
                'approver_id' => $approverId,
                'pic_signature' => $picSignFileName,
                'pic_signed_by' => sessionData('user_id'),
                'pic_signed_date' => date('Y-m-d', time()),
            );

            $data = array_merge($data, $pic_sign_data);
        }

        if ($approverSignature) {
            $approver_sign_data = array(
                'approver_signature' => $approverSignFileName,
                'approver_signed_by' => sessionData('user_id'),
                'approver_signed_date' => date('Y-m-d', time()),
            );

            $data = array_merge($data, $approver_sign_data);
        }

        $result = $this->Naskah_model->save_sop_koreksi_2($data);

        echo json_encode($result);
    }

    public function sop_koreksi_3() {
        $idNaskah = inputGet('id_naskah');
        $data['id_naskah'] = $idNaskah;

        $data['data'] = $this->Naskah_model->sop_koreksi_3($idNaskah);
        $data['pics'] = $this->Karyawan_model->getPICNaskahJSON();

        $this->template->display('naskah/sop/koreksi_3', $data);
    }

    public function save_sop_koreksi_3() {
        $naskahId = inputPost('naskahId');
        $catatan = inputPost('catatan');
        $checkList = inputPost('checklist');
        $picSignature = inputPost('picSignature');
        $approverId = inputPost('approverId');
        $approverSignature = inputPost('approverSignature');
        $isSend = inputPost('isSend');
        
        $picSignFileName = "koreksi_3_editor_$naskahId.jpg";
        $approverSignFileName = "koreksi_3_koor_editor_$naskahId.jpg";

        if ($picSignature) {
            $savePICSign = $this->save_signature($picSignature, $picSignFileName);
        }
        if ($approverSignature) {
            $saveApproverSign = $this->save_signature($approverSignature, $approverSignFileName);
        }

        // save to database
        $data = array(
            'id_naskah' => $naskahId,
            'catatan' => $catatan,
            'checklist' => $checkList,
            'is_send' => $isSend,
            'send_date' => $isSend ? date('Y-m-d H:i:s', time()) : NULL,
        );

        if ($picSignature) {
            $pic_sign_data = array(
                'approver_id' => $approverId,
                'pic_signature' => $picSignFileName,
                'pic_signed_by' => sessionData('user_id'),
                'pic_signed_date' => date('Y-m-d', time()),
            );

            $data = array_merge($data, $pic_sign_data);
        }

        if ($approverSignature) {
            $approver_sign_data = array(
                'approver_signature' => $approverSignFileName,
                'approver_signed_by' => sessionData('user_id'),
                'approver_signed_date' => date('Y-m-d', time()),
            );

            $data = array_merge($data, $approver_sign_data);
        }

        $result = $this->Naskah_model->save_sop_koreksi_3($data);

        echo json_encode($result);
    }

    public function sop_pdf() {
        $idNaskah = inputGet('id_naskah');
        $data['id_naskah'] = $idNaskah;

        $data['data'] = $this->Naskah_model->sop_pdf($idNaskah);
        $data['pics'] = $this->Karyawan_model->getPICNaskahJSON();

        $this->template->display('naskah/sop/pdf', $data);
    }

    public function save_sop_pdf() {
        $naskahId = inputPost('naskahId');
        $catatan = inputPost('catatan');
        $checkList = inputPost('checklist');
        $picSignature = inputPost('picSignature');
        $approverId = inputPost('approverId');
        $approverSignature = inputPost('approverSignature');
        $isSend = inputPost('isSend');
        
        $picSignFileName = "pdf_editor_$naskahId.jpg";
        $approverSignFileName = "pdf_koor_editor_$naskahId.jpg";

        if ($picSignature) {
            $savePICSign = $this->save_signature($picSignature, $picSignFileName);
        }
        if ($approverSignature) {
            $saveApproverSign = $this->save_signature($approverSignature, $approverSignFileName);
        }

        // save to database
        $data = array(
            'id_naskah' => $naskahId,
            'catatan' => $catatan,
            'checklist' => $checkList,
            'is_send' => $isSend,
            'send_date' => $isSend ? date('Y-m-d H:i:s', time()) : NULL,
        );

        if ($picSignature) {
            $pic_sign_data = array(
                'approver_id' => $approverId,
                'pic_signature' => $picSignFileName,
                'pic_signed_by' => sessionData('user_id'),
                'pic_signed_date' => date('Y-m-d', time()),
            );

            $data = array_merge($data, $pic_sign_data);
        }

        if ($approverSignature) {
            $approver_sign_data = array(
                'approver_signature' => $approverSignFileName,
                'approver_signed_by' => sessionData('user_id'),
                'approver_signed_date' => date('Y-m-d', time()),
            );

            $data = array_merge($data, $approver_sign_data);
        }

        $result = $this->Naskah_model->save_sop_pdf($data);

        echo json_encode($result);
    }
}