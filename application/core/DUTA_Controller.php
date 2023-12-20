<?php

class DUTA_Controller extends CI_Controller {
    public function __construct() {
        parent::__construct();

        // Initiate default time & timezone
        // date_default_timezone_set('Asia/Jakarta');
        // $this->timestamp = date('Y-m-d H:i:s', time());

        // Load high level priority helper
        $this->load->helper(
            array(
                'primary_helper',
            )
        );

        // Load frequently used helpers
        loadHelper(
            array(
                'url',
                'form',
                'file',
                // 'cookie',
                // 'ins_helper',
                // 'api_helper',
                'global'
            )
        );

        // Load frequently used libraries
        loadLibrary(
            array(
                'form_validation',
                'session',
                'template',
            )
        );

        // Load frequently used models
        loadModel(
            array(
                'master/Jenjang_model',
                'master/Mapel_model',
                'master/Kategori_model',
                'master/Ukuran_model',
                'Karyawan_model',
            )
        );

        $models = array(
            // 'authentication' => 'auth/Auth',
        );

        if (!empty($models)) {
            foreach ($models as $key => $value) {
                $this->{$key} = $value.'_model';
            }
        }
    }   
}