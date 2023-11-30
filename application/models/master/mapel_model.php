<?php

class Mapel_model extends CI_Model {
    protected $table = 'master_mapel';

    public function __construct() {
        parent::__construct();
    }

    public function getAll($filters, $pagination) {
        $this->db->from($this->table);

        if (isset($filters) && $filters != [""] && count($filters)) {
            foreach ($filters as $filter) {
                $filter = explode('=', $filter);
    
                if ($filter[1] != '') {
                    $this->db->where($filter[0], $filter[1]);
                }
            }
        }

        $tempdb = clone $this->db;
		$recordsTotal = $tempdb->count_all_results('', FALSE);

		$this->db->limit($pagination['length'], $pagination['start']);

        $mapel = $this->db->get();

        $data = $mapel->result_array();

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