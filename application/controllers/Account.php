<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

    function __construct() {
        parent::__construct();
        if($this->session->userdata('isUserLoggedIn') != TRUE){ 
            redirect('/login');
        }
        if(access_lavel(3, $this->session->userdata('role'))){
            redirect('/login');
        }
        $this->load->model('Account_model', '', TRUE);
        $this->load->model('Client_model', '', TRUE);
        $this->load->library("pagination");
    }
    
    public function getAccount(){
        if(access_lavel(3, $this->session->userdata('role'))){
            redirect('/login');
        }
        $data = array();
        $page_seg = 2;
        $search_seg = 3;
        $searchurl = '';
        if (!empty($this->uri->segment(2)) && !empty($this->uri->segment(3)) ) {
            $page_seg = 3;
            $search_seg = 2;
            $searchurl = "/";
        }else if (!empty($this->uri->segment(2)) && ($this->uri->segment(3) == 0) ) {
            if (!is_numeric($this->uri->segment(2))){
                $page_seg = 3;
                $search_seg = 2;
                $searchurl = "/";
            }
        }

        $globalsearchtext = ($this->uri->segment($search_seg)) ? $this->uri->segment($search_seg) : '';
        $data["base_url"] = base_url("getaccount");
        $config = array();
        $config["base_url"] = base_url("getaccount".$searchurl."".$globalsearchtext);
        $config["total_rows"] = $this->Account_model->get_count(urldecode($globalsearchtext));
        $config["per_page"] = PAGE_PER_ITEM;
        $config["uri_segment"] = $page_seg;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment($page_seg)) ? $this->uri->segment($page_seg) : 0;
        $data["links"] = $this->pagination->create_links();

        $account_result = $this->Account_model->account_list($config["per_page"], $page, urldecode($globalsearchtext));
        $data['clientsList'] = $this->Client_model->clients_list();
        $data['data'] = $account_result['result'];
        $data['page'] = $page;
        $this->template->set('buttonName', 'Account history List');
        $this->template->set('buttonLink', base_url('/getaccounthistory'));
        $this->template->set('globalsearch', TRUE);
        $this->template->set('globalsearchtext', urldecode($globalsearchtext));
        $this->template->set('title', 'Account List');
        $this->template->load('default_layout', 'contents' , 'account/accountdetail', $data);
    }

    public function getAccountHistory(){
        $data = array();

        $config = array();
        $config["base_url"] = base_url("getaccounthistory");
        $config["total_rows"] = $this->Account_model->get_log_count();
        $config["per_page"] = PAGE_PER_ITEM;
        $config["uri_segment"] = 2;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["links"] = $this->pagination->create_links();

        $account_log_result = $this->Account_model->account_log_list($config["per_page"], $page);
        $data['data'] = $account_log_result['result'];
        $data['page'] = $page;
        $this->template->set('buttonName', 'Account List');
        $this->template->set('buttonLink', base_url('/getaccount'));
        $this->template->set('title', 'Account History List');
        $this->template->load('default_layout', 'contents' , 'account/accountHistoy', $data);
    }

    public function getClientAccountHistory(){
        $data = array();
        $clientCode = $this->uri->segment(2);
        $config = array();
        $config["base_url"] = base_url("getclientaccounthistory/".$clientCode);
        $config["total_rows"] = $this->Account_model->get_log_count($clientCode);
        $config["per_page"] = PAGE_PER_ITEM * 15;
        $config["uri_segment"] = 3;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["links"] = $this->pagination->create_links();

        $account_log_result = $this->Account_model->account_log_list($config["per_page"], $page, $clientCode);
        $data['data'] = $account_log_result['result'];
        $data['page'] = $page;
        $this->template->set('buttonName', 'Account List');
        $this->template->set('buttonLink', base_url('/getaccount'));
        $this->template->set('title', 'Account('.$clientCode.') History List');
        $this->template->load('default_layout', 'contents' , 'account/accountHistoy', $data);
    }

    public function saveAmount(){
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['fk_client_code'] = $this->input->post('fk_client_code');
            $data['fk_client_name'] = $this->input->post('fk_client_name');
            $data['payment_mode'] = $this->input->post('payment_mode');
            $data['payment_date'] = $this->input->post('payment_date');
            $data['amount'] = $this->input->post('amount');
            $data['notes'] = $this->input->post('notes');
            $data['paymenttype'] = $this->input->post('paymenttype');
            $data['statuscode'] = '';
            $data["message"] = "";
            $invoice_item_save_result = $this->Account_model->saveAccount($data);
            if($invoice_item_save_result['code']){
                $data['code'] = $invoice_item_save_result['code'];
                $data['pk_account_id'] = $invoice_item_save_result['pk_account_id'];
                $data['totalAmount'] = $invoice_item_save_result['totalAmount'];
                $data["message"] = "Successfully payment amount ".$data['paymenttype']."!";
            }else{
                $data['code'] = $invoice_item_save_result['code'];
                $data['pk_account_id'] = $invoice_item_save_result['pk_account_id'];
                $data['totalAmount'] = $invoice_item_save_result['totalAmount'];
                $data["message"] = "Unable to save amount, may be wrong Client. Please try again!";
            }
        }else{
            $data['code'] = false;
            $data["message"] = "Unable to serve GET Request, Please try again!";
        }
        echo json_encode($data);
    }
    
}