<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mitra_model extends CI_Model
{
    private $table_mitra = 'mitra_kerjasama';
    private $table_recog = 'international_recognitions';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->_ensure_tables();
    }

    private function _ensure_tables()
    {
        // Table Mitra
        if (!$this->db->table_exists($this->table_mitra)) {
            $this->db->query("
                CREATE TABLE IF NOT EXISTS `{$this->table_mitra}` (
                    `id` INT(11) NOT NULL AUTO_INCREMENT,
                    `name` VARCHAR(255) NOT NULL,
                    `logo` VARCHAR(255) NULL,
                    `default_icon` VARCHAR(100) DEFAULT 'fas fa-handshake',
                    `urutan` INT(11) NOT NULL DEFAULT 0,
                    `aktif` TINYINT(1) NOT NULL DEFAULT 1,
                    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
            $this->_seed_mitra();
        }

        // Table Recognition
        if (!$this->db->table_exists($this->table_recog)) {
            $this->db->query("
                CREATE TABLE IF NOT EXISTS `{$this->table_recog}` (
                    `id` INT(11) NOT NULL AUTO_INCREMENT,
                    `name` VARCHAR(255) NOT NULL,
                    `logo` VARCHAR(255) NULL,
                    `default_icon` VARCHAR(100) DEFAULT 'fas fa-trophy',
                    `urutan` INT(11) NOT NULL DEFAULT 0,
                    `aktif` TINYINT(1) NOT NULL DEFAULT 1,
                    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
            $this->_seed_recog();
        }
    }

    private function _seed_mitra()
    {
        $data = [
            ['name' => 'Bank BRI', 'logo' => 'assets/Bank BRI.png', 'default_icon' => 'fas fa-university', 'urutan' => 1, 'aktif' => 1],
            ['name' => 'BPJS Kesehatan', 'logo' => 'assets/BPJS Kesehatan.png', 'default_icon' => 'fas fa-hospital-user', 'urutan' => 2, 'aktif' => 1],
            ['name' => 'Pertamina', 'logo' => 'assets/Pertamina.png', 'default_icon' => 'fas fa-gas-pump', 'urutan' => 3, 'aktif' => 1],
            ['name' => 'BRIN', 'logo' => 'assets/BRIN.png', 'default_icon' => 'fas fa-microscope', 'urutan' => 4, 'aktif' => 1],
        ];
        $this->db->insert_batch($this->table_mitra, $data);
    }

    private function _seed_recog()
    {
        $data = [
            ['name' => 'Bank BRI', 'logo' => 'assets/Bank BRI.png', 'default_icon' => 'fas fa-chart-line', 'urutan' => 1, 'aktif' => 1],
            ['name' => 'Webometri', 'logo' => 'assets/Webometrics.png', 'default_icon' => 'fas fa-globe', 'urutan' => 2, 'aktif' => 1],
            ['name' => 'Times Higher Education', 'logo' => 'assets/Times Higher Education.png', 'default_icon' => 'fas fa-graduation-cap', 'urutan' => 3, 'aktif' => 1],
            ['name' => 'Green Metric', 'logo' => 'assets/Green Metric.png', 'default_icon' => 'fas fa-leaf', 'urutan' => 4, 'aktif' => 1],
            ['name' => 'AppliedHE', 'logo' => 'assets/AppliedHE.png', 'default_icon' => 'fas fa-chalkboard-user', 'urutan' => 5, 'aktif' => 1],
            ['name' => 'World University Rankings', 'logo' => 'assets/World University Rankings.png', 'default_icon' => 'fas fa-trophy', 'urutan' => 6, 'aktif' => 1],
        ];
        $this->db->insert_batch($this->table_recog, $data);
    }

    // ==================== MITRA FUNCTIONS ====================
    public function get_all_mitra($only_active = false)
    {
        $this->db->order_by('urutan', 'ASC');
        if ($only_active) {
            $this->db->where('aktif', 1);
        }
        return $this->db->get($this->table_mitra)->result();
    }

    public function get_mitra_by_id($id)
    {
        return $this->db->get_where($this->table_mitra, ['id' => $id])->row();
    }

    public function insert_mitra($data)
    {
        return $this->db->insert($this->table_mitra, $data);
    }

    public function update_mitra($id, $data)
    {
        return $this->db->update($this->table_mitra, $data, ['id' => $id]);
    }

    public function delete_mitra($id)
    {
        return $this->db->delete($this->table_mitra, ['id' => $id]);
    }

    public function toggle_mitra($id)
    {
        $item = $this->get_mitra_by_id($id);
        if ($item) {
            $aktif = $item->aktif ? 0 : 1;
            return $this->db->update($this->table_mitra, ['aktif' => $aktif], ['id' => $id]);
        }
        return false;
    }

    // ==================== RECOGNITIONS FUNCTIONS ====================
    public function get_all_recog($only_active = false)
    {
        $this->db->order_by('urutan', 'ASC');
        if ($only_active) {
            $this->db->where('aktif', 1);
        }
        return $this->db->get($this->table_recog)->result();
    }

    public function get_recog_by_id($id)
    {
        return $this->db->get_where($this->table_recog, ['id' => $id])->row();
    }

    public function insert_recog($data)
    {
        return $this->db->insert($this->table_recog, $data);
    }

    public function update_recog($id, $data)
    {
        return $this->db->update($this->table_recog, $data, ['id' => $id]);
    }

    public function delete_recog($id)
    {
        return $this->db->delete($this->table_recog, ['id' => $id]);
    }

    public function toggle_recog($id)
    {
        $item = $this->get_recog_by_id($id);
        if ($item) {
            $aktif = $item->aktif ? 0 : 1;
            return $this->db->update($this->table_recog, ['aktif' => $aktif], ['id' => $id]);
        }
        return false;
    }
}
