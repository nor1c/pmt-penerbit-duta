<?php

class Job_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    public function getMyJob($searchableFields, $search, $filters, $pagination) {
        DBS()->select("naskah.no_job, naskah.kode, naskah.judul, naskah.halaman, naskah_level_kerja.key, naskah_level_kerja.tgl_rencana_mulai, naskah_level_kerja.tgl_rencana_selesai, naskah_level_kerja.status");
        DBS()->from("naskah_level_kerja");
        DBS()->join("naskah", "naskah.id=naskah_level_kerja.id_naskah", "left");

        $userLoginId = sessionData('user_id');
        DBS()->where('naskah_level_kerja.id_pic_aktif', $userLoginId);

        DBS()->group_by("naskah_level_kerja.order, naskah_level_kerja.key");

        $tempdb = clone DBS();
		$recordsTotal = $tempdb->count_all_results('', FALSE);
        
		DBS()->limit($pagination['length'], $pagination['start']);
        $query = DBS()->get();
        $data = $query->result_array();

        return array(
            'data' => $data,
            'recordsTotal' => $recordsTotal
        );
    }

    public function getActiveLevelKerjaInTheSameNaskah($naskahId) {
        $activeLevelKerja = DBS()->select('key')
                                ->where('id_naskah', $naskahId)
                                ->where('status', 'on_progress')
                                ->limit(1)
                                ->get('naskah_level_kerja')
                                ->row();

        return $activeLevelKerja ?? null;
    }

    public function viewJob($noJob, $levelKerja) {
        // first we need to get the naskah id
        $naskahId = DBS()->select('id')->where('no_job', $noJob)->get('naskah')->row()->id;
        
        // get job detail
        DBS()->select('naskah_level_kerja.durasi, naskah_level_kerja.tgl_rencana_mulai, naskah_level_kerja.tgl_rencana_selesai, naskah_level_kerja.total_libur, naskah_level_kerja.status');
        DBS()->where('id_naskah', $naskahId);
        DBS()->where('key', $levelKerja);
        DBS()->from('naskah_level_kerja');

        $detail = DBS()->get()->row();

        return $detail;
    }

    public function getProgressEachLevelKerja($naskahId) {
        $query = "SELECT
            lk.*, t_karyawan.nama, p.total_hari
            FROM naskah_level_kerja AS lk
            LEFT JOIN (
                SELECT id_naskah, level_kerja_key, COUNT(DISTINCT DATE(waktu_mulai)) AS total_hari
                FROM naskah_progress
                WHERE id_naskah='$naskahId'
            ) p ON (p.id_naskah=lk.id_naskah AND p.level_kerja_key=lk.key)
            LEFT JOIN t_karyawan ON (t_karyawan.id_karyawan=lk.id_pic_aktif)
            WHERE lk.id_naskah='$naskahId'";

        return DBS()->query($query)->result();
    }

    public function getProgressHalaman($naskahId) {
        $progress = DBS()->select('SUM(halaman) as halaman')
                        ->where('id_naskah', $naskahId)
                        ->get('naskah_progress')
                        ->row();
                    
        return $progress;
    }

    public function getProgressDays($picId, $naskahId, $levelKerja) {
        $progress = DBS()->select('COUNT(DISTINCT DATE(waktu_mulai)) as days')
                        ->where('id_naskah', $naskahId)
                        ->where('level_kerja_key', $levelKerja)
                        ->where('id_pic', $picId)
                        ->get('naskah_progress')
                        ->row();

        return $progress;
    }

    public function getActiveJob($userId) {
        $activeJob = DBS()->select('id_naskah, level_kerja_key, waktu_mulai')
                        ->from('naskah_progress')
                        ->where('id_pic', $userId)
                        ->where('waktu_selesai', NULL)
                        ->where('halaman', NULL)
                        ->get()->row();

        if (!$activeJob) {
            return array();
        }

        $naskah = $this->Naskah_model->findById($activeJob->id_naskah);

        return array(
            'noJob' => $naskah->no_job,
            'levelKerja' => $activeJob->level_kerja_key,
            'waktuMulai' => $activeJob->waktu_mulai,
        );
    }

    public function getRunningJob($levelKerja, $naskahId, $userId) {
        $exists = DBS()->where('level_kerja_key', $levelKerja)
                    ->where('id_naskah', $naskahId)
                    ->where('id_pic', $userId)
                    ->where('waktu_selesai', NULL)
                    ->where('halaman', NULL)
                    ->get('naskah_progress')
                    ->num_rows();

        return $exists;
    }

    public function startJob($naskahId, $levelKerja, $userId) {
        // make sure data not duplicated
        $exists = $this->getRunningJob($levelKerja, $naskahId, $userId);
        if ($exists) {
            return catchQueryResult('Pengerjaan level kerja ini sedang berlangsung, harap stop progress sebelumnya!');
        }

        $data = array(
            'id_naskah' => $naskahId,
            'level_kerja_key' => $levelKerja,
            'id_pic' => $userId,
            'waktu_mulai' => date('Y-m-d H:i:s', time()),
        );

        DBS()->insert('naskah_progress', $data);

        if (DBS()->_error_message()) {
            return catchQueryResult(DBS()->_error_message());
        } else {
            // change status to on_progress
            $changeStatus = $this->changeLevelKerjaStatus($naskahId, $levelKerja, 'on_progress');
            if ($changeStatus['success'] == true) {
                return catchQueryResult('');
            } else {
                return catchQueryResult($changeStatus['message']);
            }
        }
    }

    public function changeLevelKerjaStatus($naskahId, $levelKerja, $status) {
        $data = array(
            'status' => $status
        );

        $updated = DBS()->where('id_naskah', $naskahId)
            ->where('key', $levelKerja)
            ->update('naskah_level_kerja', $data);
        
        if (!$updated) {
            return catchQueryResult(DBS()->_error_message());
        }

        if (DBS()->_error_message()) {
            return array(
                'success' => false,
                'message' => DBS()->_error_message(),
            );
        } else {
            return array(
                'success' => true
            );
        }
    }

    public function saveDailyReport($picId, $data) {
        $exists = DBS()->where('id_pic', $picId)
                    ->where('waktu_selesai', NULL)
                    ->where('halaman', NULL)
                    ->get('naskah_progress')
                    ->num_rows();
        if (!$exists) {
            return catchQueryResult('Pekerjaan belum dimulai!');
        }
        
        // change status to on_progress
        $changeStatus = $this->changeLevelKerjaStatus($data['naskahId'], $data['levelKerja'], 'open');
        if ($changeStatus['success'] == true) {
            // update progress
            DBS()->where('id_pic', $picId)
                ->where('waktu_selesai', NULL)
                ->where('halaman', NULL)
                ->update('naskah_progress', array(
                    'waktu_selesai' => $data['waktu_selesai'],
                    'halaman' => $data['halaman'],
                ));
    
            return catchQueryResult(DBS()->_error_message());
        } else {
            return catchQueryResult($changeStatus['message']);
        }
    }

    public function getDailyJobReport($searchableFields, $search, $filters, $pagination) {
        DBS()->select("naskah_progress.created_at as tanggal, t_karyawan.nama, naskah_progress.level_kerja_key, naskah.judul, naskah_progress.catatan, naskah.kode, naskah.no_job, naskah_progress.halaman, naskah_level_kerja.tgl_rencana_mulai, naskah_level_kerja.tgl_rencana_selesai, naskah_level_kerja.durasi, naskah_level_kerja.total_libur");
        DBS()->from("naskah_progress");
        DBS()->join("naskah", "naskah.id=naskah_progress.id_naskah", "left");
        DBS()->join("t_karyawan", "naskah_progress.id_pic=t_karyawan.id_karyawan", "left");
        DBS()->join("naskah_level_kerja", "naskah_level_kerja.key=naskah_progress.level_kerja_key AND naskah_level_kerja.id_naskah=naskah_progress.id_naskah", "left");

        $userLoginId = sessionData('user_id');
        DBS()->where('naskah_progress.id_pic', $userLoginId);

        DBS()->group_by("naskah_progress.created_at, naskah_progress.id_naskah, naskah_progress.id_pic");
        DBS()->order_by("naskah_progress.created_at", "DESC");

        $tempdb = clone DBS();
		$recordsTotal = $tempdb->count_all_results('', FALSE);
        
		DBS()->limit($pagination['length'], $pagination['start']);
        $query = DBS()->get();
        $data = $query->result_array();

        return array(
            'data' => $data,
            'recordsTotal' => $recordsTotal
        );
    }
}