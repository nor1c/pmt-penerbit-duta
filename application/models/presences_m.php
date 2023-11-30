<?php

class Presences_m extends CI_Model{
	private $table_name = 't_kehadiran';
	private $table_pk = 'id_kehadiran';
	private $table_status = 't_kehadiran.active';

	public function __construct(){
		parent::__construct();
	}

	public function get_all($paging=true,$start=0,$limit=10){
		$this->db->select('id_kehadiran,id_karyawan,tanggal,jam_masuk,jam_keluar,hadir,id_alasan,keterangan');
		$this->db->from($this->table_name);
		$this->db->where($this->table_status,'1');
		if($paging==true){
			$this->db->limit($limit,$start);
		}
		return $this->db->get();
	}

	public function get_by_id($id_kehadiran){
		$this->db->select('id_kehadiran,t_kehadiran.id_karyawan,nama,tanggal,jam_masuk,jam_keluar,hadir,t_kehadiran.id_alasan,nama_alasan,keterangan');
		$this->db->from($this->table_name);
		$this->db->join('t_karyawan','t_karyawan.id_karyawan = '.$this->table_name.'.id_karyawan');
		$this->db->join('t_alasan','t_alasan.id_alasan = '.$this->table_name.'.id_alasan');
		$this->db->where($this->table_pk,$id_kehadiran);
		$this->db->where($this->table_status,'1');
		return $this->db->get();
	}

	public function get_attendance($data) {
		$this->db->from($this->table_name)
				 ->join('t_karyawan', 't_karyawan.id_karyawan = ' . $this->table_name . '.id_karyawan');
		$this->db->where($this->table_status, '1');
      	$this->db->where('t_karyawan.active','1');
		if ($this->session->userdata('id_jabatan') != '1') {
			$this->db->where('t_karyawan.id_karyawan', $this->session->userdata('user_id'));
		}
		
		if (!empty($data['id_karyawan'])) {
			$this->db->where('t_karyawan.id_karyawan', $data['id_karyawan']);
		}
		$this->db->where('tanggal >=', date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start']))));
		$this->db->where('tanggal <=', date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end']))));
		
        $this->db->order_by('nama', 'ASC');
		return $this->db->get()->result_array();
	}
	public function get_report_pekerjaan($data)
	{
		$this->db->select('report_pekerjaan.*, t_karyawan.*, buku_dikerjakan.id, buku_dikerjakan.kode_buku, buku_dikerjakan.judul_buku');
		$this->db->join('t_karyawan', 'report_pekerjaan.id_karyawan = t_karyawan.id_karyawan','left');
		$this->db->join('buku_dikerjakan', 'report_pekerjaan.id_buku_dikerjakan = buku_dikerjakan.id','left');
		
		if (!empty($data['id_karyawan'])) {
			$this->db->where('t_karyawan.id_karyawan', $data['id_karyawan']);
		}

		if (!empty($data['id_judul_buku'])) {
			$this->db->where('report_pekerjaan.id_buku_dikerjakan', $data['id_judul_buku']);
		}

		$this->db->where('date >=', date("Y-m-d",strtotime($data['date_start'])));
		$this->db->where('date <=', date("Y-m-d",strtotime($data['date_end'])));

    $this->db->order_by('nama', 'ASC');
		
		return $this->db->get('report_pekerjaan')->result_array();
	}
	public function getAllAttendance($selisih, $tgl_awal, $tgl_akhir) {
		$this->db->from($this->table_name)
				 ->join('t_karyawan', 't_karyawan.id_karyawan = ' . $this->table_name . '.id_karyawan');
		$this->db->where($this->table_status, '1');
		return $this->db->get()->result_array();
	}

	public function get_by_date($tanggal, $id_karyawan, $id_judul_buku = ''){
		$this->db->select('id_kehadiran,t_kehadiran.id_karyawan,nama,tanggal,jam_masuk,jam_keluar,hadir,t_kehadiran.id_alasan,nama_alasan,keterangan');

		$this->db->from($this->table_name);
		
		$this->db->join('t_karyawan','t_karyawan.id_karyawan = '.$this->table_name.'.id_karyawan');
		$this->db->join('t_alasan','t_alasan.id_alasan = '.$this->table_name.'.id_alasan');

		$this->db->where($this->table_name.'.id_karyawan',$id_karyawan);
		
		$this->db->where('tanggal',$tanggal);
		$this->db->where($this->table_status,'1');
		return $this->db->get();
	}

	public function save($data_kehadiran){
		$this->db->insert($this->table_name,$data_kehadiran);
	}

	public function update($id_kehadiran,$data_kehadiran){
		$this->db->where($this->table_pk,$id_kehadiran);
		$this->db->update($this->table_name,$data_kehadiran);
	}

	public function delete($id_kehadiran){
		$this->db->where($this->table_pk,$id_kehadiran);
		$this->db->delete($this->table_name);
	}
	public function update_report_pekerjaan($id_report_pekerjaan, $updated_data) {
		$this->db->where('id_report_pekerjaan', $id_report_pekerjaan);
		$updated = $this->db->update('report_pekerjaan', $updated_data);

		return $updated;
	}

	public function getHistories($filters, $pagination) {
		$this->db->query("SET @@lc_time_names = 'id_ID'");

		$this->db->select("t_karyawan.nikaryawan, t_karyawan.nama, CONCAT(DAYNAME($this->table_name.tanggal), ', ', DATE_FORMAT($this->table_name.tanggal, '%d/%m/%Y')) as tanggal, DATE_FORMAT($this->table_name.jam_masuk, '%H:%i:%s') as jam_masuk, $this->table_name.computer_name, DATE_FORMAT($this->table_name.jam_keluar, '%H:%i:%s') as jam_keluar, $this->table_name.computer_name_out, $this->table_name.keterangan", FALSE);
		$this->db->from($this->table_name);
		$this->db->join("t_karyawan", "t_karyawan.id_karyawan=$this->table_name.id_karyawan", "left");

		if ($this->session->userdata('id_jabatan') != 1) {
			$this->db->where('t_kehadiran.id_karyawan', $this->session->userdata('user_id'));
		}

        if (isset($filters) && $filters != [""] && count($filters)) {
            foreach ($filters as $filter) {
                $filter = explode('=', $filter);
				
				if ($filter[0] == 'attendance_history_filter_start_date') {
					$exp_tgl_start = explode('%2F', $filter[1]);
					$tgl_start = $exp_tgl_start[2].'-'.$exp_tgl_start[1].'-'.$exp_tgl_start[0];
					$this->db->where('tanggal >=', $tgl_start);
				}
				if ($filter[0] == 'attendance_history_filter_finish_date') {
					$exp_tgl_end = explode('%2F', $filter[1]);
					$tgl_end = $exp_tgl_end[2].'-'.$exp_tgl_end[1].'-'.$exp_tgl_end[0];
					$this->db->where('tanggal <=', $tgl_end);
				}
				if ($filter[0] == 'attendance_history_filter_karyawan') {
					$this->db->where("$this->table_name.id_karyawan", $filter[1]);
				}
				
                // if ($filter[1] != '' && $filter[0] != 'attendance_history_filter_start_date' && $filter[0] != 'attendance_history_filter_finish_date' && $filter[0] != 'attendance_history_filter_karyawan') {
                //     $this->db->where($filter[0], $filter[1]);
                // }
            }
        }

		$this->db->order_by("$this->table_name.id_kehadiran", "DESC");

		$tempdb = clone $this->db;
		$count = $tempdb->count_all_results('', FALSE);
		
		$this->db->limit($pagination['length'], $pagination['start']);
		
		$this->db->group_by("$this->table_name.id_kehadiran");

        $naskah = $this->db->get();

        $data = $naskah->result_array();

        return [
            'data' => $data,
            'recordsTotal' => $count
        ];
    }
}