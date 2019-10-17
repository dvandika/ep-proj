<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Stock extends CI_Controller
{
    public $upload_conf = [
        'allowed_types' => 'xls|xlsx',
        'upload_path' => '',
        'encrypt_name' => true
    ];
    public function __construct()
    {
        parent::__construct();

        auth_checker('admin,operator,vendor,developer');
        $this->load->model(['m_vendor', 'm_stock', 'm_material', 'm_report']);
    }

    public function index()
    {
        $role = userdata()->role;
        if (in_array($role, ['admin', 'operator'])) {
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

    public function template()
    {
        $role = userdata()->role;
        if (in_array($role, ['admin', 'operator'])) {
            $data['stock'] = $this->m_report->get_template();
            return $this->output
                ->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode($data));
        } else if ($role === 'vendor') {
            return $this->output
                ->set_status_header(500)
                ->set_content_type('application/json');
        }
    }

    public function report()
    {
        $role = userdata()->role;
        if (in_array($role, ['admin', 'operator'])) {
            $data['stock'] = $this->m_report->get_all();
            return $this->output
                ->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode($data));
        } else if ($role === 'vendor') {
            $code = userdata()->code;
            $data['stock'] = $this->m_report->get_all($code);
            return $this->output
                ->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode($data));
            // return $this->output
            //     ->set_status_header(500)
            //     ->set_content_type('application/json');
        }
    }

    public function upload_template()
    {
        $date = $this->input->post('date');

        $month = date('m.Y', strtotime($date));
        $code = $this->input->post('vendor');

        $short = $this->m_vendor->get_shortname($code)->VendorShortname;
        $file_mimes = array(
            'application/octet-stream', 'application/vnd.ms-excel',
            'application/excel', 'application/vnd.msexcel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        );
        $files = $_FILES['file'];
        $file_name = $_FILES['file']['name'];
        $file_type = $_FILES['file']['type'];
        $file_tmp = $_FILES['file']['tmp_name'];

        if (isset($file_name) && in_array($file_type, $file_mimes)) {
            $arr_file = explode('.', $file_name);
            $ext = end($arr_file);
            $filename = "Lap $short $month.$ext";
            $upload_path = FCPATH . 'storage/docs/templates/';
            $this->upload_conf['upload_path'] = $upload_path;
            $this->upload_conf['file_name'] = $filename;
            $this->load->library('upload', $this->upload_conf);
            $this->upload->validate_upload_path();

            $reader = new Xlsx();
            $spreadsheet = $reader->load($file_tmp);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            array_shift($sheetData);
            $data['sheet'] = $sheetData;
            // untuk masuk database ep_stock_template (store template)
            $cek = $this->m_report->get_template($filename, $code);
            if (!$cek) {
                if (!$this->upload->do_upload('file')) {
                    $data['files'] = $files;
                    $data['error'] = array('error' => $this->upload->display_errors());
                } else {
                    $data['files'] = $files;
                    $upload_data = $this->upload->data();
                    $data['upload_data'] = $upload_data;
                    $file = [
                        'notes' => $this->input->post('notes'),
                        'originalname' => $filename,
                        'vendorcode' => $code,
                        'path' => $upload_path,
                        'filename' => $upload_data['file_name'],
                        'uploadby' => userdata()->username
                    ];
                    $save = $this->m_report->insert_template($file);

                    // untuk masuk database ep_stock (per material)
                    $st_success = [];
                    $st_error = [];
                    foreach ($sheetData as $i) {
                        /**
                         *  VendorCode, MaterialNumber, KPD, SLS
                         *  1  - VendorCode
                         *  3  - Material Number ASKI
                         *  8  - KPD
                         *  15 - SLS
                         */
                        $vendor = str_replace(' ', '', $i[1]);
                        $material = str_replace(' ', '', $i[3]);
                        $cek = $this->m_stock->get_stock($material, $vendor);
                        $stock_data =  [
                            'VendorCode' => $vendor,
                            'MaterialNumber' => $material,
                            'KPD' => $i[8],
                            'SLS' => $i[15]
                        ];
                        if (!$cek) {
                            $save = $this->m_stock->insert($stock_data);
                        } else {
                            $stock_data['DateModified'] = date('Y-m-d H:i:s');
                            $save = $this->m_stock->update($stock_data, $material);
                        }
                    }
                }
            } else {
                $data['message'] = 'Data already exist.';
                return $this->output
                    ->set_status_header(500)
                    ->set_content_type('application/json')
                    ->set_output(json_encode($data));
            }


            $data['message'] = 'Data berhasil diupload.';
            $data['sheet'] = $sheetData;

            return $this->output
                ->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($data));
        }
    }

    public function download_template()
    {
        $month = $this->input->get('bln');
        $code = userdata()->code;
        // $data = $this->
        $template = $this->m_stock->get_template($month, $code);
    }

    public function do_upload()
    {
        $date = $this->input->post('date');

        $month = date('m', strtotime($date));

        $file_mimes = array(
            'application/octet-stream', 'application/vnd.ms-excel',
            'application/excel', 'application/vnd.msexcel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        );
        $files = $_FILES['file'];
        // var_dump($files);exit;
        $file_name = $_FILES['file']['name'];
        $file_type = $_FILES['file']['type'];
        $file_tmp = $_FILES['file']['tmp_name'];

        // $this->upload_conf['upload_path'] = realpath(APPPATH . '../storage/uploads/' . $month . '/');

        if (isset($file_name) && in_array($file_type, $file_mimes)) {
            $arr_file = explode('.', $file_name);
            $ext = end($arr_file);


            $this->upload_conf['upload_path'] = FCPATH . 'storage/uploads/' . $month . '/';
            $this->load->library('upload', $this->upload_conf);
            $this->upload->validate_upload_path();

            // if (!$this->upload->do_upload('file')) {
            //     $data['files'] = $files;
            //     $data['error'] = array('error' => $this->upload->display_errors());
            //     return $this->output
            //         ->set_status_header(500)
            //         ->set_content_type('application/json')
            //         ->set_output(json_encode($data));
            // } else {
            //     $data['files'] = $files;
            //     $data['upload_data'] = $this->upload->data();
            // }

            $reader = new Xlsx();
            $spreadsheet = $reader->load($file_tmp);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            array_shift($sheetData);
            $data['sheet'] = $sheetData;
            foreach ($sheetData as $i) {
                /**
                 * ===============================================================================
                 *  0 - ID                              9  - Stok Awal (Filled by Vendor)
                 *  1 - Vendor ID                       10 - Plan Prod Vendor (Filled by Vendor)
                 *  2 - Vendor Name                     11 - OS Pending
                 *  3 - Material Number ASKI            12 - OS Reg 
                 *  4 - Material Number Vendor          13 - Actual Stock (Formula)
                 *  5 - Material Description            14 - Level Stock (Formula)
                 *  6 - Date (Generated                 15 - Std Level Stock (Set by Admin)
                 *  7 - Level Stock (Formula)           16 - Status (Formula)
                 *  8  - Keb per day
                 * ===============================================================================
                 *  Ini untuk update stock di database material
                 *  - ActualStock
                 *  - KebPerDay
                 *  - StdLevelStock
                 */
                // $stock_data = [
                //     'ActualStock' => $i[13],
                //     ''
                // ];              
            }
            return $this->output
                ->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode($data));
        }
        return $this->output->set_status_header(400);
    }

    public function search($date = NULL)
    { }

    public function download($id = null)
    {
        if ($id) { }
    }
}
