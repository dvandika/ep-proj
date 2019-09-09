<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Material extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        auth_checker('admin,operator');
        $this->load->model(['m_vendor', 'm_material']);
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