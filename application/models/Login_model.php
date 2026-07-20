<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->_ensure_table();
    }

    /**
     * Buat tabel login_attempts jika belum ada
     */
    private function _ensure_table() {
        if (!$this->db->table_exists('login_attempts')) {
            $this->db->query("
                CREATE TABLE IF NOT EXISTS `login_attempts` (
                    `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    `device_id` VARCHAR(64) NOT NULL,
                    `ip_address` VARCHAR(45) NOT NULL,
                    `username` VARCHAR(100) NOT NULL,
                    `attempts` INT(11) DEFAULT 1,
                    `last_attempt` DATETIME NOT NULL,
                    INDEX (`device_id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ");
        }
    }

    public function cek_login($username, $password) {
        $this->db->from('users');
        $this->db->group_start();
            $this->db->where('username', $username);
            $this->db->or_where('nim', $username);
            $this->db->or_where('email', $username);
        $this->db->group_end();
        $this->db->where('status', 'aktif');
        $this->db->limit(1);

        $user = $this->db->get()->row();

        if (!$user) return false;
        if (password_verify($password, $user->password)) return $user;
        if ($user->password === md5($password)) {
            // Auto-upgrade MD5 password to secure bcrypt hash
            $new_hash = password_hash($password, PASSWORD_DEFAULT);
            $this->db->where('id', $user->id);
            $this->db->update('users', array('password' => $new_hash));
            return $user;
        }
        if ($user->password === $password) {
            // Auto-upgrade plain text password to secure bcrypt hash
            $new_hash = password_hash($password, PASSWORD_DEFAULT);
            $this->db->where('id', $user->id);
            $this->db->update('users', array('password' => $new_hash));
            return $user;
        }

        return false;
    }

    /**
     * Registrasi mahasiswa baru
     */
    public function register($data) {
        return $this->db->insert('users', $data);
    }

    /**
     * Cek apakah NIM sudah terdaftar
     */
    public function nim_exists($nim) {
        return $this->db->where('nim', $nim)->count_all_results('users') > 0;
    }

    // =======================================================
    // BRUTE FORCE PROTECTION (DEVICE BASED)
    // =======================================================

    /**
     * Cek apakah device ini sedang diblokir karena terlalu banyak gagal login
     */
    public function is_device_blocked($device_id) {
        // Hapus log yang sudah kadaluarsa (lebih dari 24 jam)
        $this->db->where('last_attempt <', date('Y-m-d H:i:s', strtotime('-24 hours')));
        $this->db->delete('login_attempts');

        $this->db->where('device_id', $device_id);
        $attempt = $this->db->get('login_attempts')->row();

        if ($attempt && $attempt->attempts >= 5) {
            return true;
        }
        return false;
    }

    /**
     * Catat kegagalan login untuk device tertentu
     */
    public function record_failed_login($device_id, $ip_address, $username) {
        $this->db->where('device_id', $device_id);
        $attempt = $this->db->get('login_attempts')->row();

        if ($attempt) {
            $this->db->where('id', $attempt->id);
            $this->db->update('login_attempts', [
                'attempts' => $attempt->attempts + 1,
                'ip_address' => $ip_address,
                'username' => $username,
                'last_attempt' => date('Y-m-d H:i:s')
            ]);
        } else {
            $this->db->insert('login_attempts', [
                'device_id' => $device_id,
                'ip_address' => $ip_address,
                'username' => $username,
                'attempts' => 1,
                'last_attempt' => date('Y-m-d H:i:s')
            ]);
        }
    }

    /**
     * Hapus riwayat gagal jika user berhasil login
     */
    public function clear_failed_login($device_id) {
        $this->db->where('device_id', $device_id);
        $this->db->delete('login_attempts');
    }
}