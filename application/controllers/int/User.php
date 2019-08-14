<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class User extends CI_Controller {

    use REST_Controller {
        REST_Controller::__construct as private __resTraitConstruct;
    } 

    function __construct()
    {
        parent::__construct();
        $this->__resTraitConstruct();

        $this->where    = array('token' => $this->input->get_request_header('SCM-INT-KEY', TRUE));
        $this->user     = $this->AuthModel->cekAuthInt($this->where);

        $this->load->model('UserModel');
    }

    public function index_get()
    {
        if($this->user->num_rows() == 0){
            $this->response(array('status' => false, 'error' => 'Unauthorization token'), 401);
        } else {
            
            $where = array(
                'id_user' => $this->get('id_user'),
                'level'   => $this->get('level')
            );

            $show   = $this->UserModel->show($where)->result();
            $user   = array();

            foreach($show as $key){
                $json = array();

                $json['id_user']        = $key->id_user;
                $json['nama_lengkap']   = $key->nama_lengkap;
                $json['email']          = $key->email;
                $json['telepon']        = $key->telepon;
                $json['jenis_kelamin']  = $key->jenis_kelamin;
                $json['alamat']         = $key->alamat;
                $json['username']       = $key->username;
                $json['level']          = $key->level;
                $json['status']         = $key->status;
                $json['tgl_reg_user']   = $key->tgl_reg_user;

                $user[] = $json;
            }

            $response = array(
                'status'    => true,
                'message'   => 'Success fetch users',
                'data'      => $user
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
                    'field' => 'nama_lengkap',
                    'label' => 'Nama Lengkap',
                    'rules' => 'required|trim'
                ),
                array(
                    'field' => 'email',
                    'label' => 'Email',
                    'rules' => 'required|trim'
                ),
                array(
                    'field' => 'username',
                    'label' => 'Username',
                    'rules' => 'required|trim'
                ),
                array(
                    'field' => 'level',
                    'label' => 'Level',
                    'rules' => 'required|trim'
                ),
                array(
                    'field' => 'status',
                    'label' => 'Status',
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
                    'id_user'       => $this->KodeModel->buatKode('user', 'USR-', 'id_user', 7),
                    'nama_lengkap'  => $this->post('nama_lengkap'),
                    'email'         => $this->post('email'),
                    'telepon'       => $this->post('telepon'),
                    'jenis_kelamin' => $this->post('jenis_kelamin'),
                    'alamat'        => $this->post('alamat'),
                    'username'      => $this->post('username'),
                    'password'      => $this->post('username'),
                    'level'         => $this->post('level'),
                    'status'        => $this->post('status'),
                    'token'         => sha1($this->post('email'))
                );

                $add = $this->UserModel->add($data);

                if(!$add){
                    $this->response(array(
                        'status'    => false,
                        'message'     => 'Failed add user'
                    ), 400);
                } else {
                    $this->response(array(
                        'status'    => true,
                        'message'   => 'Success add user'
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
                    'field' => 'id_user',
                    'label' => 'ID User',
                    'rules' => 'required|trim'
                ),
                array(
                    'field' => 'nama_lengkap',
                    'label' => 'Nama Lengkap',
                    'rules' => 'required|trim'
                ),
                array(
                    'field' => 'email',
                    'label' => 'Email',
                    'rules' => 'required|trim'
                ),
                array(
                    'field' => 'username',
                    'label' => 'Username',
                    'rules' => 'required|trim'
                ),
                array(
                    'field' => 'level',
                    'label' => 'Level',
                    'rules' => 'required|trim'
                ),
                array(
                    'field' => 'status',
                    'label' => 'Status',
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
                    'id_user'   => $this->put('id_user') 
                );

                $data   = array(
                    'nama_lengkap'  => $this->put('nama_lengkap'),
                    'email'         => $this->put('email'),
                    'telepon'       => $this->put('telepon'),
                    'jenis_kelamin' => $this->put('jenis_kelamin'),
                    'alamat'        => $this->put('alamat'),
                    'username'      => $this->put('username'),
                    'level'         => $this->put('level'),
                    'status'        => $this->put('status')
                );

                $edit = $this->UserModel->edit($where, $data);

                if(!$edit){
                    $this->response(array(
                        'status'    => false,
                        'message'     => 'Failed edit user'
                    ), 400);
                } else {
                    $this->response(array(
                        'status'    => true,
                        'message'   => 'Success edit user'
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
                    'field' => 'id_user',
                    'label' => 'ID User',
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
                    'id_user'   => $this->delete('id_user') 
                );

                $delete = $this->UserModel->delete($where);

                if(!$delete){
                    $this->response(array(
                        'status'    => false,
                        'message'     => 'Failed delete user'
                    ), 400);
                } else {
                    $this->response(array(
                        'status'    => true,
                        'message'   => 'Success delete user'
                    ), 200);
                }
            }
        } 
    }

}
