<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Group extends CI_Controller {

    use REST_Controller {
        REST_Controller::__construct as private __resTraitConstruct;
    } 

    function __construct()
    {
        parent::__construct();
        $this->__resTraitConstruct();

        $this->where    = array('token' => $this->input->get_request_header('SCM-INT-KEY', TRUE));
        $this->user     = $this->AuthModel->cekAuthInt($this->where);

        $this->load->model('GroupModel');
    }

    public function index_get()
    {
        if($this->user->num_rows() == 0){
            $this->response(array('status' => false, 'error' => 'Unauthorization token'), 401);
        } else {
            
            $where = array(
                'id_group'     => $this->get('id_group')
            );

            $show   = $this->GroupModel->show($where)->result();
            $group   = array();

            foreach($show as $key){
                $json = array();

                $json['id_group']       = $key->id_group;
                $json['nama_group']     = $key->nama_group;
                $json['lokasi_group']   = $key->lokasi_group;

                $group[] = $json;
            }

            $response = array(
                'status'    => true,
                'message'   => 'Success fetch group',
                'data'      => $group
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
                    'field' => 'nama_group',
                    'label' => 'Nama Group',
                    'rules' => 'required|trim'
                ),
                array(
                    'field' => 'lokasi_group',
                    'label' => 'Lokasi',
                    'rules' => 'required|trim'
                )
            );

            $this->form_validation->set_data($this->post());
            $this->form_validation->set_rules($config);

            if($this->form_validation->run() == FALSE){

                $this->response(array(
                    'status'    => false,
                    'message'   => 'Fields is required',
                    'error'     => $this->form_validation->error_array()
                ), 400);

            } else {
                $data = array(
                    'nama_group'    => $this->post('nama_group'),
                    'lokasi_group'  => $this->post('lokasi_group')
                );

                $add = $this->GroupModel->add($data);

                if(!$add){
                    $this->response(array(
                        'status'    => false,
                        'error'     => 'Failed add group'
                    ), 400);
                } else {
                    $this->response(array(
                        'status'    => true,
                        'message'   => 'Success add group'
                    ), 200);
                }
            }
        } 
    }

    function delete_delete()
    {
        if($this->user->num_rows() == 0){
            $this->response(array('status' => false, 'error' => 'Unauthorization token'), 401);
        } else {
            $config = array(
                array(
                    'field' => 'id_group',
                    'label' => 'ID Group',
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
                    'id_group'   => $this->delete('id_group') 
                );

                $delete = $this->GroupModel->delete($where);

                if(!$delete){
                    $this->response(array(
                        'status'    => false,
                        'error'     => 'Failed delete group'
                    ), 400);
                } else {
                    $this->response(array(
                        'status'    => true,
                        'message'   => 'Success delete group'
                    ), 200);
                }
            }
        } 
    }

}
