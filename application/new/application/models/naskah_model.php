<?php

class Naskah_model extends CI_Model {
    public function getAll() {
        $naskah = $this->db->get('naskah');

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
}