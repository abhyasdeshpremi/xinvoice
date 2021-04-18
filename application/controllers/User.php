<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    function __construct() {
        parent::__construct();
        if($this->session->userdata('isUserLoggedIn') != TRUE){ 
            redirect('/login');
        }
        $this->load->model('User_model', '', TRUE);
    }
    
    public function createUser(){
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $data['method'] = "GET";
         } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['method'] = "POST";
            $data['username'] = $this->input->post('username');
            $data['email'] = $this->input->post('email');
            $data['firstName'] = $this->input->post('firstName');
            $data['lastName'] = $this->input->post('lastName');
            $data['mobile'] = $this->input->post('mobile');
            $data['password'] = $this->input->post('password');
            $data['userRole'] = $this->input->post('userRole');
            $data['userStatus'] = $this->input->post('userStatus');
            $usernameVerify = $this->User_model->unique_username_verify($this->input->post('username'));
            if($usernameVerify){
                $mobileVerify = $this->User_model->unique_mobile_verify($this->input->post('mobile'));
                if($mobileVerify){
                    $emailVerify = $this->User_model->unique_email_verify($this->input->post('email'));
                    if($emailVerify){
                        $createUser = $this->User_model->create_user($data);
                        if($createUser ){
                            unset($data);
                            $data['successMessage'] = "Successfully User Created.";
                        }else{
                            $data['errorMessage'] = 'Unable to save firm information. Please contact your Administrator.';
                        }
                    }else{
                        $data['errorMessage'] = 'Email must be unique.';
                    }
                }else{
                    $data['errorMessage'] = 'Mobile number must be unique.';
                }

            }else{
                $data['errorMessage'] = 'Username must be unique.';
            }
         }
        $this->template->set('title', 'Create Item');
        $this->template->load('default_layout', 'contents' , 'user/createUser', $data);
    }

    public function userdetails(){
        $data = array();
        $firm_result = $this->User_model->user_list();
        $data['data'] = $firm_result['result'];
        $this->template->set('title', 'Items List');
        $this->template->load('default_layout', 'contents' , 'user/userdetail', $data);
    }


}