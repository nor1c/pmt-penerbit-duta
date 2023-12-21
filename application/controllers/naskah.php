<?php

class Naskah extends DUTA_Controller {
    private $searchableFields = ['no_job', 'kode', 'judul', 'penulis'];
    private $keyMap = array(
        'penulisan' => array(
            'order' => 1,
            'key' => 'penulisan',
            'text' => 'Penulisan',
            'next_level' => 'editing',
            'is_off' => "0",
            'pic' => 'editor'
        ),
        'editing' => array(
            'order' => 2,
            'key' => 'editing',
            'text' => 'Editing',
            'next_level' => 'setting_1',
            'is_off' => "0",
            'pic' => 'editor'
        ),
        'setting_1' => array(
            'order' => 3,
            'key' => 'setting_1',
            'text' => 'Setting 1',
            'next_level' => 'koreksi_1',
            'is_off' => "0",
            'pic' => 'setter'
        ),
        'koreksi_1' => array(
            'order' => 4,
            'key' => 'koreksi_1',
            'text' => 'Koreksi 1',
            'next_level' => 'setting_2',
            'is_off' => "0",
            'pic' => 'editor'
        ),
        'setting_2' => array(
            'order' => 5,
            'key' => 'setting_2',
            'text' => 'Setting 2',
            'next_level' => 'koreksi_2',
            'is_off' => "0",
            'pic' => 'setter'
        ),
        'koreksi_2' => array(
            'order' => 6,
            'key' => 'koreksi_2',
            'text' => 'Koreksi 2',
            'next_level' => 'setting_3',
            'is_off' => "0",
            'pic' => 'editor'
        ),
        'setting_3' => array(
            'order' => 7,
            'key' => 'setting_3',
            'text' => 'Setting 3',
            'next_level' => 'koreksi_3',
            'is_off' => "0",
            'pic' => 'setter'
        ),
        'koreksi_3' => array(
            'order' => 8,
            'key' => 'koreksi_3',
            'text' => 'Koreksi 3',
            'next_level' => 'pdf',
            'is_off' => "0",
            'pic' => 'editor'
        ),
        'pdf' => array(
            'order' => 9,
            'key' => 'pdf',
            'text' => 'PDF',
            'next_level' => null,
            'is_off' => "0",
            'pic' => 'setter'
        ),
    );

    public function __construct() {
        parent::__construct();
        
        $this->load->model(array('Naskah_model', 'Naskah_role_model'));
        $this->load->library('template');
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

    public function data() {
        $pagination = array(
            'start' => $this->input->post('start'),
            'length' => $this->input->post('length')
        );

        $search = inputPost('search')['value'];
        $filters = explode('&', $this->input->post('filters'));

        $naskah = $this->Naskah_model->getAll($this->searchableFields, $search, $filters, $pagination);

        $formattedData = array_map(function ($item) {
            return ['', $item['no_job'], $item['kode'], $item['judul'], $item['jilid'], $item['penulis']];
        }, $naskah['data']);

        $data = [
            'recordsTotal' => $naskah['recordsTotal'],
            'recordsFiltered' => $naskah['recordsTotal'],
            'data' => $formattedData
        ];

        echo json_encode($data);
    }

    public function create() {
        $post_data = $this->input->post();
        
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

        $this->template->display('naskah/view.php', $data);
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
        
        echo json_encode($insertLevelKerja);
    }
}