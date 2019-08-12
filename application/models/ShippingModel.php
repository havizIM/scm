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
                    ->join('invoice b','b.no_invoice = a.invoice','left')
                    ->join('order c','c.no_order = b.order')
                    ->join('warehouse d', 'd.id_warehouse = c.warehouse')
                    ->where($where);
        return $this->db->get();
    }
  }