<?php

class Report extends DUTA_Controller {
    private $userId;
    private $searchableFields = ['no_job', 'kode', 'judul', 'penulis'];

    public function __construct() {
        parent::__construct();
        
        $this->load->model(array('Report_model', 'Naskah_model', 'Naskah_role_model'));
        $this->load->library('template');
        $this->userId = sessionData('user_id');
    }

    /**
     * Get report for naskah job by daily
     */
    public function daily() {
        $data['jenjangs'] = $this->Jenjang_model->getDropdown();
        $data['mapels'] = $this->Mapel_model->getDropdown();
        $data['kategoris'] = $this->Kategori_model->getDropdown();
        $data['ukurans'] = $this->Ukuran_model->getDropdown();
        $data['pics'] = $this->Karyawan_model->getPICNaskahJSON();
        $data['level_kerja'] = $this->keyMap;

        $this->template->display('report/job/by-daily', $data);
    }

    public function dailyData() {
        $pagination = array(
            'start' => $this->input->post('start'),
            'length' => $this->input->post('length')
        );

        $search = inputPost('search')['value'];
        $filters = explode('&', $this->input->post('filters'));

        $naskah = $this->Report_model->dailyData($this->searchableFields, $search, $filters, $pagination);

        $formattedData = array_map(function ($item) {
            return ['', $item['no_job'], $item['judul'], $this->keyMap[$item['level_kerja']]['text'], $item['nama'], $item['waktu_mulai'], $item['waktu_selesai'], $item['halaman'] . ' hal'];
        }, $naskah['data']);

        $data = [
            'recordsTotal' => $naskah['recordsTotal'],
            'recordsFiltered' => $naskah['recordsTotal'],
            'data' => $formattedData
        ];

        echo json_encode($data);
    }

    public function dailyExport() {
        $pagination = array(
            'start' => 0,
            'length' => 9999999999
        );
        $search = inputPost('search')['value'];
        $filters = explode('&', $this->input->post('filters'));

        $data['naskah'] = $this->Report_model->dailyData($this->searchableFields, $search, $filters, $pagination);
        $data['keyMap'] = $this->keyMap;

        $this->load->view('report/job/daily-export', $data);
    }

    /**
     * Get report for naskah job by Naskah
     */
    public function naskah() {
        $data['jenjangs'] = $this->Jenjang_model->getDropdown();
        $data['mapels'] = $this->Mapel_model->getDropdown();
        $data['kategoris'] = $this->Kategori_model->getDropdown();
        $data['ukurans'] = $this->Ukuran_model->getDropdown();

        $data['default_level_kerja'] = [
            ['key' => 'penulisan', 'id_naskah' => null, 'durasi' => null, 'pic_role' => null, 'tgl_rencana_mulai' => null, 'tgl_rencana_selesai' => null, 'total_libur' => null, 'is_disabled' => 0, 'id_pic_aktif' => null, 'status' => 'open'],
            ['key' => 'editing', 'id_naskah' => null, 'durasi' => null, 'pic_role' => null, 'tgl_rencana_mulai' => null, 'tgl_rencana_selesai' => null, 'total_libur' => null, 'is_disabled' => 0, 'id_pic_aktif' => null, 'status' => 'open'],
            ['key' => 'setting_1', 'id_naskah' => null, 'durasi' => null, 'pic_role' => null, 'tgl_rencana_mulai' => null, 'tgl_rencana_selesai' => null, 'total_libur' => null, 'is_disabled' => 0, 'id_pic_aktif' => null, 'status' => 'open'],
            ['key' => 'koreksi_1', 'id_naskah' => null, 'durasi' => null, 'pic_role' => null, 'tgl_rencana_mulai' => null, 'tgl_rencana_selesai' => null, 'total_libur' => null, 'is_disabled' => 0, 'id_pic_aktif' => null, 'status' => 'open'],
            ['key' => 'setting_2', 'id_naskah' => null, 'durasi' => null, 'pic_role' => null, 'tgl_rencana_mulai' => null, 'tgl_rencana_selesai' => null, 'total_libur' => null, 'is_disabled' => 0, 'id_pic_aktif' => null, 'status' => 'open'],
            ['key' => 'koreksi_2', 'id_naskah' => null, 'durasi' => null, 'pic_role' => null, 'tgl_rencana_mulai' => null, 'tgl_rencana_selesai' => null, 'total_libur' => null, 'is_disabled' => 0, 'id_pic_aktif' => null, 'status' => 'open'],
            ['key' => 'setting_3', 'id_naskah' => null, 'durasi' => null, 'pic_role' => null, 'tgl_rencana_mulai' => null, 'tgl_rencana_selesai' => null, 'total_libur' => null, 'is_disabled' => 0, 'id_pic_aktif' => null, 'status' => 'open'],
            ['key' => 'koreksi_3', 'id_naskah' => null, 'durasi' => null, 'pic_role' => null, 'tgl_rencana_mulai' => null, 'tgl_rencana_selesai' => null, 'total_libur' => null, 'is_disabled' => 0, 'id_pic_aktif' => null, 'status' => 'open'],
            ['key' => 'pdf', 'id_naskah' => null, 'durasi' => null, 'pic_role' => null, 'tgl_rencana_mulai' => null, 'tgl_rencana_selesai' => null, 'total_libur' => null, 'is_disabled' => 0, 'id_pic_aktif' => null, 'status' => 'open'],
        ];
        $data['level_kerja_key_map'] = $this->keyMap;
        $data['level_kerja_key_map_as_json'] = json_encode($this->keyMap);
        $data['roles_karyawan'] = $this->Naskah_role_model->getEveryPICs();

        $this->template->display('report/job/by-naskah.php', $data);
    }

    public function naskahData() {
        $pagination = array(
            'start' => $this->input->post('start'),
            'length' => $this->input->post('length')
        );

        $search = inputPost('search')['value'];
        $filters = explode('&', $this->input->post('filters'));

        $naskah = $this->Report_model->naskahData($this->searchableFields, $search, $filters, $pagination);

        $formattedData = array_map(function ($item) {
            return ['', $item['no_job'], $item['kode'], $item['judul'], $item['jilid'], $item['penulis'], $item['level_kerja']];
        }, $naskah['data']);

        $data = [
            'recordsTotal' => $naskah['recordsTotal'],
            'recordsFiltered' => $naskah['recordsTotal'],
            'data' => $formattedData
        ];

        echo json_encode($data);
    }

    public function naskahView() {
        $noJob = uriSegment(3);

        $data['naskah'] = $this->Naskah_model->findByNoJob($noJob);

        $this->template->display('report/job/naskah-view.php', $data);
    }
}