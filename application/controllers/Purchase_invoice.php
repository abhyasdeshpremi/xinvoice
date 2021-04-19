<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_invoice extends CI_Controller {

    function __construct() {
        parent::__construct();
        if($this->session->userdata('isUserLoggedIn') != TRUE){ 
            redirect('/login');
        }
        $this->load->model('PurchaseInvoice_model', '', TRUE);
    }

    public function purchaseInvoice(){
        $data = array();
        $this->template->set('title', 'Purchase Invoice');
        $this->template->load('default_layout', 'contents' , 'invoice/purchaseinvoice', $data);
    }
}