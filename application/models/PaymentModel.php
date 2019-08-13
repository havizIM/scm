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
        
             ->from('payment_detail a')
             ->join('invoice b ','b.no_invoice = a.no_invoice', 'left')
             ->join('order c', 'c.no_order = b.no_order', 'left')
             ->join('supplier d', 'c.id_supplier = c.id_supplier', 'left');

        if(!empty($where)){
            foreach($where as $key => $value){
               if($value != null){
                    $this->db->where($key, $value);
                }
            }
        }
        
        return $this->db->get();
    }

  }