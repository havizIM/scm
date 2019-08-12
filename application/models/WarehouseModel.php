<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class WarehouseModel extends CI_Model {

    function show($where)
    {
        $this->db->select('a.*')
               ->select('b.id_user, b.nama_lengkap, b.email as email_user, b.telepon as tlp_user')
               ->select('c.id_group, c.nama_group, c.lokasi_group')
               
               ->from('warehouse a')
               ->join('user b', 'b.id_user = a.id_user')
               ->join('group c', 'c.id_group = a.id_group');

        if(!empty($where)){
            foreach($where as $key => $value){
               if($value != null){
                    $this->db->where($key, $value);
                }
            }
        }

        $this->db->order_by('tgl_reg_warehouse', 'DESC');
        return $this->db->get();
    }

    function add($data)
    {
        return $this->db->insert('warehouse', $data);
    }

    function edit($where, $data)
    {
        return $this->db->where($where)->update('warehouse', $data);
    }

    function delete($where)
    {
        return $this->db->where($where)->delete('warehouse');
    }



}

?>
