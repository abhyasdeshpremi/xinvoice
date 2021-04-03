<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		$data = array();
        $this->template->set('title', 'Login');
        $this->template->set('menu', FALSE);
        $this->template->load('default_layout', 'contents' , 'login', $data);
	}
}
