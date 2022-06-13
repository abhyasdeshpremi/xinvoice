<?php

class Invoice_model extends CI_Model {

    protected $table = 'Invoices';

    function __construct()  
    {  
        parent::__construct();
        $this->load->model('Account_model', '', TRUE);
        $this->load->model('Piggybank_model', '', TRUE);
        $this->load->model('Client_model', '', TRUE);
    }  

    public function get_count($invoice_type = 'sell', $globalsearchtext = '') {
        $this->db->select('pk_invoice_id');
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where('invoice_type', $invoice_type);
        if ($globalsearchtext != ''){
            $this->db->group_start();
            $this->db->or_like('client_name', $globalsearchtext, "both");
            $this->db->or_like('district', $globalsearchtext, "both");
            $this->db->or_like('area', $globalsearchtext, "both");
            $this->db->or_like('payment_mode', $globalsearchtext, "both");
            $this->db->or_like('status', $globalsearchtext, "both");
            $this->db->group_end();
        }
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
        $this->db->where_not_in('client_type', 'mine');
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

    public function invoice_list($limit, $start, $invoice_type = 'sell', $globalsearchtext = ''){
        $this->db->limit($limit, $start);
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where('invoice_type', $invoice_type);
        if ($globalsearchtext != ''){
            $this->db->group_start();
            $this->db->or_like('client_name', $globalsearchtext, "both");
            $this->db->or_like('district', $globalsearchtext, "both");
            $this->db->or_like('area', $globalsearchtext, "both");
            $this->db->or_like('payment_mode', $globalsearchtext, "both");
            $this->db->or_like('status', $globalsearchtext, "both");
            $this->db->group_end();
        }
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
        if ($invoiceType === 'sell'){

            if (date('m') <= 3) {
                $thisFYear = (date('Y')-1);
                $thisFEndYear = date('Y');
            } else {
                $thisFYear = date('Y');
                $thisFEndYear = (date('Y')+1);
            }
    
            $thisSFinancialYear = $thisFYear.'-04-01 00:00:00'; 
            $thisStartFinancial = date($thisSFinancialYear);

            $thisEFinancialYear = $thisFEndYear.'-03-31 23:59:59';
            $thisEndFinancial = date($thisEFinancialYear);
            
            $previous_invoice_ref_no = 1;
            $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
            $this->db->where('invoice_type', "sell");
            $this->db->where("created_at BETWEEN '$thisStartFinancial' AND '$thisEndFinancial'");
            $queryForNumber = $this->db->get('Invoices');
            if($queryForNumber->num_rows() > 0){
                $previous_invoice_ref_no = $previous_invoice_ref_no + $queryForNumber->num_rows();
            }
            $data = array(
                'unique_invioce_code'=>$invoiceNewID,
                'status'=>'create',
                'invoice_type'=>$invoiceType,
                'previous_invoice_ref_no'=> $previous_invoice_ref_no,
                'fk_firm_code'=>$this->session->userdata('firmcode'),
                'fk_username'=> $this->session->userdata('username')
            );
        }else{
            $data = array(
                'unique_invioce_code'=>$invoiceNewID,
                'status'=>'create',
                'invoice_type'=>$invoiceType,
                'fk_firm_code'=>$this->session->userdata('firmcode'),
                'fk_username'=> $this->session->userdata('username')
            );
        }
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

    public function items_Group_list($itemgroupcode = null){
        if($itemgroupcode != null){
            $this->db->where('pk_gfi_unique_code', $itemgroupcode);
        }
        $this->db->where('delete_flag', 'no');
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $query = $this->db->get('Group_for_item');
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
            'mobile'=>$data['owninvoicemobileno'],
            'gstnumber'=>$data['owninvoicegstin'],
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
                $data['aadharnumber'] = $row->aadharnumber;

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
                'aadharnumber'=>$data['aadharnumber'],
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

                $this->db->select_sum('mrp_value');
                $this->db->from('invoice_item');
                $this->db->where('delete_flag', 'NO');
                $this->db->where('fk_unique_invioce_code', $data['invoiceid']);
                $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
                $mrpvaluequery = $this->db->get();
                $total_mrp_value = $mrpvaluequery->row()->mrp_value;
                $total_mrp_value = round($total_mrp_value);

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
                    $amountdata['previous_invoice_ref_no'] = $row->previous_invoice_ref_no;
                    $amountdata['created_at'] = $row->created_at;
                }
                $amountdata['payment_date'] = $amountdata['created_at'];
                $amountdata['statuscode'] = $data['statuscode'];
                if($data['statuscode'] === "completed") {
                    $amountdata['amount'] = $total_bill_value;
                    if ($amountdata['invoice_type'] === "sell"){
                        $amountdata['notes'] = "INVOICE NO(#".$amountdata['previous_invoice_ref_no'].")";
                        $amountdata['paymenttype'] = "debit";
                    }else if ($amountdata['invoice_type'] === "purchase"){
                        $amountdata['notes'] = "PURCHASE INVOICE NO(#".$amountdata['previous_invoice_ref_no'].")";
                        $amountdata['paymenttype'] = "credit";
                    }
                }else if($data['statuscode'] === "force_edit") {
                    $amountdata['amount'] = $amountdata['lock_bill_amount'];
                    if ($amountdata['invoice_type'] === "sell"){
                        $amountdata['notes'] = "INVOICE NO(#".$amountdata['previous_invoice_ref_no'].")";
                        $amountdata['paymenttype'] = "credit";
                    }else if ($amountdata['invoice_type'] === "purchase"){
                        $amountdata['notes'] = "PURCHASE INVOICE NO(#".$amountdata['previous_invoice_ref_no'].")";
                        $amountdata['paymenttype'] = "debit";
                    }
                    $account_entry_id = $this->Account_model->find_id($amountdata);
                    $deleteAccountEntry = $this->Account_model->delete_account_entry($account_entry_id);
                }
                
                $account_model_saveAccount = $this->Account_model->saveAccount($amountdata);
                log_message("info", "payment debit automatically more info.: ");

                //Bonus deposit to piggy bank for every vendor
                $bonus_percent = floatval($this->session->userdata('bonus_percent'));
                if(($bonus_percent > 0) && ($amountdata['invoice_type'] === "sell")){
                    log_message("info", "bonus percentage " . $bonus_percent);
                    $clientInfo = $this->Client_model->client_by_id($amountdata['fk_client_code']);
                    $clientType = $clientInfo['client_type'];
                    if($clientType === "vendor"){
                        
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

                            $bonusDataUpdateToPiggybank['payment_date'] = $amountdata['created_at'];

                            $bonusDataUpdateToPiggybank['payment_mode'] = 'auto';
                            
                            if($data['statuscode'] === "completed") {
                                $bonusDataUpdateToPiggybank['paymenttype'] = 'credit';
                            }else if($data['statuscode'] === "force_edit") {
                                $bonusDataUpdateToPiggybank['paymenttype'] = 'debit';
                            }
                            $bonusDataUpdateToPiggybank['notes'] = 'auto '.$bonusDataUpdateToPiggybank['paymenttype'].' #('.$amountdata['previous_invoice_ref_no'].') bonus';
                            $unique_client_code_verify = $this->Piggybank_model->unique_account_holder_code_check($amountdata['fk_client_code']);
                            if($unique_client_code_verify){
                                $this->Piggybank_model->saveAccount($bonusDataUpdateToPiggybank);
                            }else{
                                $this->Piggybank_model->create_account_holder($bonusamountdata);
                                $this->Piggybank_model->saveAccount($bonusDataUpdateToPiggybank);
                            }

                        }
                        
                        if($this->session->userdata('feature_capture_saved_amount') == 'yes'){
                            $save_amount = $total_mrp_value - $total_bill_value;
                            if($save_amount > 0){
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
                                $bonusDataUpdateToPiggybank['amount'] = $save_amount;

                                $bonusDataUpdateToPiggybank['payment_date'] = $amountdata['created_at'];

                                $bonusDataUpdateToPiggybank['payment_mode'] = 'auto';
                                
                                if($data['statuscode'] === "completed") {
                                    $bonusDataUpdateToPiggybank['paymenttype'] = 'credit';
                                }else if($data['statuscode'] === "force_edit") {
                                    $bonusDataUpdateToPiggybank['paymenttype'] = 'debit';
                                }
                                $bonusDataUpdateToPiggybank['notes'] = 'auto '.$bonusDataUpdateToPiggybank['paymenttype'].' #('.$amountdata['previous_invoice_ref_no'].') Saved!';
                                $unique_client_code_verify = $this->Piggybank_model->unique_account_holder_code_check($amountdata['fk_client_code']);
                                if($unique_client_code_verify){
                                    $this->Piggybank_model->savedVendorAccount($bonusDataUpdateToPiggybank);
                                }else{
                                    $this->Piggybank_model->create_account_holder($bonusamountdata);
                                    $this->Piggybank_model->savedVendorAccount($bonusDataUpdateToPiggybank);
                                }
                            }
                        }

                    }
                }

                $dataList = array(
                    'status'=> $data['statuscode'],
                    'lock_bill_amount'=> $total_bill_value,
                    'lock_mrp_amount'=> $total_mrp_value,
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

    public function updateInvoiceCreatedDate($data){
        date_default_timezone_set('asia/kolkata');
        $result = array();
        $this->db->where('unique_invioce_code', $data['invoiceCode']);
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $query = $this->db->get('Invoices');
        if($query->num_rows() == 1){

            $currentDate = date("Y-m-d H:i:s");
            if(!empty($data['updateCreated_at']) && !empty($data['updateCreated_time_at'])){
                $currentDate = date("Y-m-d H:i:s", strtotime($data['updateCreated_at'] ." ".$data['updateCreated_time_at']));
            }else if(!empty($data['updateCreated_at'])){
                $currentDate = date("Y-m-d H:i:s", strtotime($data['updateCreated_at'] ." ".date("H:i:s")));
            }
            $dataList = array(
                'created_at'=>$currentDate
            );
            $this->db->where('unique_invioce_code', $data['invoiceCode']);
            $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
            $this->db->update('Invoices', $dataList);
            $result['code']  = ($this->db->affected_rows() == 1) ? true : false;
            $result['updated_at'] = $currentDate;
        }else{
            $result['code']  = false;
            $result['updated_at'] = $currentDate;
        }
        return $result;
    }

    public function saveInvoiceGroupItem($data){
        $result = array();
        $this->db->where('fk_item_code', $data['itemcode']);
        $this->db->where('fk_unique_invioce_code', $data['invoiceID']);
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $query = $this->db->get('invoice_item');
        if($query->num_rows() == 1){
            foreach ($query->result() as $row)  
            {  
                $result['itemcode'] = $row->fk_item_code;
                $result['itemname'] = $row->fk_item_name;
                $result['oldcase_unit'] = $row->case_unit;
                $result['oldQuatity'] = $row->quantity;
                $result['itemid']  = $row->pk_invoice_item_id;
            }
            $final_qunatity = intval( intval( intval($data['quatity']) * intval($data['groupquantity']) )  + $result['oldQuatity']);
            $old_itemunitcase = floatval($result['oldcase_unit']); 
            $old_quantity = floatval($result['oldQuatity']);
            $per_unitcase = floatval($old_itemunitcase / $old_quantity);
            $final_unitcase = floatval( $per_unitcase * $final_qunatity);
            $final_mrp = $data['itemmrp'];
            $final_mrpvalue = $final_mrp * $final_qunatity;
            $final_discount = $data['itemdiscount'];
            $final_discount_value = ($final_mrpvalue * $final_discount) / 100;
            $final_bill_value = $final_mrpvalue - $final_discount_value;
             
            $dataList = array(
                'fk_item_code'=>$data['itemcode'],
                'fk_item_name'=>$data['itemname'],
                'quantity'=>$final_qunatity,
                'case_unit'=>$final_unitcase,
                'mrp'=>$final_mrp,
                'mrp_value'=>$final_mrpvalue,
                'discount'=>$final_discount,
                'bill_value'=>$final_bill_value,
                'updated_at'=>date('Y-m-d H:i:s')
            );
            
            $this->db->where('fk_item_code', $data['itemcode']);
            $this->db->where('fk_unique_invioce_code', $data['invoiceID']);
            $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
            $this->db->update('invoice_item', $dataList);
            $result['code']  = ($this->db->affected_rows() == 1) ? true : false;
            
            $result['quatity'] = $final_qunatity;
            $result['itemunitcase'] = $final_unitcase;
            $result['itemmrp'] = $final_mrp;
            $result['itemdmrpvalue'] = $final_mrpvalue;
            $result['itemdiscount'] = $final_discount;
            $result['itembillValue'] = $final_bill_value;
        }else{

            $final_qunatity = intval( intval($data['quatity']) * intval($data['groupquantity']) );
            $old_itemunitcase = floatval($data['itemunitcase']); 
            $old_quantity = floatval($data['quatity']);
            $per_unitcase = floatval($old_itemunitcase / $old_quantity);
            $final_unitcase = floatval( $per_unitcase * $final_qunatity);
            $final_mrp = $data['itemmrp'];
            $final_mrpvalue = $final_mrp * $final_qunatity;
            $final_discount = $data['itemdiscount'];
            $final_discount_value = ($final_mrpvalue * $final_discount) / 100;
            $final_bill_value = $final_mrpvalue - $final_discount_value;

            $dataList = array(
                'fk_unique_invioce_code'=>$data['invoiceID'],
                'fk_item_code'=>$data['itemcode'],
                'fk_item_name'=>$data['itemname'],
                'quantity'=>$final_qunatity,
                'case_unit'=>$final_unitcase,
                'mrp'=>$final_mrp,
                'mrp_value'=>$final_mrpvalue,
                'discount'=>$final_discount,
                'bill_value'=>$final_bill_value,
                'fk_username'=>$this->session->userdata('username'),
                'fk_firm_code'=>$this->session->userdata('firmcode')
            );
            $this->db->insert('invoice_item', $dataList);
            $result['code']  = ($this->db->affected_rows() == 1) ? true : false;
            $result['itemid']  = $this->db->insert_id();

            $result['quatity'] = $final_qunatity;
            $result['itemunitcase'] = $final_unitcase;
            $result['itemmrp'] = $final_mrp;
            $result['itemdmrpvalue'] = $final_mrpvalue;
            $result['itemdiscount'] = $final_discount;
            $result['itembillValue'] = $final_bill_value;
        }
        return $result;
    }
}

?>