<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function index()
	{
		$this->load->view('Admin/main');
    }
    
    public function dashboard()
	{
		$this->load->view('Admin/dashboard');
	}
	
    public function user($id = null)
	{
		if($id == null){
			$this->load->view('Admin/user/data');
		} else {
			switch($id){
				case 'add':
					$this->load->view('Admin/user/add');
				break;

				case 'edit':
					$this->load->view('Admin/user/edit');
				break;

				default:
					$this->load->view('Admin/user/detail');
			}
		}
	}
	
    public function warehouse($id = null)
	{
		if($id == null){
			$this->load->view('Admin/warehouse/data');
		} else {
			switch($id){
				case 'add':
					$this->load->view('Admin/warehouse/add');
				break;

				case 'edit':
					$this->load->view('Admin/warehouse/edit');
				break;

				default:
					$this->load->view('Admin/warehouse/detail');
			}
		}
	}
	
    public function supplier($id = null)
	{
		if($id == null){
			$this->load->view('Admin/supplier/data');
		} else {
			switch($id){
				case 'add':
					$this->load->view('Admin/supplier/add');
				break;

				case 'edit':
					$this->load->view('Admin/supplier/edit');
				break;

				default:
					$this->load->view('Admin/supplier/detail');
			}
		}
	}
	
    
}
