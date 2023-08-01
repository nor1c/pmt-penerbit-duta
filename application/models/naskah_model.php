<?php

class Naskah_model extends CI_Model {
    protected $table = 'naskah';

    public function __construct() {
        parent::__construct();
    }

    public function getAll($filters) {
        if (isset($filters) && $filters != [""] && count($filters)) {
            foreach ($filters as $filter) {
                $filter = explode('=', $filter);
    
                if ($filter[1] != '') {
                    $this->db->where($filter[0], $filter[1]);
                }
            }
        }

        $naskah = $this->db->get($this->table);

        $data = $naskah->result_array();
        $recordsTotal = $naskah->num_rows();

        return [
            'data' => $data,
            'recordsTotal' => $recordsTotal
        ];
    }

    public function findByNoJob($no_job) {
        $naskah = $this->db->where('no_job', $no_job)
                           ->get($this->table)
                           ->result_array();

        return $naskah;
    }

    public function nextNaskahNoJob() {
        // first, we need to check if we have naskah ID with current year
        $is_current_year_naskah_exist = $this->db->select('no_job')->from($this->table)->like('no_job', date('Y', time()), 'after')->order_by('no_job', 'DESC')->limit(1)->get()->num_rows() > 0;
        if (!$is_current_year_naskah_exist) {
            return date('Y', time()) . str_pad(1, 4, '0', STR_PAD_LEFT);
        }

        $query = $this->db->select('no_job')->from($this->table)->order_by('no_job', 'DESC')->limit(1)->get();

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
        $this->db->insert('naskah', $data);

        return $this->db->affected_rows();
    }

    public function update($data) {
        foreach ($data as $column => $value) {
            $this->db->set($column, $value);
        }

        $this->db->where('no_job', $data['no_job'])
                 ->update($this->table);

        return $this->db->affected_rows();
    }

    public function delete($no_job) {
        $delete = $this->db->where('no_job', $no_job)
                           ->delete($this->table);

        return $this->db->affected_rows();
    }
}