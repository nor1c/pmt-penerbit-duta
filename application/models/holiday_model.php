<?php

class Holiday_model extends CI_Model {
    protected $table = 'holidays';

    public function __construct() {
        parent::__construct();
    }

    public function getAll($searchableFields, $search, $filters, $pagination) {
        $this->db->from($this->table);

        if ($search) {
            foreach($searchableFields as $field) {
                $this->db->or_like($field, $search);
            }
        }

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

    public function checkDate($date) {
        $formattedDate = convertDateFormat($date);

        $foundDate = $this->db->where('date', $formattedDate)
                            ->get($this->table)
                            ->row();

        return $foundDate;
    }

    public function create($data) {
        DBS()->insert($this->table, $data);

        return catchQueryResult(DBS()->_error_message(), DBS()->_error_number());
    }

    public function isOffDay($date) {
        $count = DBS()->where('date', $date)->get($this->table)->num_rows();

        return $count > 0 ? true : false;
    }

    public function insertWeekendDates($weekendDates) {
        foreach ($weekendDates as $date) {
            $this->db->query("INSERT IGNORE INTO holidays (date, title) VALUES ('$date', 'Weekend')");
        }
    }
}