<?php

class Account_model extends CI_Model {
    protected $table = 'Account';
    protected $historytable = 'Account_Entry';
    function __construct()  
    {  
        parent::__construct();
    }  

    public function get_count($globalsearchtext = '') {
        $this->db->select('Account.pk_account_id');
        $this->db->where('Account.fk_firm_code', $this->session->userdata('firmcode'));
        if ($globalsearchtext != ''){
            $this->db->group_start();
            $this->db->or_like('Account.fk_client_name', $globalsearchtext, "both");
            $this->db->or_like('Clients.client_type', $globalsearchtext, "both");
            $this->db->or_like('Clients.district', $globalsearchtext, "both");
            $this->db->group_end();
        }
        $this->db->order_by("Account.fk_client_name, Clients.client_type", "ASC");
        $this->db->from($this->table);
        $this->db->join('Clients', 'Account.fk_client_code = Clients.code');
        return $this->db->count_all_results();
    }

    public function account_list($limit, $start, $globalsearchtext = ''){
        $this->db->select("Account.pk_account_id, Account.fk_client_code, Account.total_amount, Clients.code, Clients.name, Clients.client_type, Clients.district");
        $this->db->limit($limit, $start);
        $this->db->where('Account.fk_firm_code', $this->session->userdata('firmcode'));
        if ($globalsearchtext != ''){
            $this->db->group_start();
            $this->db->or_like('Account.fk_client_name', $globalsearchtext, "both");
            $this->db->or_like('Clients.client_type', $globalsearchtext, "both");
            $this->db->or_like('Clients.district', $globalsearchtext, "both");
            $this->db->group_end();
        }
        $this->db->order_by("Account.fk_client_name, Clients.client_type", "ASC");
        $this->db->from($this->table);
        $this->db->join('Clients', 'Account.fk_client_code = Clients.code');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $data['result'] = $query->result();
        }else{
            $data['result'] = array();
        }
        return $data;
    }
    
    public function get_log_count($clientcode = NULL) {
        $this->db->select('account_entry_id');
        $this->db->from($this->historytable);
        if ($clientcode != NULL) {
            $this->db->where('fk_client_code', $clientcode);
        }
        $this->db->where('delete_flag', 'no');
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        return $this->db->count_all_results();
    }

    public function account_log_list($limit, $start, $clientcode = NULL){
        $this->db->limit($limit, $start);
        if ($clientcode != NULL) {
            $this->db->where('fk_client_code', $clientcode);
        }
        $this->db->where('delete_flag', 'no');
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->order_by("payment_date", "DESC");
        $query = $this->db->get($this->historytable);
        if($query->num_rows() > 0){
            $data['result'] = $query->result();
        }else{
            $data['result'] = array();
        }
        return $data;
    }

    public function saveAccount($data){
        date_default_timezone_set('asia/kolkata');
        $result = array();
        $this->db->where('fk_client_code', $data['fk_client_code']);
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $query = $this->db->get($this->table);
        if($query->num_rows() == 1){
            $preTotalAccountAmount = 0;
            foreach ($query->result() as $row)  
            {  
                $result['pk_account_id'] = $row->pk_account_id;
                $preTotalAccountAmount = $row->total_amount;

            }
            $updateAmount = (int)$preTotalAccountAmount;
            if($data['paymenttype'] == 'credit'){
                $updateAmount = (int)$preTotalAccountAmount + (int)$data['amount'];
            }elseif($data['paymenttype'] == 'debit'){
                $updateAmount = (int)$preTotalAccountAmount - (int)$data['amount'];
            }
            $string = 'payment info paymenttype:'. $data['paymenttype'].' preTotalAccountAmount: '.$preTotalAccountAmount.' amount:  '.$data['amount'].' updateAmount: '.$updateAmount.' payment date'.date("Y-m-d H:i:s", strtotime($data['payment_date'])).' payment_date'.$data['payment_date'];
            log_message("info", $string);

            $dataList = array( 
                'total_amount'=> $updateAmount,
                'updated_at'=>date('Y-m-d H:i:s')
            );
            $this->db->where('pk_account_id', $result['pk_account_id']);
            $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
            $this->db->update($this->table, $dataList);
            $result['code']  = ($this->db->affected_rows() == 1) ? true : false;
            $result['pk_account_id']  = $result['pk_account_id'];
            $result['totalAmount'] = $updateAmount;
        }else{
            if($data['paymenttype'] == 'credit'){
                $amount = (int)$data['amount'];
            }elseif($data['paymenttype'] == 'debit'){
                $amount = -(int)$data['amount'];
            }
            $dataList = array(
                'fk_client_code'=>$data['fk_client_code'],
                'fk_client_name'=>$data['fk_client_name'],
                'total_amount'=> $amount,
                'fk_username'=>$this->session->userdata('username'),
                'fk_firm_code'=>$this->session->userdata('firmcode')
            );
            $this->db->insert($this->table, $dataList);
            $result['code']  = ($this->db->affected_rows() == 1) ? true : false;
            $result['pk_account_id']  = $this->db->insert_id();
            $result['totalAmount'] = $amount;
        }
        $currentDate = date("Y-m-d H:i:s");
        if(!empty($data['payment_date'])){
            $currentDate = date("Y-m-d H:i:s", strtotime($data['payment_date']));
        }
        if($data['statuscode'] === "force_edit") {
            $account_EntryList = array(
                'fk_client_code'=>$data['fk_client_code'],
                'fk_client_name'=>$data['fk_client_name'],
                'amount'=>(int)$data['amount'],
                'payment_mode'=>$data['payment_mode'],
                'payment_type'=>$data['paymenttype'],
                'payment_date'=>$currentDate,
                'notes'=>$data['notes'],
                'fk_invoice_id'=>(isset($data['pk_invoice_id'])) ? $data['pk_invoice_id'] : 0,
                'delete_flag'=> 'YES',
                'deleted_at'=>date('Y-m-d H:i:s'),
                'fk_username'=>$this->session->userdata('username'),
                'fk_firm_code'=>$this->session->userdata('firmcode')
            );
        }else{
            
            $account_EntryList = array(
                'fk_client_code'=>$data['fk_client_code'],
                'fk_client_name'=>$data['fk_client_name'],
                'amount'=>(int)$data['amount'],
                'payment_mode'=>$data['payment_mode'],
                'payment_type'=>$data['paymenttype'],
                'payment_date'=>$currentDate,
                'notes'=>$data['notes'],
                'fk_invoice_id'=>(isset($data['pk_invoice_id'])) ? $data['pk_invoice_id'] : 0,
                'fk_username'=>$this->session->userdata('username'),
                'fk_firm_code'=>$this->session->userdata('firmcode')
            );
        }
        $this->db->insert($this->historytable, $account_EntryList);
        $result['accountcode']  = ($this->db->affected_rows() == 1) ? true : false;
        return $result;
    }

    public function find_id($data){
        $this->db->select('account_entry_id');
        $this->db->from('Account_Entry');
        $this->db->where('delete_flag', 'no');
        $this->db->where('remarks', 'invoice');
        $this->db->where('fk_invoice_id', $data['pk_invoice_id']);
        $this->db->where('amount', $data['amount']);
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $account_entry_result = $this->db->get();
        // print_r($this->db->getLastQuery());
        if($account_entry_result->num_rows() == 1){
            return $account_entry_result->row()->account_entry_id;
        }else{
            return false;
        }
        
    }

    public function delete_account_entry($account_entry_id){
        $result = array();
        $this->db->where('account_entry_id', $account_entry_id);
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $query = $this->db->get('Account_Entry');
        if($query->num_rows() == 1){
            $dataList = array(
                'delete_flag'=> 'yes',
                'deleted_at'=>date('Y-m-d H:i:s')
            );
            $this->db->where('account_entry_id', $account_entry_id);
            $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
            $this->db->update('Account_Entry', $dataList);
            $result['code']  = ($this->db->affected_rows() == 1) ? true : false;
            $result['account_entry_id']  = $account_entry_id;
        }else{
            $result['code']  = false;
            $result['account_entry_id']  = $account_entry_id;
        }
        return $result;
    }
}
?>