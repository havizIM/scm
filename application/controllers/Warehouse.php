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
    
}
