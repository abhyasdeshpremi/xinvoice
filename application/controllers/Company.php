<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends CI_Controller {

    function __construct() {
        parent::__construct();
        if($this->session->userdata('isUserLoggedIn') != TRUE){ 
            redirect('/login');
        }
        $this->load->model('Company_model', '', TRUE);
    }
    
    public function createCompany(){
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $data['method'] = "GET";
         } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['method'] = "POST";
            $data['uniqueCode'] = $this->input->post('uniqueCode');
            $data['companyName'] = $this->input->post('companyName');
            $data['description'] = $this->input->post('description');
            $uniqueCodeVerify = $this->Company_model->unique_company_code_verify($this->input->post('uniqueCode'));
            if($uniqueCodeVerify){
                $createCompany = $this->Company_model->create_company($data);
                if($createCompany ){
                    unset($data);
                    $data['successMessage'] = "Successfully Company Created.";
                }else{
                    $data['errorMessage'] = 'Unable to save firm information. Please contact your Administrator.';
                }
            }else{
                $data['errorMessage'] = 'Unique Code must be unique.';
            }
         }
        $this->template->set('title', 'Create Company');
        $this->template->load('default_layout', 'contents' , 'company/createcompany', $data);
    }

    public function companydetails(){
        $data = array();
        $firm_result = $this->Company_model->company_list();
        $data['data'] = $firm_result['result'];
        $this->template->set('title', 'Company List');
        $this->template->load('default_layout', 'contents' , 'company/companydetail', $data);
    }
}
