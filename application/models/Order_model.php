<?php

class Order_model extends CI_Model {

    protected $table = 'Orders';

    function __construct()  
    {  
        parent::__construct();
    }  

    public function get_count($order_type = 'sell') {
        $this->db->select('pk_order_id');
        if ($this->session->userdata('role') != "admin"){
            $this->db->where('fk_username', $this->session->userdata('username'));
        }
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where('order_type', $order_type);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function order_list($limit, $start, $order_type = 'sell'){
        $this->db->limit($limit, $start);
        if ($this->session->userdata('role') != "admin"){
            $this->db->where('fk_username', $this->session->userdata('username'));
        }
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where('order_type', $order_type);
        $this->db->order_by("created_at", "DESC");
        $query = $this->db->get($this->table);
        if($query->num_rows() > 0){
            $data['result'] = $query->result();
        }else{
            $data['result'] = array();
        }
        return $data;
    }

    public function order_id($order_type = 'sell'){
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where('fk_username', $this->session->userdata('username'));
        $this->db->where('status', 'create');
        $this->db->where('order_type', $order_type);
        $query = $this->db->get($this->table);
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return array();
        }
        return array();
    }

    public function orderInitial($orderNewID, $order_type = 'sell'){
        if ($order_type === 'sell'){

            if (date('m') <= 3) {
                $thisFYear = (date('Y')-1);
            } else {
                $thisFYear = date('Y');
            }
    
            $thisSFinancialYear = $thisFYear.'-04-01 00:00:00'; 
    
            $thisStartFinancial = date($thisSFinancialYear);
            $thisEndFinancial = date('y-m-d 23:59:59');
            
            $previous_order_ref_no = 1;
            $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
            $this->db->where('order_type', "sell");
            $this->db->where("created_at BETWEEN '$thisStartFinancial' AND '$thisEndFinancial'");
            $queryForNumber = $this->db->get($this->table);
            if($queryForNumber->num_rows() > 0){
                $previous_order_ref_no = $previous_order_ref_no + $queryForNumber->num_rows();
            }
            $data = array(
                'unique_order_code'=>$orderNewID,
                'status'=>'create',
                'order_type'=>$order_type,
                'previous_order_ref_no'=> $previous_order_ref_no,
                'fk_firm_code'=>$this->session->userdata('firmcode'),
                'fk_username'=> $this->session->userdata('username')
            );
        }else{
            $data = array(
                'unique_order_code'=>$orderNewID,
                'status'=>'create',
                'order_type'=>$order_type,
                'fk_firm_code'=>$this->session->userdata('firmcode'),
                'fk_username'=> $this->session->userdata('username')
            );
        }
        $this->db->insert($this->table,$data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function getorderid($orderid = null){
        $data = array();
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where('unique_order_code', $orderid);
        $query = $this->db->get($this->table);
        if($query->num_rows() >= 1){
            foreach ($query->result() as $row)  
            {  
                $data['pk_order_id'] = $row->pk_order_id;
                $data['unique_order_code'] = $row->unique_order_code;
                $data['orderstatus'] = $row->status;
                $data['ordertitle'] = $row->order_title;
                $data['subtitle'] = $row->order_subtitle;
                $data['payment_mode'] = $row->payment_mode;
                $data['vehicle'] = $row->vehicle;
                $data['ordergstin'] = $row->order_gstin;
                $data['ordermobileno'] = $row->order_mobileno;
                $data['previous_order_ref_no'] = $row->previous_order_ref_no;
                $data['created_at'] = $row->created_at;

                $data['fk_client_code'] = $row->fk_client_code;
                $data['client_name'] = $row->client_name;
                $data['gstnumber'] = $row->gstnumber;
                $data['pannumber'] = $row->pannumber;
                $data['mobilenumber'] = $row->mobilenumber;

                $data['address'] = $row->address;
                $data['state'] = $row->state;
                $data['district'] = $row->district;
                $data['city'] = $row->city;
                $data['area'] = $row->area;
                $data['pincode'] = $row->pincode;

                $data['fk_unique_invioce_code'] = $row->fk_unique_invioce_code;
                $data['fk_invioce_id'] = $row->fk_invioce_id;
            }
        }
        return $data;
    }

    public function updateOrder($data){
        $this->db->where('unique_order_code', $data['defaultorderID']);
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $query = $this->db->get($this->table);
        if($query->num_rows() == 1){
            $dataList = array(
                'fk_client_code'=>$data['clientcode'],
                'client_name'=>$data['clientname'],
                'mobilenumber'=>$data['mobilenumber'],
                'address'=>$data['clintaddress'],
                'state'=>$data['clientState'],
                'district'=>$data['clientDistrict'],
                'city'=>$data['clientcity'],
                'area'=>$data['clientarea'],
                'pincode'=>$data['clientpincode'],
                'status'=>'initiated'
            );
            $this->db->where('unique_order_code', $data['defaultorderID']);
            $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
            $this->db->update($this->table, $dataList);
            return ($this->db->affected_rows() == 1) ? true : false;
        }else{
            return false;
        }   
    }

    public function updateOrderStatus($data){
        $result = array();
        $this->db->where('unique_order_code', $data['defaultorderID']);
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $query = $this->db->get($this->table);
        if($query->num_rows() == 1){
            if ($data['statuscode'] === "completed"){
                /*
                * Get total bill value
                */
                $this->db->select_sum('bill_value');
                $this->db->from('Order_item');
                $this->db->where('delete_flag', 'NO');
                $this->db->where('fk_unique_order_code', $data['defaultorderID']);
                $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
                $billvaluequery = $this->db->get();
                $total_bill_value = $billvaluequery->row()->bill_value;
                $total_bill_value = round($total_bill_value);
                
                $dataList = array(
                    'status'=> $data['statuscode'],
                    'lock_bill_amount'=> $total_bill_value,
                    'lock_bill_amount_date'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s')
                );
            }else{
                $dataList = array(
                    'status'=> $data['statuscode'],
                    'lock_bill_amount'=> '0',
                    'updated_at'=>date('Y-m-d H:i:s')
                );
            }
            $this->db->where('unique_order_code', $data['defaultorderID']);
            $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
            $this->db->update($this->table, $dataList);
            $result['code']  = true;
        }else{
            $result['code']  = false;
        }

        return $result;
    }

    public function order_items_list($orderID){
        $this->db->where('delete_flag', 'NO');
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where('fk_unique_order_code', $orderID);
        $query = $this->db->get('Order_item');
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return array();
        }
        return array();
    }

    public function saveOrderItem($data){
        $result = array();
        $this->db->where('pk_order_item_id', $data['itemID']);
        $this->db->where('fk_unique_order_code', $data['orderID']);
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $query = $this->db->get('Order_item');
        if($query->num_rows() == 1){
            foreach ($query->result() as $row)  
            {  
                $result['itemcode'] = $row->fk_item_code;
                $result['itemname'] = $row->fk_item_name;
                $result['oldQuatity'] = $row->quantity;
            }

            $dataList = array(
                'fk_item_code'=>$data['itemcode'],
                'fk_item_name'=>$data['itemname'],
                'quantity'=>$data['quatity'],
                'case_unit'=>$data['itemunitcase'],
                'mrp'=>$data['itemmrp'],
                'mrp_value'=>$data['itemdmrpvalue'],
                'discount'=>$data['itemdiscount'],
                'bill_value'=>$data['itembillValue'],
                'updated_at'=>date('Y-m-d H:i:s')
            );
            $this->db->where('pk_order_item_id', $data['itemID']);
            $this->db->where('fk_unique_order_code', $data['orderID']);
            $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
            $this->db->update('Order_item', $dataList);
            $result['code']  = ($this->db->affected_rows() == 1) ? true : false;
            $result['itemid']  = $data['itemID'];
        }else{
            $dataList = array(
                'fk_unique_order_code'=>$data['orderID'],
                'fk_item_code'=>$data['itemcode'],
                'fk_item_name'=>$data['itemname'],
                'quantity'=>$data['quatity'],
                'case_unit'=>$data['itemunitcase'],
                'mrp'=>$data['itemmrp'],
                'mrp_value'=>$data['itemdmrpvalue'],
                'discount'=>$data['itemdiscount'],
                'bill_value'=>$data['itembillValue'],
                'fk_username'=>$this->session->userdata('username'),
                'fk_firm_code'=>$this->session->userdata('firmcode')
            );
            $this->db->insert('Order_item', $dataList);
            $result['code']  = ($this->db->affected_rows() == 1) ? true : false;
            $result['itemid']  = $this->db->insert_id();
        }
        return $result;
    }

    public function delete_order_item($order_Item){
        $result = array();
        $this->db->where('pk_order_item_id', $order_Item['itemOrderid']);
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $query = $this->db->get('Order_item');
        if($query->num_rows() == 1){
            $dataList = array(
                'delete_flag'=> 'YES',
                'deleted_at'=>date('Y-m-d H:i:s')
            );
            $this->db->where('pk_order_item_id', $order_Item['itemOrderid']);
            $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
            $this->db->update('Order_item', $dataList);
            $result['code']  = ($this->db->affected_rows() == 1) ? true : false;
            $result['itemOrderid']  = $order_Item['itemOrderid'];
            foreach ($query->result() as $row)  
            {  
                $result['itemcode'] = $row->fk_item_code;
                $result['itemname'] = $row->fk_item_name;
                $result['quatity'] = $row->quantity;
            }
        }else{
            $result['code']  = false;
            $result['itemOrderid']  = $order_Item['itemOrderid'];
        }
        return $result;
    }
    
    public function makeitordertoinvoice($data){
        $result = array();
        $this->db->where('unique_order_code', $data['defaultorderID']);
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $query = $this->db->get($this->table);
        if($query->num_rows() == 1){
            foreach ($query->result() as $row)  
            {  
                $result['statuscode'] = $row->status;
                $result['fk_invioce_id'] = $row->fk_invioce_id;
                $result['fk_unique_invioce_code'] = $row->fk_unique_invioce_code;

            }
            if (($result['statuscode'] === "completed") || ($result['statuscode'] === "paid") || ($result['statuscode'] === "partial_paid")){
                if($result['fk_invioce_id'] > 0){
                    $result['code']  = false;
                }else{
                    $getInvoiceId = false;
                    $getUniqueInvoiceID = "";
                    $getInvoiceNumber;
                    $this->load->model('Invoice_model', '', TRUE);
                    $this->load->model('Stock_model', '', TRUE);
                    $invoice = $this->Invoice_model->invoice_id();
                    if(count($invoice) == 0){
                    $invoiceNewID = invoiceIDCreation();
                    $newInvoiceResult = $this->Invoice_model->invoiceInitial($invoiceNewID);
                        if($newInvoiceResult){
                            $getInvoiceId = true;
                            $getUniqueInvoiceID = $invoiceNewID;
                            $InvoiceResultlist = $this->Invoice_model->getinvoiceid($invoiceNewID);
                            $getInvoiceNumber = $InvoiceResultlist["invoice_reference_id"];
                        }else{
                            $getInvoiceId = false;
                        }
                    }else{
                        $getInvoiceId = true;
                        $getUniqueInvoiceID = $invoice[0]->unique_invioce_code;
                        $getInvoiceNumber = $invoice[0]->previous_invoice_ref_no;
                    }

                    if($getInvoiceId){
                        $order_item_list = $this->order_items_list($data['defaultorderID']);
                        foreach($order_item_list as $order_item){
                            $tmpdata = array();
                            $tmpdata['itemID'] = '';
                            $tmpdata['invoiceID'] = $getUniqueInvoiceID;
                            $tmpdata['itemcode'] = strtoupper($order_item->fk_item_code);
                            $tmpdata['itemname'] = strtoupper($order_item->fk_item_name);
                            $tmpdata['quatity'] = $order_item->quantity;
                            $tmpdata['itemunitcase'] = $order_item->case_unit;
                            $tmpdata['itemmrp'] = $order_item->mrp;
                            $tmpdata['itemdiscount'] = $order_item->discount;
                            $tmpdata['itemdmrpvalue'] = $order_item->mrp_value;
                            $tmpdata['itembillValue'] = $order_item->bill_value;

                            $invoice_item_save_result = $this->Invoice_model->saveInvoiceItem($tmpdata);
                            if($invoice_item_save_result['code']){
                                /***
                                 * Sell:- Adjust item stock when sell item
                                 */
                                $tmpdata['item_code'] = $tmpdata['itemcode'];
                                $tmpdata['item_name'] = $tmpdata['itemname'];
                                $tmpdata['stocktype'] = "sell";
                                $tmpdata['stockunit'] = $tmpdata['quatity'];
                                $tmpdata['stockcomment'] = "Deducted items stock when invoice generated from order";
                                $this->Stock_model->saveStock($tmpdata);
                            }

                        }
                        $dataList = array(
                            'fk_unique_invioce_code'=> $getUniqueInvoiceID,
                            'fk_invioce_id'=> $getInvoiceNumber,
                            'updated_at'=>date('Y-m-d H:i:s')
                        );
                        $this->db->where('unique_order_code', $data['defaultorderID']);
                        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
                        $this->db->update($this->table, $dataList);

                        $invoicedata = array(
                            'status'=> 'pending',
                            'updated_at'=>date('Y-m-d H:i:s')
                        );
                        $this->db->where('unique_invioce_code', $getUniqueInvoiceID);
                        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
                        $this->db->update('Invoices', $invoicedata);


                        $result['fk_unique_invioce_code']  = $getUniqueInvoiceID;
                        $result['fk_invioce_id']  = $getInvoiceNumber;
                        $result['code']  = true;
                    }else{
                        $result['code']  = false;
                    }
                }
            }else{
                $result['code']  = false;
            }
        }else{
            $result['code']  = false;
        }

        return $result;
    }
}