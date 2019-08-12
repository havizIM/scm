<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Finance extends CI_Controller {

	public function index()
	{
		$this->load->view('finance/main');
    }
    
    public function dashboard()
	{
		$this->load->view('finance/dashboard');
    }
    
}
