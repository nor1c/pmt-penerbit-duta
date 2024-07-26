<?php

class Proses_job extends DUTA_Controller {
    private $userId;

    public function __construct() {
        parent::__construct();
        
        $this->load->model(array('Proses_job_model', 'Job_model', 'Naskah_model', 'Naskah_role_model'));
        $this->load->library('template');
        $this->userId = sessionData('user_id');
    }

    public function index() {
        $perPagePagination = 5;
        $data['perPagePagination'] = $perPagePagination;
        
        $filter = array(
            'no_job' => inputGet('no_job'),
            'judul' => inputGet('judul'),
            'id_jenjang' => inputGet('id_jenjang'),
            'id_mapel' => inputGet('id_mapel'),
            'id_kategori' => inputGet('id_kategori'),
        );
        $paginationPage = inputGet('page');

        $data['jobs'] = $this->Proses_job_model->getAll($filter, ($paginationPage != '' ? $paginationPage : 0), $perPagePagination);

        $data['levelKerjaMap'] = $this->keyMap;
        $data['statusMap'] = $this->statusMap;
        $data['roles_karyawan'] = $this->Naskah_role_model->getEveryPICs();
        $data['level_kerja_key_map'] = $this->keyMap;
        $data['level_kerja_key_map_as_json'] = json_encode($this->keyMap);

        $data['jenjangs'] = $this->Jenjang_model->getDropdown();
        $data['mapels'] = $this->Mapel_model->getDropdown();
        $data['kategoris'] = $this->Kategori_model->getDropdown();
        $data['ukurans'] = $this->Ukuran_model->getDropdown();
        $data['warnas'] = $this->Warna_model->getDropdown();

        $this->template->display('proses_job/index.php', $data);
    }

    public function assignTaskTo() {
        $naskahId = inputPost('naskahId');
        $levelKerja = inputPost('levelKerja');
        $picId = inputPost('picId');

        $result = $this->Proses_job_model->assignTaskTo($naskahId, $levelKerja, $picId);

        echo json_encode($result);
    }
}