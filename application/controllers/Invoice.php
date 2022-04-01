<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends CI_Controller {

    function __construct() {
        parent::__construct();
        if($this->session->userdata('isUserLoggedIn') != TRUE){ 
            redirect('/login');
        }
        $this->load->model('Invoice_model', '', TRUE);
        $this->load->model('Stock_model', '', TRUE);
        $this->load->model('Item_model', '', TRUE);
        $this->load->library("pagination");
    }

    public function checkid(){
        //$getinvoiceDetails = $this->Invoice_model->invoice_list(100, 0, 'sell');
        // print_r($getinvoiceDetails);
        /*foreach($getinvoiceDetails['result'] as $getinvoiceDetail){
            if(($getinvoiceDetail->status === "completed") || ($getinvoiceDetail->status === "partial_paid") || ($getinvoiceDetail->status === "paid")) {
                $amountdata = array();
                print($getinvoiceDetail->pk_invoice_id);
                print($getinvoiceDetail->invoice_type);
                print($getinvoiceDetail->status);
                print($getinvoiceDetail->created_at);
                print($getinvoiceDetail->unique_invioce_code);
                echo date("d-m-Y", strtotime($getinvoiceDetail->created_at));
                echo "<br>";
                $amountdata['payment_date'] = date("d-m-Y", strtotime($getinvoiceDetail->created_at));
                $amountdata['invoice_type'] = $getinvoiceDetail->invoice_type;
                $amountdata['fk_client_code'] = $getinvoiceDetail->fk_client_code;
                $amountdata['fk_client_name'] = $getinvoiceDetail->client_name;
                $amountdata['unique_invioce_code'] = $getinvoiceDetail->unique_invioce_code;
                $amountdata['previous_invoice_ref_no'] = $getinvoiceDetail->previous_invoice_ref_no;
                
                //Bonus deposit to piggy bank for every vendor
                $bonus_percent = floatval($this->session->userdata('bonus_percent'));
                if(($bonus_percent > 0) && ($amountdata['invoice_type'] === "sell")){
                    log_message("info", "bonus percentage " . $bonus_percent);
                    $clientInfo = $this->Client_model->client_by_id($amountdata['fk_client_code']);
                    $clientType = $clientInfo['client_type'];
                    if($clientType === "vendor"){
                        $this->db->select_sum('mrp_value');
                        $this->db->from('invoice_item');
                        $this->db->where('delete_flag', 'NO');
                        $this->db->where('fk_unique_invioce_code', $amountdata['unique_invioce_code']);
                        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
                        $mrpvaluequery = $this->db->get();
                        $total_mrp_value = $mrpvaluequery->row()->mrp_value;
                        $total_mrp_value = round($total_mrp_value);

                        $percentage_value = round(($total_mrp_value * $bonus_percent) / 100);
                        if($percentage_value > 0){
                            $bonusamountdata = array();
                            $bonusamountdata['uniqueCode'] = $amountdata['fk_client_code'];
                            $bonusamountdata['clientName'] = $amountdata['fk_client_name'];
                            $bonusamountdata['clientMobile'] = $clientInfo['mobile_no'];
                            $bonusamountdata['accontemail'] = '';
                            $bonusamountdata['clientAddress'] = $clientInfo['address'] ." ".$clientInfo['area'];

                            $bonusDataUpdateToPiggybank = array();
                            $bonusDataUpdateToPiggybank['fk_client_code'] = $amountdata['fk_client_code'];
                            $bonusDataUpdateToPiggybank['fk_client_name'] = $amountdata['fk_client_name'];
                            $bonusDataUpdateToPiggybank['paymenttype'] = 'credit';
                            $bonusDataUpdateToPiggybank['amount'] = $percentage_value;

                            $bonusDataUpdateToPiggybank['payment_date'] = $amountdata['payment_date'];

                            $bonusDataUpdateToPiggybank['payment_mode'] = 'auto';
                             
                            $bonusDataUpdateToPiggybank['notes'] = 'auto '.$bonusDataUpdateToPiggybank['paymenttype'].' #('.$amountdata['previous_invoice_ref_no'].') bonus';
                            $unique_client_code_verify = $this->Piggybank_model->unique_account_holder_code_check($amountdata['fk_client_code']);
                            if($unique_client_code_verify){
                                $this->Piggybank_model->saveAccount($bonusDataUpdateToPiggybank);
                            }else{
                                $this->Piggybank_model->create_account_holder($bonusamountdata);
                                $this->Piggybank_model->saveAccount($bonusDataUpdateToPiggybank);
                            }

                        }
                    }
                }
            }
             
        }*/
        /*
        echo "invoice check";
        echo "<br>";
        $invoiceString1 = "N1AyM1lNbW9TVFFFYU5wekJCRno1aThDZXNpampmN1hQUWxIZHJvRlk2OTMyNHJZdXRIQ0lRWHBRbThyYnRtQw==";
        $invoiceString  = "N2AyM1lNbW9TVFFFYU5wekJCRno1aThDZXNpampmN1hQUWxIZHJvRlk2OTMyNHJZdXRIQ0lRWHBRbThyYnRtQw==";
        echo "decrypt 1 ".encrypt_decrypt($invoiceString1, 'decrypt');
        echo "<br>";
        echo "decrypt 2 ".encrypt_decrypt($invoiceString, 'decrypt');
        */
    }

    public function createinvoiceID(){
        if(access_lavel(3, $this->session->userdata('role'))){
            redirect('/login');
        }
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
        if(access_lavel(3, $this->session->userdata('role'))){
            redirect('/login');
        }
        $data = array();
        if(!validationInvoiceID($id)){
            $data['heading'] = "Invalid Invoice ID";
            $data['message'] = "Invalid Invoice ID";
            $this->template->set('title', 'Invalid Invoice ID');
            $this->template->load('default_layout', 'contents' , 'errors/html/error_404', $data);
            return false;
        }
        $data['clients'] = $this->Invoice_model->client_list_except_supllier();
        $data['invoiceTypes'] = $this->Invoice_model->invoiceRef_list();
        $data['invoiceitemsList'] = $this->Invoice_model->invoice_items_list($id);
        $data['itemsList'] = $this->Invoice_model->items_list();
        $data['itemsGroupList'] = $this->Invoice_model->items_Group_list();
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $data['method'] = "GET";
            $data['invoiceid'] = $id;
            $invoiceDetail = $this->Invoice_model->getinvoiceid($id);
            $data['pk_invoice_id'] = $invoiceDetail['pk_invoice_id'];
            $data['invoicestatus'] = $invoiceDetail['invoicestatus'];
            $data['invoicetitle'] = $invoiceDetail['invoicetitle'];
            $data['invoicesubtitle'] = $invoiceDetail['subtitle'];
            $data['paymentmode'] = $invoiceDetail['payment_mode'];
            $data['vehicleno'] = $invoiceDetail['vehicle'];
            $data['owninvoicegstin'] = $invoiceDetail['invoicegstin'];
            $data['owninvoicemobileno'] = $invoiceDetail['invoicemobileno'];
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
        $this->template->set('buttonName', 'Sell Invoices List');
        $this->template->set('buttonLink', base_url('/invoicedetail'));
        $this->template->set('title', 'Create Sell Invoice');
        $this->template->load('default_layout', 'contents' , 'invoice/createinvoice', $data);
    }

    public function createInvoicePDF($id = null, $mode = "landscape", $download = false, $paper_size = "A4"){
        if(access_lavel(3, $this->session->userdata('role'))){
            redirect('/login');
        }
        $data = array();
        if(!validationInvoiceID($id)){
            $data['heading'] = "Invalid Invoice ID";
            $data['message'] = "Invalid Invoice ID";
            $this->template->set('title', 'Invalid Invoice ID');
            $this->template->load('default_layout', 'contents' , 'errors/html/error_404', $data);
            return false;
        }
        if($mode === "landscape"){
            $mode = "landscape";
        }elseif($mode === "portrait"){
            $mode = "portrait";
        }else{
            $mode = "landscape";
        }
        $data['clients'] = $this->Invoice_model->client_list();
        $data['invoiceTypes'] = $this->Invoice_model->invoiceRef_list();
        $data['invoiceitemsList'] = $this->Invoice_model->invoice_items_list($id);
        $data['itemsList'] = $this->Invoice_model->items_list();
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $data['method'] = "GET";
            $data['invoiceid'] = $id;
            $invoiceDetail = $this->Invoice_model->getinvoiceid($id);
            $data['invoicepkid'] = $invoiceDetail['pk_invoice_id'];
            $data['invoicestatus'] = $invoiceDetail['invoicestatus'];
            $data['invoicetitle'] = $invoiceDetail['invoicetitle'];
            $data['invoicesubtitle'] = $invoiceDetail['subtitle'];
            $data['paymentmode'] = $invoiceDetail['payment_mode'];
            $data['vehicleno'] = $invoiceDetail['vehicle'];
            $data['owninvoicegstin'] = $invoiceDetail['invoicegstin'];
            $data['owninvoicemobileno'] = $invoiceDetail['invoicemobileno'];
            $data['invoicerefNumber'] = $invoiceDetail['invoice_reference_id'];
            $data['created_at'] = $invoiceDetail['created_at'];
            $data['mode'] = $mode;
            $data['paper_size'] = $paper_size;

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
            $data['bonus_percent'] = floatval($this->session->userdata('bonus_percent'));
        }
        // $this->template->set('title', 'Create Invoice PDF');
        // $this->template->load('default_layout', 'contents' , 'invoice/createinvoicepdf', $data);
        //landscape portrait
        $this->load->library('pdf');
        $html = $this->load->view('invoice/createinvoicepdf', $data, true);
        $this->pdf->createPDF($html, $invoiceDetail['invoicetitle']."".date('Y-m-d H:i:s'), $download, 'A4', $mode);

    }

    public function viewInvoicePDF($id = null, $mode = "landscape", $download = false, $paper_size = "A4"){
        if(access_lavel(3, $this->session->userdata('role'))){
            redirect('/login');
        }
        $data = array();
        if(!validationInvoiceID($id)){
            $data['heading'] = "Invalid Invoice ID";
            $data['message'] = "Invalid Invoice ID";
            $this->template->set('title', 'Invalid Invoice ID');
            $this->template->load('default_layout', 'contents' , 'errors/html/error_404', $data);
            return false;
        }
        if($mode === "landscape"){
            $mode = "landscape";
        }elseif($mode === "portrait"){
            $mode = "portrait";
        }else{
            $mode = "landscape";
        }
        $data['link'] = 'createinvoicepdf/'.$id.'/'.$mode.'/'.$download.'/'.$paper_size;
        $this->template->set('title', 'View Invoice PDF');
        $this->template->load('default_layout', 'contents' , 'invoice/pdfview', $data);
    }

    public function saveItemInInvoice(){
        if(access_lavel(3, $this->session->userdata('role'))){
            redirect('/login');
        }
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['itemID'] = $this->input->post('itemID');
            $data['invoiceID'] = $this->input->post('invoiceid');
            $data['itemcode'] = strtoupper($this->input->post('itemcode'));
            $data['itemname'] = strtoupper($this->input->post('itemname'));
            $data['quatity'] = $this->input->post('quatity');
            $data['itemunitcase'] = $this->input->post('itemunitcase');
            $data['itemmrp'] = $this->input->post('itemmrp');
            $data['itemdiscount'] = $this->input->post('itemdiscount');
            $data['itemdmrpvalue'] = $this->input->post('itemdmrpvalue');
            $data['itembillValue'] = $this->input->post('itembillValue');
            $data["message"] = "";
            $data["previewData"] = "";
            $invoice_item_save_result = $this->Invoice_model->saveInvoiceItem($data);
            if($invoice_item_save_result['code']){
                /***
                 * Sell:- Adjust item stock when sell item
                 */
                $data['item_code'] = $data['itemcode'];
                $data['item_name'] = $data['itemname'];
                $data['stocktype'] = "sell";
                $data['stockunit'] = $data['quatity'];
                $data['stockcomment'] = "Deducted items stock when invoice generated";
                $stock_item_save_result = $this->Stock_model->saveStock($data);
                
                $data['code'] = $invoice_item_save_result['code'];
                $data["message"] = "Successfully invoice item Updated! ";
                $data["previewData"] = array(
                                        "pk_invoice_item_id" => $invoice_item_save_result['itemid'], 
                                        "fk_unique_invioce_code" => $data['invoiceID'], 
                                        "fk_item_code" => $data['itemcode'], 
                                        "fk_item_name" => $data['itemname'], 
                                        "quantity" => $data['quatity'], 
                                        "case_unit" => $data['itemunitcase'], 
                                        "mrp" => $data['itemmrp'], 
                                        "mrp_value" => $data['itemdmrpvalue'], 
                                        "discount" => $data['itemdiscount'], 
                                        "bill_value" => $data['itembillValue'], 
                                        "updated_at" => date('Y-m-d H:i:s'), 
                                        "fk_firm_code" => $this->session->userdata('firmcode')
                                        );
            }else{
                $data['code'] = $invoice_item_save_result['code'];
                $data['itemID'] = $invoice_item_save_result['itemID'];
                $data["message"] = "Unable to update invoice item, may be wrong invoice id. Please try again!";
            }
        }else{
            $data['code'] = false;
            $data["message"] = "Unable to serve GET Request, Please try again!";
        }
        echo json_encode($data);
    }

    public function updateItemInInvoice(){
        if(access_lavel(3, $this->session->userdata('role'))){
            redirect('/login');
        }
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['itemID'] = $this->input->post('itemID');
            $data['invoiceID'] = $this->input->post('invoiceid');
            $data['itemcode'] = strtoupper($this->input->post('itemcode'));
            $data['itemname'] = strtoupper($this->input->post('itemname'));
            $data['quatity'] = $this->input->post('quatity');
            $data['itemunitcase'] = $this->input->post('itemunitcase');
            $data['itemmrp'] = $this->input->post('itemmrp');
            $data['itemdiscount'] = $this->input->post('itemdiscount');
            $data['itemdmrpvalue'] = $this->input->post('itemdmrpvalue');
            $data['itembillValue'] = $this->input->post('itembillValue');
            $data["message"] = "";
            $data["previewData"] = "";
            $invoice_item_save_result = $this->Invoice_model->saveInvoiceItem($data);
            if($invoice_item_save_result['code']){

                /***
                 * Buy:- Adjust item stock when delete from invoice item
                 */
                $oldQuantity = (int)$invoice_item_save_result['oldQuatity'];
                $newQuantity = (int)$data['quatity'];
                $isAction = false;
                $quantityChange = 0;
                $actionType = "";
                if ($oldQuantity < $newQuantity) {
                    $quantityChange = $newQuantity - $oldQuantity;
                    $actionType = "sell";
                    $isAction = true;
                }else if ($oldQuantity > $newQuantity){
                    $quantityChange = $oldQuantity - $newQuantity;
                    $actionType = "buy";
                    $isAction = true;
                }

                if ($isAction) {
                    $data['item_code'] = $invoice_item_save_result['itemcode'];
                    $data['item_name'] = $invoice_item_save_result['itemname'];
                    $data['stocktype'] = $actionType;
                    $data['stockunit'] = $quantityChange;
                    $data['stockcomment'] = "Deducted items stock when invoice generated";
                    $stock_item_save_result = $this->Stock_model->saveStock($data);
                }

                $data['code'] = $invoice_item_save_result['code'];
                $data['itemID'] = $invoice_item_save_result['itemid'];
                $data["message"] = "Successfully invoice item saved! ";
                $data["previewData"] = array(
                                        "pk_invoice_item_id" => $invoice_item_save_result['itemid'], 
                                        "fk_unique_invioce_code" => $data['invoiceID'], 
                                        "fk_item_code" => $data['itemcode'], 
                                        "fk_item_name" => $data['itemname'], 
                                        "quantity" => $data['quatity'], 
                                        "case_unit" => $data['itemunitcase'], 
                                        "mrp" => $data['itemmrp'], 
                                        "mrp_value" => $data['itemdmrpvalue'], 
                                        "discount" => $data['itemdiscount'], 
                                        "bill_value" => $data['itembillValue'], 
                                        "updated_at" => date('Y-m-d H:i:s'), 
                                        "fk_firm_code" => $this->session->userdata('firmcode')
                                        );
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
        if(access_lavel(3, $this->session->userdata('role'))){
            redirect('/login');
        }
        $data = array();
        $page_seg = 2;
        $search_seg = 3;
        $searchurl = '';
        if (!empty($this->uri->segment(2)) && !empty($this->uri->segment(3)) ) {
            $page_seg = 3;
            $search_seg = 2;
            $searchurl = "/";
        }else if (!empty($this->uri->segment(2)) && ($this->uri->segment(3) == 0) ) {
            if (!is_numeric($this->uri->segment(2))){
                $page_seg = 3;
                $search_seg = 2;
                $searchurl = "/";
            }
        }

        $globalsearchtext = ($this->uri->segment($search_seg)) ? $this->uri->segment($search_seg) : '';
        $data["base_url"] = base_url("invoicedetail");

        $config = array();
        $config["base_url"] = base_url("invoicedetail".$searchurl."".$globalsearchtext);
        $config["total_rows"] = $this->Invoice_model->get_count('sell', urldecode($globalsearchtext));
        $config["per_page"] = PAGE_PER_ITEM;
        $config["uri_segment"] = $page_seg;

        $this->pagination->initialize($config);
        $page = ($this->uri->segment($page_seg)) ? $this->uri->segment($page_seg) : 0;
        $data["links"] = $this->pagination->create_links();

        $firm_result = $this->Invoice_model->invoice_list($config["per_page"], $page, 'sell', urldecode($globalsearchtext));
        $data['page'] = (int)$page;
        $data['data'] = $firm_result['result'];
        
        $this->template->set('buttonName', 'New Sell Invoice');
        $this->template->set('buttonLink', base_url('/createinvoice'));
        $this->template->set('globalsearch', TRUE);
        $this->template->set('globalsearchtext', urldecode($globalsearchtext));
        $this->template->set('title', 'Sell Invoices List');
        $this->template->load('default_layout', 'contents' , 'invoice/invoicedetail', $data);
    }

    public function getItemCode(){
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $item_result = $this->Invoice_model->items_list($this->input->post('itemcode'));
            echo json_encode($item_result);
        }
    }

    public function getGroupItemCode(){
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $item_group_result = $this->Invoice_model->items_Group_list($this->input->post('groupitemcode'));
            echo json_encode($item_group_result);
        }
    }

    public function getinvoicelist(){
        if(access_lavel(3, $this->session->userdata('role'))){
            redirect('/login');
        }
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $invoice_result = $this->Invoice_model->invoiceType_by_id($this->input->post('invoiceRefID'));
            echo json_encode($invoice_result);
        }else{
            $invoice_result = $this->Invoice_model->invoiceType_by_id();
            echo json_encode($invoice_result);
        }
    }

    public function saveInvoiceHeader(){
        if(access_lavel(3, $this->session->userdata('role'))){
            redirect('/login');
        }
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['defaultinvoiceID'] = $this->input->post('defaultinvoiceID');
            $data['invoicetitle'] = strtoupper($this->input->post('invoicetitle'));
            $data['invoicesubtitle'] = strtoupper($this->input->post('invoicesubtitle'));
            $data['paymentmode'] = $this->input->post('paymentmode');
            $data['vehicleno'] = $this->input->post('vehicleno');
            $data['owninvoicegstin'] = $this->input->post('owninvoicegstin');
            $data['owninvoicemobileno'] = $this->input->post('owninvoicemobileno');
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
            if($this->input->post('saveinvoice') === 'saveinvoice'){
                $this->Invoice_model->saveInvoiceRef($data);
            }
            $data["message"] = "Update data start";
            $invoice_save_result = $this->Invoice_model->updateInvoice($data);
            if($invoice_save_result){
                $data["message"] = "Successfully invoice saved!";
            }else{
                $data["message"] = "Unable to save invoice, may be wrong invoice id. Please try again!";
            }
        }else{
            $data["message"] = "Unable to serve GET Request, Please try again!";
        }
        echo json_encode($data);
    }

    public function getStockQuantity(){
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['item_code'] = $this->input->post('item_code');
            $stock_item_result = $this->Invoice_model->getStockItem($data);
            if($stock_item_result){
                $data["code"] = $stock_item_result["code"];
                $data["quantity"] = $stock_item_result["quantity"];
                $data["message"] = "Stock is enough. Please continue";
            }else{
                $data["code"] = $stock_item_result["code"];
                $data["quantity"] = $stock_item_result["quantity"];
                $data["message"] = "Stock in less than your need. Please check available stock";
            }
        }
        echo json_encode($data);
    }

    public function deleteInvoiceItem(){
        if(access_lavel(3, $this->session->userdata('role'))){
            redirect('/login');
        }
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['itemInvoiceCode'] = $this->input->post('itemInvoiceCode');
            $invoice_item_delete_result = $this->Invoice_model->delete_invoice_item($data);
            if($invoice_item_delete_result['code']){
                /***
                 * Buy:- Adjust item stock when delete from invoice item
                 */
                $data['item_code'] = $invoice_item_delete_result['itemcode'];
                $data['item_name'] = $invoice_item_delete_result['itemname'];
                $data['stocktype'] = "buy";
                $data['stockunit'] = $invoice_item_delete_result['quatity'];
                $data['stockcomment'] = "Deducted items stock when invoice generated";
                $stock_item_save_result = $this->Stock_model->saveStock($data);

                $data['code'] = $invoice_item_delete_result['code'];
                $data['itemInvoiceCode'] = $invoice_item_delete_result['itemInvoiceCode'];
                $data["message"] = "Successfully invoice item deleted!";
            }else{
                $data['code'] = $invoice_item_delete_result['code'];
                $data['itemInvoiceCode'] = $invoice_item_delete_result['itemInvoiceCode'];
                $data["message"] = "Unable to delete this invoice item. Please try again!";
            }
        }else{
            $data['code'] = false;
            $data['itemInvoiceCode'] = $this->input->post('itemInvoiceCode');
            $data["message"] = "Unable to serve delete Request, Please try again!";
        }
        echo json_encode($data);
    }

    function updateInvoiceStatus(){
        if(access_lavel(3, $this->session->userdata('role'))){
            redirect('/login');
        }
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['invoiceid'] = $this->input->post('invoiceid');
            $data['statuscode'] = $this->input->post('invoiceStatus');
            $invoice_status_result = $this->Invoice_model->updateInvoiceStatus($data);
            if($invoice_status_result){
                $data["code"] = $invoice_status_result["code"];
                $data["message"] = "Invoice status updated.";
            }else{
                $data["code"] = $invoice_status_result["code"];
                $data["message"] = "Invoice status unable to update.";
            }
        }
        echo json_encode($data);
    }

    function updateInvoiceCreatedDate(){
        if(access_lavel(3, $this->session->userdata('role'))){
            redirect('/login');
        }
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['updateCreated_at'] = $this->input->post('updateCreated_at');
            $data['invoiceCode'] = $this->input->post('invoiceCode');
            $invoice_created_result = $this->Invoice_model->updateInvoiceCreatedDate($data);
            if($invoice_created_result){
                $data["code"] = $invoice_created_result["code"];
                $data["updated_at"] = $invoice_created_result["updated_at"];
                $data["message"] = "Created date updated.";
            }else{
                $data["code"] = $invoice_created_result["code"];
                $data["updated_at"] = $invoice_created_result["updated_at"];
                $data["message"] = "Created date unable to update.";
            }
        }
        echo json_encode($data);
    }

    public function saveGroupItemInInvoice(){
        if(access_lavel(3, $this->session->userdata('role'))){
            redirect('/login');
        }
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['invoiceID'] = $this->input->post('invoiceid');
            $data['selectgroupitemcode'] = strtoupper($this->input->post('selectgroupitemcode'));
            $data['quatity'] = $this->input->post('quatity');
            $getAllGroupItems = $this->Item_model->get_group_of_products_list($data["selectgroupitemcode"]);
            if(count($getAllGroupItems["result"]) > 0){
                $tmpdata = array();
                foreach($getAllGroupItems["result"] as $getAllGroupItem){
                    $tmpdata['itemID'] = '';
                    $tmpdata['invoiceID'] =  $data['invoiceID'];
                    $tmpdata['itemcode'] = strtoupper($getAllGroupItem->fk_item_code);
                    $tmpdata['itemname'] = strtoupper($getAllGroupItem->fk_item_name);
                    $tmpdata['quatity'] = $getAllGroupItem->quantity;
                    $tmpdata['groupquantity'] = $data['quatity'];
                    $tmpdata['itemunitcase'] = $getAllGroupItem->case_unit;
                    $tmpdata['itemmrp'] = $getAllGroupItem->mrp;
                    $tmpdata['itemdiscount'] = $getAllGroupItem->discount;
                    $tmpdata['itemdmrpvalue'] = $getAllGroupItem->mrp_value;
                    $tmpdata['itembillValue'] = $getAllGroupItem->bill_value;
                    $invoice_item_save_result = $this->Invoice_model->saveInvoiceGroupItem($tmpdata);
                    if($invoice_item_save_result['code']){
                        $tmpdata['item_code'] = $tmpdata['itemcode'];
                        $tmpdata['item_name'] = $tmpdata['itemname'];
                        $tmpdata['stocktype'] = "sell";
                        $tmpdata['stockunit'] = intval( intval($tmpdata['quatity']) * intval($tmpdata['groupquantity']) );
                        $tmpdata['stockcomment'] = "Deducted items stock when invoice generated";
                        $stock_item_save_result = $this->Stock_model->saveStock($tmpdata);
                        $data['code'] = $invoice_item_save_result['code'];
                        $data["previewData"][] = array(
                                                    "pk_invoice_item_id" => $invoice_item_save_result['itemid'], 
                                                    "fk_unique_invioce_code" => $tmpdata['invoiceID'], 
                                                    "fk_item_code" => $tmpdata['itemcode'], 
                                                    "fk_item_name" => $tmpdata['itemname'], 
                                                    "quantity" => $invoice_item_save_result['quatity'], 
                                                    "case_unit" => $invoice_item_save_result['itemunitcase'], 
                                                    "mrp" => $invoice_item_save_result['itemmrp'], 
                                                    "mrp_value" => $invoice_item_save_result['itemdmrpvalue'], 
                                                    "discount" => $invoice_item_save_result['itemdiscount'], 
                                                    "bill_value" => $invoice_item_save_result['itembillValue'], 
                                                    "updated_at" => date('Y-m-d H:i:s'), 
                                                    "fk_firm_code" => $this->session->userdata('firmcode')
                                                    );
                    }
                }
                $data["message"] = "Successfully invoice item group Updated! ";
            }else{
                $data['code'] = false;
                $data['result'] = $getAllGroupItems["result"];
                $data['last_query'] = $getAllGroupItems["last_query"];
                $data["message"] = "Group has not been any product. Please check group of items.";
            }
        }else{
            $data['code'] = false;
            $data["message"] = "Unable to serve GET Request, Please try again!";
        }
        echo json_encode($data);
    }

}