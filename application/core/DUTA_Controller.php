<?php

class DUTA_Controller extends CI_Controller {
    public $keyMap = array(
        'penulisan' => array(
            'order' => 1,
            'key' => 'penulisan',
            'text' => 'Penulisan',
            'next_level' => 'editing',
            'is_off' => "0",
            'pic' => 'editor'
        ),
        'editing' => array(
            'order' => 2,
            'key' => 'editing',
            'text' => 'Editing',
            'next_level' => 'setting_1',
            'is_off' => "0",
            'pic' => 'editor'
        ),
        'setting_1' => array(
            'order' => 3,
            'key' => 'setting_1',
            'text' => 'Setting 1',
            'next_level' => 'koreksi_1',
            'is_off' => "0",
            'pic' => 'setter'
        ),
        'koreksi_1' => array(
            'order' => 4,
            'key' => 'koreksi_1',
            'text' => 'Koreksi 1',
            'next_level' => 'setting_2',
            'is_off' => "0",
            'pic' => 'editor'
        ),
        'setting_2' => array(
            'order' => 5,
            'key' => 'setting_2',
            'text' => 'Setting 2',
            'next_level' => 'koreksi_2',
            'is_off' => "0",
            'pic' => 'setter'
        ),
        'koreksi_2' => array(
            'order' => 6,
            'key' => 'koreksi_2',
            'text' => 'Koreksi 2',
            'next_level' => 'setting_3',
            'is_off' => "0",
            'pic' => 'editor'
        ),
        'setting_3' => array(
            'order' => 7,
            'key' => 'setting_3',
            'text' => 'Setting 3',
            'next_level' => 'koreksi_3',
            'is_off' => "0",
            'pic' => 'setter'
        ),
        'koreksi_3' => array(
            'order' => 8,
            'key' => 'koreksi_3',
            'text' => 'Koreksi 3',
            'next_level' => 'pdf',
            'is_off' => "0",
            'pic' => 'editor'
        ),
        'pdf' => array(
            'order' => 9,
            'key' => 'pdf',
            'text' => 'PDF',
            'next_level' => null,
            'is_off' => "0",
            'pic' => 'setter'
        ),
    );
    public $statusMap = array(
        'open' => array(
            'text' => 'Open',
            'bgColor' => '#ffffff'
        ),
        'on_progress' => array(
            'text' => 'On Progress',
            'bgColor' => '#c4f3ff'
        ),
        'paused' => array(
            'text' => 'Ditunda',
            'bgColor' => '#feffde'
        ),
        'cicil' => array(
            'text' => 'Dicicil',
            'bgColor' => '#ffd7cf'
        ),
        'finished' => array(
            'text' => 'Selesai',
            'bgColor' => '#ccffc7'
        ),
    );

    public $special_users = [14, 23, 28];

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
                'Naskah_model',
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