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
        $paginationPage = inputGet('page');
        $data['jobs'] = $this->Proses_job_model->getAll(($paginationPage != '' ? $paginationPage : 0), $perPagePagination);

        $data['levelKerjaMap'] = $this->keyMap;
        $data['statusMap'] = $this->statusMap;
        $data['roles_karyawan'] = $this->Naskah_role_model->getEveryPICs();
        $data['level_kerja_key_map'] = $this->keyMap;
        $data['level_kerja_key_map_as_json'] = json_encode($this->keyMap);

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