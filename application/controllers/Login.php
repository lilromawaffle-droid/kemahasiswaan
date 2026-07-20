<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Login_model');
        $this->load->model('Log_model');
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'form']);
        $this->load->model('Login_model');
        $this->load->model('Log_model');
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'form']);
        // $this->load->config('recaptcha'); // ← tambahkan ini (Google reCAPTCHA sudah tidak dipakai, diganti CAPTCHA bawaan CodeIgniter 3)
        $this->load->helper(['captcha', 'string']); // ← CAPTCHA bawaan CodeIgniter 3 (string helper untuk random_string())

    }

    /* ─── Halaman Login ─── */
    public function index() {
        if ($this->session->userdata('logged_in')) {
            redirect($this->_redirect_after_login());
        }

        // Generate ID Device jika belum ada (Cookie akan kedaluwarsa dalam 10 tahun)
        $this->load->helper('cookie');
        if (!$this->input->cookie('device_id')) {
            $device_id = bin2hex(random_bytes(16));
            set_cookie('device_id', $device_id, 315360000);
        }

        $data = [
            'title' => 'Login – Kemahasiswaan FIK Telkom University',
            'error' => $this->session->flashdata('error'),
            'success' => $this->session->flashdata('success'),
            'captcha_image' => $this->_generate_captcha(), // ← CAPTCHA bawaan CodeIgniter
        ];
        $this->load->view('login/index', $data);
    }

    /* ─── Proses Login ─── */
    public function proses() {
        $this->load->helper('cookie');
        $device_id = $this->input->cookie('device_id');
        if (!$device_id) {
            // Jika user menghapus cookie, kita buatkan baru dan anggap sebagai percobaan baru
            $device_id = bin2hex(random_bytes(16));
            set_cookie('device_id', $device_id, 315360000);
        }

        if ($this->Login_model->is_device_blocked($device_id)) {
            $this->session->set_flashdata('error', 'Perangkat Anda diblokir sementara karena terlalu banyak percobaan login yang gagal. Hubungi admin atau coba lagi dalam 24 jam.');
            redirect('login');
        }

        $this->form_validation->set_rules('username', 'Username/NIM', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

         // TAMBAHAN CAPTCHA
         /* ── Google reCAPTCHA lama, dinonaktifkan, diganti CAPTCHA bawaan CodeIgniter 3 ──
         $recaptchaResponse = $this->input->post('g-recaptcha-response');
         $secretKey =  $this->config->item('recaptcha_secret_key');

         if (empty($recaptchaResponse)) {
             $this->session->set_flashdata('error', 'Silakan centang kotak verifikasi CAPTCHA terlebih dahulu.');
             redirect('login');
         }

         $verifyUrl = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $secretKey . '&response=' . $recaptchaResponse;
         $verifyResponse = file_get_contents($verifyUrl);
         $responseData = json_decode($verifyResponse);

        if (!$responseData->success) {
            $this->session->set_flashdata('error', 'Validasi CAPTCHA gagal. Anda terdeteksi sebagai bot.');
            redirect('login');
        }
        */

        // ── CAPTCHA bawaan CodeIgniter 3 ──
        $captcha_input = trim($this->input->post('captcha'));
        $captcha_word  = $this->session->userdata('captcha_word');
        $captcha_time  = $this->session->userdata('captcha_time');

        if (empty($captcha_input) || empty($captcha_word) || $captcha_input !== $captcha_word || (time() - (int) $captcha_time) > 300) {
            $this->session->set_flashdata('error', 'Kode CAPTCHA yang Anda masukkan salah atau sudah kedaluwarsa.');
            redirect('login');
        }

        // Captcha benar, hapus dari session supaya tidak bisa dipakai ulang
        $this->session->unset_userdata('captcha_word');
        $this->session->unset_userdata('captcha_time');
        // AKHIR TAMBAHAN CAPTCHA

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('login');
        }

        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE);

        $user = $this->Login_model->cek_login($username, $password);

        if ($user) {
            $session_data = [
                'user_id'    => $user->id,
                'username'   => $user->username ?? $user->nim,
                'nama'       => $user->nama,
                'nim'        => $user->nim     ?? null,
                'nidn'       => $user->nidn    ?? null,
                'role'       => $user->role,
                'prodi'      => $user->program_studi ?? null,
                'foto'       => $user->foto    ?? null,
                'logged_in'  => TRUE,
            ];
            $this->session->set_userdata($session_data);
            
            // Hapus log percobaan gagal karena sudah berhasil login
            $this->Login_model->clear_failed_login($device_id);

            // Catat ke log history
            $this->Log_model->insert_log($user->id, $user->nama, $user->role, 'Login Berhasil');
            
            redirect($this->_redirect_after_login($user->role));
        } else {
            // Catat kegagalan login untuk device ini
            $this->Login_model->record_failed_login($device_id, $this->Log_model->get_real_ip(), $username);

            $this->session->set_flashdata('error', 'NIM/Username atau password salah.');
            redirect('login');
        }
    }

    /* ─── Halaman Registrasi ─── */
    public function register() {
        if ($this->session->userdata('logged_in')) {
            redirect($this->_redirect_after_login());
        }
        $data = [
            'title' => 'Registrasi Akun – Kemahasiswaan FIK',
            'error' => $this->session->flashdata('error'),
            'success' => $this->session->flashdata('success'),
            'captcha_image' => $this->_generate_captcha(), // ← CAPTCHA bawaan CodeIgniter
        ];
        $this->load->view('login/register', $data);
    }

    public function proses_register() {

    // Deteksi AJAX lebih awal
    $is_ajax = $this->input->is_ajax_request();

    // ── CAPTCHA bawaan CodeIgniter 3 ──
    $captcha_input = trim($this->input->post('captcha'));
    $captcha_word  = $this->session->userdata('captcha_word');
    $captcha_time  = $this->session->userdata('captcha_time');

    if (empty($captcha_input) || empty($captcha_word) || $captcha_input !== $captcha_word || (time() - (int) $captcha_time) > 300) {
        $err_msg_captcha = 'Kode CAPTCHA yang Anda masukkan salah atau sudah kedaluwarsa.';
        if ($is_ajax) {
            header('Content-Type: application/json');
            echo json_encode([
                'status'  => 'error',
                'message' => $err_msg_captcha,
                'errors'  => ['captcha' => $err_msg_captcha],
                'captcha' => $this->_generate_captcha() // ← captcha baru untuk dicoba lagi
            ]);
            exit;
        }
        $this->session->set_flashdata('error', $err_msg_captcha);
        redirect('login/register');
        return;
    }

    // Captcha benar, hapus dari session supaya tidak bisa dipakai ulang
    $this->session->unset_userdata('captcha_word');
    $this->session->unset_userdata('captcha_time');
    // ── AKHIR CAPTCHA ──

    $this->form_validation->set_rules('nim',  'NIM',  
        'required|trim|min_length[10]|max_length[20]|is_unique[users.nim]');
    $this->form_validation->set_rules('nama', 'Nama', 
        'required|trim|min_length[3]');
    $this->form_validation->set_rules('email', 'Email', 
        'required|valid_email|trim|is_unique[users.email]');
    $this->form_validation->set_rules('password', 'Password', 
        'required|min_length[8]');
    $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 
        'required|matches[password]');
    $this->form_validation->set_rules('prodi', 'Program Studi', 'required');
    $this->form_validation->set_rules('terms', 'Syarat & Ketentuan', 'required');

    $this->form_validation->set_message('is_unique', '{field} sudah terdaftar.');
    $this->form_validation->set_message('matches',   'Konfirmasi password tidak cocok.');

    if ($this->form_validation->run() == FALSE) {
        if ($is_ajax) {
            header('Content-Type: application/json');  // ← pakai header() native
            echo json_encode([
                'status'  => 'error',
                'message' => strip_tags(validation_errors()),
                'errors'  => $this->form_validation->error_array(),
                'captcha' => $this->_generate_captcha() // ← captcha lama sudah dipakai, kirim yang baru
            ]);
            exit; // ← pakai exit bukan return
        }
        $this->session->set_flashdata('error', validation_errors());
        redirect('login/register');
        return;
    }

    // Password complexity check
    $password = $this->input->post('password');
    $has_uppercase = preg_match('@[A-Z]@', $password);
    $has_lowercase = preg_match('@[a-z]@', $password);
    $has_number    = preg_match('@[0-9]@', $password);
    $has_symbol    = preg_match('@[^a-zA-Z0-9]@', $password);

    if (!$has_uppercase || !$has_lowercase || !$has_number || !$has_symbol || strlen($password) < 8) {
        $err_msg = 'Password tidak memenuhi standar keamanan (wajib terdiri dari minimal 8 karakter, serta memiliki kombinasi huruf besar, huruf kecil, angka, dan simbol/spesial karakter).';
        if ($is_ajax) {
            header('Content-Type: application/json');
            echo json_encode([
                'status'  => 'error',
                'message' => $err_msg,
                'errors'  => ['password' => $err_msg],
                'captcha' => $this->_generate_captcha()
            ]);
            exit;
        }
        $this->session->set_flashdata('error', $err_msg);
        redirect('login/register');
        return;
    }

    $nim = $this->input->post('nim', TRUE);

    $data = [
        'username'      => $nim,
        'nim'           => $nim,
        'nama'          => $this->input->post('nama',  TRUE),
        'email'         => $this->input->post('email', TRUE),
        'password'      => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
        'program_studi' => $this->input->post('prodi', TRUE),
        'role'          => 'mahasiswa',
        'status'        => 'aktif',
    ];

    if ($this->Login_model->register($data)) {
        if ($is_ajax) {
            header('Content-Type: application/json');
            echo json_encode([
                'status'  => 'success',
                'message' => 'Registrasi berhasil! Silakan login menggunakan NIM dan password Anda.'
            ]);
            exit;
        }
        $this->session->set_flashdata('success', 'Registrasi berhasil!');
        redirect('login');
    } else {
        if ($is_ajax) {
            header('Content-Type: application/json');
            echo json_encode([
                'status'  => 'error',
                'message' => 'Gagal menyimpan data. Silakan coba lagi.',
                'captcha' => $this->_generate_captcha()
            ]);
            exit;
        }
        $this->session->set_flashdata('error', 'Gagal registrasi.');
        redirect('login/register');
    }
}

    /* ─── Logout ─── */
    public function logout() {
        $this->session->sess_destroy();
        $this->session->set_flashdata('success', 'Berhasil logout. Sampai jumpa!');
        redirect('login');
    }

    /* ─── Login dengan Microsoft (SSO) ─── */
    public function microsoft() {
        header('Content-Type: application/json');

        // Pastikan hanya request POST/AJAX
        if ($this->input->method() !== 'post') {
            echo json_encode(['status' => 'error', 'message' => 'Method not allowed.']);
            exit;
        }

        $this->load->helper('cookie');
        $device_id = $this->input->cookie('device_id');
        if (!$device_id) {
            $device_id = bin2hex(random_bytes(16));
            set_cookie('device_id', $device_id, 315360000);
        }

        if ($this->Login_model->is_device_blocked($device_id)) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Perangkat Anda diblokir sementara karena terlalu banyak percobaan login yang gagal. Hubungi admin atau coba lagi dalam 24 jam.'
            ]);
            exit;
        }

        $email = trim($this->input->post('email', TRUE));
        $password = $this->input->post('password');

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['status' => 'error', 'message' => 'Format email Microsoft tidak valid.']);
            exit;
        }

        if (empty($password)) {
            echo json_encode(['status' => 'error', 'message' => 'Password tidak boleh kosong.']);
            exit;
        }

        // 1. Cek apakah email di-whitelist di sso_email_whitelist
        $this->db->where('email', $email);
        $this->db->limit(1);
        $whitelist = $this->db->get('sso_email_whitelist')->row();

        if (!$whitelist) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Email Microsoft Anda belum di-whitelist oleh Admin.'
            ]);
            exit;
        }

        // 2. Cari di database tabel users berdasarkan email
        $this->db->where('email', $email);
        $this->db->where('status', 'aktif');
        $this->db->limit(1);
        $user = $this->db->get('users')->row();

        if ($user) {
            // Verifikasi password (menggunakan method yang sama dengan Login_model)
            $password_correct = false;
            if (password_verify($password, $user->password)) {
                $password_correct = true;
            } elseif ($user->password === md5($password)) {
                $password_correct = true;
            }

            if ($password_correct) {
                $session_data = [
                    'user_id'    => $user->id,
                    'username'   => $user->username ?? $user->nim,
                    'nama'       => $user->nama,
                    'nim'        => $user->nim     ?? null,
                    'nidn'       => $user->nidn    ?? null,
                    'role'       => $user->role,
                    'prodi'      => $user->program_studi ?? null,
                    'foto'       => $user->foto    ?? null,
                    'logged_in'  => TRUE,
                    'login_time' => time(), // Simpan waktu login
                ];
                $this->session->set_userdata($session_data);

                // Hapus log percobaan gagal karena sudah berhasil login
                $this->Login_model->clear_failed_login($device_id);

                // Catat ke log history
                $this->Log_model->insert_log($user->id, $user->nama, $user->role, 'Login Berhasil (Microsoft SSO)');

                echo json_encode([
                    'status'   => 'success',
                    'redirect' => base_url($this->_redirect_after_login($user->role))
                ]);
                exit;
            } else {
                // Catat kegagalan login untuk device ini
                $this->Login_model->record_failed_login($device_id, $this->Log_model->get_real_ip(), $email);

                echo json_encode([
                    'status'  => 'error',
                    'message' => 'Password yang Anda masukkan salah.'
                ]);
                exit;
            }
        } else {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Email Microsoft terdaftar di Whitelist, namun tidak ditemukan akun user yang aktif dengan email tersebut.'
            ]);
            exit;
        }
    }

    /* ─── Refresh CAPTCHA (dipanggil via AJAX oleh tombol reload) ─── */
    public function refresh_captcha() {
        header('Content-Type: application/json');
        echo json_encode(['image' => $this->_generate_captcha()]);
        exit;
    }

    /* ─── Generate CAPTCHA bawaan CodeIgniter 3 ─── */
    private function _generate_captcha() {
        $img_path = FCPATH . 'assets/captcha/';
        if (!is_dir($img_path)) {
            @mkdir($img_path, 0755, true);
        }

        // Bersihkan file captcha lama supaya folder tidak menumpuk
        foreach (glob($img_path . '*.jpg') as $old_file) {
            if (time() - filemtime($old_file) > 300) {
                @unlink($old_file);
            }
        }

        $vals = [
            'word'        => random_string('alnum', 6),
            'img_path'    => $img_path,
            'img_url'     => base_url('assets/captcha/'),
            'img_width'   => 160,
            'img_height'  => 45,
            'expiration'  => 300,
            'word_length' => 6,
            'font_size'   => 18,
            'pool'        => 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789', // case-sensitive: huruf besar+kecil, tanpa karakter yang mirip (0/O/o, 1/I/l/i)
            'colors'      => [
                'background' => [255, 255, 255],
                'border'     => [230, 126, 34],
                'text'       => [44, 62, 80],
                'grid'       => [245, 222, 179],
            ],
        ];

        $cap = create_captcha($vals);

        // Simpan jawaban di session (bukan tabel DB) supaya lebih sederhana
        $this->session->set_userdata('captcha_word', $cap['word']);
        $this->session->set_userdata('captcha_time', time());

        return $cap['image'];
    }

    /* ─── Helper Redirect ─── */
    private function _redirect_after_login($role = null) {
        $role = $role ?? $this->session->userdata('role');
        
        switch ($role) {
            case 'admin':
            case 'kemahasiswaan': 
            case 'kaprodi':       
            case 'dosen_pembina': 
                return 'admin'; // Admin/Staff diarahkan ke halaman admin
            case 'bemdpm':
                return 'proposal?tipe=semua';
            default:              
                return 'dashboard'; // Mahasiswa diarahkan ke dashboard
        }
    }
}