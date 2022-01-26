<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

    function __construct() {
        parent::__construct();
        if($this->session->userdata('isUserLoggedIn') != TRUE){ 
            redirect('/login');
        }
        $this->load->model('Account_model', '', TRUE);
        $this->load->model('Client_model', '', TRUE);
        $this->load->library("pagination");
    }
    
    public function getAccount(){
        $data = array();

        $config = array();
        $config["base_url"] = base_url("getaccount");
        $config["total_rows"] = $this->Account_model->get_count();
        $config["per_page"] = PAGE_PER_ITEM;
        $config["uri_segment"] = 2;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["links"] = $this->pagination->create_links();

        $account_result = $this->Account_model->account_list($config["per_page"], $page);
        $data['clientsList'] = $this->Client_model->clients_list();
        $data['data'] = $account_result['result'];
        $data['page'] = $page;
        $this->template->set('buttonName', 'Account history List');
        $this->template->set('buttonLink', base_url('/getaccounthistory'));
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

        $stock_log_result = $this->Account_model->account_log_list($config["per_page"], $page);
        $data['data'] = $stock_log_result['result'];
        $data['page'] = $page;
        $this->template->set('buttonName', 'Account List');
        $this->template->set('buttonLink', base_url('/getaccount'));
        $this->template->set('title', 'Account History List');
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
            $data["message"] = "";
            $invoice_item_save_result = $this->Account_model->saveAccount($data);
            if($invoice_item_save_result['code']){
                $data['code'] = $invoice_item_save_result['code'];
                $data['pk_account_id'] = $invoice_item_save_result['pk_account_id'];
                $data["message"] = "Successfully payment amount added!";
            }else{
                $data['code'] = $invoice_item_save_result['code'];
                $data['pk_account_id'] = $invoice_item_save_result['pk_account_id'];
                $data["message"] = "Unable to save amount, may be wrong Client. Please try again!";
            }
        }else{
            $data['code'] = false;
            $data["message"] = "Unable to serve GET Request, Please try again!";
        }
        echo json_encode($data);
    }
    
}