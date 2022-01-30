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
        $this->load->library("pagination");
    }
    
    public function getStock(){
        $data = array();

        $config = array();
        $config["base_url"] = base_url("getstock");
        $config["total_rows"] = $this->Stock_model->get_count();
        $config["per_page"] = PAGE_PER_ITEM;
        $config["uri_segment"] = 2;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["links"] = $this->pagination->create_links();

        $firm_result = $this->Stock_model->stock_list($config["per_page"], $page);
        $data['itemsList'] = $this->Invoice_model->items_list();
        $data['data'] = $firm_result['result'];
        $data['page'] = $page;
        $this->template->set('buttonName', 'Stock Log List');
        $this->template->set('buttonLink', base_url('/getstocklog'));
        $this->template->set('title', 'Stock List');
        $this->template->load('default_layout', 'contents' , 'stock/stockdetail', $data);
    }

    public function getstocklog(){
        $data = array();

        $config = array();
        $config["base_url"] = base_url("getstocklog");
        $config["total_rows"] = $this->Stock_model->get_log_count();
        $config["per_page"] = PAGE_PER_ITEM;
        $config["uri_segment"] = 2;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["links"] = $this->pagination->create_links();

        $stock_log_result = $this->Stock_model->stock_log_list($config["per_page"], $page);
        $data['data'] = $stock_log_result['result'];
        $data['page'] = $page;
        $this->template->set('buttonName', 'Stock List');
        $this->template->set('buttonLink', base_url('/getstock'));
        $this->template->set('title', 'Stock Log List');
        $this->template->load('default_layout', 'contents' , 'stock/stocklogdetail', $data);
    }

    public function getItemStocklog(){
        $data = array();
        $itemCode = $this->uri->segment(2);
        $config = array();
        $config["base_url"] = base_url("getitemstocklog/".$itemCode);
        $config["total_rows"] = $this->Stock_model->get_log_count($itemCode);
        $config["per_page"] = PAGE_PER_ITEM;
        $config["uri_segment"] = 3;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["links"] = $this->pagination->create_links();

        $stock_log_result = $this->Stock_model->stock_log_list($config["per_page"], $page, $itemCode);
        $data['data'] = $stock_log_result['result'];
        $data['page'] = $page;
        $this->template->set('buttonName', 'Stock List');
        $this->template->set('buttonLink', base_url('/getstock'));
        $this->template->set('title', 'Stock ('.$itemCode.') Log List');
        $this->template->load('default_layout', 'contents' , 'stock/stocklogdetail', $data);
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