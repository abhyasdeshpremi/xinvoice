<?php

class Invoice_model extends CI_Model {

    function __construct()  
    {  
        parent::__construct();
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

    public function invoiceInitial($invoiceNewID){
        $data = array(
            'unique_invioce_code'=>$invoiceNewID,
            'status'=>'create',
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
            }
        }
        return $data;
    }

    public function invoice_id(){
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where('fk_username', $this->session->userdata('username'));
        $this->db->where('status', 'create');
        $query = $this->db->get('Invoices');
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return array();
        }
        return array();
    }

    public function saveInvoiceRef($data){
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where('fk_username', $this->session->userdata('username'));
        $this->db->where('title', $data['invoicetitle']);
        $query = $this->db->get('Invoice_reference');
        if($query->num_rows() == 0){
            $dataList = array(
                'title'=>$data['invoicetitle'],
                'subtitle'=>$data['invoicesubtitle'],
                'payment_mode'=>$data['paymentmode'],
                'vehicle'=>$data['vehicleno'],
                'fk_firm_code'=>$this->session->userdata('firmcode'),
                'fk_username'=>$this->session->userdata('username'),
            );
            $this->db->insert('Invoice_reference', $dataList);
            return true;
        }
        return false;
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
                $data['invoice_reference_id'] = $row->previous_invoice_ref_no;

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
            $dataList = array(
                'fk_item_code'=>$data['itemcode'],
                'fk_item_name'=>$data['itemname'],
                'quantity'=>$data['quatity'],
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

}

?>