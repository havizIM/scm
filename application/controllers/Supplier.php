<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends CI_Controller {

	public function index()
	{
		$this->load->view('supplier/main');
    }
    
    public function dashboard()
	{
		$this->load->view('supplier/dashboard');
    }
    
}
