<?php

class Karyawan_model extends CI_Model {
    public function getPICNaskahJSON() {
        $karyawan = $this->db->where('active', '1')
                            ->order_by('nama', 'ASC')
                            ->get('t_karyawan')
                            ->result_array();

        return $karyawan;
    }
}