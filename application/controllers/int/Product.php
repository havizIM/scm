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

        $this->where    = array('token' => $this->input->get_request_header('SCM-INT-KEY', TRUE));
        $this->user     = $this->AuthModel->cekAuthInt($this->where);

        $this->load->model('ProductModel');
    }

    public function index_get()
    {
        if($this->user->num_rows() == 0){
            $this->response(array('status' => false, 'error' => 'Unauthorization token'), 401);
        } else {
            
            $where = array(
                'a.id_product'  => $this->get('id_product'),
                'a.id_supplier' => $this->get('id_supplier')
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

    public function add_post()
    {
        if($this->user->num_rows() == 0){
            $this->response(array('status' => false, 'error' => 'Unauthorization token'), 401);
        } else {
            $config = array(
                array(
                    'field' => 'id_supplier',
                    'label' => 'Supplier',
                    'rules' => 'required|trim'
                ),
                array(
                    'field' => 'id_category',
                    'label' => 'Kategori',
                    'rules' => 'required|trim'
                ),
                array(
                    'field' => 'nama_product',
                    'label' => 'Nama Product',
                    'rules' => 'required|trim'
                ),
                array(
                    'field' => 'satuan',
                    'label' => 'Satuan',
                    'rules' => 'required|trim'
                ),
                array(
                    'field' => 'harga',
                    'label' => 'Harga',
                    'rules' => 'required|trim'
                )
            );

            $this->form_validation->set_data($this->post());
            $this->form_validation->set_rules($config);

            if($this->form_validation->run() == FALSE){

                $this->response(array(
                    'status'    => false,
                    'message'   => 'Field is required',
                    'error'     => $this->form_validation->error_array()
                ), 400);

            } else {
                $data = array(
                    'id_product'   => $this->KodeModel->buatKode('product', 'PR-', 'id_product', 8),
                    'id_supplier'  => $this->post('id_supplier'),
                    'id_category'  => $this->post('id_category'),
                    'satuan'       => $this->post('satuan'),
                    'nama_product' => $this->post('nama_product'),
                    'harga'        => $this->post('harga')
                );

                $add = $this->ProductModel->add($data);

                if(!$add){
                    $this->response(array(
                        'status'    => false,
                        'message'     => 'Failed add product'
                    ), 400);
                } else {
                    $this->response(array(
                        'status'    => true,
                        'message'   => 'Success add product'
                    ), 200);
                }
            }
        } 
    }

    public function edit_put()
    {
        if($this->user->num_rows() == 0){
            $this->response(array('status' => false, 'error' => 'Unauthorization token'), 401);
        } else {
            $config = array(
                array(
                    'field' => 'id_product',
                    'label' => 'Product',
                    'rules' => 'required|trim'
                ),
                array(
                    'field' => 'id_category',
                    'label' => 'Kategori',
                    'rules' => 'required|trim'
                ),
                array(
                    'field' => 'id_supplier',
                    'label' => 'Kategori',
                    'rules' => 'required|trim'
                ),
                array(
                    'field' => 'nama_product',
                    'label' => 'Nama Product',
                    'rules' => 'required|trim'
                ),
                array(
                    'field' => 'satuan',
                    'label' => 'Satuan',
                    'rules' => 'required|trim'
                ),
                array(
                    'field' => 'harga',
                    'label' => 'Harga',
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
                    'id_product'   => $this->put('id_product') 
                );

                $data   = array(
                    'id_supplier'  => $this->put('id_supplier'),
                    'id_category'  => $this->put('id_category'),
                    'satuan'       => $this->put('satuan'),
                    'nama_product' => $this->put('nama_product'),
                    'harga'        => $this->put('harga')
                );

                $edit = $this->ProductModel->edit($where, $data);

                if(!$edit){
                    $this->response(array(
                        'status'    => false,
                        'message'     => 'Failed edit product'
                    ), 400);
                } else {
                    $this->response(array(
                        'status'    => true,
                        'message'   => 'Success edit product'
                    ), 200);
                }
            }
        } 
    }

    public function delete_delete()
    {
        if($this->user->num_rows() == 0){
            $this->response(array('status' => false, 'error' => 'Unauthorization token'), 401);
        } else {
            $config = array(
                array(
                    'field' => 'id_product',
                    'label' => 'ID Product',
                    'rules' => 'required|trim'
                )
            );

            $this->form_validation->set_data($this->delete());
            $this->form_validation->set_rules($config);

            if($this->form_validation->run() == FALSE){

                $this->response(array(
                    'status'    => false,
                    'message'   => 'Field is required',
                    'error'     => $this->form_validation->error_array()
                ), 400);

            } else {
                $where  = array(
                    'id_product'   => $this->delete('id_product') 
                );

                $delete = $this->ProductModel->delete($where);

                if(!$delete){
                    $this->response(array(
                        'status'    => false,
                        'message'     => 'Failed delete product'
                    ), 400);
                } else {
                    $this->response(array(
                        'status'    => true,
                        'message'   => 'Success delete product'
                    ), 200);
                }
            }
        } 
    }

}
