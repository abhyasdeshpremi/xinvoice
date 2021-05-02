<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends CI_Controller {

    function __construct() {
        parent::__construct();
        if($this->session->userdata('isUserLoggedIn') != TRUE){ 
            redirect('/login');
        }
        $this->load->model('Invoice_model', '', TRUE);
    }

    public function checkid(){
        echo "invoice check";
        echo "<br>";
        $invoiceString1 = "N1AyM1lNbW9TVFFFYU5wekJCRno1aThDZXNpampmN1hQUWxIZHJvRlk2OTMyNHJZdXRIQ0lRWHBRbThyYnRtQw==";
        $invoiceString  = "N2AyM1lNbW9TVFFFYU5wekJCRno1aThDZXNpampmN1hQUWxIZHJvRlk2OTMyNHJZdXRIQ0lRWHBRbThyYnRtQw==";
        echo "decrypt 1 ".encrypt_decrypt($invoiceString1, 'decrypt');
        echo "<br>";
        echo "decrypt 2 ".encrypt_decrypt($invoiceString, 'decrypt');
    }

    public function createinvoiceID(){
        $invoice = $this->Invoice_model->invoice_id();
        if(count($invoice) == 0){
           $invoiceNewID = invoiceIDCreation();
           $newInvoiceResult = $this->Invoice_model->invoiceInitial($invoiceNewID);
           if($newInvoiceResult){
                redirect('createinvoice/'.$invoiceNewID); 
           }else{
                $data['heading'] = "Unable to create New Invoice ID, Please try again";
                $data['message'] = "Unable to create New Invoice ID, Please try again";
                $this->template->set('title', 'Unable to create Invoice ID');
                $this->template->load('default_layout', 'contents' , 'errors/html/error_404', $data);
           }
        }else{
            redirect('createinvoice/'.$invoice[0]->unique_invioce_code); 
        }
    }
    
    public function createinvoice($id = null){
        $data = array();
        if(!validationInvoiceID($id)){
            $data['heading'] = "Invalid Invoice ID";
            $data['message'] = "Invalid Invoice ID";
            $this->template->set('title', 'Invalid Invoice ID');
            $this->template->load('default_layout', 'contents' , 'errors/html/error_404', $data);
            return false;
        }
        $data['clients'] = $this->Invoice_model->client_list();
        $data['invoiceTypes'] = $this->Invoice_model->invoiceRef_list();
        $data['invoiceitemsList'] = $this->Invoice_model->invoice_items_list($id);
        $data['itemsList'] = $this->Invoice_model->items_list();
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $data['method'] = "GET";
            $data['invoiceid'] = $id;
            $invoiceDetail = $this->Invoice_model->getinvoiceid($id);
            $data['invoicestatus'] = $invoiceDetail['invoicestatus'];
            $data['invoicetitle'] = $invoiceDetail['invoicetitle'];
            $data['invoicesubtitle'] = $invoiceDetail['subtitle'];
            $data['paymentmode'] = $invoiceDetail['payment_mode'];
            $data['vehicleno'] = $invoiceDetail['vehicle'];
            $data['invoicerefNumber'] = $invoiceDetail['invoice_reference_id'];

            $data['clientcode'] = $invoiceDetail['fk_client_code'];
            $data['clientname'] = $invoiceDetail['client_name'];
            $data['gstin'] = $invoiceDetail['gstnumber'];
            $data['pannumber'] = $invoiceDetail['pannumber'];
            $data['mobilenumber'] = $invoiceDetail['mobilenumber'];

            $data['clintaddress'] = $invoiceDetail['address'];
            $data['clientState'] = $invoiceDetail['state'];
            $data['clientDistrict'] = $invoiceDetail['district'];
            $data['clientcity'] = $invoiceDetail['city'];
            $data['clientarea'] = $invoiceDetail['area'];
            $data['clientpincode'] = $invoiceDetail['pincode'];
         } 
        $this->template->set('title', 'Create Invoice');
        $this->template->load('default_layout', 'contents' , 'invoice/createinvoice', $data);
    }

    public function saveItemInInvoice(){
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['itemID'] = $this->input->post('itemID');
            $data['invoiceID'] = $this->input->post('invoiceid');
            $data['itemcode'] = strtoupper($this->input->post('itemcode'));
            $data['itemname'] = strtoupper($this->input->post('itemname'));
            $data['quatity'] = $this->input->post('quatity');
            $data['itemmrp'] = $this->input->post('itemmrp');
            $data['itemdiscount'] = $this->input->post('itemdiscount');
            $data['itemdmrpvalue'] = $this->input->post('itemdmrpvalue');
            $data['itembillValue'] = $this->input->post('itembillValue');
            $data["message"] = "";
            $invoice_item_save_result = $this->Invoice_model->saveInvoiceItem($data);
            if($invoice_item_save_result['code']){
                $data['code'] = $invoice_item_save_result['code'];
                $data['itemID'] = $invoice_item_save_result['itemid'];
                $data["message"] = "Successfully invoice item saved! ";
            }else{
                $data['code'] = $invoice_item_save_result['code'];
                $data['itemID'] = $invoice_item_save_result['itemid'];
                $data["message"] = "Unable to save invoice item, may be wrong invoice id. Please try again!";
            }
        }else{
            $data['code'] = false;
            $data["message"] = "Unable to serve GET Request, Please try again!";
        }
        echo json_encode($data);
    }

    public function invoicedetails(){
        $data = array();
        $firm_result = $this->Invoice_model->company_list();
        $data['data'] = $firm_result['result'];
        $this->template->set('title', 'Invoices List');
        $this->template->load('default_layout', 'contents' , 'invoice/invoicedetail', $data);
    }

    public function getItemCode(){
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $item_result = $this->Invoice_model->items_list($this->input->post('itemcode'));
            echo json_encode($item_result);
        }
    }

    public function getinvoicelist(){
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $invoice_result = $this->Invoice_model->invoiceType_by_id($this->input->post('invoiceRefID'));
            echo json_encode($invoice_result);
        }else{
            $invoice_result = $this->Invoice_model->invoiceType_by_id();
            echo json_encode($invoice_result);
        }
    }

    public function saveInvoiceHeader(){
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['defaultinvoiceID'] = $this->input->post('defaultinvoiceID');
            $data['invoicetitle'] = strtoupper($this->input->post('invoicetitle'));
            $data['invoicesubtitle'] = strtoupper($this->input->post('invoicesubtitle'));
            $data['paymentmode'] = $this->input->post('paymentmode');
            $data['vehicleno'] = $this->input->post('vehicleno');
            $data['invoicerefNumber'] = $this->input->post('invoicerefNumber');
            $data['clientcode'] = $this->input->post('clientcode');
            $data['clientname'] = $this->input->post('clientname');
            $data['gstin'] = $this->input->post('gstin');
            $data['pannumber'] = $this->input->post('pannumber');
            $data['mobilenumber'] = $this->input->post('mobilenumber');
            $data['clintaddress'] = $this->input->post('clintaddress');
            $data['clientState'] = $this->input->post('clientState');
            $data['clientDistrict'] = $this->input->post('clientDistrict');
            $data['clientcity'] = $this->input->post('clientcity');
            $data['clientarea'] = $this->input->post('clientarea');
            $data['clientpincode'] = $this->input->post('clientpincode');
            $this->Invoice_model->saveInvoiceRef($data);
            $data["message"] = "Update data start";
            $invoice_save_result = $this->Invoice_model->updateInvoice($data);
            if($invoice_save_result){
                $data["message"] = "Successfully invoice saved! ";
            }else{
                $data["message"] = "Unable to save invoice, may be wrong invoice id. Please try again!";
            }
        }else{
            $data["message"] = "Unable to serve GET Request, Please try again!";
        }
        echo json_encode($data);
    }
}