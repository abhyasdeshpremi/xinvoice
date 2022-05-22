<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {

    function __construct() {
        parent::__construct();
        if($this->session->userdata('isUserLoggedIn') != TRUE){ 
            redirect('/login');
        }
        $this->load->model('Invoice_model', '', TRUE);
        $this->load->model('Stock_model', '', TRUE);
        $this->load->library("pagination");
        $this->load->model('Order_model', '', TRUE);
    }
    
    public function ordersList(){
        $data = array();

        $config = array();
        $config["base_url"] = base_url("orders");
        $config["total_rows"] = $this->Order_model->get_count('sell');
        $config["per_page"] = PAGE_PER_ITEM;
        $config["uri_segment"] = 2;

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["links"] = $this->pagination->create_links();

        $order_result = $this->Order_model->order_list($config["per_page"], $page, 'sell');
        $data['page'] = $page;
        $data['data'] = $order_result['result'];
        $this->template->set('buttonName', 'New order');
        $this->template->set('buttonLink', base_url('/createorder'));
        $this->template->set('title', 'Order List');
        $this->template->load('default_layout', 'contents' , 'order/orderdetail', $data);
    }

    public function createorderID(){
        $order = $this->Order_model->order_id();
        if(count($order) == 0){
           $orderNewID = invoiceIDCreation();
           $newInvoiceResult = $this->Order_model->orderInitial($orderNewID);
           if($newInvoiceResult){
                redirect('createorder/'.$orderNewID); 
           }else{
                $data['heading'] = "Unable to create New Order ID, Please try again";
                $data['message'] = "Unable to create New Order ID, Please try again";
                $this->template->set('title', 'Unable to create Order ID');
                $this->template->load('default_layout', 'contents' , 'errors/html/error_404', $data);
           }
        }else{
            redirect('createorder/'.$order[0]->unique_order_code); 
        }
    }
    
    public function createorder($id = null){
        $data = array();
        if(!validationInvoiceID($id)){
            $data['heading'] = "Invalid Order ID";
            $data['message'] = "Invalid Order ID";
            $this->template->set('title', 'Invalid Order ID');
            $this->template->load('default_layout', 'contents' , 'errors/html/error_404', $data);
            return false;
        }
        $data['clients'] = $this->Invoice_model->client_list_except_supllier();
        $data['invoiceTypes'] = $this->Invoice_model->invoiceRef_list();
        $data['orderitemsList'] = $this->Order_model->order_items_list($id);
        $data['itemsList'] = $this->Invoice_model->items_list();
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $data['method'] = "GET";
            $data['orderid'] = $id;
            $orderDetail = $this->Order_model->getorderid($id);
            $data['orderid'] = $orderDetail['pk_order_id'];
            $data['unique_order_code'] = $orderDetail['unique_order_code'];
            $data['orderstatus'] = $orderDetail['orderstatus'];
            $data['ordertitle'] = $orderDetail['ordertitle'];
            $data['subtitle'] = $orderDetail['subtitle'];
            $data['paymentmode'] = $orderDetail['payment_mode'];
            $data['vehicleno'] = $orderDetail['vehicle'];
            $data['ordergstin'] = $orderDetail['ordergstin'];
            $data['ordermobileno'] = $orderDetail['ordermobileno'];
            $data['orderrefNumber'] = $orderDetail['previous_order_ref_no'];

            $data['clientcode'] = $orderDetail['fk_client_code'];
            $data['clientname'] = $orderDetail['client_name'];
            $data['gstin'] = $orderDetail['gstnumber'];
            $data['pannumber'] = $orderDetail['pannumber'];
            $data['mobilenumber'] = $orderDetail['mobilenumber'];

            $data['clintaddress'] = $orderDetail['address'];
            $data['clientState'] = $orderDetail['state'];
            $data['clientDistrict'] = $orderDetail['district'];
            $data['clientcity'] = $orderDetail['city'];
            $data['clientarea'] = $orderDetail['area'];
            $data['clientpincode'] = $orderDetail['pincode'];

            $data['fk_unique_invioce_code'] = $orderDetail['fk_unique_invioce_code'];
            $data['fk_invioce_id'] = $orderDetail['fk_invioce_id'];
         } 
        $this->template->set('buttonName', 'Orders List');
        $this->template->set('buttonLink', base_url('/orders'));
        $this->template->set('title', 'Create Order');
        $this->template->load('default_layout', 'contents' , 'order/createorder', $data);
    }
    
    public function saveOrderHeader(){
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['defaultorderID'] = $this->input->post('defaultorderID');
            $data['clientcode'] = $this->input->post('clientcode');
            $data['clientname'] = $this->input->post('clientname');
            $data['mobilenumber'] = $this->input->post('mobilenumber');
            $data['clintaddress'] = $this->input->post('clintaddress');
            $data['clientState'] = $this->input->post('clientState');
            $data['clientDistrict'] = $this->input->post('clientDistrict');
            $data['clientcity'] = $this->input->post('clientcity');
            $data['clientarea'] = $this->input->post('clientarea');
            $data['clientpincode'] = $this->input->post('clientpincode');
            $data["message"] = "Update data start";
            $order_save_result = $this->Order_model->updateOrder($data);
            if($order_save_result){
                $data["message"] = "Successfully order header saved!";
            }else{
                $data["message"] = "Unable to save order, may be wrong order id. Please try again!";
            }
        }else{
            $data["message"] = "Unable to serve GET Request, Please try again!";
        }
        echo json_encode($data);
    }

    function updateOrderStatus(){
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['defaultorderID'] = $this->input->post('defaultorderID');
            $data['statuscode'] = $this->input->post('orderStatus');
            $order_status_result = $this->Order_model->updateOrderStatus($data);
            if($order_status_result){
                $data["code"] = $order_status_result["code"];
                $data["message"] = "Order status updated.";
            }else{
                $data["code"] = $order_status_result["code"];
                $data["message"] = "Order status unable to update.";
            }
        }
        echo json_encode($data);
    }

    public function saveItemInOrder(){
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['itemID'] = $this->input->post('itemID');
            $data['orderID'] = $this->input->post('orderid');
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
            $order_item_save_result = $this->Order_model->saveOrderItem($data);
            if($order_item_save_result['code']){
                
                $data['code'] = $order_item_save_result['code'];
                $data["message"] = "Successfully order product saved!";
                $data["previewData"] = array(
                                        "pk_order_item_id" => $order_item_save_result['itemid'], 
                                        "fk_unique_order_code" => $data['orderID'], 
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
                $data['code'] = $order_item_save_result['code'];
                $data['itemID'] = $order_item_save_result['itemID'];
                $data["message"] = "Unable to update order product, may be wrong order id. Please try again!";
            }
        }else{
            $data['code'] = false;
            $data["message"] = "Unable to serve GET Request, Please try again!";
        }
        echo json_encode($data);
    }

    public function updateItemInOrder(){
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['itemID'] = $this->input->post('itemID');
            $data['orderID'] = $this->input->post('orderid');
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
            $order_item_save_result = $this->Order_model->saveOrderItem($data);
            if($order_item_save_result['code']){
                $data['code'] = $order_item_save_result['code'];
                $data['itemID'] = $order_item_save_result['itemid'];
                $data["message"] = "Successfully order product Updated! ";
                $data["previewData"] = array(
                                        "pk_invoice_item_id" => $order_item_save_result['itemid'], 
                                        "fk_unique_order_code" => $data['orderID'], 
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
                $data['code'] = $order_item_save_result['code'];
                $data['itemID'] = $invoice_item_save_result['itemid'];
                $data["message"] = "Unable to save order product, may be wrong invoice id. Please try again!";
            }
        }else{
            $data['code'] = false;
            $data["message"] = "Unable to serve GET Request, Please try again!";
        }
        echo json_encode($data);
    }

    public function deleteOrderItem(){
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['itemOrderid'] = $this->input->post('itemOrderid');
            $order_item_delete_result = $this->Order_model->delete_order_item($data);
            if($order_item_delete_result['code']){
                $data['code'] = $order_item_delete_result['code'];
                $data['itemOrderid'] = $order_item_delete_result['itemOrderid'];
                $data["message"] = "Successfully order product deleted!";
            }else{
                $data['code'] = $order_item_delete_result['code'];
                $data['itemOrderid'] = $order_item_delete_result['itemOrderid'];
                $data["message"] = "Unable to delete this order product. Please try again!";
            }
        }else{
            $data['code'] = false;
            $data['itemOrderid'] = $this->input->post('itemOrderid');
            $data["message"] = "Unable to serve delete Request, Please try again!";
        }
        echo json_encode($data);
    }


    public function createOrderPDF($id = null, $mode = "landscape", $download = false){
        if(access_lavel(2, $this->session->userdata('role'))){
            redirect('/login');
        }
        $data = array();
        if(!validationInvoiceID($id)){
            $data['heading'] = "Invalid Order ID";
            $data['message'] = "Invalid Order ID";
            $this->template->set('title', 'Invalid Order ID');
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
        
        $data['clients'] = $this->Invoice_model->client_list_except_supllier();
        $data['invoiceTypes'] = $this->Invoice_model->invoiceRef_list();
        $data['orderitemsList'] = $this->Order_model->order_items_list($id);
        $data['itemsList'] = $this->Invoice_model->items_list();
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $data['method'] = "GET";
            $data['orderid'] = $id;
            $orderDetail = $this->Order_model->getorderid($id);
            $data['orderid'] = $orderDetail['pk_order_id'];
            $data['unique_order_code'] = $orderDetail['unique_order_code'];
            $data['orderstatus'] = $orderDetail['orderstatus'];
            $data['ordertitle'] = $this->session->userdata('firmname');
            $data['subtitle'] = $this->session->userdata('firmaddress');
            $data['paymentmode'] = $orderDetail['payment_mode'];
            $data['vehicleno'] = $orderDetail['vehicle'];
            $data['ordergstin'] = $orderDetail['ordergstin'];
            $data['ordermobileno'] = $orderDetail['ordermobileno'];
            $data['orderrefNumber'] = $orderDetail['previous_order_ref_no'];

            $data['clientcode'] = $orderDetail['fk_client_code'];
            $data['clientname'] = $orderDetail['client_name'];
            $data['gstin'] = $orderDetail['gstnumber'];
            $data['pannumber'] = $orderDetail['pannumber'];
            $data['mobilenumber'] = $orderDetail['mobilenumber'];

            $data['clintaddress'] = $orderDetail['address'];
            $data['clientState'] = $orderDetail['state'];
            $data['clientDistrict'] = $orderDetail['district'];
            $data['clientcity'] = $orderDetail['city'];
            $data['clientarea'] = $orderDetail['area'];
            $data['clientpincode'] = $orderDetail['pincode'];
            $data['created_at'] = $orderDetail['created_at'];            
            $data['mode'] = $mode;

         } 
        // $this->template->set('title', 'Create Order PDF');
        // $this->template->load('default_layout', 'contents' , 'order/createorderpdf', $data);
        //landscape portrait
        $this->load->library('pdf');
        $html = $this->load->view('order/createorderpdf', $data, true);
        $this->pdf->createPDF($html, $orderDetail['ordertitle']."".date('Y-m-d H:i:s'), $download, 'A4', $mode);

    }

    function makeitordertoinvoice(){
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['defaultorderID'] = $this->input->post('defaultorderID');
            $makeitordertoinvoice = $this->Order_model->makeitordertoinvoice($data);
            if($makeitordertoinvoice){
                $data["code"] = $makeitordertoinvoice["code"];
                $data["fk_unique_invioce_code"] = $makeitordertoinvoice["fk_unique_invioce_code"];
                $data["fk_invioce_id"] = $makeitordertoinvoice["fk_invioce_id"];
                $data["message"] = "Generated New invoice.";
            }else{
                $data["code"] = $makeitordertoinvoice["code"];
                $data["message"] = "Unable to generated new invoice.";
            }
        }
        echo json_encode($data);
    }

}