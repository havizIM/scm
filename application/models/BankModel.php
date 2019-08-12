<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class BankModel extends CI_Model {

    function show($where)
    {
        $this->db->select('*')
               ->from('bank_account');

        if(!empty($where)){
            foreach($where as $key => $value){
               if($value != null){
                    $this->db->where($key, $value);
                }
            }
        }

        $this->db->order_by('id_account', 'DESC');
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
