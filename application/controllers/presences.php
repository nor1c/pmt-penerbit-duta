<?php

class Presences extends CI_Controller {
    private $special_users = [14, 23, 28];

    public function __construct() {
        parent::__construct();
        $this->load->model(array('User_model', 'master/Jam_kerja_m', 'Presences_m', 'Buku_model', 'Workday_plan_model'));
        $this->load->library('template');

        if (!$this->session->userdata('logged_in')) {
            redirect('/');
        }
    }

    public function index() {
        $data = $this->get_data_kehadiran();

        $this->template->display('presences/presences', $data);
    }

    public function get_data_kehadiran($attendance = false) {
        $selisih_hari = 0;
        $data['selisih_hari'] = $selisih_hari;

        $today = date('Y-m-d');
        $minus = mktime(0, 0, 0, date('m'), date('d') - $selisih_hari, date('Y'));
        $pastmonth = date('Y-m-d', $minus);

        if ($this->input->post('presences_date_start') || $this->input->post('presences_date_end')) {
            $data['date_start'] = $this->input->post('presences_date_start');
            $data['date_end'] = $this->input->post('presences_date_end');
            if ($this->input->post('id_karyawan') != null || $this->input->post('id_karyawan') != "" || empty($this->input->post('id_karyawan'))) {
                $data['id_karyawan'] = $this->input->post('id_karyawan');
                $this->session->set_userdata('id_karyawan', $this->input->post('id_karyawan'));
            } else {
                $data['id_karyawan'] = null;
            }
        } else {
            $data['date_start'] = $this->tanggal->tanggal_indo($pastmonth);
            $data['date_end'] = $this->tanggal->tanggal_indo($today);
        }

        if ($attendance) {
            $data['id_karyawan'] = $this->session->userdata('user_id');
        }

        $data['kehadiran'] = $this->Presences_m->get_attendance($data);

        return $data;
    }

    public function indeax() {
        $selisih_hari = 7;

        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->User_model->get_by_id($user_id)->row_array();
        $data['jam_kerja'] = $this->Jam_kerja_m->get_by_id($data['user']['id_jam_kerja'])->row_array();

        $today = date('Y-m-d');
        $minus = mktime(0, 0, 0, date('m'), date('d') - $selisih_hari, date('Y'));
        $pastmonth = date('Y-m-d', $minus);

        $data['date_start'] = $this->tanggal->tanggal_indo($pastmonth);
        $data['date_end'] = $this->tanggal->tanggal_indo($today);
        if ($_POST) {
            $today = $this->tanggal->tanggal_simpan_db($this->input->post('presences_date_end'));
            $pastmonth = $this->tanggal->tanggal_simpan_db($this->input->post('presences_date_start'));

            $selisih_hari = $this->tanggal->get_selisih($today, $pastmonth);

            $data['date_start'] = $this->input->post('presences_date_start');
            $data['date_end'] = $this->input->post('presences_date_end');
        }

        $data['kehadiran'] = array();
        for ($i = $selisih_hari; $i >= 0; $i--) {
            $temp = mktime(0, 0, 0, $this->tanggal->get_only_month($today), $this->tanggal->get_only_date($today) - $i, $this->tanggal->get_only_year($today));
            $tanggal = date('Y-m-d', $temp);

            $data['kehadiran'][$i]['tanggal'] = $this->tanggal->tanggal_indo_monthtext($tanggal);
            $data['kehadiran'][$i]['hari'] = $this->tanggal->get_hari($tanggal);
            if ($this->Presences_m->get_by_date($tanggal, $user_id)->num_rows() > 0) {
                $present = $this->Presences_m->get_by_date($tanggal, $user_id)->row_array();
                $data['kehadiran'][$i]['datang'] = $this->tanggal->get_jam($present['jam_masuk']);
                $data['kehadiran'][$i]['pulang'] = $this->tanggal->get_jam($present['jam_keluar']);
                $data['kehadiran'][$i]['nama'] = $present['nama'];
                $data['kehadiran'][$i]['alasan'] = $present['nama_alasan'] . '(' . $present['keterangan'] . ')';
                if ($present['id_alasan'] == '5') {
                    $data['kehadiran'][$i]['alasan'] = '-';
                }
            } else {
                $data['kehadiran'][$i]['datang'] = '-';
                $data['kehadiran'][$i]['pulang'] = '-';
                $data['kehadiran'][$i]['alasan'] = '-';
                $data['kehadiran'][$i]['nama'] = '-';
            }
            $workday_count = $this->Workday_plan_model->get_by_date(intval($this->tanggal->get_only_date($tanggal)), $this->tanggal->get_only_month($tanggal), $this->tanggal->get_only_year($tanggal))->num_rows();
            if ($workday_count > 0) {
                $workday = $this->Workday_plan_model->get_by_date(intval($this->tanggal->get_only_date($tanggal)), $this->tanggal->get_only_month($tanggal), $this->tanggal->get_only_year($tanggal))->row_array();
                if ($workday['status'] == '0') {
                    $data['kehadiran'][$i]['datang'] = $workday['keterangan'];
                    $data['kehadiran'][$i]['pulang'] = $workday['keterangan'];
                    $data['kehadiran'][$i]['alasan'] = $workday['keterangan'];
                }
            }
        }
        $this->template->display('presences/presences', $data);
    }

    public function report_pdf() {
        $startdate = date("Y-m-d", strtotime($this->input->get('startdate')));
        $enddate = date("Y-m-d", strtotime($this->input->get('enddate')));
        $id_karyawan = $this->input->get('id_karyawan');

        $selisih_hari = 0;
        $data['selisih_hari'] = $selisih_hari;

        $today = date('Y-m-d');
        $minus = mktime(0, 0, 0, date('m'), date('d') - $selisih_hari, date('Y'));
        $pastmonth = date('Y-m-d', $minus);

        if ($startdate || $enddate) {
            $data['date_start'] = $startdate;
            $data['date_end'] = $enddate;
            if ($id_karyawan != null || $id_karyawan != "") {
                $data['id_karyawan'] = $id_karyawan;
            }
        } else {
            $data['date_start'] = $startdate;
            $data['date_end'] = $enddate;
        }

        $data['kehadiran'] = $this->Presences_m->get_attendance($data);

        $this->load->view('presences/report_pdf', $data);
    }

    public function input_report_pdf() {
        $startdate = date("Y-m-d", strtotime($this->input->get('startdate')));
        $enddate = date("Y-m-d", strtotime($this->input->get('enddate')));
        $id_karyawan = $this->input->get('id_karyawan');
        $id_judul_buku = $this->input->get('id_judul_buku');

        $selisih_hari = 0;
        $data['selisih_hari'] = $selisih_hari;

        $today = date('Y-m-d');
        $minus = mktime(0, 0, 0, date('m'), date('d') - $selisih_hari, date('Y'));
        $pastmonth = date('Y-m-d', $minus);

        if ($startdate || $enddate) {
            $data['date_start'] = $this->input->get('startdate');
            $data['date_end'] = $this->input->get('enddate');
            if ($id_karyawan != null || $id_karyawan != "") {
                $data['id_karyawan'] = $id_karyawan;
            }
            if ($id_judul_buku != null || $id_judul_buku != "") {
                $data['id_judul_buku'] = $id_judul_buku;
            }
        } else {
            $data['date_start'] = $this->tanggal->tanggal_indo($pastmonth);
            $data['date_end'] = $this->tanggal->tanggal_indo($today);
        }

        $data['report_pekerjaan'] = $this->Presences_m->get_report_pekerjaan($data);
        $this->load->view('presences/input_report_pdf', $data);
    }

    public function input() {
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        $is_mobile = preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4));
        $time_now = date('H:i', time());
        $user_id = $this->session->userdata('user_id');
        if ($time_now >= '07:00' && $time_now < '09:01') {
            if (
                $user_id != 14 &&
                $user_id != 23 &&
                $user_id != 28
            ) {
                if ($is_mobile) {
                    echo "<div style='width: 100%; text-align: center; font-weight: bold; font-family: Arial; font-size: 20px; margin-top: 5%;'>
            <b style='font-size: 30px; color: red;'>WARNING!!</b>
            <br>
            <br>
            Maaf Login Gagal
            <br>
            <p>
            Website tidak bisa diakses lewat handphone di pagi hari
          </div>";
                    die;
                }
            }
        }

        $this->form_validation->set_rules('nik', 'NIK', 'required');
        $this->form_validation->set_rules('pwd', 'Password', 'required');
        $this->form_validation->set_rules('type_absen', 'Type', 'required');

        if ($this->form_validation->run() == false) {
            $data['special_users'] = $this->special_users;

            $this->template->display('presences/input_view', $data);
        } else {
            if ($this->User_model->check_absen($this->input->post('nik'), $this->input->post('pwd'))) {
                $data_user = $this->User_model->get_by_nik($this->input->post('nik'))->row_array();

                if ($this->input->post('type_absen') == '1') {
                    $cek = $this->Presences_m->get_by_date(date('Y-m-d'), $data_user['id_karyawan']);
                    $num_row = $cek->num_rows();
                    if ($num_row > 0) {
                        if ($cek->row()->jam_masuk == null || $cek->row()->jam_masuk == "") {
                            $data_kehadiran = array(
                                'id_karyawan' => $data_user['id_karyawan'],
                                'tanggal' => date('Y-m-d'),
                                'jam_masuk' => date('Y-m-d H:i:s'),
                                'hadir' => '1',
                                'id_alasan' => '5',
                                'created_date' => date('Y-m-d'),
                                'created_user' => $this->session->userdata('user_id'),
                                'active' => '1',
                            );
                            $data_kehadiran['computer_name'] = $this->getComputerName();
                            $this->Presences_m->update($cek->row()->id_kehadiran, $data_kehadiran);

                            $this->session->set_flashdata('message_alert', '<div class="alert alert-success">Data Terupdate</div>');
                            redirect('presences/input');
                        } else {
                            $this->session->set_flashdata('message_alert', '<div class="alert alert-danger">Anda Sudah Absen Untuk Hari Ini .</div>' . $cek->row()->jam_masuk);
                            redirect('presences/input');
                        }
                    } else {
                        $data_kehadiran = array(
                            'id_karyawan' => $data_user['id_karyawan'],
                            'tanggal' => date('Y-m-d'),
                            'jam_masuk' => date('Y-m-d H:i:s'),
                            'hadir' => '1',
                            'id_alasan' => '5',
                            'created_date' => date('Y-m-d'),
                            'created_user' => $this->session->userdata('user_id'),
                            'active' => '1',
                        );
                        $data_kehadiran['computer_name'] = $this->getComputerName();
                        $this->Presences_m->save($data_kehadiran);

                        $this->session->set_flashdata('message_alert', '<div class="alert alert-success">Data Tersimpan</div>');
                        redirect('presences/input');
                    }
                } else {

                    $cek = $this->Presences_m->get_by_date(date('Y-m-d'), $data_user['id_karyawan'])->num_rows();
                    if ($cek > 0) {

                        $tmp = $this->Presences_m->get_by_date(date('Y-m-d'), $data_user['id_karyawan'])->row_array();

                        $data_kehadiran = array(
                            'jam_keluar' => date('Y-m-d H:i:s'),
                            'updated_date' => date('Y-m-d'),
                            'updated_user' => $this->session->userdata('user_id'),
                            'computer_name_out' => $this->getComputerName()
                        );
                        $data_kehadiran['computer_name'] = $this->getComputerName();
                        $this->Presences_m->update($tmp['id_kehadiran'], $data_kehadiran);

                        $this->session->set_flashdata('message_alert', '<div class="alert alert-success">Data Tersimpan</div>');
                        redirect('presences/input');
                    } else {

                        $this->session->set_flashdata('message_alert', '<div class="alert alert-danger">Data absen is not available. Please input the in time first.</div>');
                        redirect('presences/input');
                    }
                }
            } else {
                $this->session->set_flashdata('message_alert', '<div class="alert alert-danger">Username atau password tidak terdaftar.</div>');
                redirect('presences/input');
            }
        }
    }

    // check status absen
    public function check() {
        $kehadiran = $this->get_data_kehadiran(true);

        if ($kehadiran && count($kehadiran['kehadiran']) && $kehadiran['kehadiran'][0]['jam_masuk'] != null) {
            $jam_masuk = $kehadiran['kehadiran'][0]['jam_masuk'];
            $jam_keluar = $kehadiran['kehadiran'][0]['jam_keluar'];

            echo json_encode([
                'tanggal' => $kehadiran['kehadiran'][0]['tanggal'],
                'jam_masuk' => explode(' ', $jam_masuk)[1],
                'jam_keluar' => $jam_keluar ? explode(' ', $jam_keluar)[1] : null,
            ]);
        } else {
            echo json_encode(null);
        }
    }

    public function is_current_user_special() {
        $user_id = $this->session->userdata('user_id');

        return in_array($user_id, $this->special_users);
    }

    public function getComputerName() {
        exec("wmic /node:$_SERVER[REMOTE_ADDR] COMPUTERSYSTEM Get UserName", $device);
        $computer_name = $device[1];

        return $computer_name;
    }

    // absen masuk
    public function attend() {
        $is_user_special = $this->is_current_user_special();
        $current_time = explode(':', date('H:i', time()));

        if (!$is_user_special && ($current_time[0] > 8 || ($current_time[0] == 8 && $current_time[1] > 30))) {
            echo json_encode(false);
            die;
        }

        $user_id = $this->session->userdata('user_id');
        // $computer_name = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        exec("wmic /node:$_SERVER[REMOTE_ADDR] COMPUTERSYSTEM Get UserName", $device);
        $computer_name = $device[1];

        $now = explode(':', date('H:i'));

        // jika blm jam 7:30, jam masuk otomatis set ke 7:30 (minimal aturan jam masuk pukul 7:30)
        $hour = $now[0];
        $minute = $now[1];

        $jam_masuk = date('Y-m-d H:i:s');
        if (!$is_user_special && ($hour < 7 || ($hour == 7 && $minute < 30))) {
            $jam_masuk = date('Y-m-d') . ' 07:30:00';
        }

        $data_kehadiran = array(
            'id_karyawan' => $user_id,
            'tanggal' => date('Y-m-d'),
            'jam_masuk' => $jam_masuk,
            'hadir' => '1',
            'id_alasan' => '5',
            'created_date' => date('Y-m-d'),
            'created_user' => $user_id,
            'active' => '1',
            'computer_name' => $this->getComputerName(),
        );

        // check if attendance data already exist (auto-generated via cron job)
        $cek = $this->Presences_m->get_by_date(date('Y-m-d'), $user_id);
        $num_row = $cek->num_rows();

        if ($num_row > 0) {
            $this->Presences_m->update($cek->row()->id_kehadiran, $data_kehadiran);
        } else {
            $this->Presences_m->save($data_kehadiran);
        }

        echo json_encode($this->db->affected_rows() ? true : false);
    }

    public function out() {
        $is_user_special = $this->is_current_user_special();

        $user_id = $this->session->userdata('user_id');
        $tmp = $this->Presences_m->get_by_date(date('Y-m-d'), $user_id)->row_array();

        $jam_keluar = date('Y-m-d H:i:s');
        $jam_menit_keluar = explode(':', date('H:i', strtotime($jam_keluar)));

        $final_clock_out = $jam_keluar;
        
        if (!$is_user_special) {
            $max_hour = 17;

            if ($jam_menit_keluar[0] > $max_hour || ($jam_menit_keluar[0] == $max_hour && $jam_menit_keluar[1] > 30)) {
                $final_clock_out = explode(' ', $jam_keluar)[0] . ' ' . $max_hour . ':30:00';
            }
        }

        $updated_data_kehadiran = array(
            'updated_date' => date('Y-m-d'),
            'updated_user' => $user_id,
            'jam_keluar' => $final_clock_out,
        );

        $this->Presences_m->update($tmp['id_kehadiran'], $updated_data_kehadiran);

        echo json_encode($this->db->affected_rows() ? true : false);
    }

    public function buku_dikerjakan() {
        $id = $this->input->post('id');

        $book = $this->Buku_model->get_book_and_no_job($id);

        echo json_encode($book);
    }

    public function report_pekerjaan() {
        //
        $data['id_karyawan'] = $this->session->userdata('user_id');
        $data['pekerjaan'] = $this->input->post('pekerjaan');
        if ($this->input->post('id_buku') == "") {
            $data['id_buku_dikerjakan'] = null;
        } else {
            $data['id_buku_dikerjakan'] = $this->input->post('id_buku');
        }
        $data['no_job'] = $this->input->post('no_job');
        $data['catatan'] = $this->input->post('catatan');
        $data['target'] = $this->input->post('target');
        $data['status'] = $this->input->post('status');
        $data['realisasi_target'] = $this->input->post('realisasi_target');
        $data['date'] = date("Y-m-d");

        if ($this->db->insert('report_pekerjaan', $data)) {
            $this->session->set_flashdata('success', 1);
            redirect('presences/input', 'refresh');
        }
    }

    public function update_report_pekerjaan() {
        $work_id = $this->input->get('work-id');
        $data['realisasi_target'] = $this->input->post('realisasi_target');
        $data['status'] = $this->input->post('status');

        $updated = $this->Presences_m->update_report_pekerjaan($work_id, $data);

        if ($updated) {
            $this->session->set_flashdata('success_update', 1);
            redirect('presences/input', 'refresh');
        }
    }

    public function laporan_filter() {
        $startdate = date("Y-m-d", strtotime($this->input->post('startdate')));
        $enddate = date("Y-m-d", strtotime($this->input->post('enddate')));

        $id_karyawan = $this->input->post('id_karyawan');
        $id_judul_buku = $this->input->post('id_judul_buku');

        $this->session->set_flashdata('startdate', $startdate);
        $this->session->set_flashdata('enddate', $enddate);
        $this->session->set_flashdata('id_karyawan', $id_karyawan);
        $this->session->set_flashdata('id_judul_buku', $id_judul_buku);

        redirect('presences/input', 'refresh');
    }

    public function histories() {
        $pagination = array(
            'start' => $this->input->post('start'),
            'length' => $this->input->post('length')
        );

        $filters = explode('&', $this->input->post('filters'));
        if ($filters[0] == "") {
            if (!isset($filters['attendance_history_filter_start_date'])) {
                array_push($filters, "attendance_history_filter_start_date=".str_replace('/', '%2F', date('d/m/Y')));
            }
            if (!isset($filters['attendance_history_filter_finish_date'])) {
                array_push($filters, "attendance_history_filter_finish_date=".str_replace('/', '%2F', date('d/m/Y')));
            }
        }

        $attendance = $this->Presences_m->getHistories($filters, $pagination);

        $formattedData = array_map(
            function ($item) {
                return [$item['nikaryawan'], $item['nama'], $item['tanggal'], $item['jam_masuk'], $item['computer_name'], $item['jam_keluar'], $item['computer_name_out'], $item['keterangan']];
            },
            $attendance['data']
        );

        $data = [
            'recordsTotal' => $attendance['recordsTotal'],
            'recordsFiltered' => $attendance['recordsTotal'],
            'data' => $formattedData
        ];

        echo json_encode($data);
    }
}
