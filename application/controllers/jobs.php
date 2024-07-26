<?php

class Jobs extends DUTA_Controller {
    private $userId;
    private $searchableFields = array('no_job', 'kode', 'judul');

    public function __construct() {
        parent::__construct();
        
        $this->load->model(array('Job_model', 'Naskah_model', 'Naskah_role_model'));
        $this->load->library('template');
        $this->userId = sessionData('user_id');
    }

    public function my_job() {
        $pagination = array(
            'start' => $this->input->post('start'),
            'length' => $this->input->post('length')
        );

        $search = inputPost('search')['value'];
        $filters = explode('&', $this->input->post('filters'));

        $naskah = $this->Job_model->getMyJob($this->searchableFields, $search, $filters, $pagination);

        $formattedData = array_map(function ($item) {
            return ['', $item['kode'], $item['no_job'], $item['judul'], $item['halaman'], $item['realisasi'], $item['key'], $item['tgl_rencana_mulai'], $item['tgl_rencana_selesai'], $item['status'], $item['catatan_cicil']];
        }, $naskah['data']);

        $data = array(
            'recordsTotal' => $naskah['recordsTotal'],
            'recordsFiltered' => $naskah['recordsTotal'],
            'data' => $formattedData
        );

        echo json_encode($data);
    }

    public function startLevelKerja() {
        $noJob = inputPost('noJob');
        $levelKerja = inputPost('levelKerja');

        // get naskah detail
        $naskahDetail = $this->Naskah_model->findByNoJob($noJob);

        // cek apakah level kerja dalam 1 naskah ada yg sedang dalam proses on_progress atau tidak
        $activeLevelKerja = $this->Job_model->getActiveLevelKerjaInTheSameNaskah($naskahDetail->id);
        if ($activeLevelKerja != null && $activeLevelKerja->key != $levelKerja) {
            echo json_encode(errorResponse('Tidak dapat memulai level kerja ini dikarenakan level kerja ' . $this->keyMap[$activeLevelKerja->key]['text'] . ' sedang berjalan.'));
            die;
        }

        // cek apakah level kerja sebelumnya sudah selesai (berstatus finished)
        $previousLevelKerjaStatus = $this->Job_model->getPreviousLevelKerjaStatus($naskahDetail->id, $levelKerja);
        if ($previousLevelKerjaStatus != null && ($previousLevelKerjaStatus != 'finished' || $previousLevelKerjaStatus != 'cicil')) {
            echo json_encode(errorResponse('Tidak dapat memulai level kerja ini dikarenakan level kerja sebelumnya belum selesai.'));
            die;
        }

        // start level kerja
        $changeResponse = $this->Job_model->changeLevelKerjaStatus($naskahDetail->id, $levelKerja, 'on_progress');

        echo json_encode($changeResponse);
    }

    public function tundaLevelKerja() {
        $noJob = inputPost('noJob');
        $levelKerja = inputPost('levelKerja');

        // get naskah detail
        $naskahDetail = $this->Naskah_model->findByNoJob($noJob);

        // tunda level kerja
        $changeResponse = $this->Job_model->changeLevelKerjaStatus($naskahDetail->id, $levelKerja, 'paused');

        echo json_encode($changeResponse);
    }

    public function viewJob() {
        $noJob = inputGet('noJob');
        $levelKerja = inputGet('levelKerja');

        $jobDetail = $this->Job_model->viewJob($noJob, $levelKerja);
        $naskahDetail = $this->Naskah_model->findByNoJob($noJob);
        $naskahLevelKerja = $this->Job_model->getProgressEachLevelKerja($naskahDetail->id);
        $naskahProgress = $this->Job_model->getProgressHalaman($naskahDetail->id, $levelKerja);
        $naskahProgressDays = $this->Job_model->getProgressDays($this->userId, $naskahDetail->id, $levelKerja);

        echo json_encode(
            array(
                'chart' => $jobDetail,
                'naskah' => $naskahDetail,
                'level_kerja' => $naskahLevelKerja,
                'progress' => $naskahProgress,
                'days' => $naskahProgressDays
            )
        );
    }

    public function getStatusLevelKerja() {
        $noJob = inputGet('noJob');
        $levelKerja = inputGet('levelKerja');

        $status = $this->Job_model->getStatusLevelKerja($noJob, $levelKerja);

        echo json_encode($status);
    }

    public function checkActiveJob() {
        $activeJob = $this->Job_model->getActiveJob($this->userId);

        echo json_encode($activeJob);
    }

    public function startJob() {
        $naskahId = inputPost('naskahId');
        $levelKerja = inputPost('levelKerja');

        // insert new empty progress
        $newProgress = $this->Job_model->startJob($naskahId, $levelKerja, $this->userId);

        echo json_encode($newProgress);
    }

    public function reportDailyProgress() {
        $data = inputPost('data');
        $data['waktu_selesai'] = date('Y-m-d H:i:s', time());

        $result = $this->Job_model->saveDailyReport($this->userId, $data);

        echo json_encode($result);
    }

    public function dailyJobReport() {
        $pagination = array(
            'start' => $this->input->post('start'),
            'length' => $this->input->post('length')
        );

        $search = inputPost('search')['value'];
        $filters = explode('&', $this->input->post('filters'));

        $reports = $this->Job_model->getDailyJobReport($this->searchableFields, $search, $filters, $pagination);

        $formattedData = array_map(function ($item) {
            return ['', date('d/m/Y H:i', strtotime($item['waktu_mulai'])), $item['waktu_selesai'] ? date('d/m/Y H:i', strtotime($item['waktu_selesai'])) : 0, $item['nama'], $this->keyMap[$item['level_kerja_key']]['text'], $item['judul'], $item['catatan'], $item['kode'], $item['no_job'], $item['halaman'], $item['tgl_rencana_mulai'], $item['tgl_rencana_selesai'], $item['durasi'], $item['total_libur']];
        }, $reports['data']);

        $data = array(
            'recordsTotal' => $reports['recordsTotal'],
            'recordsFiltered' => $reports['recordsTotal'],
            'data' => $formattedData
        );

        echo json_encode($data);
    }

    public function kirimJob() {
        $data = inputPost('data');
        $data['tgl_cicil'] = date('Y-m-d H:i:s', time());
        $data['id_pic_penyicil'] = $this->userId;

        $naskahDetail = $this->Naskah_model->findByNoJob($data['noJob']);
        $data['naskahId'] = $naskahDetail->id;

        $result = $this->Job_model->kirimJob($data);

        echo json_encode($result);
    }

    public function finishJob() {
        $data = inputPost('data');
        $data['tgl_selesai'] = date('Y-m-d', time());

        $naskahDetail = $this->Naskah_model->findByNoJob($data['noJob']);
        $data['naskahId'] = $naskahDetail->id;

        $result = $this->Job_model->finishJob($data);

        echo json_encode($result);
    }
}