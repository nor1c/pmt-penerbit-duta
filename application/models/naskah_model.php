<?php

class Naskah_model extends CI_Model {
    protected $table = 'naskah';
    protected $likeCols = ['judul'];

    public function __construct() {
        parent::__construct();
        loadModel(array('Holiday_model'));
    }

    public function getAll($searchableFields, $search, $filters, $pagination) {
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
}