<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class PaymentModel extends CI_Model
  {

    public function show($where)
    {
        $this->db->select('a.*')
                ->select('b.*')
                ->select('c.*')

                ->from('payment a')
                ->join('bank_account b ','b.id_account = a.id_account', 'left')
                ->join('supplier c', 'c.id_supplier = b.id_supplier', 'left');

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
        $this->db->select('a.*')
             ->select('b.*')
             ->select('c.*')
             ->select('d.*')
             ->select('e.*')
        
             ->from('payment_detail a')
             ->join('invoice b ','b.no_invoice = a.no_invoice', 'left')
             ->join('order c', 'c.no_order = b.no_order', 'left')
             ->join('supplier d', 'd.id_supplier = c.id_supplier', 'left')
             ->join('payment e', 'e.no_payment = a.no_payment', 'left');

        if(!empty($where)){
            foreach($where as $key => $value){
               if($value != null){
                    $this->db->where($key, $value);
                }
            }
        }
        
        return $this->db->get();
    }

    public function add($data, $detail)
    {
        $this->db->insert('payment', $data);

        if(!empty($detail)){
            $this->db->insert_batch('payment_detail', $detail);
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
        $this->db->where($where)->update('payment', $data);
        

        if(!empty($detail)){
            $this->db->where($where)->delete('payment_detail');
            $this->db->insert_batch('payment_detail', $detail);
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

    public function delete($where)
    {
        return $this->db->where($where)->delete('payment');
    }

  }