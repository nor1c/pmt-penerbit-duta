<?php

class Naskah extends CI_Controller {
    public function __construct() {
        parent::__construct();
        
        $this->load->model(array('Naskah_model', 'master/jenjang_m', 'master/kategori_m', 'master/mapel_m'));
        $this->load->library('template');
    }

    public function index() {
        $data['jenjangs'] = $this->jenjang_m->getAll();
        $data['mapels'] = $this->mapel_m->getAll();
        $data['kategoris'] = $this->kategori_m->getAll();

        $this->template->display('naskah/index.php', $data);
    }

    public function data() {
        $naskah = $this->Naskah_model->getAll();

        $formattedData = array_map(function ($item) {
            return ['', $item['no_job'], $item['kode'], $item['judul'], $item['jilid'], $item['penulis']];
        }, $naskah['data']);

        $data = [
            'recordsTotal' => $naskah['recordsTotal'],
            'recordsFiltered' => $naskah['recordsTotal'],
            'data' => $formattedData
        ];

        echo json_encode($data);
    }

    public function create() {
        $post_data = $this->input->post();
        
        $new_naskah = $this->Naskah_model->save($post_data);

        echo json_encode($new_naskah);
    }

    public function deleteNaskah() {
        $no_job = $this->input->post('no_job') . 'a';

        // delete process
        $naskah_deleted = $this->Naskah_model->delete($no_job);

        echo json_encode($naskah_deleted ? true : false);
    }
}