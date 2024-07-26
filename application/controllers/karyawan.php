<?php

class Karyawan extends DUTA_Controller {
    private $searchableFields = ['nik', 'nama', 'email'];

    public function __construct()
    {
        parent::__construct();
		loadModel(array('master/divisi_m','master/golongan_m','master/jabatan_m','master/jam_kerja_m'));
    }

    public function index() {
        if (sessionData('id_jabatan') != 1) {
            redirect('dashboard');
        }

        $data['divisi'] = $this->divisi_m->get_all(false)->result_array();
        $data['golongan'] = $this->golongan_m->get_all(false)->result_array();
        $data['jabatan'] = $this->jabatan_m->get_all(false)->result_array();
        $data['jam_kerja'] = $this->jam_kerja_m->get_all(false)->result_array();

        $this->template->display('karyawan/index', $data);
    }

    public function getAll() {
        $pagination = array(
            'start' => $this->input->post('start'),
            'length' => $this->input->post('length')
        );

        $search = inputPost('search')['value'];
        $filters = explode('&', $this->input->post('filters'));
        
        $karyawans = $this->Karyawan_model->getAll($this->searchableFields, $search, $filters, $pagination);

        $formattedData = array_map(function ($item) {
            return ['', $item['id_karyawan'], $item['nik'], $item['nama'], $item['nama_jabatan'], $item['nama_divisi'], $item['nama_golongan'], $item['no_handphone'], $item['email'], $item['jam_kerja'], $item['active']];
        }, $karyawans['data']);

        $data = [
            'recordsTotal' => $karyawans['recordsTotal'],
            'recordsFiltered' => $karyawans['recordsTotal'],
            'data' => $formattedData
        ];
        
        echo json_encode($data);
    }

    public function create() {
        $data = inputPost();
        
        $data['password'] = sha1($data['nik']);
        $data['created_user'] = sessionData('user_id');
        $data['created_date'] = date('Y-m-d H:i:s');
        $data['updated_user'] = sessionData('user_id');
        $data['updated_date'] = date('Y-m-d H:i:s');

        if (isset($data['tanggal_lahir']) && $data['tanggal_lahir'] != '') {
            $data['tanggal_lahir'] = convertDateFormat($data['tanggal_lahir']);
        } else {
            $data['tanggal_lahir'] = NULL;
        }
        if (isset($data['tanggal_masuk']) && $data['tanggal_masuk'] != '') {
            $data['tanggal_masuk'] = convertDateFormat($data['tanggal_masuk']);
        } else {
            $data['tanggal_masuk'] = NULL;
        }

        $result = $this->Karyawan_model->create($data);

        echo json_encode($result);
    }

    public function update() {
        $data = inputPost();

        $idKaryawan = inputGet('id_karyawan');
        $data['updated_user'] = sessionData('user_id');
        $data['updated_date'] = date('Y-m-d H:i:s');

        if (isset($data['tanggal_lahir']) && $data['tanggal_lahir'] != '') {
            $data['tanggal_lahir'] = convertDateFormat($data['tanggal_lahir']);
        } else {
            $data['tanggal_lahir'] = NULL;
        }
        if (isset($data['tanggal_masuk']) && $data['tanggal_masuk'] != '') {
            $data['tanggal_masuk'] = convertDateFormat($data['tanggal_masuk']);
        } else {
            $data['tanggal_masuk'] = NULL;
        }

        $update = $this->Karyawan_model->update($idKaryawan, $data);

        echo json_encode($update);
    }

    public function deleteKaryawan() {
        $idKaryawan = inputPost('id_karyawan');
        $data['active'] = '0';

        $result = $this->Karyawan_model->update($idKaryawan, $data);

        echo json_encode($result);
    }

    public function activateKaryawan() {
        $idKaryawan = inputPost('id_karyawan');
        $data['active'] = '1';

        $result = $this->Karyawan_model->update($idKaryawan, $data);

        echo json_encode($result);
    }

    public function karyawanDetail() {
        $idKaryawan = inputGet('id_karyawan');

        $karyawan = $this->Karyawan_model->findById($idKaryawan);

        echo json_encode($karyawan);
    }

    function getPICNaskahJSON() {
        $karyawan = $this->Karyawan_model->getPICNaskahJSON();

        echo json_encode($karyawan);
    }
}