<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Piggybank extends CI_Controller {

    function __construct() {
        parent::__construct();
        if($this->session->userdata('isUserLoggedIn') != TRUE){ 
            redirect('/login');
        }
        if(access_lavel(3, $this->session->userdata('role'))){
            redirect('/login');
        }
        $this->load->model('Piggybank_model', '', TRUE);
        $this->load->library("pagination");
    }

    public function accountHolderList(){
        $data = array();

        $config = array();
        $config["base_url"] = base_url("clientdetails");
        $config["total_rows"] = $this->Piggybank_model->get_count();
        $config["per_page"] = PAGE_PER_ITEM;
        $config["uri_segment"] = 2;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["links"] = $this->pagination->create_links();


        $firm_result = $this->Piggybank_model->account_holder_list($config["per_page"], $page);
        $data['data'] = $firm_result['result'];
        $data['page'] = $page;
        $this->template->set('buttonName', 'New Account Holder');
        $this->template->set('buttonLink', base_url('/newaccountholder'));
        $this->template->set('title', 'Account Holder List');
        $this->template->load('default_layout', 'contents' , 'piggybank/accountholderdetail', $data);
    }

    public function NewAccountHolder(){
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $data['method'] = "GET";
         } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['method'] = "POST";
            $data['uniqueCode'] = $this->input->post('uniqueCode');
            $data['clientName'] = $this->input->post('clientName');
            $data['clientMobile'] = $this->input->post('clientMobile');
            $data['accontemail'] = $this->input->post('accontemail'); 
            $data['clientAddress'] = $this->input->post('clientAddress');
            $uniqueCodeVerify = $this->Piggybank_model->unique_client_code_verify($this->input->post('uniqueCode'));
            if($uniqueCodeVerify){
                $createClient = $this->Piggybank_model->create_account_holder($data);
                if($createClient ){
                    unset($data);
                    $data['successMessage'] = "Successfully Account Holder Created.";
                }else{
                    $data['errorMessage'] = 'Unable to save Account Holder information. Please contact your Administrator.';
                }
            }else{
                $data['errorMessage'] = 'Unique Code must be unique.';
            }
         }
        $this->template->set('buttonName', 'Account Holder List');
        $this->template->set('buttonLink', base_url('/accountholderlist'));
        $this->template->set('title', 'New Account Holder');
        $this->template->load('default_layout', 'contents' , 'piggybank/newaccountholder', $data);
    }

    public function updateAccountHolder($account_holder_id = null){
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $data['method'] = "GET";
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['method'] = "POST";
            $data['uniqueCode'] = $this->input->post('uniqueCode');
            $data['clientName'] = $this->input->post('clientName');
            $data['clientMobile'] = $this->input->post('clientMobile');
            $data['accontemail'] = $this->input->post('accontemail'); 
            $data['clientAddress'] = $this->input->post('clientAddress');
            $uniqueCodeCheck = $this->Piggybank_model->unique_account_holder_code_check($this->input->post('uniqueCode'));
            if($uniqueCodeCheck){
                $saveClient = $this->Piggybank_model->update_account_holder($data);
                if($saveClient ){
                    $data['successMessage'] = "Successfully Account Holder Updated.";
                }else{
                    $data['errorMessage'] = 'No change on current value or Something went wrong';
                }
            }else{
                $data['errorMessage'] = 'Unique Code must be unique. Please try again later';
            }
        }

        $client_result = $this->Piggybank_model->update_account_holder_detail($account_holder_id);
        $data['data'] = $client_result['result'];
        $this->template->set('buttonName', 'Account Holder List');
        $this->template->set('buttonLink', base_url('/accountholderlist'));
        $this->template->set('title', 'Account Holder Update');
        $this->template->load('default_layout', 'contents' , 'piggybank/updateaccountholder', $data);
    }


    public function deleteAccountHolder(){
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['client_code'] = $this->input->post('client_code');
            $client_delete_result = $this->Piggybank_model->delete_account_holder($data);
            if($client_delete_result['code']){
                $data['code'] = $client_delete_result['code'];
                $data['clientid'] = $client_delete_result['clientid'];
                $data["message"] = "Successfully client deleted!";
            }else{
                $data['code'] = $client_delete_result['code'];
                $data['clientid'] = $client_delete_result['clientid'];
                $data["message"] = "Unable to delete this client. Please try again!";
            }
        }else{
            $data['code'] = false;
            $data['clientid'] = $this->input->post('client_code');
            $data["message"] = "Unable to serve delete Request, Please try again!";
        }
        echo json_encode($data);
    }


    //Piggy bank Account 
    public function accountHolderBalance(){
        $data = array();

        $config = array();
        $config["base_url"] = base_url("getaccount");
        $config["total_rows"] = $this->Piggybank_model->get_piggy_bank_count();
        $config["per_page"] = PAGE_PER_ITEM;
        $config["uri_segment"] = 2;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["links"] = $this->pagination->create_links();

        $account_result = $this->Piggybank_model->piggy_bank_account_list($config["per_page"], $page);
        $data['clientsList'] = $this->Piggybank_model->Piggy_Bank_account_name_list();
        $data['data'] = $account_result['result'];
        $data['page'] = $page;
        $this->template->set('buttonName', 'Account Holder Balance history List');
        $this->template->set('buttonLink', base_url('/getaccountholderhistory'));
        $this->template->set('title', 'Account Holder Balance');
        $this->template->load('default_layout', 'contents' , 'piggybank/accountholderbalance', $data);
    }

    public function savePiggyBankAmount(){
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
            $invoice_item_save_result = $this->Piggybank_model->saveAccount($data);
            if($invoice_item_save_result['code']){
                $data['code'] = $invoice_item_save_result['code'];
                $data['pk_account_id'] = $invoice_item_save_result['pk_piggy_account_id'];
                $data['totalAmount'] = $invoice_item_save_result['totalAmount'];
                $data["message"] = "Successfully payment amount ".$data['paymenttype']."!";
            }else{
                $data['code'] = $invoice_item_save_result['code'];
                $data['pk_account_id'] = $invoice_item_save_result['pk_piggy_account_id'];
                $data['totalAmount'] = $invoice_item_save_result['totalAmount'];
                $data["message"] = "Unable to save amount, may be wrong Client. Please try again!";
            }
        }else{
            $data['code'] = false;
            $data["message"] = "Unable to serve GET Request, Please try again!";
        }
        echo json_encode($data);
    }

    public function getAccountHolderHistory(){
        $data = array();

        $config = array();
        $config["base_url"] = base_url("getaccountholderhistory");
        $config["total_rows"] = $this->Piggybank_model->get_log_count();
        $config["per_page"] = PAGE_PER_ITEM;
        $config["uri_segment"] = 2;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["links"] = $this->pagination->create_links();

        $account_log_result = $this->Piggybank_model->account_log_list($config["per_page"], $page);
        $data['data'] = $account_log_result['result'];
        $data['page'] = $page;
        $this->template->set('buttonName', 'Account Holder Balance');
        $this->template->set('buttonLink', base_url('/accountholderbalance'));
        $this->template->set('title', 'Account Holder History List');
        $this->template->load('default_layout', 'contents' , 'piggybank/accountHolderHistoy', $data);
    }

    public function getClientAccountHolderHistory(){
        $data = array();
        $clientCode = $this->uri->segment(2);
        $config = array();
        $config["base_url"] = base_url("getclientaccountholderhistory/".$clientCode);
        $config["total_rows"] = $this->Piggybank_model->get_log_count($clientCode);
        $config["per_page"] = PAGE_PER_ITEM;
        $config["uri_segment"] = 3;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["links"] = $this->pagination->create_links();

        $account_log_result = $this->Piggybank_model->account_log_list($config["per_page"], $page, $clientCode);
        $data['data'] = $account_log_result['result'];
        $data['page'] = $page;
        $this->template->set('buttonName', 'Account Holder Balance');
        $this->template->set('buttonLink', base_url('/accountholderbalance'));
        $this->template->set('title', 'Account Holder ('.$clientCode.') History List');
        $this->template->load('default_layout', 'contents' , 'piggybank/accountHolderHistoy', $data);
    }

    public function getClientAccountHolderEarnHistory(){
        $data = array();
        $clientCode = $this->uri->segment(2);
        $config = array();
        $config["base_url"] = base_url("getclientaccountholderhistory/".$clientCode);
        $config["total_rows"] = $this->Piggybank_model->get_earned_log_count($clientCode);
        $config["per_page"] = PAGE_PER_ITEM * 10;
        $config["uri_segment"] = 3;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["links"] = $this->pagination->create_links();

        $account_log_result = $this->Piggybank_model->account_earned_log_list($config["per_page"], $page, $clientCode);
        $data['data'] = $account_log_result['result'];
        $data['page'] = $page;
        $this->template->set('buttonName', 'Account Holder Balance');
        $this->template->set('buttonLink', base_url('/accountholderbalance'));
        $this->template->set('title', 'Account Holder ('.$clientCode.') Earned History List');
        $this->template->load('default_layout', 'contents' , 'piggybank/accountHolderHistoy', $data);
    }
}