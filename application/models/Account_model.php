<?php

class Account_model extends CI_Model {
    protected $table = 'Account';
    protected $historytable = 'Account_Entry';
    function __construct()  
    {  
        parent::__construct();
    }  

    public function get_count() {
        $this->db->select('pk_account_id');
        $this->db->from($this->table);
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        return $this->db->count_all_results();
    }

    public function account_list($limit, $start){
        $this->db->select("Account.pk_account_id, Account.fk_client_code, Account.total_amount, Clients.code, Clients.name, Clients.client_type, Clients.district");
        $this->db->limit($limit, $start);
        $this->db->where('Account.fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->order_by("Account.fk_client_name", "ASC");
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
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        return $this->db->count_all_results();
    }

    public function account_log_list($limit, $start, $clientcode = NULL){
        $this->db->limit($limit, $start);
        if ($clientcode != NULL) {
            $this->db->where('fk_client_code', $clientcode);
        }
        $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
        $this->db->order_by("created_at", "DESC");
        $query = $this->db->get($this->historytable);
        if($query->num_rows() > 0){
            $data['result'] = $query->result();
        }else{
            $data['result'] = array();
        }
        return $data;
    }

    public function saveAccount($data){
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
            
            $dataList = array( 
                'total_amount'=> $updateAmount,
                'updated_at'=>date('Y-m-d H:i:s')
            );
            $this->db->where('pk_account_id', $result['pk_account_id']);
            $this->db->where('fk_firm_code', $this->session->userdata('firmcode'));
            $this->db->update($this->table, $dataList);
            $result['code']  = ($this->db->affected_rows() == 1) ? true : false;
            $result['pk_account_id']  = $result['pk_account_id'];
        }else{
            $dataList = array(
                'fk_client_code'=>$data['fk_client_code'],
                'fk_client_name'=>$data['fk_client_name'],
                'total_amount'=> (int)$data['amount'],
                'fk_username'=>$this->session->userdata('username'),
                'fk_firm_code'=>$this->session->userdata('firmcode')
            );
            $this->db->insert($this->table, $dataList);
            $result['code']  = ($this->db->affected_rows() == 1) ? true : false;
            $result['pk_account_id']  = $this->db->insert_id();
        }

        $account_EntryList = array(
            'fk_client_code'=>$data['fk_client_code'],
            'fk_client_name'=>$data['fk_client_name'],
            'amount'=>(int)$data['amount'],
            'payment_mode'=>$data['payment_mode'],
            'payment_type'=>$data['paymenttype'],
            'payment_date'=>$data['payment_date'],
            'notes'=>$data['notes'],
            'fk_username'=>$this->session->userdata('username'),
            'fk_firm_code'=>$this->session->userdata('firmcode')
        );
        $this->db->insert($this->historytable, $account_EntryList);
        $result['accountcode']  = ($this->db->affected_rows() == 1) ? true : false;
        return $result;
    }
}
?>