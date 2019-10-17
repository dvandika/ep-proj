<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_report extends CI_Model
{
    /**
     *  ep_stock          => data material stock
     *  ep_stock_report   => data file upload (vendor)
     *  ep_stock_template => data template mreport
     */
    private $table = 'ep_stock_report';
    public function get_all($code = NULL)
    {
        $where = $code === NULL ? '1=1' : "s.VendorCode='$code'";
        return $this->db->select('s.id, s.vendorcode, s.notes, s.path, s.filename, s.datestock, s.originalname, s.uploadby, s.dateupload, v.vendorname')
            ->from("$this->table s")
            ->join('ep_vendor v', 's.VendorCode = v.VendorCode')
            ->order_by('datestock', 'ASC')
            ->where($where)
            ->get()
            ->result();
    }
    
    public function report($id, $file = NULL) //$filename is encrypted
    {
        $where = $file === NULL ? '1=1' : "r.filename = '$file'";
        return $this->db->select('r.id, r.filename, r.originalname, r.path')
        ->from("$this->table r")
        ->where($where)
        ->where('r.id', $id)
        ->get()
        ->row();
    }

    public function get_report($filename, $date)
    {
        return $this->db->select('s.*')
        ->from("$this->table s")
        ->where('originalname', $filename)
        ->like('datestock', $date)
        ->get()
        ->row();
    }

    public function get_templates($month = NULL, $code = NULL)
    {
        $vendor = $code === NULL ? '1=1' : "t.vendorcode = '$code'";
        $month = $month === NULL ? '1=1' : "t.month ='$month'";
        return $this->db->select('t.id, t.month, t.status, t.path, t.notes, v.vendorname, t.filename, t.originalname, t.uploadby, t.dateupload')
        // return $this->db->select('t.*, v.vendorname')
        ->from("ep_stock_template t")
        ->join('ep_vendor v', 'v.vendorcode = t.vendorcode')
        ->where($vendor)
        ->where($month)
        ->get()
        ->result();
    }

    public function get_template($id = NULL, $code = NULL)
    {
        $role = userdata()->role;
        if (in_array($role, ['admin', 'operator'])) {
            $where = $code === NULL ? '1=1' : "t.vendorcode = '$code'";
            return $this->db->select('t.id, t.month, t.status, t.path, t.notes, v.vendorname, t.filename, t.originalname, t.uploadby, t.dateupload')
                ->from('ep_stock_template t')
                ->join('ep_vendor v', 'v.vendorcode = t.vendorcode')
                // ->where('t.month', $month)
                ->where('t.id', $id)
                ->where($where)
                ->get()->row();
        } else if ($role === 'vendor') {
            $where = $code === NULL ? userdata()->code : $code;
            return $this->db->select('t.id, t.month, t.status, t.path, t.notes, v.vendorname, t.filename, t.originalname, t.uploadby, t.dateupload')
                ->from('ep_stock_template t')
                // ->where('t.month', $month)
                ->where('t.id', $id)
                ->join('ep_vendor v', 'v.vendorcode = t.vendorcode')
                ->where('t.vendorcode', $where)
                ->get()->row();
        }
    }

    public function insert_template($data)
    {
        return $this->db->insert('ep_stock_template', $data);
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update($data, $id)
    {
        return $this->db->where('id', $id)
            ->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db->where('id', $id)
            ->delete($this->table);
    }
}
