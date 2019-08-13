<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class BankModel extends CI_Model {

    function show($where)
    {
        $this->db->select('a.*')
               ->select('b.nama_supplier')
               
               ->from('bank_account a')
               ->join('supplier b', 'b.id_supplier = a.id_supplier');

        if(!empty($where)){
            foreach($where as $key => $value){
               if($value != null){
                    $this->db->where($key, $value);
                }
            }
        }

        $this->db->order_by('a.id_account', 'DESC');
        return $this->db->get();
    }

    function add($data)
    {
        return $this->db->insert('bank_account', $data);
    }

    function edit($where, $data)
    {
        return $this->db->where($where)->update('bank_account', $data);
    }

    function delete($where)
    {
        return $this->db->where($where)->delete('bank_account');
    }



}

?>
