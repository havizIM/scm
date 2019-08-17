<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class OrderModel extends CI_Model {

    function show($where)
    {
        $this->db->select('a.*')
               ->select('b.id_supplier, b.nama_supplier, b.alamat as alamat_supplier, b.telepon as telepon_supplier, b.fax as fax_supplier, b.email as email_supplier, b.npwp, b.status_supplier')
               ->select('c.id_warehouse, c.nama_warehouse, c.alamat as alamat_warehouse, c.telepon as telepon_warehouse, c.fax as fax_warehouse, c.email as email_warehouse')
               
               ->from('order a')
               ->join('supplier b', 'b.id_supplier = a.id_supplier')
               ->join('warehouse c', 'c.id_warehouse = a.id_warehouse');

        if(!empty($where)){
            foreach($where as $key => $value){
               if($value != null){
                    $this->db->where($key, $value);
                }
            }
        }

        $this->db->order_by('a.tgl_order', 'DESC');
        return $this->db->get();
    }

    function detail($where)
    {
        $this->db->select('a.*')
               ->select('b.*')
               ->select('c.*')
               
               ->from('order_detail a')
               ->join('product b', 'b.id_product = a.id_product')
               ->join('category c', 'c.id_category = b.id_category');

        if(!empty($where)){
            foreach($where as $key => $value){
               if($value != null){
                    $this->db->where($key, $value);
                }
            }
        }

        $this->db->order_by('a.id_product', 'DESC');
        return $this->db->get();
    }

    function add($data, $detail)
    {
        $this->db->trans_start();
        $this->db->insert('order', $data);
        
        if(!empty($detail)){
            $this->db->insert_batch('order_detail', $detail);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    function edit($where, $data, $detail)
    {
        $this->db->trans_start();
        $this->db->where($where)->update('order', $data);
        

        if(!empty($detail)){
            $this->db->where($where)->delete('order_detail');
            $this->db->where($where)->insert_batch('order_detail', $detail);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    function delete($where)
    {
        return $this->db->where($where)->delete('order');
    }



}

?>
