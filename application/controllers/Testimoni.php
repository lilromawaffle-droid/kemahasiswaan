<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testimoni extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load library dan helper yang dibutuhkan
        $this->load->library('form_validation');
        $this->load->helper('form');
        
        // Proteksi: Pastikan user sudah login sebelum isi testimoni
        if (!$this->session->userdata('logged_in')) {
            redirect('login'); 
        }
    }

    // Menampilkan Form Testimoni
    public function tambah() {
        $data['title'] = 'Tambah Testimoni Alumni';
        $this->load->view('testimoni_form', $data);
    }

    // Menangani Proses Simpan Data ke Database
    // Menangani Proses Simpan Data ke Database
    public function simpan() {
        // 1. Set Aturan Validasi Form
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('posisi', 'Pekerjaan / Prodi', 'required|trim');
        $this->form_validation->set_rules('testimoni', 'Testimoni', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, kembalikan ke halaman form
            $this->tambah();
        } else {
            // 2. Siapkan Data Inputan Utama
            $data_simpan = [
                'nama'      => $this->input->post('nama', TRUE),
                'posisi'    => $this->input->post('posisi', TRUE),
                'testimoni' => $this->input->post('testimoni', TRUE),
                'rating'    => $this->input->post('rating', TRUE),
                'urutan'    => $this->input->post('urutan', TRUE) ? $this->input->post('urutan', TRUE) : 0,
                'aktif'     => $this->input->post('aktif', TRUE) ? $this->input->post('aktif', TRUE) : 0,
                'linkedin'  => $this->input->post('linkedin', TRUE),
                'pinterest' => $this->input->post('pinterest', TRUE),
                'foto'      => $this->session->userdata('foto') ? 'uploads/users/' . $this->session->userdata('foto') : NULL
            ];

            // 3. Proses Upload Foto (Jika ada file yang dipilih)
            if (!empty($_FILES['foto']['name'])) {
                $config['upload_path']   = './uploads/testimoni/'; 
                $config['allowed_types'] = 'jpg|jpeg|png|webp';
                $config['max_size']      = 2048; // Maksimal 2MB
                $config['file_name']     = 'testi_' . time() . '_' . uniqid();

                // Buat folder otomatis jika belum ada di project-mu
                if (!is_dir($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, TRUE);
                }

                // PERBAIKAN: Gunakan huruf besar 'Upload' dan lakukan initialize eksplisit
                $this->load->library('Upload');
                $this->upload->initialize($config);

                if ($this->upload->do_upload('foto')) {
                    $upload_data = $this->upload->data();
                    $data_simpan['foto'] = 'uploads/testimoni/' . $upload_data['file_name'];
                } else {
                    // DEBUG MODE: Jika gagal upload, munculkan pesan error di layar dan hentikan proses
                    echo "<h3>Proses Upload Gagal!</h3>";
                    echo $this->upload->display_errors();
                    echo "<br><a href='".base_url('testimoni/tambah')."'>Kembali ke Form</a>";
                    die();
                }
            }

            // 4. Eksekusi Query ke Database (Insert Data)
            $insert = $this->db->insert('testimoni_alumni', $data_simpan);

            if ($insert) {
                $this->session->set_flashdata('success', 'Testimoni Anda berhasil dikirim!');
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data ke database.');
            }

            // 5. Redirect balik
            redirect('dashboard');
        }
    }
}