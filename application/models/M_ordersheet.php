<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_ordersheet extends CI_Model
{
    // private $table = 'tb_ordersheet';
    private $table = 'tb_os_data';
    public function get_all($code = NULL)
    {
        // $where = $code === NULL ? '1=1' : "Vendor='$code'";
        // return $this->db->select('o.*, od.MaterialDesc v.VendorName VendorName')
        // ->join('tb_vendor v', 'o.Vendor = v.VendorCode')
        // ->join('tb_ordersheet_detail od','od.OSNumber = o.OSNumber')
        // ->where($where)
        // ->from('tb_ordersheet o')
        // ->order_by('o.DeliveryDate', 'ASC')
        // ->get()
        // ->result();
        
        $where = $code === NULL ? '1=1' : "os_vendor='$code'";
        return $this->db->select('o.*, v.name vendor_name')
            ->join('tb_vendor v', 'o.os_vendor=v.code')
            ->where($where)
            ->from("$this->table o")
            ->order_by('os_delivery_date', 'ASC')
            ->get()
            ->result();
    }

    public function insert($data)
    {
        // agar tidak redundansi
        $valid = $this->validasi($data);

        if ($valid) {
            $this->db->insert($this->table, $data);
            if ($this->db->affected_rows() > 0) {
                return TRUE;
            }
        } else {
            return FALSE;
        }
        // return $this->db->insert($this->table, $data);
    }

    public function validasi($data)
    {
        $check = $this->db->get_where($this->table, [
            'os_no' => $data['os_no'],
            'os_material' => $data['os_material'],
            'os_delivery_date' => $data['os_delivery_date']
        ]);
        if ($check->num_rows() > 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function update($data, $id)
    {
        return $this->db->where('os_id', $id)
            ->update($this->table, $data);
    }

    public function update_by_no($data, $os_no)
    {
        return $this->db->where('os_no', $os_no)
            ->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db->where('id', $id)
            ->delete($this->table);
    }
}
