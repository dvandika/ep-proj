<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cetak extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        auth_checker('vendor');

        $this->load->model(['m_ordersheet', 'm_vendor', 'm_report']);
    }

    public function index()
    {
        redirect('/');
    }

    public function ordersheet($os_no = NULL, $md5) //encrypted
    {
        if (!userdata()) {
            $code = '31011520';
            $company = 'PT JAEIL Indonesia';
        } else {
            $code = userdata()->code;
            $company = userdata()->company;
        }

        if (!$os_no) {
            $os_no = $this->input->post('os_no');
        }
        //
        $data = [
            'ordersheet' => $this->m_ordersheet->get_os($os_no, $md5),
            'date' => date('d-M-y'),
            'time' => date('H:i'),
            'vendor' => $this->m_vendor->get_by_code($code),
            'company' => $company,
            'created' => 'PT Astra Komponen Indonesia'
        ];
        $html = $this->load->view('downloads/osdata-pdf', $data, true);
        $this->load->library('pdfbuilder');
        $filename = "OS$os_no-" . date('Ymd', strtotime($data['ordersheet'][0]->os_delivery_date));
        //
        $print_count = $data['ordersheet'][0]->os_print_count;
        $date_print = ($print_count == 0) ? date('Y-m-d H:i:s') : $data['ordersheet'][0]->os_date_printed;
        $update_data = [
            'os_print_status' => 1,
            'os_print_count' => $print_count + 1,
            'os_date_printed' => $date_print
        ];
        $update = $this->m_ordersheet->update_by_no($update_data, $os_no);
        if ($this->db->affected_rows() > 0) {
            $pdfbuilder = $this->pdfbuilder->build($html, $filename, true, 'A4', 'landscape', 1);
        } else {
            return $this->output->set_status_header(500);
        }
    }

    public function templates($month = NULL)
    {
        if (!userdata()) {
            $code = '31011520';
            $company = 'PT JAEIL Indonesia';
        } else {
            $code = userdata()->code;
            $company = userdata()->company;
        }
        if (!$month) {
            $month = date('M Y');
        } else {
            // get data by month
            $template = $this->m_report->get_template($month, $code);
            
        }
        
        // get data by month
        
    }
}
