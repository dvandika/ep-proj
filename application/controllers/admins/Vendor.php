<?php
defined('BASEPATH') or exit('No direct script access allowed');

// List Vendor
// Create Vendor
// Edit Vendor
// Delete Vendor

class Vendor extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        auth_checker('admin, operator');
        $this->load->model(['m_vendor']);
    }

    public function index()
    {
        $list_vendor = $this->m_vendor->get_all();
        return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode($list_vendor));
    }

    public function insert()
    {
        
    }
    
    public function edit()
    {

    }

    public function delete()
    {

    }
}
