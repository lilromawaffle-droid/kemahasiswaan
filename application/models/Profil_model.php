<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profil_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->check_and_create_table();
    }

    private function check_and_create_table() {
        if (!$this->db->table_exists('profil_fakultas')) {
            $sql = "CREATE TABLE `profil_fakultas` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `judul` varchar(255) NOT NULL,
                `isi` text NOT NULL,
                `gambar` varchar(255) DEFAULT NULL,
                `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
            $this->db->query($sql);

            $sql_insert = "INSERT INTO `profil_fakultas` (`id`, `judul`, `isi`, `gambar`) VALUES (1, 'Tentang Fakultas Industri Kreatif', '<p>Selamat datang di Fakultas Industri Kreatif Telkom University.</p>', NULL);";
            $this->db->query($sql_insert);
        }
    }

    public function get_tentang_kami() {
        $query = $this->db->get_where('profil_fakultas', ['id' => 1]);
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            // Default jika belum ada data sama sekali
            return (object) [
                'judul' => 'Tentang Kami',
                'isi' => '',
                'gambar' => ''
            ];
        }
    }

    public function update_tentang_kami($data) {
        $this->db->where('id', 1);
        $this->db->update('profil_fakultas', $data);
        return $this->db->affected_rows() > 0;
    }
}
