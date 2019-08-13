<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Product extends CI_Controller {

    use REST_Controller {
        REST_Controller::__construct as private __resTraitConstruct;
    } 

    function __construct()
    {
        parent::__construct();
        $this->__resTraitConstruct();

        $this->where    = array('token' => $this->input->get_request_header('SCM-EXT-KEY', TRUE));
        $this->user     = $this->AuthModel->cekAuthExt($this->where);

        $this->load->model('ProductModel');
    }

    public function index_get()
    {
        if($this->user->num_rows() == 0){
            $this->response(array('status' => false, 'error' => 'Unauthorization token'), 401);
        } else {
            $user = $this->user->row();
            
            $where = array(
                'a.id_product'  => $this->get('id_product'),
                'a.id_supplier' => $user->id_supplier
            );

            $show   = $this->ProductModel->show($where)->result();
            $product   = array();

            foreach($show as $key){
                $json = array();

                $json['id_product']    = $key->id_product;
                $json['id_category']   = $key->id_category;
                $json['nama_category'] = $key->nama_category;
                $json['id_supplier']   = $key->id_supplier;
                $json['nama_supplier'] = $key->nama_supplier;
                $json['satuan']        = $key->satuan;
                $json['nama_product']  = $key->nama_product;
                $json['harga']         = $key->harga;

                $product[] = $json;
            }

            $response = array(
                'status'    => true,
                'message'   => 'Success fetch users',
                'data'      => $product
            );

            $this->response($response, 200);
        }
    }

}
