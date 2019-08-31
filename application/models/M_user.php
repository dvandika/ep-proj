<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_user extends CI_Model
{
    private $table = 'tb_admin_user';

    public function login_admin($username, $password)
    {
        // $only_admin = ENVIRONMENT === 'production' ? "u.role='admin'" : '1=1';

        return $this->db->select('*')
            ->from('tb_admin_user u')
            ->where('u.username', $username)
            ->where('u.password', $password)
            // ->where($only_admin)
            ->get($this->table)
            ->row();
    }

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
        return $this->db->where('os_id', $id)
            ->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db->where('id', $id)
            ->delete($this->table);
    }
}
