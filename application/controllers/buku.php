<?php

class Buku extends CI_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->model(array('User_model', 'Buku_model'));
    $this->load->library('template');

    if (!$this->session->userdata('logged_in')) {
      redirect('/');
    }
  }

  public function no_job() {
    if ($this->session->userdata('id_jabatan') != 1) {
      redirect('/');
    }

    $data['books'] = $this->db->get('buku_dikerjakan')->result();
    $this->template->display('buku/no_job', $data);
  }

  public function get_books() {
    $books = $this->db->select('buku_dikerjakan.*, COUNT(buku_no_jobs.id) as num_no_jobs')
                      ->join('buku_no_jobs', 'buku_no_jobs.id_buku = buku_dikerjakan.id')
                      ->group_by('buku_dikerjakan.id')
                      ->get('buku_dikerjakan')
                      ->result();

    $data = [];
    $no = 1;
    foreach ($books as $book) {
      $newBook = $book;
      $newBook->DT_RowId = "row_"+$no;

      $data[] = $newBook;
      $no++;
    }

    $final_data = new stdClass();
    $final_data->data = $data;

    echo json_encode($final_data);
  }

  public function get_no_jobs() {
    $book_id = $this->input->post('book_id');

    $no_jobs = $this->db->where('id_buku', $book_id)->get('buku_no_jobs')->result();

    $data = [];
    $no = 1;
    foreach ($no_jobs as $no_job) {
      $newNoJob = $no_job;
      $newNoJob->DT_RowId = "row_"+$no;

      $data[] = $newNoJob;
      $no++;
    }

    $final_data = new stdClass();
    $final_data->data = $data;

    echo json_encode($final_data);
  }

  public function save_no_job() {
    $this->db->db_debug = FALSE;
    $save = $this->Buku_model->save_no_job($this->input->post());

    if ($save) {
      if ($this->db->insert_id()) {
        echo json_encode(array(
          error => false,
          message => "No job berhasil disimpan!"
        )); 
        die;
      }
    }
    
    $error_message = $this->db->_error_message();

    if (strpos($error_message, "Duplicate") !== false) {
      echo json_encode(array(
        error => true,
        message => "No job sudah tersedia, silahkan pilih no job lainnya."
      ));
    } else {
      echo json_encode(array(
        error => true,
        message => "Terjadi kesalahan saat menyimpan data no job, silahkan coba lagi nanti."
      ));
    }
  }
}