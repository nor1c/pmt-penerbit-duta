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

    public function getLastInsertedNaskahId() {
        $query = $this->db->select('id')->from($this->table)->order_by('id', 'DESC')->limit(1)->get();

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $last_id = $row->id;
        } else {
            $last_id = 0;
        }

        return $last_id+1;
    }

    public function save($data) {
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