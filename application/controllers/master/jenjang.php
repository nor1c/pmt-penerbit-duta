<?php

class Jenjang extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model(array('master/jenjang_m'));
    }

    public function index() {
        $this->template->display('jenjang/index');
    }
}