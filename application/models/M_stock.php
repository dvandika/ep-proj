<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_stock extends CI_Model
{
    /**
     *  M_user
     *  ==================
     *  - Admin user
     */

    private $table = 'ep_stock';

    public function get_all($code = NULL)
    {
        $where = $code === NULL ? '1=1' : "s.VendorCode='$code'";
        return $this->db->select('s.id, s.vendorcode, s.note, s.filepath, s.stockdate, s.uploadby, s.dateupload, v.vendorname')
            ->from("$this->table s")
            ->join('ep_vendor v', 's.VendorCode = v.VendorCode')
            ->where($where)
            ->get()
            ->result();
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
