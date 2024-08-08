<?php

class Report_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('Holiday_model'));
    }

    public function dailyData($searchableFields, $search, $filters, $pagination) {
        $table = 'naskah_progress';
        $likeCols = ['judul'];

        DBS()->select("$table.*, $table.level_kerja_key as level_kerja, naskah.no_job, naskah.judul, t_karyawan.nama");
        DBS()->from($table);
        DBS()->join('naskah', "naskah.id=$table.id_naskah", 'left');
        DBS()->join('t_karyawan', "t_karyawan.id_karyawan=$table.id_pic", 'left');

        if ($search) {
            foreach($searchableFields as $field) {
                DBS()->or_like($field, urldecoded($search));
            }
        }

        if (isset($filters) && $filters != [""] && count($filters)) {
            foreach ($filters as $filter) {
                $filter = explode('=', $filter);
    
                if ($filter[1] != '') {
                    if ($filter[0] == 'waktu_mulai') {
                        $expTglMulai = explode('/', urldecode($filter[1]));
                        $tglMulai = "$expTglMulai[2]-$expTglMulai[1]-$expTglMulai[0]";

                        DBS()->where('DATE_FORMAT(waktu_mulai, "%Y-%m-%d") >=', $tglMulai);
                    } else if ($filter[0] == 'waktu_selesai') {
                        $expTglSelesai = explode('/', urldecode($filter[1]));
                        $tglSelesai = "$expTglSelesai[2]-$expTglSelesai[1]-$expTglSelesai[0]";
                        
                        DBS()->where('DATE_FORMAT(waktu_selesai, "%Y-%m-%d") <=', $tglSelesai);
                    } else {
                        if (in_array($filter[0], $likeCols)) {
                            DBS()->like($filter[0], urldecode($filter[1]));
                        } else {
                            DBS()->where($filter[0], urldecode($filter[1]));
                        }
                    }
                }
            }
        } else {
            DBS()->where('DATE_FORMAT(waktu_mulai, "%Y-%m-%d") >=', date('Y-m-d', time()));
        }

        DBS()->group_by("$table.id_naskah, $table.id_pic, $table.waktu_mulai");
        DBS()->order_by('waktu_mulai', 'DESC');

        // clone query until this line
        $tempdb = clone $this->db;
		
        DBS()->limit($pagination['length'], $pagination['start']);
        
        $naskah = DBS()->get();
        
        $data = $naskah->result_array();

        // count all records
        DBS()->from($table);

        if ($search) {
            foreach($searchableFields as $field) {
                DBS()->or_like($field, urldecoded($search));
            }
        }

        if (isset($filters) && $filters != [""] && count($filters)) {
            foreach ($filters as $filter) {
                $filter = explode('=', $filter);
    
                if ($filter[1] != '') {
                    if ($filter[0] == 'waktu_mulai') {
                        $expTglMulai = explode('/', urldecode($filter[1]));
                        $tglMulai = "$expTglMulai[2]-$expTglMulai[1]-$expTglMulai[0]";

                        DBS()->where('DATE_FORMAT(waktu_mulai, "%Y-%m-%d") >=', $tglMulai);
                    } else if ($filter[0] == 'waktu_selesai') {
                        $expTglSelesai = explode('/', urldecode($filter[1]));
                        $tglSelesai = "$expTglSelesai[2]-$expTglSelesai[1]-$expTglSelesai[0]";
                        
                        DBS()->where('DATE_FORMAT(waktu_selesai, "%Y-%m-%d") <=', $tglSelesai);
                    } else {
                        if (in_array($filter[0], $likeCols)) {
                            DBS()->like($filter[0], urldecode($filter[1]));
                        } else {
                            DBS()->where($filter[0], urldecode($filter[1]));
                        }
                    }
                }
            }
        }

		$recordsTotal = $tempdb->count_all_results('', FALSE);

        return [
            'data' => $data,
            'recordsTotal' => $recordsTotal
        ];
    }
    
    public function naskahData($searchableFields, $search, $filters, $pagination) {
        $table = 'naskah';
        $likeCols = ['judul'];

        DBS()->select("$table.*, naskah_level_kerja.id_naskah as level_kerja");
        DBS()->from($table);
        DBS()->join('naskah_level_kerja', "naskah_level_kerja.id_naskah=$table.id", 'left');

        if ($search) {
            foreach($searchableFields as $field) {
                $this->db->or_like($field, $search);
            }
        }

        if (isset($filters) && $filters != [""] && count($filters)) {
            foreach ($filters as $filter) {
                $filter = explode('=', $filter);
    
                if ($filter[1] != '') {
                    if (in_array($filter[0], $likeCols)) {
                        DBS()->like($filter[0], $filter[1]);
                    } else {
                        DBS()->where($filter[0], $filter[1]);
                    }
                }
            }
        }

        DBS()->group_by("$table.id");

		DBS()->limit($pagination['length'], $pagination['start']);

        $naskah = DBS()->get();
        
        $data = $naskah->result_array();

        // count all records
        DBS()->from($table);

        if ($search) {
            foreach($searchableFields as $field) {
                $this->db->or_like($field, $search);
            }
        }

        if (isset($filters) && $filters != [""] && count($filters)) {
            foreach ($filters as $filter) {
                $filter = explode('=', $filter);
    
                if ($filter[1] != '') {
                    if (in_array($filter[0], $likeCols)) {
                        DBS()->like($filter[0], $filter[1]);
                    } else {
                        DBS()->where($filter[0], $filter[1]);
                    }
                }
            }
        }

        $tempdb = clone DBS();
		$recordsTotal = $tempdb->count_all_results('', FALSE);

        return [
            'data' => $data,
            'recordsTotal' => $recordsTotal
        ];
    }
}