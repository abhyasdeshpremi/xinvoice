<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item extends CI_Controller {

    function __construct() {
        parent::__construct();
        if($this->session->userdata('isUserLoggedIn') != TRUE){ 
            redirect('/login');
        }
        $this->load->model('Item_model', '', TRUE);
    }
    
    public function createItem(){
        $data = array();
        $company_result = $this->Item_model->company_list();
        $data['companiesList'] = $company_result['result'];
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $data['method'] = "GET";
         } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['method'] = "POST";
            $data['uniqueItemCode'] = $this->input->post('uniqueItemCode');
            $data['itemName'] = $this->input->post('itemName');
            $data['itemsubdescription'] = $this->input->post('itemsubdescription');
            $data['weightinlitter'] = $this->input->post('weightinlitter');
            $data['itemunitcase'] = $this->input->post('itemunitcase');
            $data['itemmrp'] = $this->input->post('itemmrp');
            $data['itemcostprice'] = $this->input->post('itemcostprice');
            $data['itemopbalanceinquantity'] = $this->input->post('itemopbalanceinquantity');
            $data['itemCompanyCode'] = $this->input->post('itemCompanyCode');
            $uniqueCodeVerify = $this->Item_model->unique_item_code_verify($this->input->post('uniqueItemCode'));
            if($uniqueCodeVerify){
                $createItem = $this->Item_model->create_item($data);
                if($createItem ){
                    $data['uniqueItemCode'] = '';
                    $data['itemName'] = '';
                    $data['itemsubdescription'] = '';
                    $data['weightinlitter'] = '';
                    $data['itemunitcase'] = '';
                    $data['itemmrp'] = '';
                    $data['itemcostprice'] = '';
                    $data['itemopbalanceinquantity'] = '';
                    $data['itemCompanyCode'] = '';
                    $data['successMessage'] = "Successfully Item Created.";
                }else{
                    $data['errorMessage'] = 'Unable to save firm information. Please contact your Administrator.';
                }
            }else{
                $data['errorMessage'] = 'Unique Code must be unique.';
            }
         }
        $this->template->set('title', 'Create Item');
        $this->template->load('default_layout', 'contents' , 'item/createitem', $data);
    }

    public function itemdetails(){
        $data = array();
        $firm_result = $this->Item_model->item_list();
        $data['data'] = $firm_result['result'];
        $this->template->set('title', 'Items List');
        $this->template->load('default_layout', 'contents' , 'item/itemdetail', $data);
    }


}