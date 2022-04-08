<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item extends CI_Controller {

    function __construct() {
        parent::__construct();
        if($this->session->userdata('isUserLoggedIn') != TRUE){ 
            redirect('/login');
        }
        if(access_lavel(3, $this->session->userdata('role'))){
            redirect('/login');
        }
        $this->load->model('Item_model', '', TRUE);
        $this->load->model('Invoice_model', '', TRUE);
        $this->load->library("pagination");
    }
    
    public function createItem(){
        $data = array();
        $company_result = $this->Item_model->company_list();
        $data['companiesList'] = $company_result['result'];
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $data['method'] = "GET";
         } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['method'] = "POST";
            $data['uniqueItemCode'] = $this->input->post('uniqueItemCode');
            $data['itemName'] = $this->input->post('itemName');
            $data['itemsubdescription'] = $this->input->post('itemsubdescription');
            $data['weightinlitter'] = $this->input->post('weightinlitter');
            $data['itemunitcase'] = $this->input->post('itemunitcase');
            $data['itemmrp'] = $this->input->post('itemmrp');
            $data['itemcostprice'] = $this->input->post('itemcostprice');
            $data['itemopbalanceinquantity'] = $this->input->post('itemopbalanceinquantity');
            $data['itemCompanyCode'] = $this->input->post('itemCompanyCode');
            $uniqueCodeVerify = $this->Item_model->unique_item_code_verify($this->input->post('uniqueItemCode'));
            if($uniqueCodeVerify){
                $createItem = $this->Item_model->create_item($data);
                if($createItem ){
                    $data['uniqueItemCode'] = '';
                    $data['itemName'] = '';
                    $data['itemsubdescription'] = '';
                    $data['weightinlitter'] = '';
                    $data['itemunitcase'] = '';
                    $data['itemmrp'] = '';
                    $data['itemcostprice'] = '';
                    $data['itemopbalanceinquantity'] = '';
                    $data['itemCompanyCode'] = '';
                    $data['successMessage'] = "Successfully Product Created.";
                }else{
                    $data['errorMessage'] = 'Unable to save Product information. Please contact your Administrator.';
                }
            }else{
                $data['errorMessage'] = 'Unique Code must be unique.';
            }
         }
        $this->template->set('buttonName', 'Products List');
        $this->template->set('buttonLink', base_url('/itemdetails'));
        $this->template->set('title', 'Create Product');
        $this->template->load('default_layout', 'contents' , 'item/createitem', $data);
    }

    public function itemdetails(){
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
        $data["base_url"] = base_url("itemdetails");

        $config = array();
        $config["base_url"] = base_url("itemdetails".$searchurl."".$globalsearchtext);
        $config["total_rows"] = $this->Item_model->get_count(urldecode($globalsearchtext));
        $config["per_page"] = PAGE_PER_ITEM;
        $config["uri_segment"] = $page_seg;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment($page_seg)) ? $this->uri->segment($page_seg) : 0;
        $data["links"] = $this->pagination->create_links();

        $firm_result = $this->Item_model->item_list($config["per_page"], $page, urldecode($globalsearchtext));
        $data['data'] = $firm_result['result'];
        $data['page'] = $page ;
        $this->template->set('buttonName', 'New Product');
        $this->template->set('buttonLink', base_url('/createitem'));
        $this->template->set('globalsearch', TRUE);
        $this->template->set('globalsearchtext', urldecode($globalsearchtext));
        $this->template->set('title', 'Products List');
        $this->template->load('default_layout', 'contents' , 'item/itemdetail', $data);
    }

    public function updateItem($item_id = null){
        $data = array();
        $company_result = $this->Item_model->company_list();
        $data['companiesList'] = $company_result['result'];

        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $data['method'] = "GET";
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['method'] = "POST";
            $data['itemCode'] = $this->input->post('uniqueItemCode');
            $data['itemName'] = $this->input->post('itemName');
            $data['itemsubdescription'] = $this->input->post('itemsubdescription');
            $data['weightinlitter'] = $this->input->post('weightinlitter');
            $data['itemunitcase'] = $this->input->post('itemunitcase');
            $data['itemmrp'] = $this->input->post('itemmrp');
            $data['itemcostprice'] = $this->input->post('itemcostprice');
            $data['itemopbalanceinquantity'] = $this->input->post('itemopbalanceinquantity');
            $data['itemCompanyCode'] = $this->input->post('itemCompanyCode');
            $uniqueCodeVerify = $this->Item_model->unique_item_code_check($this->input->post('uniqueItemCode'));
            if($uniqueCodeVerify){
                $createItem = $this->Item_model->update_item($data);
                if($createItem ){
                    $data['successMessage'] = "Successfully Product Updated.";
                }else{
                    $data['errorMessage'] = 'No change on current value or Something went wrong';
                }
            }else{
                $data['errorMessage'] = 'Unique Code must be unique. Please try again later';
            }
         }

        $item_result = $this->Item_model->update_item_detail($item_id);
        $data['data'] = $item_result['result'];
        $this->template->set('buttonName', 'Products List');
        $this->template->set('buttonLink', base_url('/itemdetails'));
        $this->template->set('title', 'Products Update');
        $this->template->load('default_layout', 'contents' , 'item/updateitem', $data);
    }

    public function deleteItem(){
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['item_code'] = $this->input->post('item_code');
            $item_delete_result = $this->Item_model->delete_item($data);
            if($item_delete_result['code']){
                $data['code'] = $item_delete_result['code'];
                $data['itemid'] = $item_delete_result['itemid'];
                $data["message"] = "Successfully Product deleted!";
            }else{
                $data['code'] = $item_delete_result['code'];
                $data['itemid'] = $item_delete_result['itemid'];
                $data["message"] = "Unable to delete this Product. Please try again!";
            }
        }else{
            $data['code'] = false;
            $data['itemid'] = $this->input->post('item_code');
            $data["message"] = "Unable to serve delete Request, Please try again!";
        }
        echo json_encode($data);
    }

    /***
     * Group of product list
     */

    public function productgroupdetails(){
        $data = array();

        $config = array();
        $config["base_url"] = base_url("productgroupdetails");
        $config["total_rows"] = $this->Item_model->get_group_count();
        $config["per_page"] = PAGE_PER_ITEM;
        $config["uri_segment"] = 2;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["links"] = $this->pagination->create_links();

        $firm_result = $this->Item_model->item_group_list($config["per_page"], $page);
        $data['data'] = $firm_result['result'];
        $data['page'] = $page ;
        $this->template->set('buttonName', 'New Product Group');
        $this->template->set('buttonLink', base_url('/createproductgroup'));
        $this->template->set('title', 'Product Group List');
        $this->template->load('default_layout', 'contents' , 'item/productgroupdetail', $data);
    }

    public function createproductgroup(){
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $data['method'] = "GET";
         } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['method'] = "POST";
            $data['uniqueCode'] = $this->input->post('uniqueCode');
            $data['productgroupName'] = $this->input->post('productgroupName');
            $data['description'] = $this->input->post('description');
            $uniqueCodeVerify = $this->Item_model->unique_item_group_code_verify($this->input->post('uniqueCode'));
            if($uniqueCodeVerify){
                $createItem = $this->Item_model->create_group_item($data);
                if($createItem ){
                    $data['uniqueCode'] = '';
                    $data['productgroupName'] = '';
                    $data['description'] = '';
                    $data['successMessage'] = "Successfully Product Group Created.";
                }else{
                    $data['errorMessage'] = 'Unable to save Product group information. Please contact your Administrator.';
                }
            }else{
                $data['errorMessage'] = 'Unique Code must be unique.';
            }
         }
        $this->template->set('buttonName', 'Product Group List');
        $this->template->set('buttonLink', base_url('/productgroupdetails'));
        $this->template->set('title', 'Create Product Group');
        $this->template->load('default_layout', 'contents' , 'item/createproductgroup', $data);
    }

    public function deleteproductgroup(){
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['productgroupCode'] = $this->input->post('productgroupCode');
            $product_group_delete_result = $this->Item_model->delete_product_group($data);
            if($product_group_delete_result['code']){
                $data['code'] = $product_group_delete_result['code'];
                $data['productgroupCode'] = $product_group_delete_result['productgroupCode'];
                $data["message"] = "Successfully Product deleted!";
            }else{
                $data['code'] = $product_group_delete_result['code'];
                $data['productgroupCode'] = $product_group_delete_result['productgroupCode'];
                $data["message"] = "Unable to delete this Product. Please try again!";
            }
        }else{
            $data['code'] = false;
            $data['productgroupCode'] = $this->input->post('productgroupCode');
            $data["message"] = "Unable to serve delete Request, Please try again!";
        }
        echo json_encode($data);
    }

    public function updateproductgroup($productgroup = null){
        $data = array(); 
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $data['method'] = "GET";
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['method'] = "POST";
            $data['uniqueCode'] = $this->input->post('uniqueCode');
            $data['productgroupName'] = $this->input->post('productgroupName');
            $data['description'] = $this->input->post('description');
            $uniqueCodeCheck = $this->Item_model->unique_item_group_code_check($this->input->post('uniqueCode'));
            if($uniqueCodeCheck){
                $updategroupproduct = $this->Item_model->update_group_of_product($data);
                if($updategroupproduct ){
                    $data['successMessage'] = "Successfully group of product Updated.";
                }else{
                    $data['errorMessage'] = 'No change on current value or Something went wrong';
                }
            }else{
                $data['errorMessage'] = 'Unique Code must be unique. Please try again later';
            }
        }
        $productgroup_result = $this->Item_model->update_group_of_product_detail($productgroup);
        $data['data'] = $productgroup_result['result'];
        $this->template->set('buttonName', 'Product Group List');
        $this->template->set('buttonLink', base_url('/productgroupdetails'));
        $this->template->set('title', 'Update Product Group');
        $this->template->load('default_layout', 'contents' , 'item/updateproductgroup', $data);
    }

    public function addproducttoproductgroup($productgroup = null){
        $data = array(); 
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $data['method'] = "GET";
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['method'] = "POST";
        }
        $productgroup_result = $this->Item_model->update_group_of_product_detail($productgroup);
        $data['data'] = $productgroup_result['result'];
        foreach($productgroup_result['result'] as $value){ 
            $data['uniqueCode'] = $value->pk_gfi_unique_code;
            $data['productgroupName'] =  $value->name;
            $data['description'] = $value->description; 
        }
        $data['invoiceitemsList'] = $this->Item_model->product_group_list($productgroup);
        $data['itemsList'] = $this->Invoice_model->items_list();
        $this->template->set('buttonName', 'Product Group List');
        $this->template->set('buttonLink', base_url('/productgroupdetails'));
        $this->template->set('title', 'Add Ptoduct to Product Group ('.$data['productgroupName'].')');
        $this->template->load('default_layout', 'contents' , 'item/addproducttoproductgroup', $data);
    }

    public function saveproducttoproductgroup(){
        if(access_lavel(3, $this->session->userdata('role'))){
            redirect('/login');
        }
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['itemID'] = $this->input->post('itemID');
            $data['productgroupcode'] = $this->input->post('productgroupcode');
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
            $invoice_item_save_result = $this->Item_model->saveProducttoproductgroup($data);
            if($invoice_item_save_result['code']){ 
                
                $data['code'] = $invoice_item_save_result['code'];
                $data["message"] = "Successfully invoice item saved! ";
                $data["previewData"] = array(
                                        "goi_id" => $invoice_item_save_result['itemid'], 
                                        "fk_unique_invioce_code" => $data['productgroupcode'], 
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
                $data["message"] = "Unable to update invoice item, may be wrong invoice id. Please try again!";
            }
        }else{
            $data['code'] = false;
            $data["message"] = "Unable to serve GET Request, Please try again!";
        }
        echo json_encode($data);
    }

    public function deleteproducttoproductgroup(){
        if(access_lavel(3, $this->session->userdata('role'))){
            redirect('/login');
        }
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data['productgroupCode'] = $this->input->post('productgroupCode');
            $invoice_item_delete_result = $this->Item_model->delete_group_product($data);
            if($invoice_item_delete_result['code']){
                $data['code'] = $invoice_item_delete_result['code'];
                $data['itemInvoiceCode'] = $invoice_item_delete_result['goi_id'];
                $data["message"] = "Successfully invoice item deleted!";
            }else{
                $data['code'] = $invoice_item_delete_result['code'];
                $data['itemInvoiceCode'] = $invoice_item_delete_result['goi_id'];
                $data["message"] = "Unable to delete this invoice item. Please try again!";
            }
        }else{
            $data['code'] = false;
            $data['itemInvoiceCode'] = $this->input->post('productgroupCode');
            $data["message"] = "Unable to serve delete Request, Please try again!";
        }
        $data['query'] = $invoice_item_delete_result['query'];
        echo json_encode($data);
    }

    
}