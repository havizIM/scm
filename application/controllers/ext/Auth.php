<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Auth extends CI_Controller {

    use REST_Controller {
        REST_Controller::__construct as private __resTraitConstruct;
    } 

    function __construct()
    {
        parent::__construct();
        $this->__resTraitConstruct();
    }

    public function login_post()
    {
        $config = array(
            array(
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'required|trim'
            ),
            array(
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required|trim'
            )
        );

        $this->form_validation->set_data($this->post());
        $this->form_validation->set_rules($config);

        if($this->form_validation->run() == FALSE){
            $this->response(array('status' => false, 'error' => $this->form_validation->error_array()), 400);
        }else{

            $where  = array('username' => $this->post('username'));
            $user   = $this->AuthModel->cekAuthExt($where);

            if($user->num_rows() == 0){
                $this->response(array('status' => false, 'error' => 'Username not found'), 400);
            } else {
                $auth = $user->row();
                
                if(hash_equals($this->post('password'), $auth->password)){
                    if($auth->status_supplier != 'Aktif'){
                        $this->response(array('status' => false, 'error' => 'User is not active'), 400);
                    } else {
                        $this->response(array('status' => true, 'message' => 'Success login. Welcome to Supply Chain Management', 'key' => $auth->token), 200);
                    }
                } else {
                    $this->response(array('status' => false, 'error' => 'Wrong password'), 400);
                }
            }
        }  
    }

}
