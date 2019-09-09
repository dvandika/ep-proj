<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_authentication extends CI_Model
{
    public function login_vendor($username, $password)
    {
        return $this->db->select("a.ID, a.Fullname, a.Username, a.Email, a.Role, v.VendorCode, v.VendorName Company")
            ->from("ep_vendor_auth a")
            ->join('ep_vendor v', 'a.VendorCode = v.VendorCode')
            ->where('a.Username', $username)
            ->where('a.Password', $password)
            ->get()
            ->row();
    }

    public function login_admin($username, $password)
    {
        $only_admin = ENVIRONMENT === 'production' ? "u.role='admin'" : '1=1';

        return $this->db->select('*')
            ->from('ep_admin u')
            ->where('u.username', $username)
            ->where('u.password', $password)
            ->where($only_admin)
            ->get()
            ->row();
    }
}
