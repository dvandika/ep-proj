<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Stock extends CI_Controller
{
    public $config_upload = [];
    public function __construct()
    {
        parent::__construct();

        auth_checker('admin,operator,vendor,developer');
        $this->load->model(['m_vendor', 'm_stock']);


        $this->config_upload['allowed_types'] = 'xls|xlsx';
        $this->config_upload['upload_path'] = realpath(APPPATH . '../storage/uploads/' . date('m') . '/');
        $this->config_upload['encrypted_name'] = TRUE;

        $this->load->library('upload', $this->config_upload);
        $this->upload->validate_upload_path();
    }

    public function index()
    {
        $role = userdata()->role;
        if (in_array($role, ['admin','operator']))
        {
            $data['stock'] = $this->m_stock->get_all();
            return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
        } else if ($role === 'vendor') {
            $data['stock'] = $this->m_stock->get_all(userdata()->code);
            return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
        }
    }

    public function do_upload()
    {
        var_dump($this->input->post());
        $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel',
        'application/excel', 'application/vnd.msexcel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $files = $_FILES['file'];
        var_dump($files);exit;
        $file_name = $_FILES['file']['name'];
        $file_type = $_FILES['file']['type'];
        $file_tmp = $_FILES['file']['tmp_name'];

        if (isset($file_name) && in_array($file_type, $file_mimes)) {
            $arr_file = explode('.', $file_name);
            $ext = end($arr_file);

            $upload = $this->upload->do_upload('file');
            if ($upload) {
                $data = $this->upload->data();
                // var_dump($this->upload->data());
                exit;
            } else {
                return false;
            }

            // $reader = new Xlsx();
            // $spreadsheet = $reader->load($file_tmp);
            // $sheetData = $spreadsheet->getActiveSheet()->toArray();

            // $data = $sheetData;
            return $this->output
                ->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode($data));
        }
        return $this->output->set_status_header(400);
    }

    public function download($id = null)
    {
        if ($id) {
            
        }
    }
}
