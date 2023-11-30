<?php

class Naskah_roles extends DUTA_Controller {
    public function __construct() {
        parent::__construct();
        loadModel(array('Naskah_role_model'));
    }

    public function getAll() {
        $filters = explode('&', $this->input->post('filters'));
        
        $data = $this->Naskah_role_model->getAll();

        $naskah_role = $this->Naskah_role_model->getAll($filters);

        $formattedData = array_map(function ($item) {
            return ['', $item['key'], $item['nama_role'], $item['is_active'], $item['nama']];
        }, $naskah_role['data']);

        $data = [
            'recordsTotal' => $naskah_role['recordsTotal'],
            'recordsFiltered' => $naskah_role['recordsTotal'],
            'data' => $formattedData
        ];
        
        echo json_encode($data);
    }

    public function getDropdown() {
        $naskah_role_dropdown = $this->Naskah_role_model->getDropdown();

        return $naskah_role_dropdown;
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
        $this->template->display('naskah/roles/index');
    }

    public function getMappedKaryawans() {
        $roleKey = inputGet('roleKey');

        $mappedKaryawans = $this->Naskah_role_model->getMappedKaryawans($roleKey);

        echo json_encode($mappedKaryawans);
    }

    public function saveMapping() {
        $data = inputPost('data');
        $response = $this->Naskah_role_model->saveMapping($data);

        echo json_encode($response > 0 ? true : false);
    }
}