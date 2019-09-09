<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_user extends CI_Model
{
    /**
     *  M_user
     *  ==================
     *  - Admin user
     */
    
    private $table = 'ep_admin';

    public function get_all()
    {
        return $this->db->select('*')
        ->from($this->table)
        ->where('id !=', userdata()->id)
        ->get()
        ->result();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update($data, $id)
    {
        return $this->db->where('id', $id)
            ->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db->where('id', $id)
            ->delete($this->table);
    }
}
