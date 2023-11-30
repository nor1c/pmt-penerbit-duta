<?php

class Jenjang_model extends CI_Model {
    protected $table = 'master_jenjang';

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

        $jenjang = $this->db->get($this->table);

        $data = $jenjang->result_array();
        $recordsTotal = $jenjang->num_rows();

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