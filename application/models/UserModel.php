<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends CI_Model {

    function show($where)
    {
        $this->db->select('*')
               ->from('user');

        if(!empty($where)){
            foreach($where as $key => $value){
               if($value != null){
                    $this->db->where($key, $value);
                }
            }
        }

        $this->db->where('level !=', 'Admin');
        $this->db->order_by('tgl_reg_user', 'DESC');
        return $this->db->get();
    }

    function add($data)
    {
        return $this->db->insert('user', $data);
    }

    function edit($where, $data)
    {
        return $this->db->where($where)->update('user', $data);
    }

    function delete($where)
    {
        return $this->db->where($where)->delete('user');
    }



}

?>
