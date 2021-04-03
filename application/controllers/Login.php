<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Login_model', '', TRUE);
    }

	public function index()
	{
        $email = $this->input->post('email');
        $password = $this->input->post('password');
		$data = array(
            'email' => $email,
            'password' => $password
        );
        $queryResult = $this->Login_model->login($email, $password);
        print_r($data);
        if($queryResult['login']){
            $this->session->set_userdata('email', $email);
            $this->session->set_userdata('username', $queryResult['result'][0]->username);
            $this->session->set_userdata('firstname', $queryResult['result'][0]->first_name);
            $this->session->set_userdata('lastname', $queryResult['result'][0]->last_name);
            $this->session->set_userdata('firmcode', $queryResult['result'][0]->firm_code);
            $this->session->set_userdata('role', $queryResult['result'][0]->role);
            redirect('/home');
        }else{
            $this->template->set('title', 'Login');
            $this->template->load('login_layout', 'contents' , 'login', $data);
        }
        
        
	}
}
