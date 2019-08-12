<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SupplierModel extends CI_Model {

    function show($where)
    {
        $this->db->select('a.*')
               ->select('b.id_pic, b.nama_pic, b.handphone, b.email_pic, b.username, b.tgl_reg_pic')
               
               ->from('supplier a')
               ->join('pic b', 'b.id_supplier = a.id_supplier');

        if(!empty($where)){
            foreach($where as $key => $value){
               if($value != null){
                    $this->db->where($key, $value);
                }
            }
        }

        $this->db->order_by('tgl_reg_supplier', 'DESC');
        return $this->db->get();
    }

    function add($data, $pic, $bank, $supply_group)
    {
        $this->db->trans_start();
        $this->db->insert('supplier', $data);
        

        if(!empty($pic)){
            $this->db->insert('pic', $pic);
        }

        if(!empty($bank)){
            $this->db->insert_batch('bank_account', $bank);
        }

        if(!empty($supply_group)){
            $this->db->insert_batch('supply_group', $supply_group);
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

    function edit($where, $data, $pic, $bank, $supply_group)
    {
        $this->db->trans_start();
        $this->db->where($where)->update('supplier', $data);
        

        if(!empty($pic)){
            $this->db->where($where)->update('pic', $pic);
        }

        if(!empty($bank)){
            $this->db->where($where)->delete('bank_account');
            $this->db->insert_batch('bank_account', $bank);
        }

        if(!empty($supply_group)){
            $this->db->where($where)->delete('supply_group');
            $this->db->insert_batch('supply_group', $supply_group);
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
        return $this->db->where($where)->delete($where);
    }



}

?>
