<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		$data = array();
        $this->template->set('title', 'Home');
        $this->template->load('default_layout', 'contents' , 'home', $data);
	}
}
