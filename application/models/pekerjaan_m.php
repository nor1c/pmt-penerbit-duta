<?php

class Pekerjaan_m extends CI_Model{
	private $table_name = 'report_pekerjaan';
	private $table_pk = 'id_report_pekerjaan';

	public function __construct(){
		parent::__construct();
	}

    public function getLaporanData($filters, $pagination) {
        $this->db->query("SET @@lc_time_names = 'id_ID'");

		$this->db->select("$this->table_name.*, t_karyawan.*, buku_dikerjakan.*, report_pekerjaan.no_job, buku_no_jobs.standar_halaman", FALSE);
		$this->db->from($this->table_name);
		$this->db->join("t_karyawan", "t_karyawan.id_karyawan=$this->table_name.id_karyawan", "left");
		$this->db->join("buku_dikerjakan", "buku_dikerjakan.id=$this->table_name.id_buku_dikerjakan", "left");
		$this->db->join("buku_no_jobs", "buku_no_jobs.id_buku=$this->table_name.id_buku_dikerjakan AND buku_no_jobs.no_job=$this->table_name.no_job", "left");

        if (isset($filters) && $filters != [""] && count($filters)) {
            foreach ($filters as $filter) {
                $filter = explode('=', $filter);
				
				if ($filter[0] == 'startdate') {
					$exp_tgl_start = explode('%2F', $filter[1]);
					$tgl_start = $exp_tgl_start[2].'-'.$exp_tgl_start[1].'-'.$exp_tgl_start[0];
					$this->db->where('DATE_FORMAT(date, "%Y-%m-%d") >=', $tgl_start);
				}
				if ($filter[0] == 'enddate') {
					$exp_tgl_end = explode('%2F', $filter[1]);
					$tgl_end = $exp_tgl_end[2].'-'.$exp_tgl_end[1].'-'.$exp_tgl_end[0];
					$this->db->where('DATE_FORMAT(date, "%Y-%m-%d") <=', $tgl_end);
				}
				if ($filter[0] == 'id_karyawan' && $filter[1] != '') {
					$this->db->where("$this->table_name.id_karyawan", $filter[1]);
				}
				
                if ($filter[1] != '' && $filter[0] != 'startdate' && $filter[0] != 'enddate' && $filter[0] != 'id_karyawan') {
                    $this->db->where($filter[0], $filter[1]);
                }
            }
        }

        // $this->db->where('date=CURDATE()');

		$this->db->order_by("t_karyawan.nama", "ASC");

		$tempdb = clone $this->db;
		$count = $tempdb->count_all_results('', FALSE);
		
		$this->db->limit($pagination['length'], $pagination['start']);
		
		$this->db->group_by("$this->table_name.id_report_pekerjaan");

        $naskah = $this->db->get();

        $data = $naskah->result_array();
        $recordsTotal = $naskah->num_rows();

        return [
            'data' => $data,
            'recordsTotal' => $count
        ];
    }
}