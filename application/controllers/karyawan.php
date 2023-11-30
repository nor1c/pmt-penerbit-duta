<?php

class Karyawan extends DUTA_Controller {
    public function __construct()
    {
        parent::__construct();
    }

    function getPICNaskahJSON() {
        $karyawan = $this->Karyawan_model->getPICNaskahJSON();

        echo json_encode($karyawan);
    }
}