<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    function __construct() {
        parent::__construct();
        if($this->session->userdata('isUserLoggedIn') != TRUE){ 
            redirect('/login');
        }
        $this->load->model('User_model', '', TRUE);
        $this->load->model('Firm_model', '', TRUE);
        $this->load->library("pagination");
    }
    
    public function createUser(){
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $data['method'] = "GET";
         } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['method'] = "POST";
            $data['username'] = $this->input->post('username');
            
            $data['firstName'] = $this->input->post('firstName');
            $data['lastName'] = $this->input->post('lastName');
            $data['userRole'] = $this->input->post('userRole');
            $data['userStatus'] = $this->input->post('userStatus');

            $usernameVerify = $this->User_model->unique_username_verify($this->input->post('username'));
            if($usernameVerify){
                $mobileVerify = $this->User_model->unique_mobile_verify($this->input->post('mobile'));
                if($mobileVerify){
                    $emailVerify = $this->User_model->unique_email_verify($this->input->post('email'));
                    if($emailVerify){
                        $data['username'] = $this->input->post('username');
                        $data['mobile'] = $this->input->post('mobile');
                        $data['email'] = $this->input->post('email');
                        $data['password'] = $this->input->post('password');
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
        $this->template->set('buttonName', 'Users List');
        $this->template->set('buttonLink', base_url('/userdetails'));
        $this->template->set('title', 'Create User');
        $this->template->load('default_layout', 'contents' , 'user/createUser', $data);
    }

    public function userdetails(){
        $data = array();

        $config = array();
        $config["base_url"] = base_url("userdetails");
        $config["total_rows"] = $this->User_model->get_count();
        $config["per_page"] = PAGE_PER_ITEM;
        $config["uri_segment"] = 2;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["links"] = $this->pagination->create_links();

        $firm_result = $this->User_model->user_list($config["per_page"], $page);
        $data['data'] = $firm_result['result'];
        $data['page'] = $page;
        $this->template->set('buttonName', 'New User');
        $this->template->set('buttonLink', base_url('/createuser'));
        $this->template->set('title', 'Users List');
        $this->template->load('default_layout', 'contents' , 'user/userdetail', $data);
    }

    public function updateUser($username = null){
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $data['method'] = "GET";
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['method'] = "POST";
            $firmCode = $this->input->post('firmCode');
            $data['username'] = $this->input->post('username');
            $data['firstName'] = $this->input->post('firstName');
            $data['lastName'] = $this->input->post('lastName');
            $data['userRole'] = $this->input->post('userRole');
            $data['userStatus'] = $this->input->post('userStatus');
            $data['firmCode'] = (empty($firmCode)) ? $this->session->userdata('firmcode') : $firmCode;
            $usernameCheck = $this->User_model->unique_username_check($this->input->post('username'));
            if($usernameCheck){
                $updateUser = $this->User_model->update_user($data);
                if($updateUser){
                    $data['successMessage'] = "Successfully User Updated.";
                }else{
                    $data['errorMessage'] = 'No change on current value or Something went wrong';
                }
            }else{
                $data['errorMessage'] = 'Unique username must be unique. Please try again later';
            }
         }
        $user_result = $this->User_model->update_user_detail($username);
        $data['data'] = $user_result['result'];
        if ($this->session->userdata('role') == "superadmin"){
            $queryResult = $this->Firm_model->firm_list();
            $data['firmData'] = $queryResult['result'];
        }
        $this->template->set('buttonName', 'Users List');
        $this->template->set('buttonLink', base_url('/userdetails'));
        $this->template->set('title', 'Update User');
        $this->template->load('default_layout', 'contents' , 'user/updateUser', $data);
    }

    public function deleteUser(){
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['userName'] = $this->input->post('userName');
            $item_delete_result = $this->User_model->delete_user($data);
            if($item_delete_result['code']){
                $data['code'] = $item_delete_result['code'];
                $data['username'] = $item_delete_result['username'];
                $data["message"] = "Successfully user deleted!";
            }else{
                $data['code'] = $item_delete_result['code'];
                $data['username'] = $item_delete_result['username'];
                $data["message"] = "Unable to delete this user. Please try again!";
            }
        }else{
            $data['code'] = false;
            $data['username'] = $this->input->post('userName');
            $data["message"] = "Unable to serve delete Request, Please try again!";
        }
        echo json_encode($data);
    }


}