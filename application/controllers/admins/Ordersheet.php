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

        auth_checker('admin,operator');

        $this->load->model(['m_ordersheet', 'm_vendor']);
    }

    public function index() // list
    {
        $data['ordersheet'] = $this->m_ordersheet->get_all();

        return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
    
        public function do_upload()
        {
            $file_mimes = [
                'application/vnd.ms-excel', 'application/excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            ];
            $file_name = $_FILES['file']['name'];
            $file_type = $_FILES['file']['type'];
            $file_tmp = $_FILES['file']['tmp_name'];
            if (isset($file_name) && in_array($file_type, $file_mimes)) {
                $arr_file = explode('.', $file_name);
                $ext = end($arr_file);
                $reader = new Xlsx();
                $spreadsheet = $reader->load($file_tmp);
                $sheetData = $spreadsheet->getActiveSheet()->toArray();
                array_shift($sheetData);
                array_pop($sheetData);
                $st_success = [];
                $st_error = [];
                foreach ($sheetData as $i) {

                    if (empty($i[0])) {
                        continue;
                    }

                    $os = str_replace(' ', '', $i[0]);
                    $vendor = str_replace(' ', '', $i[1]);
                    $material = str_replace(' ', '', $i[3]);
                    $transm = str_replace('.', ':', $i[6]);
                    $deliverydate = date('Y-m-d', strtotime($i[7]));


                    $os_detail = [
                        'os_id' => '',
                        'os_no' => $os,
                        'os_vendor' => $vendor,
                        'os_po_number' => $i[2],
                        'os_material' => $material,
                        'os_material_desc' => $i[4],
                        'os_bun' => $i[5],
                        'os_transm' => $transm,
                        'os_delivery_date' => $deliverydate,
                        'os_kanban_qty' => intval($i[11]),
                        'os_schedule_qty' => intval($i[8]),
                        'os_sum_schedule_qty' => intval($i[12]),
                        'os_status' => $i[10],
                        'os_status_item' => $i[9],
                        'os_print_enc' => md5($os),
                        'os_print_status' => 'UNPRINTED', // set default UNPRINTED
                        'os_date_printed' => NULL,
                        'os_date_uploaded' => date('Y-m-d H:i:s'),
                        'os_upload_by' => userdata()->username // userdata()->username
                    ];
                    $save = $this->m_ordersheet->insert($os_detail);
                    if ($save) {
                        $st_success[]++;
                    }
                    if (!$save) {
                        $st_error[]++;
                    }
                }
                $data['success'] = array_sum($st_success);
                $data['failed'] = array_sum($st_error);
                $data['sheetData'] = $sheetData;

                return $this->output
                    ->set_status_header(200)
                    ->set_content_type('application/json')
                    ->set_output(json_encode($data));
            }
            return $this->output->set_status_header(400);
        }

    public function debugdownload()
    {
        $data['vendor'] = $this->input->post('vendor');
        $html = $this->load->view('downloads/debug-download', $data, true);
        $this->load->library('pdfbuilder');
        $filename = 'DEBUGOS-' . date('Ymd');
        // $this->pdfbuilder->build($html, $filename, true);
        $this->pdfbuilder->build($html, $filename, true, 'A4', 'landscape');
    }

    public function download()
    {
        $selected = $this->input->post('selected');
        $selected = json_decode($selected);
        $vendor_code = $selected[0]->os_vendor;
        $data['nama'] = userdata()->fullname;
        $data['vendor'] = $this->m_vendor->get_by_code($vendor_code);
        $data['os'] = $selected;
        // var_dump(array_sum($data));
        // var_dump($data);
        // exit;

        $html = $this->load->view('downloads/osdata-pdf', $data, true);
        $filename = 'OS-' . date('Ymd');

        $this->load->view('downloads/osdata-pdf', $data);
        // $this->load->library('pdfbuilder');
        // $this->pdfbuilder->build($html, $filename, true, 'F4', 'landscape');
    }

    public function download_os($vendor, $deliverydate)
    {
        $fullname = userdata()->fullname;
        #
        $data['nama'] = $fullname;
        $data['os'] = $this->m_ordersheet->download_data($vendor, $deliverydate);
        $html = $this->load->view('downloads/osdata-pdf', $data, true);
        $filename = 'OS' . date('Ymd');

        $this->load->library('pdfbuilder');
        $this->pdfbuilder->build($html, $filename, false);
    }

    public function complete($os_no)
    {
        $data['status'] = 'C';
        $save = $this->m_ordersheet->update_by_no($data, $os_no);
        if ($save) {
            set_success("Status order sheet dengan nomor $os_no berhasil diperbaharui..");
        } else {
            set_error('Tidak dapat menyimpan');
        }

        redirect('ordersheet');
    }
}
