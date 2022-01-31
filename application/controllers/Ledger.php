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

    /**
     * For Stock report
     */
    public function getstock(){
        $data = array();

        $this->template->set('title', 'Stock Report');
        $this->template->load('default_layout', 'contents' , 'ledger/stockreport', $data);
    }

    public function stockReport(){
        $data = array();
        if($this->session->userdata('isUserLoggedIn') != TRUE){ 
            $data['code'] = false;
            $data['result'] = [];
            $data["message"] = "Unable to serve because your session is expire!";
        }else{
            if ($this->input->server('REQUEST_METHOD') === 'POST') {
                $data['start_date'] = $this->input->post('start_date');
                $data['end_date'] = $this->input->post('end_date');
                $data["message"] = "";
                $stock_result = $this->Ledger_model->stock_list($data);
                if($stock_result['code']){
                    $data['code'] = $stock_result['code'];
                    $data['result'] = $stock_result['result'];
                    $data["message"] = "Successfully get stock!";
                }else{
                    $data['code'] = $stock_result['code'];
                    $data['result'] = [];
                    $data["message"] = "Unable to fetch Stock. Please try again!";
                }
            }else{
                $data['code'] = false;
                $data['result'] = [];
                $data["message"] = "Unable to serve GET Request, Please try again!";
            }
        }
        echo json_encode($data);
    }

    function getPDF(){
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $data['start_date'] = $this->uri->segment(2);;
            $data['end_date'] = $this->uri->segment(3);;
            $stock_result = $this->Ledger_model->stock_list($data);
            if($stock_result['code']){
                $data['code'] = $stock_result['code'];
                $data['result'] = $stock_result['result'];
                $data["message"] = "Successfully get stock!";
                $data['title'] = "Saytem Enterprice";
                // $this->template->load('default_layout', 'contents' , 'ledger/stockreportpdf', $data);
                $this->load->library('pdf');
                $html = $this->load->view('ledger/stockreportpdf', $data, true);
                $this->pdf->createPDF($html, "Stock Report".$data['start_date']."_".$data['end_date'] , true, 'A4', "portrait");
            }
        }
    }

    /**
     * For ledger report
     */

    public function getClient(){
        $data = array();

        $this->template->set('title', 'Ledger Report');
        $this->template->load('default_layout', 'contents' , 'ledger/ledgerreport', $data);
    }

    public function clientReport(){
        $data = array();
        if($this->session->userdata('isUserLoggedIn') != TRUE){ 
            $data['code'] = false;
            $data['result'] = [];
            $data["message"] = "Unable to serve because your session is expire!";
        }else{
            if ($this->input->server('REQUEST_METHOD') === 'POST') {
                $data['start_date'] = $this->input->post('start_date');
                $data['end_date'] = $this->input->post('end_date');
                $data["message"] = "";
                $client_result = $this->Ledger_model->client_list($data);
                if($client_result['code']){
                    $data['code'] = $client_result['code'];
                    $data['result'] = $client_result['result'];
                    $data["message"] = "Successfully get sale report!";
                }else{
                    $data['code'] = $client_result['code'];
                    $data['result'] = [];
                    $data["message"] = "No sale report according to search string";
                }
            }else{
                $data['code'] = false;
                $data['result'] = [];
                $data["message"] = "Unable to serve GET Request, Please try again!";
            }
        }
        echo json_encode($data);
    }

    function getClinetPDF(){
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $data['start_date'] = $this->uri->segment(2);;
            $data['end_date'] = $this->uri->segment(3);;
            $client_result = $this->Ledger_model->client_list($data);
            if($client_result['code']){
                $data['code'] = $client_result['code'];
                $data['result'] = $client_result['result'];
                $data["message"] = "Successfully get stock!";
                $data['title'] = "Saytem Enterprice";
                // $this->template->load('default_layout', 'contents' , 'ledger/ledgerreportpdf', $data);
                $this->load->library('pdf');
                $html = $this->load->view('ledger/ledgerreportpdf', $data, true);
                $this->pdf->createPDF($html, "Ledger Report ".$data['start_date']."_".$data['end_date'] , true, 'A4', "portrait");
            }
        }
    }

    /**
     * For Sale report
     */
    public function getsaleresister(){
        $data = array();

        $this->template->set('title', 'Sales Report');
        $this->template->load('default_layout', 'contents' , 'ledger/saleresisterreport', $data);
    }

    public function saleReport(){
        $data = array();
        if($this->session->userdata('isUserLoggedIn') != TRUE){ 
            $data['code'] = false;
            $data['result'] = [];
            $data["message"] = "Unable to serve because your session is expire!";
        }else{
            if ($this->input->server('REQUEST_METHOD') === 'POST') {
                $data['start_date'] = $this->input->post('start_date');
                $data['end_date'] = $this->input->post('end_date');
                $data["message"] = "";
                $client_result = $this->Ledger_model->sale_list($data);
                if($client_result['code']){
                    $data['code'] = $client_result['code'];
                    $data['result'] = $client_result['result'];
                    $data["message"] = "Successfully get stock!";
                }else{
                    $data['code'] = $client_result['code'];
                    $data['result'] = [];
                    $data["message"] = "Unable to fetch Stock. Please try again!";
                }
            }else{
                $data['code'] = false;
                $data['result'] = [];
                $data["message"] = "Unable to serve GET Request, Please try again!";
            }
        }
        echo json_encode($data);
    }

    function getSalePDF(){
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $data['start_date'] = $this->uri->segment(2);;
            $data['end_date'] = $this->uri->segment(3);;
            $client_result = $this->Ledger_model->sale_list($data);
            if($client_result['code']){
                $data['code'] = $client_result['code'];
                $data['result'] = $client_result['result'];
                $data["message"] = "Successfully get stock!";
                $data['title'] = "Saytem Enterprice";
                // $this->template->load('default_layout', 'contents' , 'ledger/ledgerreportpdf', $data);
                $this->load->library('pdf');
                $html = $this->load->view('ledger/saleresisterreportpdf', $data, true);
                $this->pdf->createPDF($html, "Sale Report ".$data['start_date']."_".$data['end_date'] , true, 'A4', "portrait");
            }
        }
    }
}
