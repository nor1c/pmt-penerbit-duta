<?php

class Mapel extends DUTA_Controller {
    public function __construct() {
        parent::__construct();
    }

    public function getAll() {
        $pagination = array(
            'start' => $this->input->post('start'),
            'length' => $this->input->post('length')
        );

        $filters = explode('&', $this->input->post('filters'));

        $mapel = $this->Mapel_model->getAll($filters, $pagination);

        $formattedData = array_map(function ($item) {
            return ['', $item['nama_mapel'], $item['is_active']];
        }, $mapel['data']);

        $data = [
            'recordsTotal' => $mapel['recordsTotal'],
            'recordsFiltered' => $mapel['recordsTotal'],
            'data' => $formattedData
        ];
        
        echo json_encode($data);
    }

    public function getDropdown() {
        $mapel_dropdown = $this->Mapel_model->getDropdown();

        return $mapel_dropdown;
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
        $this->template->display('master/mapel/index');
    }
}