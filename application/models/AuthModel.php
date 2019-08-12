<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AuthModel extends CI_Model {

    function cekAuthInt($where)
    {
      $this->db->select('a.*')
               ->select('b.id_warehouse, b.nama_warehouse, b.alamat as alm_warehouse, b.telepon as telp_supplier, b.fax, b.tgl_reg_warehouse')
               ->select('c.*')

               ->from('user a')
               ->join('warehouse b', 'b.id_user = a.id_user', 'left')
               ->join('group c', 'c.id_group = b.id_group', 'left');

      
      $this->db->where($where);
               
      $this->db->limit(1);
      return $this->db->get();
    }

    function updateAuthInt($where, $data)
    {
      return $this->db->where($where)->update('user', $data);
    }

    function cekAuthExt($where)
    {
      $this->db->select('a.*')
               ->select('b.*')

               ->from('pic a')
               ->join('supplier b', 'b.id_supplier = a.id_supplier', 'left');

      
      $this->db->where($where);
               
      $this->db->limit(1);
      return $this->db->get();
    }

    function updateAuthExt($where, $data)
    {
      return $this->db->where($where)->update('pic', $data);
    }



}

?>
