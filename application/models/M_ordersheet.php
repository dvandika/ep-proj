<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_ordersheet extends CI_Model
{
    // private $table = 'ep_ordersheet';
    private $table = 'ep_os_data';
    public function get_all($code = NULL)
    {
        // $where = $code === NULL ? '1=1' : "Vendor='$code'";
        // return $this->db->select('o.*, od.MaterialDesc v.VendorName VendorName')
        // ->join('ep_vendor v', 'o.Vendor = v.VendorCode')
        // ->join('ep_ordersheet_detail od','od.OSNumber = o.OSNumber')
        // ->where($where)
        // ->from('ep_ordersheet o')
        // ->order_by('o.DeliveryDate', 'ASC')
        // ->get()
        // ->result();
        if ($code = NULL) {
            $where = '1=1';
        } else {
            $where = "os_vendor='$code'";
        }
        
        $where = $code === NULL ? '1=1' : "os_vendor='$code'";
        return $this->db->select('count(o.os_material) as count_material, o.*, GROUP_CONCAT(o.os_material) as material_no, GROUP_CONCAT(o.os_material_desc) as material_desc, v.vendorname vendor_name')
            ->join('ep_vendor v', 'o.os_vendor=v.vendorcode')
            ->where($where)
            ->group_by('os_no')
            ->from("$this->table o")
            ->order_by('os_delivery_date', 'ASC')
            ->get()
            ->result();
    }

    public function get_os($os_no, $md5)
    {
        return $this->db->select('o.*, v.vendorname vendor_name')
        ->join('ep_vendor v', 'o.os_vendor = v.vendorcode')
        ->where('o.os_print_enc', $md5)
        ->where('o.os_no', $os_no)
        ->from("$this->table o")
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
