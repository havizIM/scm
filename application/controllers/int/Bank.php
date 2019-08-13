<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Bank extends CI_Controller {

    use REST_Controller {
        REST_Controller::__construct as private __resTraitConstruct;
    } 

    function __construct()
    {
        parent::__construct();
        $this->__resTraitConstruct();

        $this->where    = array('token' => $this->input->get_request_header('SCM-INT-KEY', TRUE));
        $this->user     = $this->AuthModel->cekAuthInt($this->where);

        $this->load->model('BankModel');
    }

    public function index_get()
    {
        if($this->user->num_rows() == 0){
            $this->response(array('status' => false, 'error' => 'Unauthorization token'), 401);
        } else {
            
            $where = array(
                'id_account'    => $this->get('id_account'),
                'id_supplier'   => $this->get('id_supplier')
            );

            $show   = $this->BankModel->show($where)->result();
            $bank   = array();

            foreach($show as $key){
                $json = array();

                $json['id_account']         = $key->id_account;
                $json['id_supplier']        = $key->id_supplier;
                $json['nama_supplier']      = $key->nama_supplier;
                $json['nama_bank']          = $key->nama_bank;
                $json['cabang']             = $key->cabang;
                $json['pemilik_account']    = $key->pemilik_account;
                $json['no_rekening']        = $key->no_rekening;

                $bank[] = $json;
            }

            $response = array(
                'status'    => true,
                'message'   => 'Success fetch warehouses',
                'data'      => $bank
            );

            $this->response($response, 200);
        }
    }

}
