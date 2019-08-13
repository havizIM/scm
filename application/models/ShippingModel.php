<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class ShippingModel extends CI_Model
  {

    public function show($where)
    {
        $this->db->select('a.*')
                ->select('b.*')
                ->select('c.*')
                ->select('d.*')

                ->from('shipping a')
                ->join('order b ','b.no_order = a.no_order', 'left')
                ->join('warehouse c', 'c.id_warehouse = b.id_warehouse', 'left')
                ->join('supplier d','d.id_supplier = b.id_supplier');

        if(!empty($where)){
            foreach($where as $key => $value){
               if($value != null){
                    $this->db->where($key, $value);
                }
            }
        }

        return $this->db->get();
    }

    function detail($where)
    {
        $this->db->select('a.*')
               ->select('b.*')
               ->select('c.*')
               
               ->from('shipping_detail a')
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
        $this->db->insert('shipping', $data);
        
        if(!empty($detail)){
            $this->db->insert_batch('shipping_detail', $detail);
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

    function edit($where, $data)
    {
        $this->db->trans_start();
        $this->db->where($where)->update('shipping', $data);

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
        return $this->db->where($where)->delete('shipping');
    }

  }