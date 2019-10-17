<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stock extends CI_Controller
{
    /**
     *  ini untuk upload report bagian vendor
     */
    public function __construct()
    {
        parent::__construct();

        auth_checker('vendor, admin');
        $this->load->model(['m_stock', 'm_vendor']);
    }

    public function index()
    {
        
    }

}