<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item extends CI_Controller {

    function __construct() {
        parent::__construct();
        if($this->session->userdata('isUserLoggedIn') != TRUE){ 
            redirect('/login');
        }
        $this->load->model('Item_model', '', TRUE);
        $this->load->library("pagination");
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
        $this->template->set('buttonName', 'Items List');
        $this->template->set('buttonLink', base_url('/itemdetails'));
        $this->template->set('title', 'Create Item');
        $this->template->load('default_layout', 'contents' , 'item/createitem', $data);
    }

    public function itemdetails(){
        $data = array();

        $config = array();
        $config["base_url"] = base_url("itemdetails");
        $config["total_rows"] = $this->Item_model->get_count();
        $config["per_page"] = PAGE_PER_ITEM;
        $config["uri_segment"] = 2;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["links"] = $this->pagination->create_links();

        $firm_result = $this->Item_model->item_list($config["per_page"], $page);
        $data['data'] = $firm_result['result'];
        $this->template->set('buttonName', 'New Item');
        $this->template->set('buttonLink', base_url('/createitem'));
        $this->template->set('title', 'Items List');
        $this->template->load('default_layout', 'contents' , 'item/itemdetail', $data);
    }

    public function updateItem($item_id = null){
        $data = array();
        $company_result = $this->Item_model->company_list();
        $data['companiesList'] = $company_result['result'];

        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $data['method'] = "GET";
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['method'] = "POST";
            $data['itemCode'] = $this->input->post('uniqueItemCode');
            $data['itemName'] = $this->input->post('itemName');
            $data['itemsubdescription'] = $this->input->post('itemsubdescription');
            $data['weightinlitter'] = $this->input->post('weightinlitter');
            $data['itemunitcase'] = $this->input->post('itemunitcase');
            $data['itemmrp'] = $this->input->post('itemmrp');
            $data['itemcostprice'] = $this->input->post('itemcostprice');
            $data['itemopbalanceinquantity'] = $this->input->post('itemopbalanceinquantity');
            $data['itemCompanyCode'] = $this->input->post('itemCompanyCode');
            $uniqueCodeVerify = $this->Item_model->unique_item_code_check($this->input->post('uniqueItemCode'));
            if($uniqueCodeVerify){
                $createItem = $this->Item_model->update_item($data);
                if($createItem ){
                    $data['successMessage'] = "Successfully Item Updated.";
                }else{
                    $data['errorMessage'] = 'No change on current value or Something went wrong';
                }
            }else{
                $data['errorMessage'] = 'Unique Code must be unique. Please try again later';
            }
         }

        $item_result = $this->Item_model->update_item_detail($item_id);
        $data['data'] = $item_result['result'];
        $this->template->set('buttonName', 'Items List');
        $this->template->set('buttonLink', base_url('/itemdetails'));
        $this->template->set('title', 'Items Update');
        $this->template->load('default_layout', 'contents' , 'item/updateitem', $data);
    }

    public function deleteItem(){
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['item_code'] = $this->input->post('item_code');
            $item_delete_result = $this->Item_model->delete_item($data);
            if($item_delete_result['code']){
                $data['code'] = $item_delete_result['code'];
                $data['itemid'] = $item_delete_result['itemid'];
                $data["message"] = "Successfully item deleted!";
            }else{
                $data['code'] = $item_delete_result['code'];
                $data['itemid'] = $item_delete_result['itemid'];
                $data["message"] = "Unable to delete this item. Please try again!";
            }
        }else{
            $data['code'] = false;
            $data['itemid'] = $this->input->post('item_code');
            $data["message"] = "Unable to serve delete Request, Please try again!";
        }
        echo json_encode($data);
    }

}