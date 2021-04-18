<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Firm extends CI_Controller {

    function __construct() {
        parent::__construct();
        if($this->session->userdata('isUserLoggedIn') != TRUE){ 
            redirect('/login');
        }
        $this->load->model('Firm_model', '', TRUE);
    }
    

	public function index()
	{
        $queryResult = $this->Firm_model->primary_firm();
		$data = array();
        $data['data'] = $queryResult['result'];
        $this->template->set('title', 'Firm');
        $this->template->load('default_layout', 'contents' , 'firm/firm', $data);
	}

    public function createfirm(){
        $data = array();
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
            $uniqueCodeVerify = $this->Firm_model->unique_firm_code_verify($this->input->post('uniqueCode'));
            if($uniqueCodeVerify){
                $createFirm = $this->Firm_model->create_firm($data);
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
        $this->template->set('title', 'Create Firm');
        $this->template->load('default_layout', 'contents' , 'firm/createfirm', $data);
    }

    public function firmdetails(){
        $data = array();
        $firm_result = $this->Firm_model->firm_list();
        $data['data'] = $firm_result['result'];
        $this->template->set('title', 'Firms List');
        $this->template->load('default_layout', 'contents' , 'firm/firmdetail', $data);
    }
}
