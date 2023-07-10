<?php

class Naskah extends CI_Controller {
    public function __construct() {
        parent::__construct();
        
        $this->load->model(array('Naskah_model'));
        $this->load->library('template');
    }

    public function index() {
        $this->template->display('naskah/index.php');
    }

    public function data() {
        $naskah = $this->Naskah_model->getAll();

        $formattedData = array_map(function ($item) {
            return ['', $item['nojob'], $item['kode_buku'], $item['judul_buku'], '-', $item['penulis']];
        }, $naskah['data']);

        $data = [
            'recordsTotal' => $naskah['recordsTotal'],
            'data' => $formattedData
        ];

        echo json_encode($data);
    }

    public function create() {
        $post_data = $this->input->post();
        
        $new_naskah = $this->Naskah_model->save($post_data);

        echo json_encode($new_naskah);
    }
}