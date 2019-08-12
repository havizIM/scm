<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ProductModel extends CI_Model {

    function show($where)
    {
        $this->db->select('*')
               ->from('product a')

               ->join('category b', 'b.id_category = a.id_category');

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
