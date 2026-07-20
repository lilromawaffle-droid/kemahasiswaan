<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Testimoni_model extends CI_Model
{
    private $table = 'testimoni_alumni';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->_ensure_table();
    }

    private function _ensure_table()
    {
        if (!$this->db->table_exists($this->table)) {
            $this->db->query("
                CREATE TABLE IF NOT EXISTS `{$this->table}` (
                    `id` INT(11) NOT NULL AUTO_INCREMENT,
                    `nama` VARCHAR(100) NOT NULL,
                    `posisi` VARCHAR(100) NOT NULL,
                    `testimoni` TEXT NOT NULL,
                    `rating` INT(1) NOT NULL DEFAULT 5,
                    `foto` VARCHAR(255) NULL,
                    `linkedin` VARCHAR(255) NULL,
                    `pinterest` VARCHAR(255) NULL,
                    `urutan` INT(11) NOT NULL DEFAULT 0,
                    `aktif` TINYINT(1) NOT NULL DEFAULT 1,
                    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
            $this->_seed_data();
        }
    }

    private function _seed_data()
    {
        $data = [
            [
                'nama' => 'Mitchela Smith',
                'posisi' => 'UI/UX Design',
                'testimoni' => 'Explore a diverse selection of courses all in one platform, designed to cater to various learning needs and interests, making education more accessible and convenient. Explore a diverse selection of courses all in one platform, designed to cater to various learning needs and interests, making education.',
                'rating' => 4,
                'foto' => null,
                'linkedin' => 'https://linkedin.com',
                'pinterest' => 'https://pinterest.com',
                'urutan' => 1,
                'aktif' => 1
            ],
            [
                'nama' => 'John Doe',
                'posisi' => 'Software Engineer',
                'testimoni' => 'Belajar di Fakultas Industri Kreatif Telkom University memberikan landasan teoritis yang kuat dan keterampilan praktis yang luar biasa. Kurikulumnya sangat selaras dengan kebutuhan industri modern saat ini.',
                'rating' => 5,
                'foto' => null,
                'linkedin' => 'https://linkedin.com',
                'pinterest' => 'https://pinterest.com',
                'urutan' => 2,
                'aktif' => 1
            ],
            [
                'nama' => 'Sarah Jennings',
                'posisi' => 'Creative Director',
                'testimoni' => 'Fasilitas laboratorium yang lengkap dan dukungan dari dosen-dosen yang berpengalaman membantu saya mengeksplorasi potensi kreatif saya secara maksimal, hingga mampu bersaing secara global.',
                'rating' => 5,
                'foto' => null,
                'linkedin' => 'https://linkedin.com',
                'pinterest' => 'https://pinterest.com',
                'urutan' => 3,
                'aktif' => 1
            ]
        ];
        $this->db->insert_batch($this->table, $data);
    }

    public function get_all_testimoni($only_active = false)
    {
        $this->db->order_by('urutan', 'ASC');
        if ($only_active) {
            $this->db->where('aktif', 1);
        }
        return $this->db->get($this->table)->result();
    }

    public function get_testimoni_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    public function insert_testimoni($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update_testimoni($id, $data)
    {
        return $this->db->update($this->table, $data, ['id' => $id]);
    }

    public function delete_testimoni($id)
    {
        return $this->db->delete($this->table, ['id' => $id]);
    }

    public function toggle_testimoni($id)
    {
        $item = $this->get_testimoni_by_id($id);
        if ($item) {
            $aktif = $item->aktif ? 0 : 1;
            return $this->db->update($this->table, ['aktif' => $aktif], ['id' => $id]);
        }
        return false;
    }
}
