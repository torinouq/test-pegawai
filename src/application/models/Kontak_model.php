<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Kontak_model extends CI_Model

{

    public function get_all() {
        return $this->db->get('telepon')->result();
    }
    public function get_by_id($id) {
        $this->db->where('id', $id);
        return $this->db->get('telepon')->row();
    }
    public function insert($data) {
        return $this->db->insert('telepon', $data);
    }
    public function update($id, $data) {
        $this->db->set($data);
        $this->db->where('id', $id);
        $this->db->update('telepon', $data, ['id' => $id]);
    }
    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('telepon');
    }
}