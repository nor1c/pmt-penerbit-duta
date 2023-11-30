<?php

class Ukuran extends DUTA_Controller {
    public function __construct() {
        parent::__construct();
    }

    public function getAll() {
        $filters = explode('&', $this->input->post('filters'));
        
        $data = $this->Ukuran_model->getAll();

        $ukuran = $this->Ukuran_model->getAll($filters);

        $formattedData = array_map(function ($item) {
            return ['', $item['nama_ukuran'], $item['is_active']];
        }, $ukuran['data']);

        $data = [
            'recordsTotal' => $ukuran['recordsTotal'],
            'recordsFiltered' => $ukuran['recordsTotal'],
            'data' => $formattedData
        ];
        
        echo json_encode($data);
    }

    public function getDropdown() {
        $ukuran_dropdown = $this->Ukuran_model->getDropdown();

        return $ukuran_dropdown;
    }

    public function create() {
        // 
    }

    public function update() {
        // 
    }

    public function delete() {
        // 
    }

    public function index() {
        $this->template->display('master/ukuran/index');
    }
}