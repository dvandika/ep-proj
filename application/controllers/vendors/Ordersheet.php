<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *  Ordersheet untuk ADMIN
 *  - Create (upload)
 *  - View (list OS)
 *  - Edit (edit status)
 *  - Delete by Row OS
 */

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Ordersheet extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        auth_checker('vendor');

        $this->load->model(['m_ordersheet', 'm_vendor']);
    }

    public function index() // list
    {
        
        $code = userdata()->code;
        $data['ordersheet'] = $this->m_ordersheet->get_all($code);

        return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
    // only get OS by userdata()->code; 
    public function get($os_no = NULL)
    {
        // $code = userdata()->code;
        // -- start of debugging code
        if (!userdata()) {
            $code = '31011520';
            $company = 'PT JAEIL Indonesia';
        } else {
            $code = userdata()->code;
            $company = userdata()->company;
        }
        // -- end of debugging code
        if (!$os_no) {
            $os_no = $this->input->post('os_no');
        }
        
        $data['ordersheet'] = $this->m_ordersheet->get_os($os_no);
        $data['date'] = date('Y-M-d');
        $data['vendor'] = $this->m_vendor->get_by_code($code);
        $data['company'] = $company;
        $data['created'] = "PT. ASKI";
        return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
}
