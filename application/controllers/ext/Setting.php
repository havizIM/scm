<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Setting extends CI_Controller {

    use REST_Controller {
        REST_Controller::__construct as private __resTraitConstruct;
    } 

    function __construct()
    {
        parent::__construct();
        $this->__resTraitConstruct();

        $this->where    = array('token' => $this->input->get_request_header('SCM-EXT-KEY', TRUE));
        $this->user     = $this->AuthModel->cekAuthExt($this->where);
    }

    public function user_info_get()
    {
        if($this->user->num_rows() == 0){
            $this->response(array('status' => false, 'error' => 'Unauthorization token'), 401);
        } else {
            $user  = $this->user->row();

            $json    = array();

            $json['id_pic']         = $user->id_pic;
            $json['nama_pic']       = $user->nama_pic;
            $json['handphone']      = $user->handphone;
            $json['email_pic']      = $user->email_pic;
            $json['username']       = $user->username;
            $json['tgl_reg_pic']    = $user->tgl_reg_pic;
            

            if($user->id_supplier != null){
                $json['supplier'] = array(
                    'id_supplier'      => $user->id_supplier,
                    'nama_supplier'    => $user->nama_supplier,
                    'alamat'           => $user->alamat,
                    'telepon'          => $user->telepon,
                    'fax'              => $user->fax,
                    'npwp'             => $user->npwp,
                    'email'            => $user->email,
                    'tgl_reg_supplier' => $user->tgl_reg_supplier,
                    'status_supplier'  => $user->status_supplier
                );
            } else {
                $json['supplier'] = array();
            }

            $this->response(array('status' => true, 'message' => 'Success fetch profile', 'data' => $json), 200);

        }
    }

    public function change_pass_put()
    {
        if($this->user->num_rows() == 0){
            $this->response(array('status' => false, 'error' => 'Unauthorization token'), 401);
        } else {
            $otorisasi  = $this->user->row();

            $config = array(
                array(
                    'field' => 'old_password',
                    'label' => 'Old Password',
                    'rules' => 'required|trim'
                ),
                array(
                    'field' => 'new_password',
                    'label' => 'New Password',
                    'rules' => 'required|trim'
                ),
                array(
                    'field' => 'conf_password',
                    'label' => 'Confirm Password',
                    'rules' => 'required|trim|matches[new_password]'
                )
            );

            $this->form_validation->set_data($this->put());
            $this->form_validation->set_rules($config);

            if($this->form_validation->run() == FALSE){
                $this->response(array('status' => false, 'error' => $this->form_validation->error_array()), 400);
            } else {
                if($this->put('old_password') != $otorisasi->password){
                    $this->response(array('status' => false, 'error' => 'Wrong password'), 400);
                } else {
                    $where  = array('id_pic' => $otorisasi->id_pic);
                    $data   = array('password' => $this->put('new_password'));

                    $update = $this->AuthModel->updateAuthExt($where, $data);

                    if(!$update){
                        $this->response(array('status' => false, 'error' => 'Failed to change password'), 500);
                    } else {
                        $this->response(array('status' => true, 'message' => 'Success change password'), 200);
                    }
                }
            }
        }
        
    }

}
