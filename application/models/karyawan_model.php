<?php

class Karyawan_model extends CI_Model {
    protected $table = 't_karyawan';

    public function getAll($searchableFields, $search, $filters, $pagination) {
        $this->db->select("$this->table.*, t_divisi.nama_divisi, t_jabatan.nama_jabatan, t_golongan.nama_golongan, t_jam_kerja.keterangan as jam_kerja");
        $this->db->from($this->table);
        $this->db->join('t_divisi', "t_divisi.id_divisi=$this->table.id_divisi", 'left');
        $this->db->join('t_jabatan', "t_jabatan.id_jabatan=$this->table.id_jabatan", 'left');
        $this->db->join('t_golongan', "t_golongan.id_golongan=$this->table.id_golongan", 'left');
        $this->db->join('t_jam_kerja', "t_jam_kerja.id_jam_kerja=$this->table.id_jam_kerja", 'left');

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

        $this->db->order_by('id_karyawan', 'desc');

        $tempdb = clone $this->db;
		$recordsTotal = $tempdb->count_all_results('', FALSE);

		$this->db->limit($pagination['length'], $pagination['start']);
        $mapel = $this->db->order_by('id_karyawan', 'desc')->get();
        $data = $mapel->result_array();

        return [
            'data' => $data,
            'recordsTotal' => $recordsTotal
        ];
    }

    public function create($data) {
        DBS()->insert($this->table, $data);

        return catchQueryResult(DBS()->_error_message(), DBS()->_error_number());
    }

    public function update($idKaryawan, $data) {
        DBS()->where('id_karyawan', $idKaryawan)->update($this->table, $data);

        return catchQueryResult(DBS()->_error_message(), DBS()->_error_number());
    }

    public function findById($idKaryawan) {
        return DBS()->from($this->table)
                    ->where('id_karyawan', $idKaryawan)
                    ->limit(1)
                    ->get()
                    ->row();
    }

    public function getPICNaskahJSON() {
        $karyawan = $this->db->where('active', '1')
                            ->order_by('nama', 'ASC')
                            ->get('t_karyawan')
                            ->result_array();

        return $karyawan;
    }

    public function getKoordinatorList() {
        $karyawan = $this->db->where('active', '1')
                            ->where('id_jabatan', 4)
                            ->order_by('nama', 'ASC')
                            ->get('t_karyawan')
                            ->result_array();

        return $karyawan;
    }
}