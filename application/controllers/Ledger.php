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

}
