<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SupplyGroupModel extends CI_Model {

    function show($where)
    {
        $this->db->select('a.*')
               ->select('b.id_group, b.nama_group, b.lokasi_group')
               
               ->from('supply_group a')
               ->join('group b', 'b.id_group = a.id_group');

        if(!empty($where)){
            foreach($where as $key => $value){
               if($value != null){
                    $this->db->where($key, $value);
                }
            }
        }

        $this->db->order_by('a.id_group', 'DESC');
        return $this->db->get();
    }

    function add($data)
    {
        return $this->db->insert('supply_group', $data);
    }

    function edit($where, $data)
    {
        return $this->db->where($where)->update('supply_group', $data);
    }

    function delete($where)
    {
        return $this->db->where($where)->delete('supply_group');
    }



}

?>
