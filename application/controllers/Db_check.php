<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Db_check extends CI_Controller {
    public function index() {
        $this->load->database();
        echo "FORUM ALUMNI COMMENTS TABLE SCHEMA DETAILS:\n";
        $query = $this->db->query("SHOW COLUMNS FROM forum_alumni_comments");
        foreach ($query->result() as $row) {
            echo "Field: {$row->Field} | Type: {$row->Type} | Null: {$row->Null} | Key: {$row->Key} | Default: " . (is_null($row->Default) ? 'NULL' : $row->Default) . " | Extra: {$row->Extra}\n";
        }
    }
}
