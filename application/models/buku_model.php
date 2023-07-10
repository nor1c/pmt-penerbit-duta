<?php

class Buku_model extends CI_Model {
  private $table_name = 'buku_dikerjakan';
  
  public function __constuct() {
    parent::__construct();
  }

  public function save_no_job($data) {
    $no_job_data = array(
      'id_buku' => $data['id_buku'],
      'no_job' => $data['no_job'],
      'standar_halaman' => $data['standar_halaman']
    );

    $save = $this->db->insert('buku_no_jobs', $no_job_data);

    return $save;
  }

  public function get_book_and_no_job($book_id) {
    $book = $this->db->select('buku_dikerjakan.*, buku_no_jobs.standar_halaman, buku_no_jobs.no_job, SUM(report_pekerjaan.realisasi_target) as halaman_selesai')
                     ->join('buku_no_jobs', 'buku_no_jobs.id_buku=buku_dikerjakan.id', 'left')
                     ->join('report_pekerjaan', 'buku_dikerjakan.id=report_pekerjaan.id_buku_dikerjakan AND buku_no_jobs.no_job=report_pekerjaan.no_job', 'left')
                     ->from('buku_dikerjakan')
                     ->where('buku_dikerjakan.id', $book_id)
                     ->order_by('buku_no_jobs.id', 'desc')
                     ->group_by('buku_no_jobs.id')
                     ->limit(1)
                     ->get()
                     ->row();

    return $book;
  }
}