<?php

class Proses_job_model extends CI_Model {
    protected $lk_table = 'naskah_level_kerja';
    protected $progress_table = 'naskah_progress';

    public function __construct() {
        parent::__construct();
    }

    public function getAll($page, $perPage) {
        $queryFrom = "FROM naskah
                    LEFT JOIN (
                        SELECT 
                            lk.total,
                            naskah.id as id_naskah, naskah.no_job, naskah.kode, naskah.judul, 
                            nlk.`order`, nlk.`key` AS level, nlk.tgl_rencana_mulai, nlk.tgl_rencana_selesai, nlk.catatan_cicil AS catatan, nlk.tgl_cicil, nlk.durasi, nlk.status,
                            t_karyawan.nama,
                            IF(np.total_hari IS NULL, 0, np.total_hari) AS progress_hari
                        FROM naskah_level_kerja AS nlk
                        LEFT JOIN (
                            SELECT COUNT(*) AS total, naskah_level_kerja.id_naskah
                            FROM naskah_level_kerja
                            WHERE naskah_level_kerja.tgl_rencana_mulai IS NOT NULL
                            GROUP BY naskah_level_kerja.id_naskah
                        ) lk ON lk.id_naskah=nlk.id_naskah
                        LEFT JOIN naskah ON naskah.id=nlk.id_naskah
                        LEFT JOIN (
                            SELECT id_naskah, level_kerja_key, COUNT(DISTINCT DATE(waktu_mulai)) AS total_hari
                            FROM naskah_progress
                            GROUP BY DATE(created_at)
                        ) np ON np.id_naskah=nlk.id_naskah AND np.level_kerja_key=nlk.`key`
                        LEFT JOIN t_karyawan ON t_karyawan.id_karyawan=nlk.id_pic_aktif
                        WHERE nlk.tgl_rencana_mulai IS NOT NULL
                        GROUP BY nlk.`key`, nlk.id_naskah
                    ) as nlk2 ON nlk2.id_naskah=naskah.id";

        $query = "SELECT
                        naskah.no_job, naskah.kode, naskah.judul,
                        nlk2.total,
                        CONCAT('[', 
                            GROUP_CONCAT(
                                JSON_OBJECT(
                                    'total', nlk2.total,
                                    'order', nlk2.`order`,
                                    'id_naskah', nlk2.id_naskah,
                                    'no_job', nlk2.no_job,
                                    'kode', nlk2.kode,
                                    'judul', nlk2.judul,
                                    'level', nlk2.level,
                                    'tgl_rencana_mulai', nlk2.tgl_rencana_mulai,
                                    'tgl_rencana_selesai', nlk2.tgl_rencana_selesai,
                                    'durasi', nlk2.durasi,
                                    'status', nlk2.status,
                                    'catatan', nlk2.catatan,
                                    'tgl_cicil', nlk2.tgl_cicil,
                                    'nama', nlk2.nama,
                                    'progress_hari', nlk2.progress_hari
                                )
                        )
                        ,']') AS lk_data
                        $queryFrom ";

        $countFoundRecordQuery = "SELECT COUNT(*) as foundRows FROM naskah";

        $query .= "GROUP BY naskah.id
                ORDER BY naskah.created_at DESC
                LIMIT $perPage
                OFFSET $page";

        $foundRows = DBS()->query($countFoundRecordQuery)->row();
        $jobs = DBS()->query($query)->result_array();

        return array(
            'foundRows' => $foundRows->foundRows,
            'jobs' => $jobs,
        );
    }

    public function assignTaskTo($naskahId, $levelKerja, $picId) {
        $data = array(
            'id_pic_aktif' => $picId
        );

        $updated = DBS()->where('id_naskah', $naskahId)
                        ->where('key', $levelKerja)
                        ->update($this->lk_table, $data);

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
}