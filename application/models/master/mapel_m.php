<?php

class Mapel_m extends CI_Model {
    public function getAll() {
        return $this->db->where('is_active', 1)
                        ->get('master_mapel')
                        ->result_array();
    }
}