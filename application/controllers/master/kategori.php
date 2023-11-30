<?php

class Kategori extends DUTA_Controller {
    public function __construct() {
        parent::__construct();
    }

    public function getAll() {
        $pagination = array(
            'start' => $this->input->post('start'),
            'length' => $this->input->post('length')
        );

        $filters = explode('&', $this->input->post('filters'));

        $kategori = $this->Kategori_model->getAll($filters, $pagination);

        $formattedData = array_map(function ($item) {
            return ['', $item['nama_kategori'], $item['is_active']];
        }, $kategori['data']);

        $data = [
            'recordsTotal' => $kategori['recordsTotal'],
            'recordsFiltered' => $kategori['recordsTotal'],
            'data' => $formattedData
        ];
        
        echo json_encode($data);
    }

    public function getDropdown() {
        $kategori_dropdown = $this->Kategori_model->getDropdown();

        return $kategori_dropdown;
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
        $this->template->display('master/kategori/index');
    }
}