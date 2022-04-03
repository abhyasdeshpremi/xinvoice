<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ledger extends CI_Controller {

    function __construct() {
        parent::__construct();
        if($this->session->userdata('isUserLoggedIn') != TRUE){ 
            redirect('/login');
        }
        if(access_lavel(3, $this->session->userdata('role'))){
            redirect('/login');
        }
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
                $data['stocksearch'] = urldecode($this->input->post('stocksearch'));
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
            $data['start_date'] = $this->uri->segment(2);
            $data['end_date'] = $this->uri->segment(3);
            $data['stocksearch'] = urldecode($this->uri->segment(4));
            $stock_result = $this->Ledger_model->stock_list($data);
            if($stock_result['code']){
                $data['code'] = $stock_result['code'];
                $data['result'] = $stock_result['result'];
                $data["message"] = "Successfully get stock!";
                $data['title'] = $this->session->userdata('firmname');
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
                $data['salesearch'] = urldecode($this->input->post('salesearch'));
                $data["message"] = "";
                $client_result = $this->Ledger_model->client_list($data);
                if($client_result['code']){
                    $data['code'] = $client_result['code'];
                    $data['result'] = $client_result['result'];
                    $data["message"] = "Successfully get Ledger report!";
                }else{
                    $data['code'] = $client_result['code'];
                    $data['result'] = [];
                    $data["message"] = "No Ledger report according to search string";
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
            $data['start_date'] = $this->uri->segment(2);
            $data['end_date'] = $this->uri->segment(3);
            $data['ledgerearch'] = urldecode($this->uri->segment(4));
            $client_result = $this->Ledger_model->sale_list($data);
            if($client_result['code']){
                $data['code'] = $client_result['code'];
                $data['result'] = $client_result['result'];
                $data["message"] = "Successfully get client!";
                $data['title'] = $this->session->userdata('firmname');
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
                $data['ledgerearch'] = urldecode($this->input->post('ledgerearch'));
                $data["message"] = "";
                $client_result = $this->Ledger_model->sale_list($data);
                if($client_result['code']){
                    $data['code'] = $client_result['code'];
                    $data['result'] = $client_result['result'];
                    $data["message"] = "Successfully get sale!";
                }else{
                    $data['code'] = $client_result['code'];
                    $data['result'] = [];
                    $data["message"] = "Unable to fetch sale. Please try again!";
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
            $data['start_date'] = $this->uri->segment(2);
            $data['end_date'] = $this->uri->segment(3);
            $data['salesearch'] = urldecode($this->uri->segment(4));
            $client_result = $this->Ledger_model->client_list($data);
            if($client_result['code']){
                $data['code'] = $client_result['code'];
                $data['result'] = $client_result['result'];
                $data["message"] = "Successfully get stock!";
                $data['title'] = $this->session->userdata('firmname');
                // $this->template->load('default_layout', 'contents' , 'ledger/ledgerreportpdf', $data);
                $this->load->library('pdf');
                $html = $this->load->view('ledger/saleresisterreportpdf', $data, true);
                $this->pdf->createPDF($html, "Sale Report ".$data['start_date']."_".$data['end_date'] , true, 'A4', "portrait");
            }
        }
    }


    /**
     * For ledger invoice report
     */

    public function getInvoice(){
        $data = array();

        $this->template->set('title', 'Invoice Report');
        $this->template->load('default_layout', 'contents' , 'ledger/invoicereport', $data);
    }

    public function invoiceReport(){
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
                $client_result = $this->Ledger_model->invoice_list($data);
                if($client_result['code']){
                    $data['code'] = $client_result['code'];
                    $data['result'] = $client_result['result'];
                    $data["message"] = "Successfully get Invoice report!";
                }else{
                    $data['code'] = $client_result['code'];
                    $data['result'] = [];
                    $data["message"] = "No Invoice report according to search string";
                }
            }else{
                $data['code'] = false;
                $data['result'] = [];
                $data["message"] = "Unable to serve GET Request, Please try again!";
            }
        }
        echo json_encode($data);
    }

    function getInvoicePDF(){
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $data['start_date'] = $this->uri->segment(2);;
            $data['end_date'] = $this->uri->segment(3);;
            $client_result = $this->Ledger_model->invoice_list($data);
            if($client_result['code']){
                $data['code'] = $client_result['code'];
                $data['result'] = $client_result['result'];
                $data["message"] = "Successfully get Invoice!";
                $data['title'] = $this->session->userdata('firmname');
                // $this->template->load('default_layout', 'contents' , 'ledger/ledgerreportpdf', $data);
                $this->load->library('pdf');
                $html = $this->load->view('ledger/ledgerreportpdf', $data, true);
                $this->pdf->createPDF($html, "Ledger Report ".$data['start_date']."_".$data['end_date'] , true, 'A4', "portrait");
            }
        }
    }

    /**
     * For Vendor Eared report
     */
    public function earnedVendor(){
        $data = array();

        $this->template->set('title', 'Vendor Earned Report');
        $this->template->load('default_layout', 'contents' , 'ledger/earnedvendorreport', $data);
    }

    public function earnedvendorReport(){
        $data = array();
        if($this->session->userdata('isUserLoggedIn') != TRUE){ 
            $data['code'] = false;
            $data['result'] = [];
            $data["message"] = "Unable to serve because your session is expire!";
        }else{
            if ($this->input->server('REQUEST_METHOD') === 'POST') {
                $data['start_date'] = $this->input->post('start_date');
                $data['end_date'] = $this->input->post('end_date');
                $data['stocksearch'] = urldecode($this->input->post('stocksearch'));
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

    function getearnedvendorPDF(){
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $data['start_date'] = $this->uri->segment(2);
            $data['end_date'] = $this->uri->segment(3);
            $data['stocksearch'] = urldecode($this->uri->segment(4));
            $stock_result = $this->Ledger_model->stock_list($data);
            if($stock_result['code']){
                $data['code'] = $stock_result['code'];
                $data['result'] = $stock_result['result'];
                $data["message"] = "Successfully get stock!";
                $data['title'] = $this->session->userdata('firmname');
                // $this->template->load('default_layout', 'contents' , 'ledger/stockreportpdf', $data);
                $this->load->library('pdf');
                $html = $this->load->view('ledger/stockreportpdf', $data, true);
                $this->pdf->createPDF($html, "Stock Report".$data['start_date']."_".$data['end_date'] , true, 'A4', "portrait");
            }
        }
    }

}
