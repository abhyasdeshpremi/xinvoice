<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ledger extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Ledger_model', '', TRUE);
    }

	public function index()
	{
        echo "Hello";
	}

    public function getledger(){
        $data = array();

        $this->template->set('title', 'Ledger Report');
        $this->template->load('default_layout', 'contents' , 'ledger/ledgerreport', $data);
    }

    public function getstock(){
        $data = array();

        $this->template->set('title', 'Stock Report');
        $this->template->load('default_layout', 'contents' , 'ledger/stockreport', $data);
    }
    
    public function getsaleresister(){
        $data = array();

        $this->template->set('title', 'Sales Report');
        $this->template->load('default_layout', 'contents' , 'ledger/saleresisterreport', $data);
    }

    public function stockReport(){
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['start_date'] = $this->input->post('start_date');
            $data['end_date'] = $this->input->post('end_date');
            $data["message"] = "";
            $stock_result = $this->Ledger_model->stock_list();
            if($stock_result['code']){
                $data['code'] = $stock_result['code'];
                $data['data'] = $stock_result['result'];
                $data["message"] = "Successfully stock added!";
            }else{
                $data['code'] = $stock_result['code'];
                $data['data'] = [];
                $data["message"] = "Unable to save Stock item, may be wrong Stock item OR Input stock grater than available stock. Please try again!";
            }
        }else{
            $data['code'] = false;
            $data['data'] = [];
            $data["message"] = "Unable to serve GET Request, Please try again!";
        }
        echo json_encode($data);
    }

}
