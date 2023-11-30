<?php

class Karyawan_model extends CI_Model {
    public function getPICNaskahJSON() {
        $karyawan = $this->db->where('active', '1')
                            ->get('t_karyawan')
                            ->result_array();

        return $karyawan;
    }
}