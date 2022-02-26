<?php

class Piggybank_model extends CI_Model {
    protected $table = 'Clients';
    function __construct()  
    {  
        parent::__construct();
    }

    public function get_count() {
        $this->db->select('piggy_bank_account_id');
        $this->db->where('delete_flag', 'no');
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->from('Piggy_Bank_account');
        return $this->db->count_all_results();
    }

    public function account_holder_list($limit, $start){
        $this->db->limit($limit, $start);
        $this->db->where('delete_flag', 'no');
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->order_by("account_name", "ASC");
        $query = $this->db->get('Piggy_Bank_account');
        if($query->num_rows() > 0){
            $data['result'] = $query->result();
        }else{
            $data['result'] = array();
        }
        return $data;
    }

    public function get_log_count($clientcode = NULL) {
        $this->db->select('pk_piggy_account_entry_id');
        $this->db->from('Piggy_Account_Entry');
        if ($clientcode != NULL) {
            $this->db->where('fk_piggy_account_code', $clientcode);
        }
        $this->db->where('delete_flag', 'no');
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        return $this->db->count_all_results();
    }

    public function account_log_list($limit, $start, $clientcode = NULL){
        $this->db->limit($limit, $start);
        if ($clientcode != NULL) {
            $this->db->where('fk_piggy_account_code', $clientcode);
        }
        $this->db->where('delete_flag', 'no');
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->order_by("payment_date", "DESC");
        $query = $this->db->get('Piggy_Account_Entry');
        if($query->num_rows() > 0){
            $data['result'] = $query->result();
        }else{
            $data['result'] = array();
        }
        return $data;
    }

    public function unique_client_code_verify($unique_code){
        $this->db->where('account_code', strtoupper($unique_code));
        $query = $this->db->get('Piggy_Bank_account');
        if($query->num_rows() === 0){
            return true;
        }else{
            return false;
        }
        return false;
    }

    public function unique_account_holder_code_check($unique_code){
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where('account_code', strtoupper($unique_code));
        $query = $this->db->get('Piggy_Bank_account');
        if($query->num_rows() === 1){
            return true;
        }else{
            return false;
        }
        return false;
    }

    public function create_account_holder($data){
        $data = array(
            'account_code'=>strtoupper($data['uniqueCode']),
            'account_name'=>$data['clientName'],
            'contact_number'=>$data['clientMobile'],
            'email'=>$data['accontemail'],
            'address'=>$data['clientAddress'],
            'fk_firm_code'=>$this->session->userdata('firmcode'),
            'fk_username'=> $this->session->userdata('username')
        );
        $this->db->insert('Piggy_Bank_account',$data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function update_account_holder_detail($account_holder_id){
        $this->db->where('delete_flag', 'no');
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where('account_code', $account_holder_id);
        $query = $this->db->get('Piggy_Bank_account');
        if($query->num_rows() == 1){
            $data['result'] = $query->result();
        }else{
            $data['result'] = array();
        }
        return $data;
    }

    public function update_account_holder($data){
        $itemdata = array(
            'account_name'=>$data['clientName'],
            'contact_number'=>$data['clientMobile'],
            'email'=>$data['accontemail'],
            'address'=>$data['clientAddress']
        );
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->where('account_code', strtoupper($data['uniqueCode']));
        $this->db->update('Piggy_Bank_account',$itemdata);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function delete_account_holder($client){
        $result = array();
        $this->db->where('account_code', $client['client_code']);
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $query = $this->db->get('Piggy_Bank_account');
        if($query->num_rows() == 1){
            $dataList = array(
                'delete_flag'=> 'yes',
                'deleted_at'=>date('Y-m-d H:i:s')
            );
            $this->db->where('account_code', $client['client_code']);
            $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
            $this->db->update('Piggy_Bank_account', $dataList);
            $result['code']  = ($this->db->affected_rows() == 1) ? true : false;
            $result['clientid']  = $client['client_code'];
        }else{
            $result['code']  = false;
            $result['clientid']  = $client['client_code'];
        }
        return $result;
    }

    public function get_piggy_bank_count() {
        $this->db->select('pk_piggy_account_id');
        $this->db->from('Piggy_Account');
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        return $this->db->count_all_results();
    }

    public function piggy_bank_account_list($limit, $start){
        $this->db->select("Piggy_Account.pk_piggy_account_id, Piggy_Account.fk_piggy_account_code, Piggy_Account.fk_account_name, Piggy_Account.total_amount, Piggy_Bank_account.contact_number, Piggy_Bank_account.email, Piggy_Bank_account.address");
        $this->db->limit($limit, $start);
        $this->db->where('Piggy_Account.fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->order_by("Piggy_Account.fk_account_name", "ASC");
        $this->db->from('Piggy_Account');
        $this->db->join('Piggy_Bank_account', 'Piggy_Account.fk_piggy_account_code = Piggy_Bank_account.account_code');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $data['result'] = $query->result();
        }else{
            $data['result'] = array();
        }
        return $data;
    }

    public function Piggy_Bank_account_name_list(){
        $this->db->where('delete_flag', 'no');
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->order_by("account_name", "ASC");
        $query = $this->db->get('Piggy_Bank_account');
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return array();
        }
    }

    public function saveAccount($data){
        date_default_timezone_set('asia/kolkata');
        $result = array();
        $this->db->where('fk_piggy_account_code', $data['fk_client_code']);
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $query = $this->db->get('Piggy_Account');
        if($query->num_rows() == 1){
            $preTotalAccountAmount = 0;
            foreach ($query->result() as $row)  
            {  
                $result['pk_piggy_account_id'] = $row->pk_piggy_account_id;
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
            $this->db->where('pk_piggy_account_id', $result['pk_piggy_account_id']);
            $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
            $this->db->update('Piggy_Account', $dataList);
            $result['code']  = ($this->db->affected_rows() == 1) ? true : false;
            $result['pk_piggy_account_id']  = $result['pk_piggy_account_id'];
            $result['totalAmount'] = $updateAmount;
        }else{
            if($data['paymenttype'] == 'credit'){
                $amount = (int)$data['amount'];
            }elseif($data['paymenttype'] == 'debit'){
                $amount = -(int)$data['amount'];
            }
            $dataList = array(
                'fk_piggy_account_code'=>$data['fk_client_code'],
                'fk_account_name'=>$data['fk_client_name'],
                'total_amount'=> $amount,
                'fk_username'=>$this->session->userdata('username'),
                'fk_firm_code'=>$this->session->userdata('firmcode')
            );
            $this->db->insert('Piggy_Account', $dataList);
            $result['code']  = ($this->db->affected_rows() == 1) ? true : false;
            $result['pk_piggy_account_id']  = $this->db->insert_id();
            $result['totalAmount'] = $amount;
        }
        
        $account_EntryList = array(
            'fk_piggy_account_code'=>$data['fk_client_code'],
            'fk_piggy_account_name'=>$data['fk_client_name'],
            'amount'=>(int)$data['amount'],
            'payment_mode'=>$data['payment_mode'],
            'payment_type'=>$data['paymenttype'],
            'payment_date'=>date("Y-m-d H:i:s", strtotime($data['payment_date'] ." ".date("H:i:s") )),
            'notes'=>$data['notes'],
            'fk_username'=>$this->session->userdata('username'),
            'fk_firm_code'=>$this->session->userdata('firmcode')
        );
        $this->db->insert('Piggy_Account_Entry', $account_EntryList);
        $result['accountcode']  = ($this->db->affected_rows() == 1) ? true : false;
        return $result;
    }
}