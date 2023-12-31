<?php

class Jenjang extends DUTA_Controller {
    public function __construct() {
        parent::__construct();
    }

    public function getAll() {
        $filters = explode('&', $this->input->post('filters'));
        
        $data = $this->Jenjang_model->getAll();

        $jenjang = $this->Jenjang_model->getAll($filters);

        $formattedData = array_map(function ($item) {
            return ['', $item['nama_jenjang'], $item['is_active']];
        }, $jenjang['data']);

        $data = [
            'recordsTotal' => $jenjang['recordsTotal'],
            'recordsFiltered' => $jenjang['recordsTotal'],
            'data' => $formattedData
        ];
        
        echo json_encode($data);
    }

    public function getDropdown() {
        $jenjang_dropdown = $this->Jenjang_model->getDropdown();

        return $jenjang_dropdown;
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
        $this->template->display('master/jenjang/index');
    }
}