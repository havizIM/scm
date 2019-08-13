<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Warehouse extends CI_Controller {

	public function index()
	{
		$this->load->view('Warehouse/main');
    }

    public function dashboard()
	{
		$this->load->view('Warehouse/dashboard');
	}

	public function supplier($id = null)
	{
		if($id == null){
			$this->load->view('Warehouse/supplier/data');
		} else {
			$this->load->view('Warehouse/supplier/detail');
		}
	}

	public function order($id = null)
	{
		if($id == null){
			$this->load->view('Warehouse/order/data');
		} else {
			switch($id){
				case 'add':
					$this->load->view('Warehouse/order/add');
				break;

				case 'edit':
					$this->load->view('Warehouse/order/edit');
				break;

				default:
					$this->load->view('Warehouse/order/detail');
			}
		}
	}

	public function shipping($id = null)
	{
		if($id == null){
			$this->load->view('Warehouse/shipping/data');
		} else {
			$this->load->view('Warehouse/shipping/detail');
		}
	}



}
