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

        if($this->session->userdata('isUserLoggedIn') === TRUE){ 
            redirect('/home');
        }
        if($queryResult['login']){
            $this->session->set_userdata('remember_me', $this->input->post('remember_me'));
            $firmResult = $this->Login_model->firm_detail($queryResult['result'][0]->fk_firm_code);
            if($firmResult['flag']){
                $this->session->set_userdata('email', $email);
                $this->session->set_userdata('isUserLoggedIn', TRUE);
                $this->session->set_userdata('username', $queryResult['result'][0]->username);
                $this->session->set_userdata('firstname', $queryResult['result'][0]->first_name);
                $this->session->set_userdata('lastname', $queryResult['result'][0]->last_name);
                $this->session->set_userdata('firmcode', $queryResult['result'][0]->fk_firm_code);
                $this->session->set_userdata('firmname', $firmResult['result'][0]->name);
                $this->session->set_userdata('bill_include_tax', $firmResult['result'][0]->bill_include_tax);
                $this->session->set_userdata('pk_firm_id', $firmResult['result'][0]->pk_firm_id);
                $this->session->set_userdata('role', $queryResult['result'][0]->role);


                $address = isset($firmResult['result'][0]->address) ? $firmResult['result'][0]->address : "";
                $area = isset($firmResult['result'][0]->area) ? $firmResult['result'][0]->area : "";
                $city = isset($firmResult['result'][0]->city) ? $firmResult['result'][0]->city : "";
                $district = isset($firmResult['result'][0]->district) ? $firmResult['result'][0]->district : "";
                $state = isset($firmResult['result'][0]->state) ? $firmResult['result'][0]->state : "";
                $pin_code = isset($firmResult['result'][0]->pin_code) ? $firmResult['result'][0]->pin_code : "";

                $full_address = $address." ".$area." ".$city." ".$district." ".$state." ".$pin_code;
                $this->session->set_userdata('firmaddress', $full_address);


                redirect('/home');
            }else{
                $this->template->set('title', 'Login');
                $this->template->load('login_layout', 'contents' , 'login', $data);
            }
            
        }else{
            $this->template->set('title', 'Login');
            $this->template->load('login_layout', 'contents' , 'login', $data);
        }
	}

    public function logout(){
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('isUserLoggedIn');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('firstname');
        $this->session->unset_userdata('lastname');
        $this->session->unset_userdata('firmcode');
        $this->session->unset_userdata('role');
        redirect('/login');
    }
}
