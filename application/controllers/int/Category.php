<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Category extends CI_Controller {

    use REST_Controller {
        REST_Controller::__construct as private __resTraitConstruct;
    } 

    function __construct()
    {
        parent::__construct();
        $this->__resTraitConstruct();

        $this->where    = array('token' => $this->input->get_request_header('SCM-INT-KEY', TRUE));
        $this->user     = $this->AuthModel->cekAuthInt($this->where);

        $this->load->model('CategoryModel');
    }

    public function index_get()
    {
        if($this->user->num_rows() == 0){
            $this->response(array('status' => false, 'error' => 'Unauthorization token'), 401);
        } else {
            
            $where = array(
                'id_category'  => $this->get('id_category'),
            );

            $show   = $this->CategoryModel->show($where)->result();
            $category   = array();

            foreach($show as $key){
                $json = array();

                $json['id_category']    = $key->id_category;
                $json['nama_category']  = $key->nama_category;

                $category[] = $json;
            }

            $response = array(
                'status'    => true,
                'message'   => 'Success fetch users',
                'data'      => $category
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
                    'field' => 'nama_category',
                    'label' => 'Nama Kategori',
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
                    'id_product'     => $this->KodeModel->buatKode('category', 'CAT-', 'id_category', 7),
                    'nama_category'  => $this->post('nama_category')
                );

                $add = $this->CategoryModel->add($data);

                if(!$add){
                    $this->response(array(
                        'status'    => false,
                        'message'     => 'Failed add category'
                    ), 400);
                } else {
                    $this->response(array(
                        'status'    => true,
                        'message'   => 'Success add category'
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
                    'field' => 'id_category',
                    'label' => 'ID Kategori',
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
                    'id_category'   => $this->delete('id_category') 
                );

                $delete = $this->CategoryModel->delete($where);

                if(!$delete){
                    $this->response(array(
                        'status'    => false,
                        'message'     => 'Failed delete category'
                    ), 400);
                } else {
                    $this->response(array(
                        'status'    => true,
                        'message'   => 'Success delete category'
                    ), 200);
                }
            }
        } 
    }

}
