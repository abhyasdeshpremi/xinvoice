<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client extends CI_Controller {

    function __construct() {
        parent::__construct();
        if($this->session->userdata('isUserLoggedIn') != TRUE){ 
            redirect('/login');
        }
        $this->load->model('Client_model', '', TRUE);
    }
    

	public function index()
	{
        $queryResult = $this->Client_model->primary_firm();
		$data = array();
        $data['data'] = $queryResult['result'];
        $this->template->set('title', 'Client');
        $this->template->load('default_layout', 'contents' , 'firm/firm', $data);
	}

    public function createClient(){
        $data = array();
        $data['roleTypes'] = $this->Client_model->get_enum_values();
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $data['method'] = "GET";
         } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['method'] = "POST";
            $data['uniqueCode'] = $this->input->post('uniqueCode');
            $data['clientName'] = $this->input->post('clientName');
            $data['clienttype'] = $this->input->post('clienttype');
            $data['clientMobile'] = $this->input->post('clientMobile');
            $data['clientgst'] = $this->input->post('clientgst');
            $data['clientPan'] = $this->input->post('clientPan');
            $data['clientaadhar'] = $this->input->post('clientaadhar');
            $data['clientfssai'] = $this->input->post('clientfssai');
            $data['clientAddress'] = $this->input->post('clientAddress');
            $data['clientArea'] = $this->input->post('clientArea');
            $data['clientCity'] = $this->input->post('clientCity');
            $data['clientdistrict'] = $this->input->post('clientdistrict');
            $data['clientState'] = $this->input->post('clientState');
            $data['clientZip'] = $this->input->post('clientZip');
            $uniqueCodeVerify = $this->Client_model->unique_client_code_verify($this->input->post('uniqueCode'));
            if($uniqueCodeVerify){
                $createClient = $this->Client_model->create_client($data);
                if($createClient ){
                    unset($data);
                    $data['successMessage'] = "Successfully Client Created.";
                }else{
                    $data['errorMessage'] = 'Unable to save Client information. Please contact your Administrator.';
                }
            }else{
                $data['errorMessage'] = 'Unique Code must be unique.';
            }
         }
        $this->template->set('title', 'Create Client');
        $this->template->load('default_layout', 'contents' , 'client/createclient', $data);
    }

    public function clientdetails(){
        $data = array();
        $firm_result = $this->Client_model->client_list();
        $data['data'] = $firm_result['result'];
        $this->template->set('title', 'Clients List');
        $this->template->load('default_layout', 'contents' , 'client/clientdetail', $data);
    }

    public function getclientID(){
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $client_result = $this->Client_model->client_by_id($this->input->post('uniqueCode'));
            echo json_encode($client_result);
        }else{
            echo json_encode(array());
        }
    }
}
