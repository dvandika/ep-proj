<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_vendor extends CI_Model
{
    private $table = 'ep_vendor';

    /**
     *  Model Vendor
     *  ===================
     *  - Create, Update, Delete
     */

    public function get_all($code = NULL)
    {
        $where = $code === NULL ? '1=1' : "vendorcode='$code'";
        return $this->db->select('*')
            ->where($where)
            ->from($this->table)
            ->get()
            ->result();
    }

    public function get_shortname($code)
    {
        return $this->db->select('VendorShortname')->get($this->table)->row();
    }

    public function get_by_code($code)
    {
        return $this->db->get_where($this->table, ['VendorCode' => $code])->row();
    }

    public function get($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->result();
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
