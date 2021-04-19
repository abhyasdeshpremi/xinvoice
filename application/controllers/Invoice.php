<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends CI_Controller {

    function __construct() {
        parent::__construct();
        if($this->session->userdata('isUserLoggedIn') != TRUE){ 
            redirect('/login');
        }
        $this->load->model('Invoice_model', '', TRUE);
    }
    
    public function createinvoice(){
        $data = array();
        $data['clients'] = $this->Invoice_model->client_list();
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $data['method'] = "GET";
         } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['method'] = "POST";
            $data['uniqueCode'] = $this->input->post('uniqueCode');
            $data['firmName'] = $this->input->post('firmName');
            $data['firmMobile'] = $this->input->post('firmMobile');
            $data['firmEmail'] = $this->input->post('firmEmail');
            $data['description'] = $this->input->post('description');
            $data['firmAddress'] = $this->input->post('firmAddress');
            $data['firmArea'] = $this->input->post('firmArea');
            $data['firmCity'] = $this->input->post('firmCity');
            $data['firmdistrict'] = $this->input->post('firmdistrict');
            $data['firmState'] = $this->input->post('firmState');
            $data['firmZip'] = $this->input->post('firmZip');
            $uniqueCodeVerify = $this->Invoice_model->unique_firm_code_verify($this->input->post('uniqueCode'));
            if($uniqueCodeVerify){
                $createFirm = $this->Invoice_model->create_company($data);
                if($createFirm ){
                    unset($data);
                    $data['successMessage'] = "Successfully Firm Created.";
                }else{
                    $data['errorMessage'] = 'Unable to save firm information. Please contact your Administrator.';
                }
            }else{
                $data['errorMessage'] = 'Unique Code must be unique.';
            }
         }
        $this->template->set('title', 'Create Invoice');
        $this->template->load('default_layout', 'contents' , 'invoice/createinvoice', $data);
    }

    public function invoicedetails(){
        $data = array();
        $firm_result = $this->Invoice_model->company_list();
        $data['data'] = $firm_result['result'];
        $this->template->set('title', 'Invoices List');
        $this->template->load('default_layout', 'contents' , 'invoice/invoicedetail', $data);
    }
}
