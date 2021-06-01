<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends CI_Controller {

    function __construct() {
        parent::__construct();
        if($this->session->userdata('isUserLoggedIn') != TRUE){ 
            redirect('/login');
        }
        $this->load->model('Stock_model', '', TRUE);
        $this->load->model('Invoice_model', '', TRUE);
    }
    
    public function getStock(){
        $data = array();
        $firm_result = $this->Stock_model->stock_list();
        $data['itemsList'] = $this->Invoice_model->items_list();
        $data['data'] = $firm_result['result'];
        $this->template->set('title', 'Stock List');
        $this->template->load('default_layout', 'contents' , 'stock/stockdetail', $data);
    }

    public function saveStock(){
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['item_code'] = $this->input->post('item_code');
            $data['item_name'] = $this->input->post('item_name');
            $data['stocktype'] = $this->input->post('stocktype');
            $data['stockunit'] = $this->input->post('stockunit');
            $data['stockcomment'] = $this->input->post('stockcomment');
            $data["message"] = "";
            $invoice_item_save_result = $this->Stock_model->saveStock($data);
            if($invoice_item_save_result['code']){
                $data['code'] = $invoice_item_save_result['code'];
                $data['stockid'] = $invoice_item_save_result['stockid'];
                $data["message"] = "Successfully stock added!";
            }else{
                $data['code'] = $invoice_item_save_result['code'];
                $data['stockid'] = $invoice_item_save_result['stockid'];
                $data["message"] = "Unable to save Stock item, may be wrong Stock item OR Input stock grater than available stock. Please try again!";
            }
        }else{
            $data['code'] = false;
            $data["message"] = "Unable to serve GET Request, Please try again!";
        }
        echo json_encode($data);
    }

}