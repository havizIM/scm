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
                    ->join('order b ','b.no_order = a.order', 'left')
                    ->join('warehouse c', 'c.id_warehouse = b.warehouse', 'left')
                    ->join('supplier d','d.id_supplier = b.supplier');
        $this->db->where($where);
        return $this->db->get();
    }

  }