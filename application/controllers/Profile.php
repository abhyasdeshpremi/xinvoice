<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    function __construct() {
        parent::__construct();
        if($this->session->userdata('isUserLoggedIn') != TRUE){ 
            redirect('/login');
        }
        $this->load->model('User_model', '', TRUE);
        $this->load->model('Firm_model', '', TRUE);
        $this->load->model('Profile_model', '', TRUE);
        $this->load->library("pagination");
    }
     
    
    public function Account(){
        $data = array();

        // $config = array();
        // $config["base_url"] = base_url("userdetails");
        // $config["total_rows"] = $this->User_model->get_count();
        // $config["per_page"] = PAGE_PER_ITEM;
        // $config["uri_segment"] = 2;
        // $this->pagination->initialize($config);
        // $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        // $data["links"] = $this->pagination->create_links();

        // $firm_result = $this->User_model->user_list($config["per_page"], $page);
        // $data['data'] = $firm_result['result'];
        // $data['page'] = $page;
        // $this->template->set('buttonName', 'New User');
        // $this->template->set('buttonLink', base_url('/createuser'));

        $data = array();
        $username = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $profile_result = $this->Profile_model->profile($username);
        $data['data'] = $profile_result['result'];
        $this->template->set('title', 'Account');
        $this->template->load('default_layout', 'contents' , 'settings/profile', $data);
    }

    public function ChangePassword(){
        $data = array();

        $this->template->set('title', 'Change Password');
        $this->template->load('default_layout', 'contents' , 'settings/changepassword', $data);
    }

}