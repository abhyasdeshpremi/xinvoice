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

    public function updateClient($client_id = null){
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
            $uniqueCodeCheck = $this->Client_model->unique_client_code_check($this->input->post('uniqueCode'));
            if($uniqueCodeCheck){
                $saveClient = $this->Client_model->update_client($data);
                if($saveClient ){
                    $data['successMessage'] = "Successfully Client Updated.";
                }else{
                    $data['errorMessage'] = 'No change on current value or Something went wrong';
                }
            }else{
                $data['errorMessage'] = 'Unique Code must be unique. Please try again later';
            }
        }

        $client_result = $this->Client_model->update_client_detail($client_id);
        $data['data'] = $client_result['result'];
        $this->template->set('title', 'Client Update');
        $this->template->load('default_layout', 'contents' , 'client/updateclient', $data);
    }

    public function deleteClient(){
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['client_code'] = $this->input->post('client_code');
            $client_delete_result = $this->Client_model->delete_client($data);
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

}
