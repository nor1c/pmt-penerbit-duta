<?php

class Pekerjaan extends CI_Controller {
    public function __construct() {
        parent::__construct();
        
        $this->load->model(array('Naskah_model', 'master/jenjang_model', 'master/kategori_model', 'master/mapel_model', 'Pekerjaan_m'));
        $this->load->library('template');
    }

    public function index() {
        $data['jenjangs'] = $this->jenjang_model->getDropdown();
        $data['mapels'] = $this->mapel_model->getDropdown();
        $data['kategoris'] = $this->kategori_model->getDropdown();

        $this->template->display('pekerjaan/index.php', $data);
    }

    public function laporan_filter() {
        $startdate = date("Y-m-d", strtotime($this->input->post('startdate')));
        $enddate = date("Y-m-d", strtotime($this->input->post('enddate')));

        $id_karyawan = $this->input->post('id_karyawan');
        $id_judul_buku = $this->input->post('id_judul_buku');

        $this->session->set_flashdata('startdate', $startdate);
        $this->session->set_flashdata('enddate', $enddate);
        $this->session->set_flashdata('id_karyawan', $id_karyawan);
        $this->session->set_flashdata('id_judul_buku', $id_judul_buku);

        redirect('pekerjaan', 'refresh');
    }

    public function report_pekerjaan() {
        $data['id_karyawan'] = $this->session->userdata('user_id');
        $data['pekerjaan'] = $this->input->post('pekerjaan');
        if ($this->input->post('id_buku') == "") {
            $data['id_buku_dikerjakan'] = null;
        } else {
            $data['id_buku_dikerjakan'] = $this->input->post('id_buku');
        }
        $data['no_job'] = $this->input->post('no_job');
        $data['catatan'] = $this->input->post('catatan');
        $data['target'] = $this->input->post('target');
        $data['status'] = $this->input->post('status');
        $data['realisasi_target'] = $this->input->post('realisasi_target');
        $data['date'] = date("Y-m-d");

        if ($this->db->insert('report_pekerjaan', $data)) {
            $this->session->set_flashdata('success', 1);
            redirect('pekerjaan', 'refresh');
        }
    }

    public function laporan() {
        $pagination = array(
            'start' => $this->input->post('start'),
            'length' => $this->input->post('length')
        );

        $filters = explode('&', $this->input->post('filters'));
        if ($filters[0] == "") {
            if (!isset($filters['startdate'])) {
                array_push($filters, "startdate=".str_replace('/', '%2F', date('d/m/Y')));
            }
            if (!isset($filters['enddate'])) {
                array_push($filters, "enddate=".str_replace('/', '%2F', date('d/m/Y')));
            }
        }

        $laporan = $this->Pekerjaan_m->getLaporanData($filters, $pagination);

        $formattedData = array_map(
            function ($item) {
                return ['', $item['date'], $item['nama'], $item['pekerjaan'], $item['judul_buku'], $item['catatan'], $item['kode_buku'], $item['no_job'], $item['target'], $item['realisasi_target'], $item['status']];
            },
            $laporan['data']
        );

        $data = [
            'recordsTotal' => $laporan['recordsTotal'],
            'recordsFiltered' => $laporan['recordsTotal'],
            'data' => $formattedData
        ];

        echo json_encode($data);
    }
}