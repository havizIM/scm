<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Shipping extends CI_Controller {

    use REST_Controller {
        REST_Controller::__construct as private __resTraitConstruct;
    } 

    function __construct()
    {
        parent::__construct();
        $this->__resTraitConstruct();

        $this->where    = array('token' => $this->input->get_request_header('SCM-EXT-KEY', TRUE));
        $this->user     = $this->AuthModel->cekAuthExt($this->where);

        $this->load->model('ShippingModel');
        $this->load->model('OrderModel');
    }

    public function index_get()
    {
        if($this->user->num_rows() == 0){
            $this->response(array('status' => false, 'error' => 'Unauthorization token'), 401);
        } else {
            $user = $this->user->row();
            
            $where = array(
                'a.no_shipping'    => $this->get('no_shipping'),
                'a.no_order'       => $this->get('no_order'),
                'd.id_supplier'    => $user->id_supplier
            );

            $show   = $this->ShippingModel->show($where)->result();
            $shipping   = array();

            foreach($show as $key){
                $json           = array();
                $grand_total    = 0;

                $json['no_shipping']        = $key->no_shipping;
                $json['no_order']           = $key->no_order;
                $json['warehouse']      = array(
                    'id_warehouse'      => $key->id_warehouse,
                    'nama_warehouse'    => $key->nama_warehouse,
                    'alamat'            => $key->alamat_warehouse,
                    'telepon'           => $key->telepon_warehouse,
                    'fax'               => $key->fax_warehouse,
                    'email'             => $key->email_warehouse
                );
                $json['supplier']           = array(
                    'id_supplier'        => $key->id_supplier,
                    'nama_supplier'      => $key->nama_supplier,
                    'alamat'             => $key->alamat_supplier,
                    'telepon'            => $key->telepon_supplier,
                    'fax'                => $key->fax_supplier,
                    'email'              => $key->email_supplier,
                    'npwp'               => $key->npwp,
                    'status_supplier'    => $key->status_supplier
                );
                $json['tgl_shipping']        = $key->tgl_shipping;
                $json['tgl_receive']         = $key->tgl_receive;
                $json['status_shipping']     = $key->status_shipping;
                
                $json['detail']         = array();

                $where_2   = array('a.no_shipping' => $key->no_shipping);
                $detail   = $this->ShippingModel->detail($where_2);

                foreach($detail->result() as $key1){
                    $json_ba = array();

                    $json_ba['id_product']      = $key1->id_product;
                    $json_ba['nama_product']    = $key1->nama_product;
                    $json_ba['harga']           = $key1->harga;
                    $json_ba['qty']             = $key1->actual_qty;
                    $json_ba['satuan']          = $key1->satuan;
                    $json_ba['total']           = $key1->harga * $key1->actual_qty;

                    $json['detail'][] = $json_ba;
                }

                $shipping[] = $json;
            }

            $response = array(
                'status'    => true,
                'message'   => 'Success fetch shipping',
                'data'      => $shipping
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
            
            $this->form_validation->set_rules('no_order', 'Order', 'required|trim');
            $this->form_validation->set_rules('tgl_shipping', 'Tanggal Shipping', 'required|trim');
            $this->form_validation->set_rules('id_product[]', 'Product', 'required|trim');
            $this->form_validation->set_rules('actual_qty[]', 'Qty', 'required|trim');

            if($this->form_validation->run() == FALSE){

                $this->response(array(
                    'status'    => false,
                    'message'   => 'Field is required',
                    'error'     => $this->form_validation->error_array()
                ), 400);

            } else {

                $post           = $this->post();
                $no_shipping    = $this->KodeModel->buatKode('shipping', 'DO-', 'no_shipping', 8);


                $data           = array(
                    'no_shipping'       => $no_shipping,
                    'no_order'          => $post['no_order'],
                    'tgl_shipping'      => $post['tgl_shipping'],
                    'status_shipping'   => 'Open' 
                );
                
                $detail  = array();

                foreach($post['id_product'] as $key => $val){
                    $detail[] = array(
                        'no_shipping'    => $no_shipping,
                        'id_product'     => $post['id_product'][$key],
                        'actual_qty'     => $post['actual_qty'][$key]
                    );
                }

                $add = $this->ShippingModel->add($data, $detail);

                if(!$add){
                    $this->response(array(
                        'status'    => false,
                        'error'     => 'Failed add shipping'
                    ), 400);
                } else {
                    $this->response(array(
                        'status'    => true,
                        'message'   => 'Success add shipping'
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
            $user = $this->user->row();
            $this->form_validation->set_data($this->put());
            
            $this->form_validation->set_rules('no_shipping', 'Shipping', 'required|trim');
            $this->form_validation->set_rules('no_order', 'Order', 'required|trim');
            $this->form_validation->set_rules('tgl_shipping', 'Tanggal Shipping', 'required|trim');
            $this->form_validation->set_rules('id_product[]', 'Product', 'required|trim');
            $this->form_validation->set_rules('actual_qty[]', 'Qty', 'required|trim');

            if($this->form_validation->run() == FALSE){

                $this->response(array(
                    'status'    => false,
                    'message'   => 'Field is required',
                    'error'     => $this->form_validation->error_array()
                ), 400);

            } else {

                $put           = $this->put();

                $where          = array(
                    'no_shipping'       => $put['no_shipping'],
                );


                $data           = array(
                    'no_order'          => $put['no_order'],
                    'tgl_shipping'      => $put['tgl_shipping']
                );
                
                $detail  = array();

                foreach($put['id_product'] as $key => $val){
                    $detail[] = array(
                        'no_shipping'    => $put['no_shipping'],
                        'id_product'     => $put['id_product'][$key],
                        'actual_qty'     => $put['actual_qty'][$key]
                    );
                }

                $edit = $this->ShippingModel->edit($where, $data, $detail);

                if(!$edit){
                    $this->response(array(
                        'status'    => false,
                        'error'     => 'Failed edit shipping'
                    ), 400);
                } else {
                    $this->response(array(
                        'status'    => true,
                        'message'   => 'Success edit shipping'
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
                    'field' => 'no_shipping',
                    'label' => 'Shipping',
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
                    'no_shipping'   => $this->delete('no_shipping') 
                );

                $delete = $this->ShippingModel->delete($where);

                if(!$delete){
                    $this->response(array(
                        'status'    => false,
                        'error'     => 'Failed delete shipping'
                    ), 400);
                } else {
                    $this->response(array(
                        'status'    => true,
                        'message'   => 'Success delete shipping'
                    ), 200);
                }
            }
        } 
    }

}
