<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends CI_Controller {

    function __construct() {
        parent::__construct();
        if($this->session->userdata('isUserLoggedIn') != TRUE){ 
            redirect('/login');
        }
        if(access_lavel(3, $this->session->userdata('role'))){
            redirect('/login');
        }
        $this->load->model('Company_model', '', TRUE);
        $this->load->library("pagination");
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
        $this->template->set('buttonName', 'Company List');
        $this->template->set('buttonLink', base_url('/companydetails'));
        $this->template->set('title', 'Create Company');
        $this->template->load('default_layout', 'contents' , 'company/createcompany', $data);
    }

    public function companydetails(){
        $data = array();

        $config = array();
        $config["base_url"] = base_url("companydetails");
        $config["total_rows"] = $this->Company_model->get_count();
        $config["per_page"] = PAGE_PER_ITEM;
        $config["uri_segment"] = 2;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["links"] = $this->pagination->create_links();

        $firm_result = $this->Company_model->company_list($config["per_page"], $page);
        $data['data'] = $firm_result['result'];
        $data['page'] = $page;
        $this->template->set('buttonName', 'New Company');
        $this->template->set('buttonLink', base_url('/createcompany'));
        $this->template->set('title', 'Company List');
        $this->template->load('default_layout', 'contents' , 'company/companydetail', $data);
    }

    public function updateCompany($companyCode = null){
        $data = array(); 
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $data['method'] = "GET";
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['method'] = "POST";
            $data['uniqueCode'] = $this->input->post('uniqueCode');
            $data['companyName'] = $this->input->post('companyName');
            $data['description'] = $this->input->post('description');
            $uniqueCodeCheck = $this->Company_model->unique_company_code_check($this->input->post('uniqueCode'));
            if($uniqueCodeCheck){
                $updateCompany = $this->Company_model->update_company($data);
                if($updateCompany ){
                    $data['successMessage'] = "Successfully Item Updated.";
                }else{
                    $data['errorMessage'] = 'No change on current value or Something went wrong';
                }
            }else{
                $data['errorMessage'] = 'Unique Code must be unique. Please try again later';
            }
         }

        $company_result = $this->Company_model->update_company_detail($companyCode);
        $data['data'] = $company_result['result'];
        $this->template->set('buttonName', 'Company List');
        $this->template->set('buttonLink', base_url('/companydetails'));
        $this->template->set('title', 'Update Company');
        $this->template->load('default_layout', 'contents' , 'company/updatecompany', $data);
    }

    public function deleteCompany(){
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['companyCode'] = $this->input->post('companyCode');
            $company_delete_result = $this->Company_model->delete_company($data);
            if($company_delete_result['code']){
                $data['code'] = $company_delete_result['code'];
                $data['companyCode'] = $company_delete_result['companyCode'];
                $data["message"] = "Successfully company deleted!";
            }else{
                $data['code'] = $company_delete_result['code'];
                $data['companyCode'] = $company_delete_result['companyCode'];
                $data["message"] = "Unable to delete this company. Please try again!";
            }
        }else{
            $data['code'] = false;
            $data['companyCode'] = $this->input->post('companyCode');
            $data["message"] = "Unable to serve delete Request, Please try again!";
        }
        echo json_encode($data);
    }
}
