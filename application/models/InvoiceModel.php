<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class InvoiceModel extends CI_Model
  {

    public function show($where)
    {
        $this->db->select('a.*')
                ->select('b.*')
                ->select('c.*')
                ->select('d.*')

                ->from('invoice a')
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

    public function detail($where)
    {
        $this->db->select('*')->from('invoice_detail');

        if(!empty($where)){
            foreach($where as $key => $value){
               if($value != null){
                    $this->db->where($key, $value);
                }
            }
        }
        
        return $this->db->get();
    }

    function add($data, $detail)
    {
        $this->db->trans_start();
        $this->db->insert('invoice', $data);
        
        if(!empty($detail)){
            $this->db->insert_batch('invoice_detail', $detail);
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
        $this->db->where($where)->update('invoice', $data);
        

        if(!empty($pic)){
            $this->db->where($where)->delete('invoice_detail', $detail);
            $this->db->where($where)->insert_batch('invoice_detail', $detail);
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
        return $this->db->where($where)->delete('invoice');
    }

  }