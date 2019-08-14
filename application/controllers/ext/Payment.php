<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Payment extends CI_Controller {

    use REST_Controller {
        REST_Controller::__construct as private __resTraitConstruct;
    } 

    function __construct()
    {
        parent::__construct();
        $this->__resTraitConstruct();

        $this->where    = array('token' => $this->input->get_request_header('SCM-EXT-KEY', TRUE));
        $this->user     = $this->AuthModel->cekAuthExt($this->where);

        $this->load->model('PaymentModel');
    }

    public function index_get()
    {
        if($this->user->num_rows() == 0){
            $this->response(array('status' => false, 'error' => 'Unauthorization token'), 401);
        } else {
            $user = $this->user->row();
            
            $where = array(
                'a.no_payment'      => $this->get('no_payment'),
                'c.id_supplier'     => $user->id_supplier
            );

            $show   = $this->PaymentModel->show($where)->result();
            $payment   = array();

            foreach($show as $key){
                $json = array();

                $json['no_payment']       = $key->no_payment;
                $json['supplier']       = array(
                    'id_supplier'        => $key->id_supplier,
                    'nama_supplier'      => $key->nama_supplier,
                    'alamat'             => $key->alamat,
                    'telepon'            => $key->telepon,
                    'fax'                => $key->fax,
                    'email'              => $key->email,
                    'npwp'               => $key->npwp,
                    'status_supplier'    => $key->status_supplier
                );
                $json['account']       = array(
                    'id_account'         => $key->id_account,
                    'id_supplier'        => $key->id_supplier,
                    'nama_supplier'      => $key->nama_supplier,
                    'nama_bank'          => $key->nama_bank,
                    'cabang'             => $key->cabang,
                    'pemilik_account'    => $key->pemilik_account,
                    'no_rekening'        => $key->no_rekening
                );
                $json['tgl_payment']    = $key->tgl_payment;
                $json['status_payment'] = $key->status_payment;
                $json['total_bayar']    = $key->total_bayar;
                
                $json['detail']         = array();

                $where_2   = array('a.no_payment' => $key->no_payment);
                $detail   = $this->PaymentModel->detail($where_2);

                foreach($detail->result() as $key1){
                    $json_ba = array();

                    $json_ba['no_invoice']      = $key1->no_invoice;
                    $json_ba['no_order']        = $key1->no_order;
                    $json_ba['nama_supplier']   = $key1->nama_supplier;
                    $json_ba['jml_bayar']       = $key1->jml_bayar;

                    $json['detail'][] = $json_ba;
                }

                $payment[] = $json;
            }

            $response = array(
                'status'    => true,
                'message'   => 'Success fetch warehouses',
                'data'      => $payment
            );

            $this->response($response, 200);
        }
    }

    public function approve_put()
    {
        if($this->user->num_rows() == 0){
            $this->response(array('status' => false, 'error' => 'Unauthorization token'), 401);
        } else {
            $config = array(
                array(
                    'field' => 'no_payment',
                    'label' => 'Payment',
                    'rules' => 'required|trim'
                )
            );

            $this->form_validation->set_data($this->put());
            $this->form_validation->set_rules($config);

            if($this->form_validation->run() == FALSE){

                $this->response(array(
                    'status'    => false,
                    'message'   => 'Field is required',
                    'error'     => $this->form_validation->error_array()
                ), 400);

            } else {
                $where  = array(
                    'no_payment'   => $this->put('no_payment') 
                );

                $data  = array(
                    'status_payment' => 'Close'
                );

                $detail = array();

                $delete = $this->PaymentModel->edit($where, $data, $detail);

                if(!$delete){
                    $this->response(array(
                        'status'    => false,
                        'error'     => 'Failed approve payment'
                    ), 400);
                } else {
                    $this->response(array(
                        'status'    => true,
                        'message'   => 'Success approve payment'
                    ), 200);
                }
            }
        } 
    }

}
