<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
{
    /**
     *  ini untuk upload report bagian vendor
     */
    public function __construct()
    {
        parent::__construct();

        auth_checker('vendor');
        $this->load->model(['m_stock', 'm_vendor', 'm_report', 'm_material']);
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

    public function upload()
    {
        // upload report daily vendor
    }

    public function download_template()
    {
        $month = $this->input->get('bln');
        $code = userdata()->code;
        $vendor = userdata()->username;
        // model get month template
        if (!$month) {
            $month = date('m');
        }
        $templates = $this->m_report->get_template($month, $code);
        redirect("vendors/report/templates?bln=$month&vendor=$vendor&orig=".$templates->originalname."&file=".$templates->filename);
        /* return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode($data)); */
    }

    public function templates()
    {
        $get = new stdClass;
        $get->month = $this->input->get('bln');
        $get->vendor = $this->input->get('vendor');
        $get->filename = $this->input->get('file');
        $get->orig = $this->input->get('orig');

        $this->load->view('downloads/templates', $get);
    }

    public function upload_report()
    {
        $date = $this->input->post('date');
        $notes = $this->input->post('notes');
        //
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
            // $filename = "Lap $short $month.$ext";
            $filename = "Lap $short $date.$ext";
            $upload_path = FCPATH . 'storage/docs//';
            $this->upload_conf['upload_path'] = $upload_path;
            $this->upload_conf['file_name'] = $filename;
            $this->load->library('upload', $this->upload_conf);
            $this->upload->validate_upload_path();

            $reader = new Xlsx();
            $spreadsheet = $reader->load($file_tmp);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            array_shift($sheetData);
            $data['sheet'] = $sheetData;

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
}
