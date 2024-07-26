<?php

class PPIC extends DUTA_Controller {
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
        $data['warnas'] = $this->Warna_model->getDropdown();

        $this->template->display('ppic/index', $data);
    }

}