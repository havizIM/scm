<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function login_int()
	{
		$this->load->view('auth/login_int');
    }
    
    public function login_ext()
	{
		$this->load->view('auth/login_ext');
    }
    
}
