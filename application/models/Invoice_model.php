<?php

class Invoice_model extends CI_Model {

    protected $table = 'Invoices';

    function __construct()  
    {  
        parent::__construct();
    }  

    public function get_count($invoice_type = 'sell') {
        $this->db->select('pk_invoice_id');
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where('invoice_type', $invoice_type);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function client_list(){
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $query = $this->db->get('Clients');
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return array();
        }
        return array();
    }

    public function client_list_except_supllier(){
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where_not_in('client_type', 'supplier');
        $query = $this->db->get('Clients');
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return array();
        }
        return array();
    }

    public function client_list_ONLY_supllier(){
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where('client_type', 'supplier');
        $query = $this->db->get('Clients');
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return array();
        }
        return array();
    }

    public function unique_company_code_verify($unique_code){
        $this->db->where('company_code', strtoupper($unique_code));
        $query = $this->db->get('Companies');
        if($query->num_rows() === 0){
            return true;
        }else{
            return false;
        }
        return false;
    }

    public function create_company($data){
        $data = array(
            'company_code'=>strtoupper($data['uniqueCode']),
            'name'=>$data['companyName'],
            'description'=>$data['description'],
            'fk_firm_code'=>$this->session->userdata('firmcode'),
            'fk_username'=> $this->session->userdata('username')
        );
        $this->db->insert('Companies',$data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function company_list(){
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $query = $this->db->get('Companies');
        if($query->num_rows() > 0){
            $data['result'] = $query->result();
        }else{
            $data['result'] = array();
        }
        return $data;
    }

    public function invoice_list($limit, $start, $invoice_type = 'sell'){
        $this->db->limit($limit, $start);
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where('invoice_type', $invoice_type);
        $this->db->order_by("created_at", "DESC");
        $query = $this->db->get('Invoices');
        if($query->num_rows() > 0){
            $data['result'] = $query->result();
        }else{
            $data['result'] = array();
        }
        return $data;
    }

    public function invoiceInitial($invoiceNewID, $invoiceType = 'sell'){
        $data = array(
            'unique_invioce_code'=>$invoiceNewID,
            'status'=>'create',
            'invoice_type'=>$invoiceType,
            'fk_firm_code'=>$this->session->userdata('firmcode'),
            'fk_username'=> $this->session->userdata('username')
        );
        $this->db->insert('Invoices',$data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function invoiceRef_list(){
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where('fk_username', $this->session->userdata('username'));
        $query = $this->db->get('Invoice_reference');
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return array();
        }
        return array();
    }

    public function invoice_items_list($invoiceID){
        $this->db->where('delete_flag', 'NO');
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where('fk_unique_invioce_code', $invoiceID);
        $query = $this->db->get('invoice_item');
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return array();
        }
        return array();
    }

    public function items_list($itemcode = null){
        if($itemcode != null){
            $this->db->where('item_code', $itemcode);
        }
        $this->db->where('delete_flag', 'NO');
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $query = $this->db->get('Items');
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return array();
        }
        return array();
    }

    public function invoiceType_by_id($invoice_ref_id = null){
        $data = array();
        if($invoice_ref_id != null){
            $this->db->where('invoice_reference_id', $invoice_ref_id);
        }
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $query = $this->db->get('Invoice_reference');
        if($query->num_rows() >= 1){
            foreach ($query->result() as $row)  
            {  
                $data['invoice_reference_id'] = $row->invoice_reference_id;
                $data['title'] = $row->title;
                $data['subtitle'] = $row->subtitle;
                $data['payment_mode'] = $row->payment_mode;
                $data['vehicle'] = $row->vehicle;
                $data['mobile'] = $row->mobile;
                $data['gstnumber'] = $row->gstnumber;
            }
        }
        return $data;
    }

    public function invoice_id($invoiceType = 'sell'){
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where('fk_username', $this->session->userdata('username'));
        $this->db->where('status', 'create');
        $this->db->where('invoice_type', $invoiceType);
        $query = $this->db->get('Invoices');
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return array();
        }
        return array();
    }

    public function saveInvoiceRef($data){
        $dataList = array(
            'title'=>$data['invoicetitle'],
            'subtitle'=>$data['invoicesubtitle'],
            'payment_mode'=>$data['paymentmode'],
            'vehicle'=>$data['vehicleno'],
            'mobile'=>$data['invoicemobileno'],
            'gstnumber'=>$data['invoicegstin'],
            'fk_firm_code'=>$this->session->userdata('firmcode'),
            'fk_username'=>$this->session->userdata('username'),
        );
        $this->db->insert('Invoice_reference', $dataList);
        return ($this->db->affected_rows() == 1) ? true : false;
    }

    public function getinvoiceid($invoiceid = null){
        $data = array();
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where('unique_invioce_code', $invoiceid);
        $query = $this->db->get('Invoices');
        if($query->num_rows() >= 1){
            foreach ($query->result() as $row)  
            {  
                $data['pk_invoice_id'] = $row->pk_invoice_id;
                $data['unique_invioce_code'] = $row->unique_invioce_code;
                $data['invoicestatus'] = $row->status;
                $data['invoicetitle'] = $row->invoice_title;
                $data['subtitle'] = $row->invoice_subtitle;
                $data['payment_mode'] = $row->payment_mode;
                $data['vehicle'] = $row->vehicle;
                $data['invoicegstin'] = $row->invoice_gstin;
                $data['invoicemobileno'] = $row->invoice_mobileno;
                $data['invoice_reference_id'] = $row->previous_invoice_ref_no;
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
            }
        }
        return $data;
    }
    public function updateInvoice($data){

        $this->db->where('unique_invioce_code', $data['defaultinvoiceID']);
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where('fk_username', $this->session->userdata('username'));
        $query = $this->db->get('Invoices');
        if($query->num_rows() == 1){
            $dataList = array(
                'invoice_title'=>$data['invoicetitle'],
                'invoice_subtitle'=>$data['invoicesubtitle'],
                'invoice_mobileno'=>$data['owninvoicemobileno'],
                'invoice_gstin'=>$data['owninvoicegstin'],
                'payment_mode'=>$data['paymentmode'],
                'vehicle'=>$data['vehicleno'],
                'previous_invoice_ref_no'=>$data['invoicerefNumber'],
                'fk_client_code'=>$data['clientcode'],
                'client_name'=>$data['clientname'],
                'gstnumber'=>$data['gstin'],
                'pannumber'=>$data['pannumber'],
                'mobilenumber'=>$data['mobilenumber'],
                'address'=>$data['clintaddress'],
                'state'=>$data['clientState'],
                'district'=>$data['clientDistrict'],
                'city'=>$data['clientcity'],
                'area'=>$data['clientarea'],
                'pincode'=>$data['clientpincode'],
                'status'=>'initiated'
            );
            $this->db->where('unique_invioce_code', $data['defaultinvoiceID']);
            $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
            $this->db->where('fk_username', $this->session->userdata('username'));
            $this->db->update('Invoices', $dataList);
            return ($this->db->affected_rows() == 1) ? true : false;
        }else{
            return false;
        }        
    }

    public function saveInvoiceItem($data){
        $result = array();
        $this->db->where('pk_invoice_item_id', $data['itemID']);
        $this->db->where('fk_unique_invioce_code', $data['invoiceID']);
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $query = $this->db->get('invoice_item');
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
            $this->db->where('pk_invoice_item_id', $data['itemID']);
            $this->db->where('fk_unique_invioce_code', $data['invoiceID']);
            $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
            $this->db->update('invoice_item', $dataList);
            $result['code']  = ($this->db->affected_rows() == 1) ? true : false;
            $result['itemid']  = $data['itemID'];
        }else{
            $dataList = array(
                'fk_unique_invioce_code'=>$data['invoiceID'],
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
            $this->db->insert('invoice_item', $dataList);
            $result['code']  = ($this->db->affected_rows() == 1) ? true : false;
            $result['itemid']  = $this->db->insert_id();
        }
        return $result;
    }

    public function updateInvoiceItem($data){
        $result = array();
        $this->db->where('pk_invoice_item_id', $data['itemID']);
        $this->db->where('fk_unique_invioce_code', $data['invoiceID']);
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $query = $this->db->get('invoice_item');
        if($query->num_rows() == 1){
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
            $this->db->where('pk_invoice_item_id', $data['itemID']);
            $this->db->where('fk_unique_invioce_code', $data['invoiceID']);
            $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
            $this->db->update('invoice_item', $dataList);
            $result['code']  = ($this->db->affected_rows() == 1) ? true : false;
        } else{
            $result['code']  = false;
        }
        return $result;
    }

    public function getStockItem($data){
        $result = array();
        $this->db->where('item_code', $data['item_code']);
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $query = $this->db->get('Stocks');
        if($query->num_rows() == 1){
            $preTotalStockItem = 0;
            foreach ($query->result() as $row)  
            {  
                $result['stockid'] = $row->pk_stock_id;
                $preTotalStockItem = $row->item_total_count;

            }
            $result['code']  = true;
            $result['quantity']  = (int)$preTotalStockItem;
        }else{
            $result['stockid'] = 0;
            $result['code']  = false;
            $result['quantity']  = 0;
        }

        return $result;
    }

    public function updateInvoiceStatus($data){
        $result = array();
        $this->db->where('unique_invioce_code', $data['invoiceid']);
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $query = $this->db->get('Invoices');
        if($query->num_rows() == 1){
            if (($data['statuscode'] === "completed") || ($data['statuscode'] === "force_edit")){
                /*
                * Get total bill value
                */
                $this->db->select_sum('bill_value');
                $this->db->from('invoice_item');
                $this->db->where('delete_flag', 'NO');
                $this->db->where('fk_unique_invioce_code', $data['invoiceid']);
                $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
                $billvaluequery = $this->db->get();
                $total_bill_value = $billvaluequery->row()->bill_value;
                $total_bill_value = round($total_bill_value);

                /*
                * payment value add/sub to account from invoice bill value when invoice status is completed(+) or force_edit(-)
                */
                $amountdata = array();
                foreach ($query->result() as $row)  
                {  
                    $amountdata['fk_client_code'] = $row->fk_client_code;
                    $amountdata['fk_client_name'] = $row->client_name;
                    $amountdata['payment_mode'] = $row->payment_mode;
                    $amountdata['lock_bill_amount'] = $row->lock_bill_amount;
                    $amountdata['invoice_type'] = $row->invoice_type;
                    $amountdata['pk_invoice_id'] = $row->pk_invoice_id;
                }
                $amountdata['payment_date'] = date('Y-m-d H:i:s');
                
                if($data['statuscode'] === "completed") {
                    $amountdata['amount'] = $total_bill_value;
                    if ($amountdata['invoice_type'] === "sell"){
                        $amountdata['notes'] = "Amount ".$total_bill_value." debited automatically when invoice status change to completed state. || sell invoice(#".$amountdata['pk_invoice_id'].")";
                        $amountdata['paymenttype'] = "debit";
                    }else if ($amountdata['invoice_type'] === "purchase"){
                        $amountdata['notes'] = "Amount ".$total_bill_value." credited automatically when invoice status change to completed state. || purchase invoice(#".$amountdata['pk_invoice_id'].")";
                        $amountdata['paymenttype'] = "credit";
                    }
                }else if($data['statuscode'] === "force_edit") {
                    $amountdata['amount'] = $amountdata['lock_bill_amount'];
                    if ($amountdata['invoice_type'] === "sell"){
                        $amountdata['notes'] = "Amount ".$amountdata['lock_bill_amount']." credited automatically when invoice status change to force_edit state. || sell invoice(#".$amountdata['pk_invoice_id'].")";
                        $amountdata['paymenttype'] = "credit";
                    }else if ($amountdata['invoice_type'] === "purchase"){
                        $amountdata['notes'] = "Amount ".$amountdata['lock_bill_amount']." debited automatically when invoice status change to force_edit state. || purchase invoice(#".$amountdata['pk_invoice_id'].")";
                        $amountdata['paymenttype'] = "debit";
                    }
                }
                
                $this->load->model('Account_model', '', TRUE);
                $account_model_saveAccount = $this->Account_model->saveAccount($amountdata);
                log_message("info", "payment debit automatically more info.: ");

                $dataList = array(
                    'status'=> $data['statuscode'],
                    'lock_bill_amount'=> $total_bill_value,
                    'lock_bill_amount_date'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s')
                );
            }else{
                $dataList = array(
                    'status'=> $data['statuscode'],
                    'updated_at'=>date('Y-m-d H:i:s')
                );
            }
            $this->db->where('unique_invioce_code', $data['invoiceid']);
            $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
            $this->db->update('Invoices', $dataList);

            $result['code']  = true;
        }else{
            $result['code']  = false;
        }

        return $result;
    }


    public function delete_invoice_item($invoice_Item){
        $result = array();
        $this->db->where('pk_invoice_item_id', $invoice_Item['itemInvoiceCode']);
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $query = $this->db->get('invoice_item');
        if($query->num_rows() == 1){
            $dataList = array(
                'delete_flag'=> 'YES',
                'deleted_at'=>date('Y-m-d H:i:s')
            );
            $this->db->where('pk_invoice_item_id', $invoice_Item['itemInvoiceCode']);
            $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
            $this->db->update('invoice_item', $dataList);
            $result['code']  = ($this->db->affected_rows() == 1) ? true : false;
            $result['itemInvoiceCode']  = $invoice_Item['itemInvoiceCode'];
            foreach ($query->result() as $row)  
            {  
                $result['itemcode'] = $row->fk_item_code;
                $result['itemname'] = $row->fk_item_name;
                $result['quatity'] = $row->quantity;
            }
        }else{
            $result['code']  = false;
            $result['itemInvoiceCode']  = $invoice_Item['itemInvoiceCode'];
        }
        return $result;
    }

}

?>