<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Order extends CI_Controller {

    use REST_Controller {
        REST_Controller::__construct as private __resTraitConstruct;
    } 

    function __construct()
    {
        parent::__construct();
        $this->__resTraitConstruct();

        $this->where    = array('token' => $this->input->get_request_header('SCM-INT-KEY', TRUE));
        $this->user     = $this->AuthModel->cekAuthInt($this->where);

        $this->load->model('OrderModel');
    }

    public function index_get()
    {
        if($this->user->num_rows() == 0){
            $this->response(array('status' => false, 'error' => 'Unauthorization token'), 401);
        } else {
            $user = $this->user->row();
            
            $where = array(
                'a.no_order'      => $this->get('no_order'),
                'a.id_warehouse'  => $user->id_warehouse
            );

            $show   = $this->OrderModel->show($where)->result();
            $order   = array();

            foreach($show as $key){
                $json = array();

                $json['no_order']       = $key->no_order;
                $json['warehouse']      = array(
                    'id_warehouse'      => $key->id_warehouse,
                    'nama_warehouse'    => $key->nama_warehouse,
                    'alamat'            => $key->alamat,
                    'telepon'           => $key->telepon,
                    'fax'               => $key->fax,
                    'email'             => $key->email
                );
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
                $json['status_order']   = $key->status_order;
                $json['tgl_order']      = $key->tgl_order;
                
                $json['detail']         = array();

                $where_2   = array('a.no_order' => $key->no_order);
                $detail   = $this->OrderModel->detail($where_2);

                foreach($detail->result() as $key1){
                    $json_ba = array();

                    $json_ba['id_product']      = $key1->id_product;
                    $json_ba['nama_product']    = $key1->nama_product;
                    $json_ba['harga']           = $key1->harga;
                    $json_ba['qty']             = $key1->qty;
                    $json_ba['satuan']          = $key1->satuan;
                    $json_ba['total']           = $key1->harga * $key1->qty;

                    $json['detail'][] = $json_ba;
                }

                $order[] = $json;
            }

            $response = array(
                'status'    => true,
                'message'   => 'Success fetch warehouses',
                'data'      => $order
            );

            $this->response($response, 200);
        }
    }

    public function add_post()
    {
        if($this->user->num_rows() == 0){
            $this->response(array('status' => false, 'error' => 'Unauthorization token'), 401);
        } else {
            $user = $this->user->row();
            $this->form_validation->set_data($this->post());
            
            $this->form_validation->set_rules('id_supplier', 'Supplier', 'required|trim');
            $this->form_validation->set_rules('id_product[]', 'Product', 'required|trim');
            $this->form_validation->set_rules('qty[]', 'Qty', 'required|trim');

            if($this->form_validation->run() == FALSE){

                $this->response(array(
                    'status'    => false,
                    'message'   => 'Field is required',
                    'error'     => $this->form_validation->error_array()
                ), 400);

            } else {

                $post           = $this->post();
                $no_order       = $this->KodeModel->buatKode('`order`', 'PO-', 'no_order', 8);


                $data           = array(
                    'no_order'        => $no_order,
                    'id_supplier'     => $post['id_supplier'],
                    'id_warehouse'    => $user->id_warehouse,
                    'status_order'    => 'Open' 
                );
                
                $detail  = array();

                foreach($post['id_product'] as $key => $val){
                    $detail[] = array(
                        'no_order'       => $no_order,
                        'id_product'     => $post['id_product'][$key],
                        'qty'            => $post['qty'][$key]
                    );
                }

                $add = $this->OrderModel->add($data, $detail);

                if(!$add){
                    $this->response(array(
                        'status'    => false,
                        'error'     => 'Failed add order'
                    ), 400);
                } else {
                    $this->response(array(
                        'status'    => true,
                        'message'   => 'Success add order'
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
                    'field' => 'id_warehouse',
                    'label' => 'ID Warehouse',
                    'rules' => 'required|trim'
                ),
                array(
                    'field' => 'group',
                    'label' => 'Group',
                    'rules' => 'required|trim'
                ),
                array(
                    'field' => 'user',
                    'label' => 'User',
                    'rules' => 'required|trim'
                ),
                array(
                    'field' => 'nama_warehouse',
                    'label' => 'Nama Warehouse',
                    'rules' => 'required|trim'
                ),
                array(
                    'field' => 'alamat',
                    'label' => 'Alamat',
                    'rules' => 'required|trim'
                ),
                array(
                    'field' => 'telepon',
                    'label' => 'Telepon',
                    'rules' => 'required|trim'
                ),
                array(
                    'field' => 'fax',
                    'label' => 'Fax',
                    'rules' => 'required|trim'
                ),
                array(
                    'field' => 'email',
                    'label' => 'Email',
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
                    'id_warehouse'   => $this->put('id_warehouse') 
                );

                $data   = array(
                    'group'             => $this->put('group'),
                    'user'              => $this->put('user'),
                    'nama_warehouse'    => $this->put('nama_warehouse'),
                    'alamat'            => $this->put('alamat'),
                    'telepon'           => $this->put('telepon'),
                    'fax'               => $this->put('fax'),
                    'email'             => $this->put('email')
                );

                $edit = $this->SupplierModel->edit($where, $data);

                if(!$edit){
                    $this->response(array(
                        'status'    => false,
                        'error'     => 'Failed edit warehouse'
                    ), 400);
                } else {
                    $this->response(array(
                        'status'    => true,
                        'message'   => 'Success edit warehouse'
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
                    'field' => 'no_order',
                    'label' => 'Order',
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
                    'no_order'   => $this->delete('no_order') 
                );

                $delete = $this->OrderModel->delete($where);

                if(!$delete){
                    $this->response(array(
                        'status'    => false,
                        'error'     => 'Failed delete order'
                    ), 400);
                } else {
                    $this->response(array(
                        'status'    => true,
                        'message'   => 'Success delete order'
                    ), 200);
                }
            }
        } 
    }

}
