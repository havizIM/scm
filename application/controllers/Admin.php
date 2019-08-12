<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function index()
	{
		$this->load->view('admin/main');
    }
    
    public function dashboard()
	{
		$this->load->view('admin/dashboard');
	}
	
    public function user($id = null)
	{
		if($id == null){
			$this->load->view('admin/user/data');
		} else {
			switch($id){
				case 'add':
					$this->load->view('admin/user/add');
				break;

				case 'edit':
					$this->load->view('admin/user/edit');
				break;

				default:
					$this->load->view('admin/user/detail');
			}
		}
	}
	
    public function warehouse($id = null)
	{
		if($id == null){
			$this->load->view('admin/warehouse/data');
		} else {
			switch($id){
				case 'add':
					$this->load->view('admin/warehouse/add');
				break;

				case 'edit':
					$this->load->view('admin/warehouse/edit');
				break;

				default:
					$this->load->view('admin/warehouse/detail');
			}
		}
	}
	
    public function supplier($id = null)
	{
		if($id == null){
			$this->load->view('admin/supplier/data');
		} else {
			switch($id){
				case 'add':
					$this->load->view('admin/supplier/add');
				break;

				case 'edit':
					$this->load->view('admin/supplier/edit');
				break;

				default:
					$this->load->view('admin/supplier/detail');
			}
		}
	}
	
    
}
