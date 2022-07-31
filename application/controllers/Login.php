<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Login_model', '', TRUE);
        $this->load->model('Profile_model', '', TRUE);
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
                $this->session->set_userdata('firm_mobile_number', $firmResult['result'][0]->mobile_number);
                $this->session->set_userdata('firm_email', $firmResult['result'][0]->firm_email);
                $this->session->set_userdata('bill_include_tax', $firmResult['result'][0]->bill_include_tax);
                $this->session->set_userdata('feature_group_for_item', $firmResult['result'][0]->feature_group_for_item);
                $this->session->set_userdata('feature_capture_saved_amount', $firmResult['result'][0]->feature_capture_saved_amount);
                $this->session->set_userdata('bonus_percent', $firmResult['result'][0]->bonus_percent);
                $this->session->set_userdata('pk_firm_id', $firmResult['result'][0]->pk_firm_id);

                $this->session->set_userdata('invoice_format', $firmResult['result'][0]->invoice_format);
                $this->session->set_userdata('invoice_pdf_format', $firmResult['result'][0]->invoice_pdf_format);
                $this->session->set_userdata('cgstrate', $firmResult['result'][0]->cgstrate);
                $this->session->set_userdata('sgstrate', $firmResult['result'][0]->sgstrate);
                $this->session->set_userdata('igstrate', $firmResult['result'][0]->igstrate);
                $this->session->set_userdata('pan_number', $firmResult['result'][0]->pan_number);
                $this->session->set_userdata('gst_number', $firmResult['result'][0]->gst_number);
                $this->session->set_userdata('firm_state', $firmResult['result'][0]->state);

                $this->session->set_userdata('role', $queryResult['result'][0]->role);
                $termcondition = $this->Profile_model->gettermcondition();
                if(count($termcondition['result']) > 0){
                    $this->session->set_userdata('tc_title', $termcondition['result'][0]->tc_title);
                    $this->session->set_userdata('line1', $termcondition['result'][0]->line1);
                    $this->session->set_userdata('line2', $termcondition['result'][0]->line2);
                    $this->session->set_userdata('line3', $termcondition['result'][0]->line3);
                    $this->session->set_userdata('line4', $termcondition['result'][0]->line4);
                }

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

    public function register(){
        $data = array(); 
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $data['method'] = "GET";
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['method'] = "POST";
        }
        $this->template->set('title', 'Register');
        $this->template->load('login_layout', 'contents' , 'register', $data);
    }

    public function checkfirmuniquecode(){
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $firm_result = $this->Login_model->firmUniqueCode($this->input->post('firmuniquecode'));
            echo json_encode($firm_result);
        }
    }

    public function checkuseremail(){
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $firm_result = $this->Login_model->checkuseremail($this->input->post('firmEmail'));
            echo json_encode($firm_result);
        }
    }

    public function checkusername(){
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $firm_result = $this->Login_model->checkusername($this->input->post('username'));
            echo json_encode($firm_result);
        }
    }

    public function registeruser(){
        $data = array(); 
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['firstname'] = $this->input->post('firstname');
            $data['lastname'] = $this->input->post('lastname');

            $data['username'] = $this->input->post('username');
            $data['password'] = $this->input->post('password');
            $data['firmuniquecode'] = $this->input->post('firmuniquecode');
            $data['firmName'] = $this->input->post('firmName');
            $data['firmMobile'] = $this->input->post('firmMobile');
            $data['firmEmail'] = $this->input->post('firmEmail');

            $data['firmAddress'] = $this->input->post('firmAddress');
            $data['firmArea'] = $this->input->post('firmArea');
            $data['firmCity'] = $this->input->post('firmCity');
            $data['firmdistrict'] = $this->input->post('firmdistrict');
            $data['firmState'] = $this->input->post('firmState');
            $data['firmZip'] = $this->input->post('firmZip');


            $register_result = $this->Login_model->registeruser($data);
            echo json_encode($register_result);
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
