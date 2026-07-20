<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Direktorat_model extends CI_Model
{
    private $table = 'konten_direktorat';

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
                    `id`         INT(11)       NOT NULL AUTO_INCREMENT,
                    `judul`      VARCHAR(255)  NOT NULL,
                    `isi`        TEXT          NULL,
                    `gambar`     VARCHAR(255)  NULL COMMENT 'path relatif dari root project',
                    `link`       VARCHAR(255)  NULL,
                    `aktif`      TINYINT(1)    NOT NULL DEFAULT 1,
                    `created_at` DATETIME      NULL,
                    `updated_at` TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`),
                    KEY `idx_aktif` (`aktif`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
            $this->_seed_initial_data();
            log_message('info', 'Table konten_direktorat created and seeded.');
        }
    }

    private function _seed_initial_data()
    {
        $now = date('Y-m-d H:i:s');
        $data = [
            'judul'      => 'Direktorat Kemahasiswaan, Karier, dan Alumni',
            'isi'        => 'Direktorat Kemahasiswaan, Karier dan Alumni (KKA) merupakan Direktorat yang berfungsi mengelola prestasi, kegiatan mahasiswa, pengembangan karakter, kesejahteraan mahasiswa, pengembangan Karier dan kontribusi alumni. Dengan keberadaan Direktorat KKA diharapkan seluruh mahasiswa dapat mengembangkan minat dan bakat sehingga dapat meningkatkan kompetensi khususnya dalam mempersiapkan diri dalam memasuki dunia kerja.',
            'gambar'     => 'assets/Direktorat.png',
            'aktif'      => 1,
            'created_at' => $now,
        ];
        $this->db->insert($this->table, $data);
    }

    public function get_all($filter_aktif = null)
    {
        $this->db->order_by('id', 'ASC');
        if ($filter_aktif !== null) {
            $this->db->where('aktif', $filter_aktif);
        }
        return $this->db->get($this->table)->result();
    }

    public function get_aktif()
    {
        return $this->db->where('aktif', 1)
                        ->order_by('id', 'ASC')
                        ->get($this->table)
                        ->result();
    }

    public function get_by_id($id)
    {
        return $this->db->where('id', (int)$id)->get($this->table)->row();
    }

    public function insert($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data)
    {
        $this->db->where('id', (int)$id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db->where('id', (int)$id)->delete($this->table);
    }

    public function toggle_aktif($id)
    {
        $item = $this->get_by_id($id);
        if (!$item) return false;
        return $this->db->where('id', (int)$id)
                        ->update($this->table, ['aktif' => $item->aktif ? 0 : 1]);
    }

    public function count_all()   { return $this->db->count_all($this->table); }
    public function count_aktif() { return $this->db->where('aktif', 1)->count_all_results($this->table); }
}
