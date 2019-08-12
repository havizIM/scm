<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class GroupModel extends CI_Model {

    function show($where)
    {
        $this->db->select('*')
               ->from('group');

        if(!empty($where)){
            foreach($where as $key => $value){
               if($value != null){
                    $this->db->where($key, $value);
                }
            }
        }

        $this->db->order_by('id_group', 'DESC');
        return $this->db->get();
    }

    function add($data)
    {
        return $this->db->insert('group', $data);
    }

    function delete($where)
    {
        return $this->db->where($where)->delete('group');
    }



}

?>
