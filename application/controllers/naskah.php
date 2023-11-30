<?php

class Naskah extends DUTA_Controller {
    public function __construct() {
        parent::__construct();
        
        $this->load->model(array('Naskah_model'));
        $this->load->library('template');
    }

    public function index() {
        $data['jenjangs'] = $this->Jenjang_model->getDropdown();
        $data['mapels'] = $this->Mapel_model->getDropdown();
        $data['kategoris'] = $this->Kategori_model->getDropdown();
        $data['next_naskah_no_job'] = $this->Naskah_model->nextNaskahNoJob();

        $this->template->display('naskah/index.php', $data);
    }

    public function next_new_no_job() {
        echo json_encode((int)$this->Naskah_model->nextNaskahNoJob());
    }

    public function data() {
        $filters = explode('&', $this->input->post('filters'));

        $naskah = $this->Naskah_model->getAll($filters);

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

    public function update() {
        $post_data = $this->input->post();

        $naskah_updated = $this->Naskah_model->update($post_data);

        echo json_encode($naskah_updated ? true : false);
    }

    public function naskahDetail() {
        $no_job = $this->input->get('no_job');

        $naskah = $this->Naskah_model->findByNoJob($no_job);

        echo json_encode($naskah[0]);
    }

    public function deleteNaskah() {
        $no_job = $this->input->post('no_job');

        // delete process
        $naskah_deleted = $this->Naskah_model->delete($no_job);

        echo json_encode($naskah_deleted ? true : false);
    }

    public function view() {
        $data['no_job'] = $this->uri->segment(3);

        $data['naskah'] = $this->Naskah_model->findByNoJob($data['no_job'])[0];

        $this->template->display('naskah/view.php', $data);
    }
}