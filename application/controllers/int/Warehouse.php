<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Warehouse extends CI_Controller {

    use REST_Controller {
        REST_Controller::__construct as private __resTraitConstruct;
    } 

    function __construct()
    {
        parent::__construct();
        $this->__resTraitConstruct();

        $this->where    = array('token' => $this->input->get_request_header('SCM-INT-KEY', TRUE));
        $this->user     = $this->AuthModel->cekAuthInt($this->where);

        $this->load->model('WarehouseModel');
    }

    public function index_get()
    {
        if($this->user->num_rows() == 0){
            $this->response(array('status' => false, 'error' => 'Unauthorization token'), 401);
        } else {
            
            $where = array(
                'id_warehouse' => $this->get('id_warehouse'),
                'id_group'     => $this->get('id_group')
            );

            $show   = $this->WarehouseModel->show($where)->result();
            $warehouse   = array();

            foreach($show as $key){
                $json = array();

                $json['id_warehouse']       = $key->id_warehouse;
                $json['nama_warehouse']     = $key->nama_warehouse;
                $json['alamat']             = $key->alamat;
                $json['telepon']            = $key->telepon;
                $json['fax']                = $key->fax;
                $json['email']              = $key->email;
                $json['tgl_reg_warehouse']  = $key->tgl_reg_warehouse;
                $json['group']              = array(
                                                'id_group'      => $key->id_group,
                                                'nama_group'    => $key->nama_group,
                                                'lokasi_group'  => $key->lokasi_group
                                            );
                $json['user']                = array(
                                                'id_user'       => $key->id_user,
                                                'nama_lengkap'  => $key->nama_lengkap,
                                                'email_user'    => $key->email_user,
                                                'tlp_user'      => $key->tlp_user
                                            );

                $warehouse[] = $json;
            }

            $response = array(
                'status'    => true,
                'message'   => 'Success fetch warehouses',
                'data'      => $warehouse
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
                    'field' => 'id_group',
                    'label' => 'Group',
                    'rules' => 'required|trim'
                ),
                array(
                    'field' => 'id_user',
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
                    'id_warehouse'      => $this->KodeModel->buatKode('warehouse', 'WH-', 'id_warehouse', 8),
                    'id_group'             => $this->post('id_group'),
                    'id_user'              => $this->post('id_user'),
                    'nama_warehouse'    => $this->post('nama_warehouse'),
                    'alamat'            => $this->post('alamat'),
                    'telepon'           => $this->post('telepon'),
                    'fax'               => $this->post('fax'),
                    'email'             => $this->post('email')
                );

                $add = $this->WarehouseModel->add($data);

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
                    'field' => 'id_group',
                    'label' => 'Group',
                    'rules' => 'required|trim'
                ),
                array(
                    'field' => 'id_user',
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
                    'id_group'             => $this->put('id_group'),
                    'id_user'              => $this->put('id_user'),
                    'nama_warehouse'    => $this->put('nama_warehouse'),
                    'alamat'            => $this->put('alamat'),
                    'telepon'           => $this->put('telepon'),
                    'fax'               => $this->put('fax'),
                    'email'             => $this->put('email')
                );

                $edit = $this->WarehouseModel->edit($where, $data);

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

                $delete = $this->WarehouseModel->delete($where);

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
