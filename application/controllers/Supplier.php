<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends CI_Controller {

	public function index()
	{
		$this->load->view('Supplier/main');
    }
    
    public function dashboard()
	{
		$this->load->view('Supplier/dashboard');
	}
	
    public function product() {
		$this->load->view('Supplier/product/data');
	}

	public function order($id = null)
	{
		if($id == null){
			$this->load->view('Supplier/order/data');
		} else {
			$this->load->view('Supplier/order/detail');
		}
	}

	public function shipping($id = null)
	{
		if($id == null){
			$this->load->view('Supplier/shipping/data');
		} else {
			switch($id){
				case 'add':
					$this->load->view('Supplier/shipping/add');
				break;

				case 'edit':
					$this->load->view('Supplier/shipping/edit');
				break;

				default:
					$this->load->view('Supplier/shipping/detail');
			}
		}
	}

	public function invoice($id = null)
	{
		if($id == null){
			$this->load->view('Supplier/invoice/data');
		} else {
			switch($id){
				case 'add':
					$this->load->view('Supplier/invoice/add');
				break;

				case 'edit':
					$this->load->view('Supplier/invoice/edit');
				break;

				default:
					$this->load->view('Supplier/invoice/detail');
			}
		}
	}

	public function payment($id = null)
	{
		if($id == null){
			$this->load->view('Supplier/payment/data');
		} else {
			switch($id){
				case 'add':
					$this->load->view('Supplier/payment/add');
				break;

				case 'edit':
					$this->load->view('Supplier/payment/edit');
				break;

				default:
					$this->load->view('Supplier/payment/detail');
			}
		}
	}
    
}
