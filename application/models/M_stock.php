<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_stock extends CI_Model
{
    /**
     *  ep_stock          => data material stock
     *  ep_stock_report   => data file upload (vendor)
     *  ep_stock_template => data template mreport
     */
    // private $table = 'ep_stocks';
    private $table = 'ep_stock';
    public function get_all($code = NULL)
    {
        $where = $code === NULL ? '1=1' : "s.VendorCode='$code'";
        return $this->db->select('s.id, s.vendorcode, s.notes, s.path, s.filename, s.datestock, s.uploadby, s.dateupload, v.vendorname')
            ->from("$this->table s")
            ->join('ep_vendor v', 's.VendorCode = v.VendorCode')
            ->where($where)
            ->get()
            ->result();
    }

    public function get_stock($material_num, $vendor)
    {
        return $this->db->get_where("$this->table", ['MaterialNumber'=>$material_num, 'VendorCode'=> $vendor])->result();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update($data, $id)
    {
        return $this->db->where('MaterialNumber', $id)
            ->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db->where('id', $id)
            ->delete($this->table);
    }
}
