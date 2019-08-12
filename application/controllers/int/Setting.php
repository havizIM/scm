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

        $this->where    = array('token' => $this->input->get_request_header('SCM-INT-KEY', TRUE));
        $this->user     = $this->AuthModel->cekAuthInt($this->where);
    }

    public function user_info_get()
    {
        if($this->user->num_rows() == 0){
            $this->response(array('status' => false, 'error' => 'Unauthorization token'), 401);
        } else {
            $user  = $this->user->row();

            $json    = array();

            $json['id_user']        = $user->id_user;
            $json['nama_lengkap']   = $user->nama_lengkap;
            $json['email']          = $user->email;
            $json['telepon']        = $user->telepon;
            $json['jenis_kelamin']  = $user->jenis_kelamin;
            $json['alamat']         = $user->alamat;
            $json['level']          = strtolower($user->level);
            $json['status']         = $user->status;
            $json['tgl_reg_user']   = $user->tgl_reg_user;
            

            if($user->id_warehouse != null){
                $json['warehouse'] = array(
                    'id_warehouse'      => $user->id_warehouse,
                    'group'             => array(
                        'nama_group'    => $user->nama_group,
                        'lokasi_group'  => $user->lokasi_group
                    ),
                    'nama_warehouse'    => $user->nama_warehouse,
                    'alm_warehouse'     => $user->alm_warehouse,
                    'telp_supplier'     => $user->telp_supplier,
                    'fax'               => $user->fax,
                    'tgl_reg_warehouse' => $user->tgl_reg_warehouse
                );
            } else {
                $json['warehouse'] = array();
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
                    $where  = array('id_user' => $otorisasi->id_user);
                    $data   = array('password' => $this->put('new_password'));

                    $update = $this->AuthModel->updateAuthInt($where, $data);

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
