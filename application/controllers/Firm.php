<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Firm extends CI_Controller {

    function __construct() {
        parent::__construct();
        if($this->session->userdata('isUserLoggedIn') != TRUE){ 
            redirect('/login');
        }
        $this->load->model('Firm_model', '', TRUE);
        $this->load->library("pagination");
    }
    

	public function index()
	{
        if($this->session->userdata('role') != "superadmin"){
            redirect('/login');
        }
        $queryResult = $this->Firm_model->primary_firm();
		$data = array();
        $data['data'] = $queryResult['result'];
        $this->template->set('title', 'Firm');
        $this->template->load('default_layout', 'contents' , 'firm/firm', $data);
	}

    public function createfirm(){
        if($this->session->userdata('role') != "superadmin"){
            redirect('/login');
        }
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
            $data['business_type'] = $this->input->post('business_type');
            $data['billIncludeTax'] = $this->input->post('billIncludeTax');
            $data['firmbonus'] = $this->input->post('firmbonus');
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
        $business_type = $this->Firm_model->business_type_list();
        $data['business_types'] = $business_type['result'];
        $this->template->set('buttonName', 'Firm List');
        $this->template->set('buttonLink', base_url('/firmdetails'));
        $this->template->set('title', 'Create Firm');
        $this->template->load('default_layout', 'contents' , 'firm/createfirm', $data);
    }

    public function firmdetails(){
        if($this->session->userdata('role') != "superadmin"){
            redirect('/login');
        }
        $data = array();

        $config = array();
        $config["base_url"] = base_url("firmdetails");
        $config["total_rows"] = $this->Firm_model->get_count();
        $config["per_page"] = PAGE_PER_ITEM;
        $config["uri_segment"] = 2;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["links"] = $this->pagination->create_links();

        
        $firm_result = $this->Firm_model->firm_list($config["per_page"], $page);
        $data['data'] = $firm_result['result'];
        $data['page'] = $page;
        $this->template->set('buttonName', 'New Firm');
        $this->template->set('buttonLink', base_url('/createfirm'));
        $this->template->set('title', 'Firms List');
        $this->template->load('default_layout', 'contents' , 'firm/firmdetail', $data);
    }

    public function updateFirm($firmcode = null){
        if($this->session->userdata('role') != "superadmin"){
            redirect('/login');
        }
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
            $data['firmstatus'] = $this->input->post('firmstatus');
            $data['billIncludeTax'] = $this->input->post('billIncludeTax');
            $data['feature_group_for_item'] = $this->input->post('feature_group_for_item');
            $data['feature_capture_saved_amount'] = $this->input->post('feature_capture_saved_amount');
            $data['firmbonus'] = $this->input->post('firmbonus');
            $data['business_type'] = $this->input->post('business_type');
            $data['invoice_format'] = $this->input->post('invoice_format');
            $data['invoice_pdf_format'] = $this->input->post('invoice_pdf_format');
            $data['cgstrate'] = $this->input->post('cgstrate');
            $data['sgstrate'] = $this->input->post('sgstrate');
            $data['igstrate'] = $this->input->post('igstrate');
            $uniqueCodecheck = $this->Firm_model->unique_firm_code_check($this->input->post('uniqueCode'));
            if($uniqueCodecheck){
                $updateFirm = $this->Firm_model->update_firm($data);
                if($updateFirm){
                    $data['successMessage'] = "Successfully firm Updated.";
                }else{
                    $data['errorMessage'] = 'No change on current value or Something went wrong';
                }
            }else{
                $data['errorMessage'] = 'Firm Code must be unique. Please try again later';
            }
         }

        $business_type = $this->Firm_model->business_type_list();
        $data['business_types'] = $business_type['result'];
        $firm_result = $this->Firm_model->update_firm_detail($firmcode);
        $data['data'] = $firm_result['result'];
        $this->template->set('buttonName', 'Firm List');
        $this->template->set('buttonLink', base_url('/firmdetails'));
        $this->template->set('title', 'Update Firm');
        $this->template->load('default_layout', 'contents' , 'firm/updatefirm', $data);
    }

    public function deleteFirm(){
        if($this->session->userdata('role') != "superadmin"){
            redirect('/login');
        }
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['firmCode'] = $this->input->post('firmCode');
            $firm_delete_result = $this->Firm_model->delete_firm($data);
            if($firm_delete_result['code']){
                $data['code'] = $firm_delete_result['code'];
                $data['firmCode'] = $firm_delete_result['firmCode'];
                $data["message"] = "Successfully firm deleted!";
            }else{
                $data['code'] = $firm_delete_result['code'];
                $data['firmCode'] = $firm_delete_result['firmCode'];
                $data["message"] = "Unable to delete this firm. Please try again!";
            }
        }else{
            $data['code'] = false;
            $data['firmCode'] = $this->input->post('firmCode');
            $data["message"] = "Unable to serve delete Request, Please try again!";
        }
        echo json_encode($data);
    }

    public function firmstore()
    {
        if($this->session->userdata('role') != "superadmin"){
            redirect('/login');
        }
        $this->load->helper('url');
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->library('zip');
        $this->load->dbutil();
        $db_format=array('format'=>'zip','filename'=>'my_db_backup.sql');
        $backup=& $this->dbutil->backup($db_format);
        $dbname='backup-on-'.date('Y-m-d').'.zip';
        $save=$dbname;
        write_file($save,$backup);
        force_download($dbname,$backup);
    }
}
