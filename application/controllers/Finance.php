<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Finance extends CI_Controller {

	public function index()
	{
		$this->load->view('Finance/main');
    }
    
    public function dashboard()
	{
		$this->load->view('Finance/dashboard');
	}

	public function warehouse($id = null)
	{
		if($id === null){
			$this->load->view('Finance/warehouse/data');
		} else {
			$this->load->view('Finance/warehouse/detail');
		}
		
	}

	public function supplier($id = null)
	{
		if($id == null){
			$this->load->view('Finance/supplier/data');
		} else {
			$this->load->view('Finance/supplier/detail');
		}
		
	}

	public function product($id = null)
	{
		if($id == null){
			$this->load->view('Finance/product/data');
		} else {
			switch($id){
				case 'add':
					$this->load->view('Finance/product/add');
				break;

				case 'edit':
					$this->load->view('Finance/product/edit');
				break;

				default:
					$this->load->view('Finance/product/data');
			}
		}
	}

	public function order($id = null)
	{
		if($id == null){
			$this->load->view('Finance/order/data');
		} else {
			$this->load->view('Finance/order/detail');
		}
	}

	public function shipping($id = null)
	{
		if($id == null){
			$this->load->view('Finance/shipping/data');
		} else {
			$this->load->view('Finance/shipping/detail');
		}
	}
	
	public function invoice($id = null)
	{
		if($id == null){
			$this->load->view('Finance/invoice/data');
		} else {
			$this->load->view('Finance/invoice/detail');
		}
	}

	public function payment($id = null)
	{
		if($id == null){
			$this->load->view('Finance/payment/data');
		} else {
			switch($id){
				case 'add':
					$this->load->view('Finance/payment/add');
				break;

				case 'edit':
					$this->load->view('Finance/payment/edit');
				break;

				default:
					$this->load->view('Finance/payment/detail');
			}
		}
	}

	public function laporan($id)
	{
		switch($id){
				case 'payment':
					$this->load->view('Finance/laporan/payment');
				break;

				case 'hutang':
					$this->load->view('Finance/laporan/hutang');
				break;
			}
	}
    
}
