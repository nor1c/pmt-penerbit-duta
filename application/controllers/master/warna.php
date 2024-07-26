<?php

class Warna extends DUTA_Controller {
    public function __construct() {
        parent::__construct();
    }

    public function getAll() {
        $filters = explode('&', $this->input->post('filters'));
        
        $warna = $this->Warna_model->getAll();

        $formattedData = array_map(function ($item) {
            return ['', $item['id'], $item['nama_warna'], $item['is_active']];
        }, $warna['data']);

        $data = [
            'recordsTotal' => $warna['recordsTotal'],
            'recordsFiltered' => $warna['recordsTotal'],
            'data' => $formattedData
        ];
        
        echo json_encode($data);
    }

    public function getDropdown() {
        $warna_dropdown = $this->Warna_model->getDropdown();

        return $warna_dropdown;
    }

    public function warnaDetail() {
        $id = inputGet('id');

        $warna = $this->Warna_model->findById($id);

        echo json_encode($warna);
    }

    public function create() {
        $data = inputPost();
        $data['nama_warna'] = $data['nama_warna'];
        $data['is_active'] = $data['is_active'];

        $result = $this->Warna_model->create($data);

        echo json_encode($result);
    }

    public function update() {
        $data = inputPost();
        $id = inputGet('id');
        $update = $this->Warna_model->update($id, $data);

        echo json_encode($update);
    }

    public function deleteWarna() {
        $id = $this->input->post('id');

        $deleteResponse = $this->Warna_model->delete($id);

        echo json_encode($deleteResponse);
    }

    public function index() {
        $this->template->display('master/warna/index');
    }
}