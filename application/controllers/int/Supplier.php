<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Supplier extends CI_Controller {

    use REST_Controller {
        REST_Controller::__construct as private __resTraitConstruct;
    } 

    function __construct()
    {
        parent::__construct();
        $this->__resTraitConstruct();

        $this->where    = array('token' => $this->input->get_request_header('SCM-INT-KEY', TRUE));
        $this->user     = $this->AuthModel->cekAuthInt($this->where);

        $this->load->model('SupplierModel');
        $this->load->model('SupplyGroupModel');
        $this->load->model('BankModel');
    }

    public function index_get()
    {
        if($this->user->num_rows() == 0){
            $this->response(array('status' => false, 'error' => 'Unauthorization token'), 401);
        } else {
            
            $where = array(
                'id_supplier' => $this->get('id_supplier')
            );

            $show   = $this->SupplierModel->show($where)->result();
            $supplier   = array();

            foreach($show as $key){
                $json = array();

                $json['id_supplier']        = $key->id_supplier;
                $json['nama_supplier']      = $key->nama_supplier;
                $json['alamat']             = $key->alamat;
                $json['telepon']            = $key->telepon;
                $json['fax']                = $key->fax;
                $json['email']              = $key->email;
                $json['npwp']               = $key->npwp;
                $json['status_supplier']    = $key->status_supplier;
                $json['tgl_reg_supplier']   = $key->tgl_reg_supplier;
                $json['pic']                = array(
                                                'id_pic'        => $key->id_pic,
                                                'nama_pic'      => $key->nama_pic,
                                                'handphone'     => $key->handphone,
                                                'email_pic'     => $key->email_pic,
                                                'username'      => $key->username,
                                                'tgl_reg_pic'   => $key->tgl_reg_pic
                                            );
                $json['bank_account']       = array();
                $json['supply_group']       = array();

                $where_2   = array('id_supplier' => $key->id_supplier);

                $bank_acc   = $this->BankModel->show($where_2);
                foreach($bank_acc->result() as $key1){
                    $json_ba = array();

                    $json_ba['id_account']      = $key1->id_account;
                    $json_ba['no_rekening']     = $key1->no_rekening;
                    $json_ba['nama_bank']       = $key1->nama_bank;
                    $json_ba['cabang']          = $key1->cabang;
                    $json_ba['pemilik_account'] = $key1->pemilik_account;

                    $json['bank_account'][] = $json_ba;
                }

                $supply_group   = $this->SupplyGroupModel->show($where_2);
                foreach($supply_group->result() as $key2){
                    $json_sg = array();

                    $json_sg['id_group']        = $key2->id_group;
                    $json_sg['nama_group']      = $key2->nama_group;
                    $json_sg['lokasi_group']    = $key2->lokasi_group;

                    $json['supply_group'][] = $json_sg;
                }

                $supplier[] = $json;
            }

            $response = array(
                'status'    => true,
                'message'   => 'Success fetch warehouses',
                'data'      => $supplier
            );

            $this->response($response, 200);
        }
    }

    public function add_post()
    {
        if($this->user->num_rows() == 0){
            $this->response(array('status' => false, 'error' => 'Unauthorization token'), 401);
        } else {

            $this->form_validation->set_data($this->post());
            $this->form_validation->set_rules('nama_supplier', 'Nama Supplier', 'required|trim');
            $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
            $this->form_validation->set_rules('telepon', 'Telepon', 'required|trim');
            $this->form_validation->set_rules('email', 'Email', 'required|trim');
            $this->form_validation->set_rules('npwp', 'NPWP', 'required|trim');
            $this->form_validation->set_rules('status_supplier', 'Status', 'required|trim');
            $this->form_validation->set_rules('nama_pic', 'Nama PIC', 'required|trim');
            $this->form_validation->set_rules('username', 'Username', 'required|trim');
            $this->form_validation->set_rules('handphone', 'Handphone', 'required|trim');

            $this->form_validation->set_rules('no_rekening[]', 'No Rekening', 'required|trim');
            $this->form_validation->set_rules('nama_bank[]', 'Nama Bank', 'required|trim');
            $this->form_validation->set_rules('cabang[]', 'Cabanag', 'required|trim');
            $this->form_validation->set_rules('pemilik_account[]', 'Pemilik Account', 'required|trim');

            $this->form_validation->set_rules('id_group[]', 'Group', 'required|trim');



            if($this->form_validation->run() == FALSE){

                $this->response(array(
                    'status'    => false,
                    'message'   => 'Field is required',
                    'error'     => $this->form_validation->error_array()
                ), 400);

            } else {

                $post           = $this->post();
                $id_supplier    = $this->KodeModel->buatKode('supplier', 'SP-', 'id_supplier', 8);


                $data           = array(
                    'id_supplier'       => $id_supplier,
                    'nama_supplier'     => $post['nama_supplier'],
                    'alamat'            => $post['alamat'],
                    'telepon'           => $post['telepon'],
                    'fax'               => $post['fax'],
                    'npwp'              => $post['npwp'],
                    'email'             => $post['email'],
                    'status_supplier'   => $post['status_supplier']
                );

                $pic            = array(
                    'supplier'     => $id_supplier,
                    'nama_pic'     => $post['nama_pic'],
                    'handphone'    => $post['handphone'],
                    'email_pic'    => $post['email_pic'],
                    'username'     => $post['username'],
                    'password'     => substr(str_shuffle("01234567890abcdefghijklmnopqestuvwxyz"), 0, 5)
                );
                
                $bank           = array();
                $supply_group   = array();

                foreach($post['no_rekening'] as $key => $val){
                    $bank[] = array(
                        'supplier'          => $id_supplier,
                        'nama_bank'         => $post['nama_bank'][$key],
                        'cabang'            => $post['cabang'][$key],
                        'pemilik_account'   => $post['pemilik_account'][$key],
                        'no_rekening'       => $post['no_rekening'][$key]
                    );
                }

                foreach($post['id_group'] as $key => $val){
                    $supply_group[] = array(
                        'supplier'    => $id_supplier,
                        'group'       => $post['id_group'][$key]
                    );
                }

                $coba = array(
                    'data' => $data,
                    'pic' => $pic,
                    'bank' => $bank,
                    'supply_group' => $supply_group
                );

                $add = $this->SupplierModel->add($data, $pic, $bank, $supply_group);

                if(!$add){
                    $this->response(array(
                        'status'    => false,
                        'error'     => 'Failed add warehouse'
                    ), 400);
                } else {
                    $this->response(array(
                        'status'    => true,
                        'message'   => 'Success add warehouse'
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
                    'field' => 'id_warehouse',
                    'label' => 'ID Warehouse',
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
                    'id_warehouse'   => $this->delete('id_warehouse') 
                );

                $delete = $this->SupplierModel->delete($where);

                if(!$delete){
                    $this->response(array(
                        'status'    => false,
                        'error'     => 'Failed delete warehouse'
                    ), 400);
                } else {
                    $this->response(array(
                        'status'    => true,
                        'message'   => 'Success delete warehouse'
                    ), 200);
                }
            }
        } 
    }

}
