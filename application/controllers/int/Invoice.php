<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Invoice extends CI_Controller {

    use REST_Controller {
        REST_Controller::__construct as private __resTraitConstruct;
    } 

    function __construct()
    {
        parent::__construct();
        $this->__resTraitConstruct();

        $this->where    = array('token' => $this->input->get_request_header('SCM-INT-KEY', TRUE));
        $this->user     = $this->AuthModel->cekAuthInt($this->where);

        $this->load->model('InvoiceModel');
    }

    public function index_get()
    {
        if($this->user->num_rows() == 0){
            $this->response(array('status' => false, 'error' => 'Unauthorization token'), 401);
        } else {
            $user = $this->user->row();
            
            $where = array(
                'a.no_invoice'    => $this->get('no_invoice'),
                'd.id_supplier'   => $this->get('id_supplier')
            );

            $show   = $this->InvoiceModel->show($where)->result();
            $invoice   = array();

            foreach($show as $key){
                $json           = array();
                $grand_total    = 0;

                $json['no_invoice']         = $key->no_invoice;
                $json['no_order']           = $key->no_order;
                $json['warehouse']      = array(
                    'id_warehouse'      => $key->id_warehouse,
                    'nama_warehouse'    => $key->nama_warehouse,
                    'alamat'            => $key->alamat,
                    'telepon'           => $key->telepon,
                    'fax'               => $key->fax,
                    'email'             => $key->email
                );
                $json['supplier']           = array(
                    'id_supplier'        => $key->id_supplier,
                    'nama_supplier'      => $key->nama_supplier,
                    'alamat'             => $key->alamat,
                    'telepon'            => $key->telepon,
                    'fax'                => $key->fax,
                    'email'              => $key->email,
                    'npwp'               => $key->npwp,
                    'status_supplier'    => $key->status_supplier
                );
                $json['tgl_invoice']        = $key->tgl_invoice;
                $json['tgl_tempo']          = $key->tgl_tempo;
                $json['status_invoice']     = $key->status_invoice;
                
                $json['detail']         = array();

                $where_2   = array('no_invoice' => $key->no_invoice);
                $detail   = $this->InvoiceModel->detail($where_2);

                foreach($detail->result() as $key1){
                    $json_ba = array();
                    $grand_total += $key1->total_harga;

                    $json_ba['deskripsi']   = $key1->deskripsi;
                    $json_ba['harga']       = $key1->harga;
                    $json_ba['qty']         = $key1->qty;
                    $json_ba['ppn']         = $key1->ppn;
                    $json_ba['total_harga'] = $key1->total_harga;

                    $json['detail'][] = $json_ba;
                }

                $json['grand_total']         = $grand_total;

                $invoice[] = $json;
            }

            $response = array(
                'status'    => true,
                'message'   => 'Success fetch warehouses',
                'data'      => $invoice
            );

            $this->response($response, 200);
        }
    }

}
