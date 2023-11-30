<?php

class Naskah_role_model extends CI_Model {
    protected $table = 'naskah_roles';

    public function __construct() {
        parent::__construct();
    }

    public function getAll() {
        $this->db->select("$this->table.*, GROUP_CONCAT(t_karyawan.nama) AS nama");
        $this->db->join('naskah_role_karyawan', "naskah_role_karyawan.role_key=$this->table.key", 'left');
        $this->db->join('t_karyawan', "t_karyawan.id_karyawan=naskah_role_karyawan.id_karyawan", 'left');
        $this->db->where('t_karyawan.active', '1');

        if (isset($filters) && $filters != [""] && count($filters)) {
            foreach ($filters as $filter) {
                $filter = explode('=', $filter);
    
                if ($filter[1] != '') {
                    $this->db->where($filter[0], $filter[1]);
                }
            }
        }

        $this->db->group_by("$this->table.key");

        $naskah_role = $this->db->get($this->table);

        $data = $naskah_role->result_array();
        $recordsTotal = $naskah_role->num_rows();

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

    public function getMappedKaryawans($key) {
        $mappedKaryawans = $this->db->select('t_karyawan.id_karyawan', 't_karyawan.nama')
                                    ->where('key', $key)
                                    ->where('t_karyawan.active', '1')
                                    ->join('naskah_role_karyawan', "naskah_role_karyawan.role_key=$this->table.key", 'left')
                                    ->join('t_karyawan', "t_karyawan.id_karyawan=naskah_role_karyawan.id_karyawan", 'left')
                                    ->get($this->table)
                                    ->result_array();

        return count($mappedKaryawans) > 0 ? $mappedKaryawans : [];
    }

    public function saveMapping($data) {
        $this->clearMapping($data[0]['role_key']);
        $this->db->insert_batch('naskah_role_karyawan', $data);

        return $this->db->affected_rows();
    }

    public function clearMapping($key) {
        return $this->db->where('role_key', $key)
                        ->delete('naskah_role_karyawan');
    }
}