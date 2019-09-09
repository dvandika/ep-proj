<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_material extends CI_Model
{
    private $table = 'ep_material';

    public function get_all()
    {
        return $this->db->select('m.*, v.vendorname, v.vendorshortname')
            ->from("$this->table m")
            ->join('ep_vendor v', 'm.vendorcode = v.vendorcode')
            ->get()
            ->result();
    }

    public function get($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row();
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
