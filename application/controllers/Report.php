<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Report extends CI_Controller
{
    /**
     *  Middleware Report
     *  - list report
     *  - upload report
     *  - download report
     *  ///////////
     *  - list templates
     *  - download templates
     *  - upload templates 
     */
    public $role;
    public $upload_conf = [
        'allowed_types' => 'xls|xlsx',
        'upload_path' => '',
        'encrypt_name' => true
    ];
    public function __construct()
    {
        parent::__construct();

        auth_checker('admin,vendor,operator');
        $this->role = userdata()->role;
        $this->load->model(['m_stock', 'm_vendor', 'm_report', 'm_material']);
    }
    // Show Report
    public function index()
    {
        $id = $this->input->get('id');
        $role = userdata()->role;
        if (in_array($role, ['admin', 'operator'])) {
            if ($id) {
                $data['reports'] = $this->m_report->report($id);
            } else {
                $data['report'] = $this->m_report->get_all();
            }
        } else if ($role === 'vendor') {
            $data['report'] = $this->m_report->get_all(userdata()->code);
        }
        return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    // Report
    public function upload()
    {
        // vendor only
        $_date = date('Y-m-d', strtotime($this->input->post('date')));
        $date = date('d.m.y', strtotime($_date));
        $month = date('m', strtotime($_date));
        $notes = $this->input->post('notes');
        $code = userdata()->code;

        //$code = $this->input->post('vendor'); // default from userdata
        $short = $this->m_vendor->get_shortname($code)->VendorShortname;
        // define files
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
            // encrypt files
            $filename = "Lap $short $date.$ext";
            $upload_path = FCPATH . "storage/docs/report/$month/";

            $this->upload_conf['upload_path'] = $upload_path;
            $this->upload_conf['file_name'] = $filename;
            $this->upload_conf['allowed_types'] = 'xlsx|xls';
            $this->load->library('upload', $this->upload_conf);
            $this->upload->validate_upload_path();

            // reader
            $reader = new Xlsx();
            $spreadsheet = $reader->load($file_tmp);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            array_shift($sheetData);
            // $data['sheet'] = $sheetData;

            // validasi report
            $cek = $this->m_report->get_report($filename, $_date);
            if (!$cek) {
                if (!$this->upload->do_upload('file')) {
                    $data['files'] = $files;
                    $data['error'] = array('error' => $this->upload->display_errors());
                } else {
                    $data['files'] = $files;
                    $upload_data = $this->upload->data();
                    $data['upload_data'] = $upload_data;
                    $file = [
                        'notes' => $notes,
                        'originalname' => $filename,
                        'vendorcode' => $code,
                        'path' => $upload_path,
                        'filename' => $upload_data['file_name'],
                        'datestock' => $_date,
                        'uploadby' => userdata()->username
                    ];
                    // insert to db
                    $save = $this->m_report->insert($file);
                    $data['saved'] = $files;

                    // masukkan data per baris ke db
                    $st_success = [];
                    $st_error = [];

                    foreach ($sheetData as $i) {
                        /**
                         *  1   - VendorCode
                         *  3   - Material Number ASKI
                         *  7   - Level Stock (LS)
                         *  8   - Keb per Day (KPD)
                         *  9   - Stock Awal
                         *  10  - Plan Prod
                         *  11  - OS Pending
                         *  13  - Actual Stock
                         *  15  - SLS
                         */
                        $vendor = str_replace(' ', '', $i[1]);
                        $material = str_replace(' ', '', $i[3]);

                        $cek = $this->m_stock->get_stock($material, $vendor);

                        $stock_data = [
                            'VendorCode' => $vendor,
                            'MaterialNumber' => $material,
                            'LS' => intval($i[7]),
                            'KPD' => intval($i[8]),
                            'ActualStock' => intval($i[13]),
                            'SLS' => intval($i[15])
                        ];
                        if (!$cek) {
                            $save = $this->m_stock->insert($stock_data);
                        } else {
                            $stock_data['datemodified'] = date('Y-m-d H:i:s');
                            $save = $this->m_stock->update($stock_data, $material);
                        }
                    }
                }
            } else {
                // message jika data sudah ada
                $data['message'] = 'Data sudah ada. Jika ini merupakan kesalahan, harap hubungi Pak XX (088-888-888)';
                return $this->output
                    ->set_status_header(500)
                    ->set_content_type('application/json')
                    ->set_output(json_encode($data));
            }
            $data['message'] = 'Data berhasil di upload.';
            // $data['data'] = $sheetData;

            return $this->output
                ->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode($data));
        }
    }

    // Templates

    public function templates($id = NULL)
    {
        // list templates
        if ($id) {
            $data['templates'] = $this->m_report->get_template($id);
        } else {
            $role = userdata()->role;
            if (in_array($role, ['admin', 'operator'])) {
                $data['templates'] = $this->m_report->get_templates();
            } else if ($role === 'vendor') {
                $code = userdata()->code;
                $data['templates'] = $this->m_report->get_templates(null, $code);
            }
        }

        return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function upload_templates()
    {
        // admin only
        $_date = $this->input->post('date'); // dalam bentuk DD-MM-YYYY
        $date = date('m.Y', strtotime($_date));
        // $month = date('m', strtotime($_date));
        $month = bulan_tahun(date('Y-m-d', strtotime($_date)));

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
            // encrypt files
            $filename = "Lap $short $date.$ext";

            $upload_path = FCPATH . 'storage/docs/templates/';
            $this->upload_conf['upload_path'] = $upload_path;
            $this->upload_conf['file_name'] = $filename;
            $this->load->library('upload', $this->upload_conf);
            $this->upload->validate_upload_path();

            $reader = new Xlsx();
            $spreadsheet = $reader->load($file_tmp);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            array_shift($sheetData);

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
                        'month' => $month,
                        'originalname' => $filename,
                        'vendorcode' => $code,
                        'path' => $upload_path,
                        'filename' => $upload_data['file_name'],
                        'uploadby' => userdata()->username
                    ];
                    $save = $this->m_report->insert_template($file);
                }
            }
        }
        // validates before upload
    }

    public function download_template($id = NULL)
    {
        $enc = $this->input->get('d');
        // vendor only
        $code = userdata()->code;

        $template = $this->m_report->get_template($id, $code);
        force_download($template->originalname, file_get_contents($template->path . $enc));
    }

    public function download($id = NULL)
    {
        $enc = $this->input->get('r');
        $role = userdata()->role;
        if (in_array($role, ['admin', 'operator'])) {
            $report = $this->m_report->report($id, $enc);
            $path = $report->path . "/" . $report->filename;
            // var_dump($path);
            // var_dump($report);exit;
            force_download($report->originalname, file_get_contents($report->path . $enc));
            // var_dump(json_encode($path));exit;
        }
    }
}
