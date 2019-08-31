<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_authorized extends CI_Model
{
    private $table = 'ep_vendor_auth';

    public function login_vendor($username, $password)
    {
        return $this->db->select("a.ID, a.Fullname, a.Username, a.Email, a.Role, v.VendorCode, v.VendorName Company")
        ->from("$this->table a")
        ->join('ep_vendor v', 'a.VendorCode = v.VendorCode')
        ->where('a.Username', $username)
        ->where('a.Password', $password)
        ->get()
        ->row();
        // return $this->db->select("a.id, a.fullname, a.username, a.email, a.role, v.name company")
        //     ->from('tb_v_authorized a')
        //     ->join('tb_vendor v', 'a.vendor_code = v.code')
        //     ->where('a.username', $username)
        //     ->where('a.password', $password)
        //     ->get()->row();
    }

    public function get_all()
    {
        return $this->db->select('*')
            ->from($this->table)
            ->where('uid !=', userdata()->uid)
            ->get()
            ->result();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update($data, $id)
    {
        return $this->db->where('uid', $id)
            ->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db->where('uid', $id)
            ->delete($this->table);
    }
}
