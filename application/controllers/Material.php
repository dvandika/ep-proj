<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Material extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // auth_checker('admin,operator');
        $this->load->model(['m_vendor', 'm_material']);
    }

    public function test()
    {

        $test = $this->db->select("a.materialnumber, a.materialdescription,sum(b.os_kanban_qty) as kanban_total, c.vendorname")
        ->from("ep_material a")
        ->join("ep_os_data b", "a.materialnumber = b.os_material", "left")
        ->join("ep_vendor c", "c.vendorcode = b.os_vendor","left")
        ->get()
        ->result();
        echo $this->db->last_query() . "<br>";
        var_dump($test);exit;
    }
    public function index()
    {
        $data['material'] = $this->m_material->get_all();
        return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
}