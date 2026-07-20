<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tentangkami extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Profil_model');
        $this->load->library('session');
    }

    public function index() {
        $data['title'] = 'Tentang Kami | Fakultas Industri Kreatif';
        $data['profil'] = $this->Profil_model->get_tentang_kami();

        $is_logged_in = $this->session->userdata('logged_in');
        if ($is_logged_in) {
            $data['user_data'] = [
                'user_id' => $this->session->userdata('user_id'),
                'username' => $this->session->userdata('username'),
                'nama' => $this->session->userdata('nama'),
                'nim' => $this->session->userdata('nim'),
                'nidn' => $this->session->userdata('nidn'),
                'role' => $this->session->userdata('role'),
                'prodi' => $this->session->userdata('prodi'),
                'foto' => $this->session->userdata('foto'),
                'logged_in' => true
            ];
        } else {
            $data['user_data'] = null;
        }

        $this->load->view('tentang_kami', $data);
    }
}
