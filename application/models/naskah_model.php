<?php

class Naskah_model extends CI_Model {
    protected $table = 'naskah';

    public function __construct() {
        parent::__construct();
    }

    public function getAll() {
        $naskah = $this->db->get($this->table);

        $data = $naskah->result_array();
        $recordsTotal = $naskah->num_rows();

        return [
            'data' => $data,
            'recordsTotal' => $recordsTotal
        ];
    }

    public function save($data) {
        $this->db->insert('naskah', $data);

        return $this->db->affected_rows();
    }

    public function delete($no_job) {
        $delete = $this->db->where('no_job', $no_job)
                           ->delete($this->table);

        return $this->db->affected_rows();
    }
}