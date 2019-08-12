<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Warehouse extends CI_Controller {

	public function index()
	{
		$this->load->view('warehouse/main');
    }
    
    public function dashboard()
	{
		$this->load->view('warehouse/dashboard');
	}
	
	public function order($id = null)
	{
		if($id == null){
			$this->load->view('warehouse/order/data');
		} else {
			switch($id){
				case 'add':
					$this->load->view('warehouse/order/add');
				break;

				case 'edit':
					$this->load->view('warehouse/order/edit');
				break;

				default:
					$this->load->view('warehouse/order/detail');
			}
		}
	}
    
}
