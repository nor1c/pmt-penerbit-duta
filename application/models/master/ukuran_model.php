<?php

class Ukuran_model extends CI_Model {
    protected $table = 'master_ukuran';

    public function __construct() {
        parent::__construct();
    }

    public function getAll() {
        if (isset($filters) && $filters != [""] && count($filters)) {
            foreach ($filters as $filter) {
                $filter = explode('=', $filter);
    
                if ($filter[1] != '') {
                    $this->db->where($filter[0], $filter[1]);
                }
            }
        }

        $ukuran = $this->db->get($this->table);

        $data = $ukuran->result_array();
        $recordsTotal = $ukuran->num_rows();

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
}