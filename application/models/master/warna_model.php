<?php

class Warna_model extends CI_Model {
    protected $table = 'master_warna';

    public function __construct() {
        parent::__construct();
    }

    public function getAll() {
        $this->db->order_by('id', 'desc');
        $warna = $this->db->get($this->table);

        $data = $warna->result_array();
        $recordsTotal = $warna->num_rows();

        return [
            'data' => $data,
            'recordsTotal' => $recordsTotal
        ];
    }

    public function getDropdown() {
        return $this->db->where('is_active', '1')
                        ->get($this->table)
                        ->result_array();
    }

    public function findById($id) {
        return DBS()->from($this->table)
                    ->where('id', $id)
                    ->limit(1)
                    ->get()
                    ->row();
    }

    public function create($data) {
        DBS()->insert($this->table, $data);

        return catchQueryResult(DBS()->_error_message(), DBS()->_error_number());
    }

    public function update($id, $data) {
        DBS()->where('id', $id)->update($this->table, $data);

        return catchQueryResult(DBS()->_error_message(), DBS()->_error_number());
    }

    public function delete($id) {
        DBS()->where('id', $id)->delete($this->table);

        return catchQueryResult(DBS()->_error_message(), DBS()->_error_number());
    }
}