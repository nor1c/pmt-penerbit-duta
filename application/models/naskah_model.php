<?php

class Naskah_model extends CI_Model {
    protected $table = 'naskah';
    protected $likeCols = ['judul'];

    public function __construct() {
        parent::__construct();
        $this->load->model(array('Holiday_model'));
    }

    public function getAll($searchableFields, $search, $filters, $pagination, $isPengajuan) {
        DBS()->select("$this->table.*, naskah_level_kerja.id_naskah as level_kerja");
        DBS()->from($this->table);
        DBS()->join('naskah_level_kerja', "naskah_level_kerja.id_naskah=$this->table.id", 'left');

        if ($search) {
            foreach($searchableFields as $field) {
                $this->db->or_like($field, $search);
            }
        }

        if (isset($filters) && $filters != [""] && count($filters)) {
            foreach ($filters as $filter) {
                $filter = explode('=', $filter);
    
                if ($filter[1] != '') {
                    if (in_array($filter[0], $this->likeCols)) {
                        DBS()->like($filter[0], $filter[1]);
                    } else {
                        DBS()->where($filter[0], $filter[1]);
                    }
                }
            }
        }

        if ($isPengajuan == 'true') {
            if (sessionData('id_jabatan') == 1) {
                DBS()->where('id_pengaju IS NOT NULL')->where('tgl_pengajuan IS NOT NULL')->where('is_pengajuan_processed', '0');
            } else {
                DBS()->where('id_pengaju IS NOT NULL')->where('tgl_pengajuan IS NOT NULL');
            }
        }
        
        DBS()->group_by("$this->table.id");
		DBS()->limit($pagination['length'], $pagination['start']);
        $naskah = DBS()->get();
        $data = $naskah->result_array();

        // count all records
        DBS()->from($this->table);

        if ($search) {
            foreach($searchableFields as $field) {
                $this->db->or_like($field, $search);
            }
        }

        if (isset($filters) && $filters != [""] && count($filters)) {
            foreach ($filters as $filter) {
                $filter = explode('=', $filter);
    
                if ($filter[1] != '') {
                    if (in_array($filter[0], $this->likeCols)) {
                        DBS()->like($filter[0], $filter[1]);
                    } else {
                        DBS()->where($filter[0], $filter[1]);
                    }
                }
            }
        }

        $tempdb = clone DBS();
		$recordsTotal = $tempdb->count_all_results('', FALSE);

        return [
            'data' => $data,
            'recordsTotal' => $recordsTotal
        ];
    }

    public function findById($id) {
        $naskah = DBS()->select("$this->table.*, master_jenjang.nama_jenjang, master_mapel.nama_mapel, master_kategori.nama_kategori, master_ukuran.nama_ukuran")
                ->from($this->table)
                ->join('master_jenjang', "master_jenjang.id=$this->table.id_jenjang", 'left')
                ->join('master_mapel', "master_mapel.id=$this->table.id_mapel", 'left')
                ->join('master_kategori', "master_kategori.id=$this->table.id_kategori", 'left')
                ->join('master_ukuran', "master_ukuran.id=$this->table.id_ukuran", 'left')
                ->where("$this->table.id", $id)
                ->limit(1)
                ->get()
                ->row();

        return $naskah;
    }

    public function findByNoJob($no_job) {
        $naskah = DBS()->select("$this->table.*, master_jenjang.nama_jenjang, master_mapel.nama_mapel, master_kategori.nama_kategori, master_ukuran.nama_ukuran")
                ->from($this->table)
                ->join('master_jenjang', "master_jenjang.id=$this->table.id_jenjang", 'left')
                ->join('master_mapel', "master_mapel.id=$this->table.id_mapel", 'left')
                ->join('master_kategori', "master_kategori.id=$this->table.id_kategori", 'left')
                ->join('master_ukuran', "master_ukuran.id=$this->table.id_ukuran", 'left')
                ->where("$this->table.no_job", $no_job)
                ->limit(1)
                ->get()
                ->row();

        return $naskah;
    }

    public function nextNaskahNoJob() {
        // first, we need to check if we have naskah ID with current year
        $is_current_year_naskah_exist = DBS()->select('no_job')->from($this->table)->like('no_job', date('Y', time()), 'after')->order_by('no_job', 'DESC')->limit(1)->get()->num_rows() > 0;
        if (!$is_current_year_naskah_exist) {
            return date('Y', time()) . str_pad(1, 4, '0', STR_PAD_LEFT);
        }

        $query = DBS()->select('no_job')->from($this->table)->order_by('no_job', 'DESC')->limit(1)->get();

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $last_id = (int)substr($row->no_job, 4);
        } else {
            $last_id = 0;
        }

        $next_number = $last_id+1;
        return date('Y',time()) . str_pad($next_number, 4, '0', STR_PAD_LEFT);
    }

    public function save($data) {
        $data['no_job'] = $this->nextNaskahNoJob();
        DBS()->insert('naskah', $data);

        return catchQueryResult(DBS()->_error_message());
    }

    public function update($data) {
        foreach ($data as $column => $value) {
            DBS()->set($column, $value);
        }

        DBS()->where('no_job', $data['no_job'])
            ->update($this->table);

        return catchQueryResult(DBS()->_error_message());
    }

    public function delete($no_job) {
        DBS()->where('no_job', $no_job)->delete($this->table);

        return catchQueryResult(DBS()->_error_message());
    }

    public function updateCover($naskahId, $coverFileName) {
        DBS()->set('cover', $coverFileName);
        DBS()->where('id', $naskahId)->update($this->table);

        return catchQueryResult(DBS()->_error_message());
    }

    public function getEndDate($duration, $startDate) {
        $query = "
            SELECT
                COUNT(*) AS total_off_days,
                DATE_ADD('$startDate', INTERVAL $duration - 1 DAY) AS end_date
            FROM holidays
            WHERE date BETWEEN '$startDate' AND DATE_ADD('$startDate', INTERVAL ($duration - 1) DAY);
        ";

        $result = DBS()->query($query)->row();

        $offDays = $result->total_off_days;
        $endDate = $result->end_date;

        for ($i=1; $i <= $offDays; $i++) { 
            $endDate = getNextDay($endDate);
            $isOffDay = $this->Holiday_model->isOffDay($endDate);

            if ($isOffDay) {
                $offDays+=1;
            }
        }
        
        return array(
            'offDays' => $offDays,
            'endDate' => $endDate,
        );
    }

    public function saveLevelKerja($data) {
        foreach ($data as $row) {
            $columns = implode(", ", array_map(function ($column) {
                return "`$column`";
            }, array_keys($row)));
            $values = implode("', '", $row);
            $sql = "INSERT INTO naskah_level_kerja ($columns) VALUES ('$values')";
            DBS()->query($sql);
        }

        return true;
    }

    public function deleteLevelKerja($naskahId) {
        return DBS()->where('id_naskah', $naskahId)->delete('naskah_level_kerja');
    }

    public function getNaskahLevelKerja($idNaskah) {
        $level_kerja = DBS()->where('id_naskah', $idNaskah)
                            ->from('naskah_level_kerja')
                            ->get()
                            ->result_array();

        return $level_kerja;
    }

    public function getNaskahLevelKerjaFull($idNaskah) {
        $level_kerja = DBS()->select('naskah_level_kerja.*, t_karyawan.nama')
                            ->where('id_naskah', $idNaskah)
                            ->from('naskah_level_kerja')
                            ->join('t_karyawan', 't_karyawan.id_karyawan=naskah_level_kerja.id_pic_aktif', 'left')
                            ->get()
                            ->result_array();

        return $level_kerja;
    }

    public function getProgressWithRealizationDate($idNaskah) {
        $query = "SELECT 
                nlk.`key`, nlk.tgl_rencana_mulai, nlk.tgl_rencana_selesai, npm.waktu_mulai, IF(nlk.status='finished', nlk.tgl_selesai, '') AS waktu_selesai, nlk.catatan_selesai as catatan
                FROM naskah_level_kerja nlk
                LEFT JOIN (
                    SELECT id_naskah, waktu_mulai, level_kerja_key
                    FROM naskah_progress
                    ORDER BY created_at ASC
                    LIMIT 1
                ) npm ON npm.id_naskah=nlk.id_naskah AND npm.level_kerja_key=nlk.`key`
                WHERE nlk.id_naskah=$idNaskah
                GROUP BY nlk.`key`";

        $progress = $this->db->query($query)->result_array();

        return $progress;
    }

    public function setAsProcessed($idNaskah) {
        return DBS()->where('id', $idNaskah)->update($this->table, array(
            'is_pengajuan_processed' => '1'
        ));
    }

    public function countPengajuan() {
        $activePengajuan = $this->db->select('COUNT(*) as total')->where('is_pengajuan', '1')->where('is_pengajuan_processed', '0')->from($this->table)->get()->row()->total;
        return $activePengajuan;
    }

    public function countSOPRequests() {
        $loginUserId = $this->session->userdata('user_id');
        $query = "SELECT
                    (SELECT COUNT(*) FROM sop_editing WHERE approver_id=$loginUserId AND approver_signature IS NULL AND is_send='1') +
                    (SELECT COUNT(*) FROM sop_koreksi_1 WHERE approver_id=$loginUserId AND approver_signature IS NULL AND is_send='1') +
                    (SELECT COUNT(*) FROM sop_koreksi_2 WHERE approver_id=$loginUserId AND approver_signature IS NULL AND is_send='1') +
                    (SELECT COUNT(*) FROM sop_koreksi_3 WHERE approver_id=$loginUserId AND approver_signature IS NULL AND is_send='1') +
                    (SELECT COUNT(*) FROM sop_pdf WHERE approver_id=$loginUserId AND approver_signature IS NULL AND is_send='1')
                AS total_requests";

        return $this->db->query($query)->row();
    }

    public function getProgressSOP($idNaskah) {
        $query = "SELECT
                    (SELECT approver_signed_by AS editing_done FROM sop_editing WHERE id_naskah=$idNaskah AND approver_signature IS NOT NULL) AS editing_done,
                    (SELECT approver_signed_by AS koreksi_1_done FROM sop_koreksi_1 WHERE id_naskah=$idNaskah AND approver_signature IS NOT NULL) AS koreksi_1_done,
                    (SELECT approver_signed_by AS koreksi_2_done FROM sop_koreksi_2 WHERE id_naskah=$idNaskah AND approver_signature IS NOT NULL) AS koreksi_2_done,
                    (SELECT approver_signed_by AS koreksi_3_done FROM sop_koreksi_3 WHERE id_naskah=$idNaskah AND approver_signature IS NOT NULL) AS koreksi_3_done,
                    (SELECT approver_signed_by AS pdf_done FROM sop_pdf WHERE id_naskah=$idNaskah AND approver_signature IS NOT NULL) AS pdf_done
                ";

        return DBS()->query($query)->row();
    }

    public function getSOPRequestList($searchableFields, $search, $filters, $pagination) {
        $select_query = "
            SELECT *
            FROM (
                (
                    SELECT naskah.id, naskah.no_job, naskah.judul, 'editing' AS type, t_karyawan.nama as nama_editor, sop_editing.send_date as tanggal_request
                    FROM sop_editing
                    LEFT JOIN naskah ON (naskah.id=sop_editing.id_naskah)
                    LEFT JOIN t_karyawan ON (t_karyawan.id_karyawan=sop_editing.pic_signed_by)
                    WHERE is_send='1' AND approver_signature IS NULL
                ) UNION
                (
                    SELECT naskah.id, naskah.no_job, naskah.judul, 'koreksi 1' AS type, t_karyawan.nama as nama_editor, sop_koreksi_1.send_date as tanggal_request
                    FROM sop_koreksi_1
                    LEFT JOIN naskah ON (naskah.id=sop_koreksi_1.id_naskah)
                    LEFT JOIN t_karyawan ON (t_karyawan.id_karyawan=sop_koreksi_1.pic_signed_by)
                    WHERE is_send='1' AND approver_signature IS NULL
                ) UNION
                (
                    SELECT naskah.id, naskah.no_job, naskah.judul, 'koreksi 2' AS type, t_karyawan.nama as nama_editor, sop_koreksi_2.send_date as tanggal_request
                    FROM sop_koreksi_2
                    LEFT JOIN naskah ON (naskah.id=sop_koreksi_2.id_naskah)
                    LEFT JOIN t_karyawan ON (t_karyawan.id_karyawan=sop_koreksi_2.pic_signed_by)
                    WHERE is_send='1' AND approver_signature IS NULL
                ) UNION
                (
                    SELECT naskah.id, naskah.no_job, naskah.judul, 'koreksi 3' AS type, t_karyawan.nama as nama_editor, sop_koreksi_3.send_date as tanggal_request
                    FROM sop_koreksi_3
                    LEFT JOIN naskah ON (naskah.id=sop_koreksi_3.id_naskah)
                    LEFT JOIN t_karyawan ON (t_karyawan.id_karyawan=sop_koreksi_3.pic_signed_by)
                    WHERE is_send='1' AND approver_signature IS NULL
                ) UNION
                (
                    SELECT naskah.id, naskah.no_job, naskah.judul, 'pdf' AS type, t_karyawan.nama as nama_editor, sop_pdf.send_date as tanggal_request
                    FROM sop_pdf
                    LEFT JOIN naskah ON (naskah.id=sop_pdf.id_naskah)
                    LEFT JOIN t_karyawan ON (t_karyawan.id_karyawan=sop_pdf.pic_signed_by)
                    WHERE is_send='1' AND approver_signature IS NULL
                )
            ) AS requests
            LIMIT " . $pagination['length'] . "
            OFFSET " . $pagination['start'] . "
        ";

        $data = DBS()->query($select_query)->result_array();

        // count all records
        $select_query = "
            SELECT COUNT(*) as total
            FROM (
                (
                    SELECT naskah.no_job, naskah.judul, 'editing' AS type
                    FROM sop_editing
                    LEFT JOIN naskah ON (naskah.id=sop_editing.id_naskah)
                ) UNION
                (
                    SELECT naskah.no_job, naskah.judul, 'koreksi' AS type
                    FROM sop_editing
                    LEFT JOIN naskah ON (naskah.id=sop_editing.id_naskah)
                )
            ) AS requests
        ";

        $recordsTotal = DBS()->query($select_query)->row()->total;

        return [
            'data' => $data,
            'recordsTotal' => $recordsTotal
        ];
    }

    public function sop_editing($idNaskah) {
        DBS()->select('sop_editing.*, tpic.nama as nama_pic, ta.nama as nama_approver');
        DBS()->where('id_naskah', $idNaskah);
        DBS()->from('sop_editing');
        DBS()->join('t_karyawan as tpic', 'tpic.id_karyawan=sop_editing.pic_signed_by', 'left');
        DBS()->join('t_karyawan as ta', 'ta.id_karyawan=sop_editing.approver_signed_by', 'left');
        $data = DBS()->get()->row();

        return $data;
    }

    public function save_sop_editing($data) {
        // check if record based on naskah ID is exists
        $foundRows = DBS()->where('id_naskah', $data['id_naskah'])->from('sop_editing')->get()->num_rows();
        
        if ($foundRows > 0) {
            $idNaskah = $data['id_naskah'];
            unset($data['id_naskah']);
            DBS()->where('id_naskah', $idNaskah)->update('sop_editing', $data);
        } else {
            DBS()->insert('sop_editing', $data);
        }
        
        return catchQueryResult(DBS()->_error_message());
    }

    public function sop_koreksi_1($idNaskah) {
        DBS()->select('sop_koreksi_1.*, tpic.nama as nama_pic, ta.nama as nama_approver');
        DBS()->where('id_naskah', $idNaskah);
        DBS()->from('sop_koreksi_1');
        DBS()->join('t_karyawan as tpic', 'tpic.id_karyawan=sop_koreksi_1.pic_signed_by', 'left');
        DBS()->join('t_karyawan as ta', 'ta.id_karyawan=sop_koreksi_1.approver_signed_by', 'left');
        $data = DBS()->get()->row();

        return $data;
    }

    public function save_sop_koreksi_1($data) {
        // check if record based on naskah ID is exists
        $foundRows = DBS()->where('id_naskah', $data['id_naskah'])->from('sop_koreksi_1')->get()->num_rows();
        
        if ($foundRows > 0) {
            $idNaskah = $data['id_naskah'];
            unset($data['id_naskah']);
            DBS()->where('id_naskah', $idNaskah)->update('sop_koreksi_1', $data);
        } else {
            DBS()->insert('sop_koreksi_1', $data);
        }
        
        return catchQueryResult(DBS()->_error_message());
    }

    public function sop_koreksi_2($idNaskah) {
        DBS()->select('sop_koreksi_2.*, tpic.nama as nama_pic, ta.nama as nama_approver');
        DBS()->where('id_naskah', $idNaskah);
        DBS()->from('sop_koreksi_2');
        DBS()->join('t_karyawan as tpic', 'tpic.id_karyawan=sop_koreksi_2.pic_signed_by', 'left');
        DBS()->join('t_karyawan as ta', 'ta.id_karyawan=sop_koreksi_2.approver_signed_by', 'left');
        $data = DBS()->get()->row();

        return $data;
    }

    public function save_sop_koreksi_2($data) {
        // check if record based on naskah ID is exists
        $foundRows = DBS()->where('id_naskah', $data['id_naskah'])->from('sop_koreksi_2')->get()->num_rows();
        
        if ($foundRows > 0) {
            $idNaskah = $data['id_naskah'];
            unset($data['id_naskah']);
            DBS()->where('id_naskah', $idNaskah)->update('sop_koreksi_2', $data);
        } else {
            DBS()->insert('sop_koreksi_2', $data);
        }
        
        return catchQueryResult(DBS()->_error_message());
    }

    public function sop_koreksi_3($idNaskah) {
        DBS()->select('sop_koreksi_3.*, tpic.nama as nama_pic, ta.nama as nama_approver');
        DBS()->where('id_naskah', $idNaskah);
        DBS()->from('sop_koreksi_3');
        DBS()->join('t_karyawan as tpic', 'tpic.id_karyawan=sop_koreksi_3.pic_signed_by', 'left');
        DBS()->join('t_karyawan as ta', 'ta.id_karyawan=sop_koreksi_3.approver_signed_by', 'left');
        $data = DBS()->get()->row();

        return $data;
    }

    public function save_sop_koreksi_3($data) {
        // check if record based on naskah ID is exists
        $foundRows = DBS()->where('id_naskah', $data['id_naskah'])->from('sop_koreksi_3')->get()->num_rows();
        
        if ($foundRows > 0) {
            $idNaskah = $data['id_naskah'];
            unset($data['id_naskah']);
            DBS()->where('id_naskah', $idNaskah)->update('sop_koreksi_3', $data);
        } else {
            DBS()->insert('sop_koreksi_3', $data);
        }
        
        return catchQueryResult(DBS()->_error_message());
    }

    public function sop_pdf($idNaskah) {
        DBS()->select('sop_pdf.*, tpic.nama as nama_pic, ta.nama as nama_approver');
        DBS()->where('id_naskah', $idNaskah);
        DBS()->from('sop_pdf');
        DBS()->join('t_karyawan as tpic', 'tpic.id_karyawan=sop_pdf.pic_signed_by', 'left');
        DBS()->join('t_karyawan as ta', 'ta.id_karyawan=sop_pdf.approver_signed_by', 'left');
        $data = DBS()->get()->row();

        return $data;
    }

    public function save_sop_pdf($data) {
        // check if record based on naskah ID is exists
        $foundRows = DBS()->where('id_naskah', $data['id_naskah'])->from('sop_pdf')->get()->num_rows();
        
        if ($foundRows > 0) {
            $idNaskah = $data['id_naskah'];
            unset($data['id_naskah']);
            DBS()->where('id_naskah', $idNaskah)->update('sop_pdf', $data);
        } else {
            DBS()->insert('sop_pdf', $data);
        }
        
        return catchQueryResult(DBS()->_error_message());
    }
}